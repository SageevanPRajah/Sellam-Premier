<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seat;

class SeatController extends Controller
{
    public function index()
    {
        $seats = Seat::all();
        return view('seats.index', ['seats' => $seats]);
    }

    public function create()
    {
        return view('seats.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'seat_code' => 'required',
            'seat_no' => 'required',
            'seat_type' => 'required',
            'seat_letter' => 'required',
            'seat_digit' => 'required',
        ]);

        $newSeat = Seat::create($data);

        return redirect(route('seat.index'));
    }

    public function detail(Seat $seat){
        return view('seats.detail', ['seat' => $seat]);
    }
}
