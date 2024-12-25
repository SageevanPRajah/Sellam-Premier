<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Price;

class PriceController extends Controller
{
    public function index(){
        $prices = Price::all();
        return view('prices.index', ['prices' => $prices]);
    }

    public function create(){
        return view('prices.create');
    }

    public function store(Request $request){
        $data = $request->validate([
            'seat_type' => 'required',
            'seat_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'full_price' => 'required|decimal:0,2',
            'half_price' => 'required|decimal:0,2',
        ]);

        // Handle file upload
    if ($request->hasFile('seat_logo')) {
        $data['seat_logo'] = $request->file('seat_logo')->store('seat_logos', 'public');
    }

        Price::create($data);

        return redirect(route('price.index'))->with('success', 'Price added successfully!');
    }

    public function edit(Price $price){
        return view('prices.edit', ['price' => $price]);
    }

    public function update(Price $price, Request $request){
        $data = $request->validate([
            'seat_type' => 'required',
            'full_price' => 'required|decimal:0,2',
            'half_price' => 'required|decimal:0,2',
        ]);

        // Check if a new poster is uploaded
    if ($request->hasFile('seat_logo')) {
        // Delete the old poster file, if it exists
        if ($price->seat_logo && file_exists(storage_path('app/public/' . $price->seat_logo))) {
            unlink(storage_path('app/public/' . $price->seat_logo));
        }

        // Store the new poster and update the poster path
        $data['seat_logo'] = $request->file('seat_logo')->store('seat_logos', 'public');
    }

        $price->update($data);

        return redirect(route('price.index'))->with('success', 'Price updated successfully!');
    }
}
