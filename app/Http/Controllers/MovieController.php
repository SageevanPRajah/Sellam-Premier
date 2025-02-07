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
            'poster' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trailer_link' => 'required',
            'duration' => 'required|numeric',
            'release_date' => 'required',
            'imdb_link' => 'required'
        ]);

        // Handle file upload directly to public folder
    if ($request->hasFile('poster')) {
        // Create a unique filename based on time
        $fileName = time() . '.' . $request->file('poster')->getClientOriginalExtension();
        
        // Move the file to public/posters
        $request->file('poster')->move(public_path('posters'), $fileName);
        
        // Update the $data array to store the path or filename
        $data['poster'] = 'posters/' . $fileName;
    }

    // Create a new movie with the validated data, including the poster path
    Movie::create($data);

    return redirect(route('movie.index'))->with('success', 'Movie added successfully!');
    }

    public function edit(Movie $movie){
        return view('movies.edit', ['movie' => $movie]);
    }

    public function update(Movie $movie, Request $request){
        $data = $request->validate([
            'name' => 'required',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trailer_link' => 'required',
            'duration' => 'required|numeric',
            'release_date' => 'required',
            'imdb_link' => 'required',
            'active' => 'required'
        ]);

        // Check if a new poster is uploaded
    if ($request->hasFile('poster')) {
        // Delete the old poster file, if it exists
        if ($movie->poster && file_exists(storage_path('app/public/' . $movie->poster))) {
            unlink(storage_path('app/public/' . $movie->poster));
        }

        // Store the new poster and update the poster path
        $data['poster'] = $request->file('poster')->store('posters', 'public');
    }

    // Update the movie with the new data
    $movie->update($data);

    return redirect(route('movie.index'))->with('success', 'Movie updated successfully!');
    }

    public function destroy(Movie $movie){
        $movie->delete();
        return redirect(route('movie.index'))->with('success', 'Movie Deleted Successfully');
    }

    public function detail(Movie $movie){
        return view('movies.detail', ['movie' => $movie]);
    }

    public function inspect(Movie $movie){
        // Fetch all movies
        $movies = Movie::all();

        // Find the current movie's index
        $currentIndex = $movies->search(function ($m) use ($movie) {
            return $m->id === $movie->id;
        });

        // Pass all movies and the current index to the view
        return view('movies.inspect', [
            'movie' => $movie,
            'movies' => $movies,
            'currentIndex' => $currentIndex,
        ]);
    }
}

