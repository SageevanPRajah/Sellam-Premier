<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Show;
use App\Models\Price;
use App\Models\Billing;


class BillingController extends Controller
{
    public function create(Request $request)
    {
        // Retrieve movie_id and seat_type from the session or request
        $movieId  = session('movie_id') ?? $request->query('movie_id');
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
            'show'  => $show,
            'price' => $price, // Pass the matched price object
        ]);
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'booking_id'     => 'required|exists:bookings,id',
            'movie_id'       => 'required|exists:shows,id',
            'movie_name'     => 'required|string',
            'date'           => 'required',
            'time'           => 'required',
            'seat_type'      => 'required|string',
            'total_tickets'  => 'required|integer|min:1',
            'full_tickets'   => 'required|integer|min:0',
            'half_tickets'   => 'required|integer|min:0',
            'total_price'    => 'required|numeric|min:0',
            'bookingIds'     => 'nullable',
        ]);

        try {
            // Store billing data
            Billing::create([
                'booking_id'    => $validated['booking_id'],
                'movie_id'      => $validated['movie_id'],
                'movie_name'    => $validated['movie_name'],
                'date'          => $validated['date'],
                'time'          => $validated['time'],
                'seat_type'     => $validated['seat_type'],
                'total_tickets' => $validated['total_tickets'],
                'full_tickets'  => $validated['full_tickets'],
                'half_tickets'  => $validated['half_tickets'],
                'total_price'   => $validated['total_price'],
            ]);

               // Optionally, call generateTickets() if needed
            // if (!empty($validated['bookingIds'])) {
            //     try {
            //         $this->generateTickets($validated['bookingIds']);
            //     } catch (\Exception $printEx) {
            //         Log::error("Ticket printing failed: " . $printEx->getMessage());
            //     }
            // }

            // Redirect to the ticket printing view (replace booking.selectSeats if desired)
            return redirect()->route('billing.printTickets', ['bookingIds' => $validated['bookingIds']])
                ->with('success', 'Booking confirmed! Tickets are being printed.');
        } catch (\Exception $e) {
            Log::error('Billing Store Error: ', [
                'message'   => $e->getMessage(),
                'trace'     => $e->getTraceAsString(),
                'validated' => $validated,
            ]);
            return redirect()->back()->withErrors('Failed to store billing data.')->withInput();
        }
    }

    public function index()
    {
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
            'booking_id'     => 'required|exists:bookings,id',
            'movie_id'       => 'required|exists:shows,id',
            'movie_name'     => 'required|string',
            'date'           => 'required',
            'time'           => 'required',
            'seat_type'      => 'required|string',
            'total_tickets'  => 'required|integer|min:1',
            'full_tickets'   => 'required|integer|min:0',
            'half_tickets'   => 'required|integer|min:0',
            'total_price'    => 'required',
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
                'message'   => $e->getMessage(),
                'trace'     => $e->getTraceAsString(),
                'validated' => $validated,
            ]);
            return redirect()->back()->withErrors('Failed to update billing data.')->withInput();
        }
    }

    public function destroy($id)
    {
        // Fetch the billing data by ID
        $billing = Billing::find($id);

        if (!$billing) {
            return redirect()->route('billing.index')->withErrors('Billing data not found.');
        }

        // Delete the billing data
        $billing->delete();

        return redirect()->route('billing.index')->with('success', 'Billing data deleted successfully.');
    }

    public function printTickets($bookingIds)
{
    // Split the comma-separated string into an array of IDs
    $ids = explode(',', $bookingIds);

    // Retrieve bookings from the database (adjust the model and field names as needed)
    $bookings = \App\Models\Booking::whereIn('id', $ids)->get();

    // Return the ticket view with the retrieved booking data
    return view('billings.ticket', compact('bookings'));
}

    
}