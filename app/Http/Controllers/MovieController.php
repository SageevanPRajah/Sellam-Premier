<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    public function index(){
        $movies = Movie::all();
        return view('movies.index', ['movies' => $movies]);
    }

    public function create(){
        return view('movies.create');
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'trailer_link' => 'required',
            'duration' => 'required|numeric',
            'release_date' => 'required',
            'imdb_link' => 'required'
        ]);

        $newMovie = Movie::create($data);

        return redirect(route('movie.index'));
    }

    public function edit(Movie $movie){
        return view('movies.edit', ['movie' => $movie]);
    }

    public function update(Movie $movie, Request $request){
        $data = $request->validate([
            'name' => 'required',
            'trailer_link' => 'required',
            'duration' => 'required|numeric',
            'release_date' => 'required',
            'imdb_link' => 'required',
            'active' => 'required'
        ]);

        $movie->update($data);

        return redirect(route('movie.index'))->with('success', 'Movie Updated Successfully');
    }

    public function destroy(Movie $movie){
        $movie->delete();
        return redirect(route('movie.index'))->with('success', 'Movie Deleted Successfully');
    }

    public function detail(Movie $movie){
        return view('movies.detail', ['movie' => $movie]);
    }
}
