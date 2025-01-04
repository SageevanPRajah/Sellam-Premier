<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Show;
use App\Models\Price;

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






}
