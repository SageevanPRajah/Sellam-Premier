<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Show;
use App\Models\Seat;

class BookingController extends Controller
{
    public function index(){
        $bookings = Booking::all();
        return view('bookings.index', compact('bookings'));
    }

    public function create(){
        return view('bookings.create');
    }

    // Store booking when user selects seats designated for a show
    public function store(Request $request){
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
            $createdBookings = []; // Store created booking IDs

            if (is_array($selectedSeats) && count($selectedSeats) > 0) {
                foreach ($selectedSeats as $seatCode) {
                    $seat = Seat::where('seat_code', $seatCode)->firstOrFail();
    
                    $booking = Booking::create([
                        'movie_id' => $show->id,
                        'movie_name' => $show->movie_name,
                        'seat_type' => $request->seat_type,
                        'seat_code' => $seatCode,
                        'seat_no' => $seat->seat_no,
                        'date' => $request->selected_date,
                        'name' => Auth::user()->name,
                        'time' => $request->time,
                    ]);
    
                    // Add the booking ID to the array
                    $createdBookings[] = $booking->id;
                }
            } else {
                return redirect()->back()
                    ->withErrors(['error' => 'No seats selected. Please select at least one seat.'])
                    ->withInput();
            }
            
        // Save booking-related data in session
        session([
            'movie_id' => $show->id,
            'seat_type' => $request->seat_type,
            'selected_seats_count' => count($selectedSeats),
            'created_booking_ids' => $createdBookings,
        ]);

        // Check which button was pressed
        if ($request->has('confirm_booking')) {
            // Redirect to billing.create route
            return redirect()->route('billing.create')->with('success', 'Booking successfully created!');
        } elseif ($request->has('reserve_seats')) {
            // Redirect to booking.edit route with booking IDs
            return redirect()->route('booking.edit', ['ids' => implode(',', $createdBookings)])
                ->with('success', 'Seats reserved successfully!');
        }
            
        } catch (\Exception $e) {
            Log::error('Booking Store Error: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Failed to create booking. ' . $e->getMessage()])
                ->withInput();
        }
    }

    // reserved booking view
    public function show(){
        $bookings = Booking::all();
        return view('bookings.show', compact('bookings'));
    }

    // reserved booking conform or cancel
    public function updateSelected(Request $request){
        $validated = $request->validate([
            'booking_ids' => 'required|array',
            'action' => 'required|string', // Either 'confirm' or 'cancel'
        ]);

        $bookingIds = $validated['booking_ids'];

        if ($validated['action'] === 'confirm') {
            // Update the status of selected bookings
            Booking::whereIn('id', $bookingIds)->update(['status' => true]);
            
            // Redirect to billing page with the count of selected tickets
            $selectedSeatsCount = count($bookingIds);
            session(['selected_seats_count' => $selectedSeatsCount]);

            return redirect()->route('billing.create')->with('success', 'Booking confirmed.');
        } elseif ($validated['action'] === 'cancel') {
            // Delete the selected bookings
            Booking::whereIn('id', $bookingIds)->delete();

            return redirect()->route('booking.show')->with('success', 'Selected bookings have been canceled.');
        }

        return redirect()->back()->withErrors(['error' => 'Invalid action.']);
    }

    //going add reservation number and name
    public function edit(Request $request){
        $bookingIds = explode(',', $request->query('ids')); // Get booking IDs from query string
        $bookings = Booking::whereIn('id', $bookingIds)->get();

        if ($bookings->isEmpty()) {
            return redirect()->route('booking.index')->withErrors('No bookings found for editing.');
        }

        return view('bookings.edit', compact('bookings'));
    }


    //Add reservartion number and name
    public function bulkUpdate(Request $request){
        $validated = $request->validate([
            'booking_ids' => 'required|array', // Array of booking IDs to update
            'phone' => 'nullable|string',
            'name' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        try {
            $bookingIds = $validated['booking_ids'];

            // Fetch the movie_id from the first booking (assuming all bookings are for the same movie)
            $movieId = Booking::find($bookingIds[0])->movie_id;

            // Update all selected bookings with the same values
            Booking::whereIn('id', $bookingIds)->update([
                'phone' => $validated['phone'] ?? 'Counter booking',
                'name' => $validated['name'] ?? 'Counter booking',
                'status' => $validated['status'] ?? true,
            ]);

            // Redirect to the 'selectSeats' route with the movie_id
            return redirect()->route('booking.selectSeats', ['id' => $movieId])
            ->with('success', 'Bookings updated successfully!');
        } catch (\Exception $e) {
            Log::error('Bulk Update Error: ' . $e->getMessage());
            return redirect()->back()->withErrors('Failed to update bookings: ' . $e->getMessage());
        }
    }


    public function destroy(Booking $booking){
        $booking->delete();

        return redirect()->route('bookings.index')
            ->with('success', 'Booking deleted successfully');
    }

    // Get shows based on the selected date helping seat selection
    public function getShows(Request $request){
        $date = $request->input('date'); // Use `date` from the `shows` table
        $shows = Show::where('date', $date)->get();

        if ($shows->isEmpty()) {
            return response()->json([], 200); // No shows found
        }

        return response()->json($shows, 200); // Return shows
    }

    // Get seats based on the selected show and seat type helping seat selecting 
    public function getSeats(Request $request){
        $showId = $request->input('show_id'); // Match `show_id`
        $seatType = $request->input('seat_type'); // Match `seat_type`

        $seats = Seat::where('seat_type', $seatType)->get(); // Filter seats by type
        $bookedSeats = Booking::where('movie_id', $showId) // Match `movie_id` as per `bookings`
                            ->where('seat_type', $seatType)
                            ->pluck('seat_code'); // Fetch booked `seat_code`

        return response()->json(['seats' => $seats, 'bookedSeats' => $bookedSeats]);
    }

    // Select seats for a show picture logic 
    public function selectSeats($id){
        $show = Show::findOrFail($id);

        // Fetch booked seats with status for the selected show
        $bookedSeats = Booking::where('movie_id', $show->id)
            ->select('seat_code', 'status') // Fetch seat_code and status
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->seat_code => $item->status]; // Example: ["A1" => true, "A2" => false]
            })
            ->toArray();

        return view('bookings.select_seats', compact('show', 'bookedSeats'));
    }


    public function detail(){
        return view('bookings.detail');
    }

    public function overview(){
        return view('bookings.overview');
    }

    public function getSeatCounts(Request $request)
    {
        try {
            $showId = $request->input('show_id');
            if (!$showId) {
                return response()->json(['error' => 'Show ID is required.'], 400);
            }

            Log::info("Fetching seat counts for show_id: $showId");

            // Define total seats for each seat type
            $totalSeats = [
                'Gold'      => 182,
                'Silver'    => 50,
                'Platinum'  => 19,
            ];

            // We'll gather booked & reserved seats from the `bookings` table
            $seatCounts = [];

            // For each seat type, figure out how many are "booked" (status = true) 
            // and how many are "reserved" (status = false).
            foreach ($totalSeats as $type => $total) {
                // Booked count
                $bookedCount = Booking::where('movie_id', $showId)
                    ->where('seat_type', $type)
                    ->where('status', true)    // true => "booked"
                    ->count();

                // Reserved count
                $reservedCount = Booking::where('movie_id', $showId)
                    ->where('seat_type', $type)
                    ->where('status', false)   // false => "reserved"
                    ->count();

                // Available = total - (booked + reserved)
                $availableCount = $total - ($bookedCount + $reservedCount);

                $seatCounts[$type] = [
                    'booked'    => $bookedCount,
                    'reserved'  => $reservedCount,
                    'available' => $availableCount,
                ];
            }

            // Return array of seat counts keyed by seat type
            return response()->json($seatCounts, 200);
        } catch (\Exception $e) {
            Log::error('Error in getSeatCounts: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching seat counts.'], 500);
        }
    }

    public function clone(){
        return view('bookings.clone');
    }

    public function cloneSeats($id){
        $show = Show::findOrFail($id);

        // Fetch booked seats with status for the selected show
        $bookedSeats = Booking::where('movie_id', $show->id)
            ->select('seat_code', 'status') // Fetch seat_code and status
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->seat_code => $item->status]; // Example: ["A1" => true, "A2" => false]
            })
            ->toArray();

        return view('bookings.clone_seats', compact('show', 'bookedSeats'));
    }

    public function platinumSeats($id){
        $show = Show::findOrFail($id);

        // Fetch booked seats with status for the selected show
        $bookedSeats = Booking::where('movie_id', $show->id)
            ->select('seat_code', 'status') // Fetch seat_code and status
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->seat_code => $item->status]; // Example: ["A1" => true, "A2" => false]
            })
            ->toArray();

        return view('bookings.platinum_seats', compact('show', 'bookedSeats'));
    }

    public function goldSeats($id){
        $show = Show::findOrFail($id);

        // Fetch booked seats with status for the selected show
        $bookedSeats = Booking::where('movie_id', $show->id)
            ->select('seat_code', 'status') // Fetch seat_code and status
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->seat_code => $item->status]; // Example: ["A1" => true, "A2" => false]
            })
            ->toArray();

        return view('bookings.gold_seats', compact('show', 'bookedSeats'));
    }

    // view reaction of cancel or reprint
    public function reaction(){
        $bookings = Booking::all();
        return view('bookings.reaction', compact('bookings'));
    }

    //reaction of cancel or reprint
    public function actionSelected(Request $request){
        $validated = $request->validate([
            'booking_ids' => 'required|array',
            'action' => 'required|string', // Either 'confirm' or 'cancel'
        ]);

        $bookingIds = $validated['booking_ids'];

        if ($validated['action'] === 'confirm') {
            // Update the status of selected bookings
            Booking::whereIn('id', $bookingIds)->update(['status' => true]);
            
            // Redirect to billing page with the count of selected tickets
            $selectedSeatsCount = count($bookingIds);
            session(['selected_seats_count' => $selectedSeatsCount]);

            return redirect()->route('billing.create')->with('success', 'Booking confirmed.');
        } elseif ($validated['action'] === 'cancel') {
            // Delete the selected bookings
            Booking::whereIn('id', $bookingIds)->delete();

            return redirect()->route('bookings.reaction')->with('success', 'Selected bookings have been canceled.');
        }

        return redirect()->back()->withErrors(['error' => 'Invalid action.']);
    }

}
