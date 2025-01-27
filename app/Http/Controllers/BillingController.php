<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Show;
use App\Models\Price;
use App\Models\Billing;
use Mpdf\Mpdf;

class BillingController extends Controller
{
    
    public function create(Request $request)
    {
        // Retrieve movie_id and seat_type from the session or request
        $movieId = session('movie_id') ?? $request->query('movie_id');
        $seatType = session('seat_type') ?? $request->query('seat_type');

        if (!$movieId || !$seatType) {
            return redirect()->route('booking.index')->withErrors('Missing booking information.');
        }

        // Fetch the Show based on movie_id
        $show = Show::find($movieId);
        if (!$show) {
            return redirect()->route('booking.index')->withErrors('Show not found.');
        }

        // Fetch the price row where movie_code and seat_type match
        $price = Price::where('movie_code', $show->movie_code)
            ->where('seat_type', $seatType)
            ->first(); // Retrieve the single matching price

        if (!$price) {
            return redirect()->back()->withErrors('Price information not found for the selected movie and seat type.');
        }

        // Pass the data to the billing view
        return view('billings.create', [
            'show' => $show,
            'price' => $price, // Pass the matched price object
        ]);
    }


    public function store(Request $request)
{
    // Validate the request
    $validated = $request->validate([
        'booking_id' => 'required|exists:bookings,id',
        'movie_id' => 'required|exists:shows,id',
        'movie_name' => 'required|string',
        'date' => 'required',
        'time' => 'required',
        'seat_type' => 'required|string',
        'total_tickets' => 'required|integer|min:1',
        'full_tickets' => 'required|integer|min:0',
        'half_tickets' => 'required|integer|min:0',
        'total_price' => 'required|numeric|min:0',
    ]);

    try {
        // Store billing data
        Billing::create([
            'booking_id' => $validated['booking_id'],
            'movie_id' => $validated['movie_id'],
            'movie_name' => $validated['movie_name'],
            'date' => $validated['date'],
            'time' => $validated['time'],
            'seat_type' => $validated['seat_type'],
            'total_tickets' => $validated['total_tickets'],
            'full_tickets' => $validated['full_tickets'],
            'half_tickets' => $validated['half_tickets'],
            'total_price' => $validated['total_price'],
        ]);

        // Redirect to the 'selectSeats' route
        return redirect()->route('booking.selectSeats', ['id' => $validated['movie_id']])
            ->with('success', 'Billing data stored successfully. Please proceed to select your seats.');
    } catch (\Exception $e) {
        // Log error and redirect back with an error message
        Log::error('Billing Store Error: ', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'validated' => $validated,
        ]);

        return redirect()->back()->withErrors('Failed to store billing data.')->withInput();
    }
}


    public function index(){
        // Fetch all billing data
        $billings = Billing::all();

        return view('billings.index', [
            'billings' => $billings,
        ]);
    }

    public function detail($id)
    {
        // Fetch the billing data by ID
        $billing = Billing::find($id);

        if (!$billing) {
            return redirect()->route('billing.index')->withErrors('Billing data not found.');
        }

        return view('billings.detail', [
            'billing' => $billing,
        ]);
    }

    public function edit($id)
    {
        // Fetch the billing data by ID
        $billing = Billing::find($id);

        if (!$billing) {
            return redirect()->route('billing.index')->withErrors('Billing data not found.');
        }

        return view('billings.edit', [
            'billing' => $billing,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'movie_id' => 'required|exists:shows,id',
            'movie_name' => 'required|string',
            'date' => 'required',
            'time' => 'required',
            'seat_type' => 'required|string',
            'total_tickets' => 'required|integer|min:1',
            'full_tickets' => 'required|integer|min:0',
            'half_tickets' => 'required|integer|min:0',
            'total_price' => 'required',
        ]);

        try {
            // Fetch the billing data by ID
            $billing = Billing::find($id);

            if (!$billing) {
                return redirect()->route('billing.index')->withErrors('Billing data not found.');
            }

            // Update the billing data
            $billing->update($validated);

            return redirect()->route('billing.index')->with('success', 'Billing data updated successfully.');
        } catch (\Exception $e) {
            Log::error('Billing Update Error: ', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'validated' => $validated,
            ]);
            return redirect()->back()->withErrors('Failed to update billing data.')->withInput();
        }
    }

    public function destroy($id){
        // Fetch the billing data by ID
        $billing = Billing::find($id);

        if (!$billing) {
            return redirect()->route('billing.index')->withErrors('Billing data not found.');
        }

        // Delete the billing data
        $billing->delete();

        return redirect()->route('billing.index')->with('success', 'Billing data deleted successfully.');
    }

    public function generateTickets(Request $request, $bookingIds)
    {
        try {
            $seatFilter = $request->input('seat_codes', []); // Fetch selected seat codes for re-print
    
            $bookingIdsArray = explode(',', $bookingIds);
    
            $bookings = Booking::whereIn('id', $bookingIdsArray)
                ->when(!empty($seatFilter), function ($query) use ($seatFilter) {
                    $query->whereIn('seat_code', $seatFilter);
                })
                ->get();
    
            if ($bookings->isEmpty()) {
                return redirect()->back()->withErrors(['error' => 'No bookings found.']);
            }
    
            // Initialize mPDF with the desired dimensions
        $mpdf = new \Mpdf\Mpdf([
            'format' => [80, 150], // 80mm x 150mm dimensions
            'margin_top' => 0,
            'margin_right' => 0,
            'margin_bottom' => 0,
            'margin_left' => 0,
        ]);

        $ticketHtml = ''; // Variable to hold the full ticket HTML

        foreach ($bookings as $index => $booking) {
            // Ticket HTML content
            $html = "
                <div style='width: 100%; text-align: center; font-family: Arial, sans-serif; padding: 0px;'>
                    <p style='font-size: 10px; margin: 5px;'>DEL LANKA ADVANCED TICKETBOOKING</p>
                    <h2 style='margin: 5px 0;'>Sellam Premier</h2>
                    <p style='margin: 5px 0; margin:0;'>3D Digital Cinema</p>
                    <p style='margin: 5px 0; margin:0;'>Chenkalady, Batticaloa</p>
                    <p style='margin: 5px 0; margin:0;'>TP: 065-2240064 / 071-3641686</p>
                    <hr style='border: 1px dashed #000; margin:5px;'>
                    <p style='font-size: 10px; padding-left:40px; margin:0; text-align: left;'>Serial #: {$booking->id}</p>
                    <p style='font-size: 10px; padding-left:40px; margin:5px; text-align: left;'>Date: " . date('d-M-Y h:i A') . "</p>
                    <hr style='border: 1px dashed #000; margin:0;'>
                    <p style='font-size: 14px; margin: 5px;'><strong>Movie Date:</strong> {$booking->date}</p>
                    <p style='font-size: 14px; margin: 5px;'><strong>Movie Time:</strong> {$booking->time}</p>
                    <hr style='border: 1px dashed #000;'>
                    <p style='font-size: 20px; margin: 5px;'><strong> {$booking->movie_name}</strong></p>
                    <p style='font-size: 24px; margin:5px;'><strong> {$booking->seat_type}</strong></p>
                    <hr style='border: 1px dashed #000;'>
                    <p style='font-size: 20px; margin: 5px;'>Seat No: <strong>{$booking->seat_no}</strong> .  .  . PAID</p>
                    <hr style='border: 1px dashed #000;'>
                    <p style='font-size: 12px; padding-left:30px; margin:5px; text-align: left;'><strong>அறிவித்தல்:</strong></p>
                    <p style='font-size: 12px; padding-left:20px; margin:0; text-align: left;'>வெளியில் இருந்து கொண்டுவரும்<br/> உணவுப்பண்டங்கள் குளிர்பானங்கள் மதுபானங்கள் <br/>அரங்கினுள் கொண்டு வர முற்றாகத் தடை.</p>
                    <p style='font-size: 12px; padding-left:20px; margin:0; text-align: left;'>குறித்த காட்சிக்கு மட்டுமே<br/> இந்த டிக்கட் செல்லுபடியாகும்.</p>
                    <p style='font-size: 12px; padding-left:20px; margin:0; text-align: left;'>புகைத்தல் முற்றாக தடை செய்யப்பட்டுள்ளது.</p>
                    <hr style='border: 1px dashed #000;'>
                    <p style='font-size: 10px; margin:0;'>Software Developed By : ForgeTech Crafters</p>
                    <p style='font-size: 10px; margin:0;'>076-2646376</p>
                </div>";

            $ticketHtml .= $html;

            // Add page break if not the last ticket
            if ($index < count($bookings) - 1) {
                $ticketHtml .= "<div style='page-break-after: always;'></div>";
            }
        }

        // Embed the generated ticket HTML into the response with auto-print functionality
        return response("
            <html>
            <head>
                <style>
                    @page { size: 80mm 150mm; margin: 0; }
                    body { margin: 0; font-family: Arial, sans-serif; }
                    .ticket { width: 100%; text-align: center; padding: 10px; }
                    hr { border: 1px dashed #000; margin: 5px 0; }
                </style>
                <script>
                    window.onload = function() {
                        window.print(); // Trigger the print dialog
                        window.onafterprint = function() {
                            window.close(); // Close the print tab after printing
                        };
                    };
                </script>
            </head>
            <body>
                {$ticketHtml}
            </body>
            </html>
        ", 200, ['Content-Type' => 'text/html']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to generate tickets: ' . $e->getMessage()]);
        }
    }



//     public function generateTickets(Request $request, $bookingIds)
// {
//     try {
//         $seatFilter = $request->input('seat_codes', []); 
//         $bookingIdsArray = explode(',', $bookingIds);

//         $bookings = Booking::whereIn('id', $bookingIdsArray)
//             ->when(!empty($seatFilter), function ($query) use ($seatFilter) {
//                 $query->whereIn('seat_code', $seatFilter);
//             })
//             ->get();

//         if ($bookings->isEmpty()) {
//             return response()->json(['error' => 'No bookings found.'], 404);
//         }

//         $tickets = $bookings->map(function ($booking) {
//             return [
//                 'movie_name' => $booking->movie_name,
//                 'date' => $booking->date,
//                 'time' => $booking->time,
//                 'seat_no' => $booking->seat_no,
//                 'seat_type' => $booking->seat_type,
//             ];
//         });

//         return response()->json(['success' => true, 'tickets' => $tickets], 200);

//     } catch (\Exception $e) {
//         return response()->json(['success' => false, 'message' => 'Failed to generate tickets: ' . $e->getMessage()], 500);
//     }
// }

    


}



