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

    // Generate tickets for the selected booking IDs
    public function generateTickets(Request $request, $bookingIds)
{
    try {
        $seatFilter = $request->input('seat_codes', []); // Fetch selected seat codes for re-print

        // Split the booking IDs into an array
        $bookingIdsArray = explode(',', $bookingIds);

        // Fetch all bookings that match the given IDs
        $bookings = Booking::whereIn('id', $bookingIdsArray)
            ->when(!empty($seatFilter), function ($query) use ($seatFilter) {
                $query->whereIn('seat_code', $seatFilter); // Filter specific seats for re-print
            })
            ->get();

        if ($bookings->isEmpty()) {
            return redirect()->back()->withErrors(['error' => 'No bookings found.']);
        }

        // Initialize mPDF
        $mpdf = new Mpdf(['format' => [80, 150]]); // Adjust for POS printer dimensions

        $bookingsCount = $bookings->count(); // Get total bookings count
        $currentIndex = 0; // Initialize current index

        foreach ($bookings as $booking) {
            $currentIndex++; // Increment the current index for each iteration

            // Generate ticket content for each booking
            $html = "
                <div style='text-align: center; font-family: Arial, sans-serif; border: 1px dashed #000; padding: 10px; margin: 5px;'>
                    <h2>Movie Ticket</h2>
                    <p><strong>Movie:</strong> {$booking->movie_name}</p>
                    <p><strong>Date:</strong> {$booking->date}</p>
                    <p><strong>Time:</strong> {$booking->time}</p>
                    <p><strong>Seat:</strong> {$booking->seat_no}</p>
                    <p><strong>Seat Type:</strong> {$booking->seat_type}</p>
                </div>
            ";

            // Add ticket to the PDF
            $mpdf->WriteHTML($html);

            // Add a page break if this is not the last ticket
            if ($currentIndex < $bookingsCount) {
                $mpdf->AddPage();
            }
        }

        // Output the combined PDF for download or inline display
        return $mpdf->Output('Tickets.pdf', 'I'); // 'I' for inline display, 'D' for download
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Failed to generate tickets: ' . $e->getMessage()]);
    }
}



}



