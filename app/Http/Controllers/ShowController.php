<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Show;

class ShowController extends Controller
{
    public function index()
    {
        $shows = Show::all();
        return view('shows.index', ['shows' => $shows]);
    }

    public function create()
    {
        return view('shows.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required',
            'time' => 'required',
            'movie_code' => 'required',
            'movie_name' => 'required',
            'poster' => 'required|string',
        ]);

        $newShow = Show::create($data);

        return redirect(route('show.index'));
    }

    public function edit(Show $show){
        return view('shows.edit', ['show' => $show]);
    }

    public function update(Show $show, Request $request){
        $data = $request->validate([
            'date' => 'required',
            'time' => 'required',
            'movie_code' => 'required',
            
        ]);

        $show->update($data);

        return redirect(route('show.index'))->with('success', 'Show Updated Successfully');
    }

    public function destroy(Show $show){
        $show->delete();
        return redirect(route('show.index'))->with('success', 'Show Deleted Successfully');
    }

    public function detail(Show $show){
        return view('shows.detail', ['show' => $show]);
    }
}
