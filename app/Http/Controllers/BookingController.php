<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Show;
use App\Models\Seat;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::all();
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        return view('bookings.create');
    }

    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'selected_seats' => 'required|json', // Validate selected_seats as JSON array
            'movie_id' => 'required|exists:shows,id',
            'seat_type' => 'required',
            'selected_date' => 'required|date',
            'time' => 'required'
        ]);

        try {
            $show = Show::findOrFail($request->movie_id);
            $selectedSeats = json_decode($request->selected_seats, true); // Decode JSON array of seats

            foreach ($selectedSeats as $seatCode) {
                $seat = Seat::where('seat_code', $seatCode)->firstOrFail();

                Booking::create([
                    'movie_id' => $show->id,
                    'movie_name' => $show->movie_name,
                    'seat_type' => $request->seat_type,
                    'seat_code' => $seatCode,
                    'seat_no' => $seat->seat_no,
                    'date' => $request->selected_date,
                    'time' => $request->time
                ]);
            }
            
        // Save booking-related data in session
        session([
            'movie_id' => $show->id,
            'seat_type' => $request->seat_type,
            'selected_seats_count' => count($selectedSeats),
        ]);
        // Redirect to billing.create route
        return redirect()->route('billing.create')->with('success', 'Booking successfully created!');
            
        } catch (\Exception $e) {
            Log::error('Booking Store Error: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Failed to create booking. ' . $e->getMessage()])
                ->withInput();
        }
    }


    public function show(Booking $booking){
        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking){
        return view('bookings.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'date' => 'required',
            'time' => 'required',
            'movie_id' => 'required',
            'movie_name' => 'required',
            'seat_type' => 'required',
            'seat_no' => 'required',
            'seat_code' => 'required',
        ]);

        $booking->update($request->all());

        return redirect()->route('bookings.index')
            ->with('success', 'Booking updated successfully');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('bookings.index')
            ->with('success', 'Booking deleted successfully');
    }

    public function getShows(Request $request){
        $date = $request->input('date'); // Use `date` from the `shows` table
        $shows = Show::where('date', $date)->get();

        if ($shows->isEmpty()) {
            return response()->json([], 200); // No shows found
        }

        return response()->json($shows, 200); // Return shows
    }



    public function getSeats(Request $request){
        $showId = $request->input('show_id'); // Match `show_id`
        $seatType = $request->input('seat_type'); // Match `seat_type`

        $seats = Seat::where('seat_type', $seatType)->get(); // Filter seats by type
        $bookedSeats = Booking::where('movie_id', $showId) // Match `movie_id` as per `bookings`
                            ->where('seat_type', $seatType)
                            ->pluck('seat_code'); // Fetch booked `seat_code`

        return response()->json(['seats' => $seats, 'bookedSeats' => $bookedSeats]);
    }


    public function selectSeats($id)
{
    $show = Show::findOrFail($id);

    // Fetch booked seats for the selected show
    $bookedSeats = Booking::where('movie_id', $show->id)
        ->pluck('seat_code')
        ->toArray();

    return view('bookings.select_seats', compact('show', 'bookedSeats'));
}

    public function detail(){
        return view('bookings.detail');
    }

}
