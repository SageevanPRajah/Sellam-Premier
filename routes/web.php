<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

Route::get('/', function () {
    return view('welcome');
});

    //Route Movie
    Route::get('/movie',[MovieController::class, 'index'])->name('movie.index');
    Route::get('/movie/create',[MovieController::class, 'create'])->name('movie.create');
    Route::post('/movie',[MovieController::class, 'store'])->name('movie.store');
    Route::get('/movie/{movie}/edit',[MovieController::class, 'edit'])->name('movie.edit');
    Route::put('/movie/{movie}/update',[MovieController::class, 'update'])->name('movie.update');
    Route::delete('/movie/{movie}/destroy',[MovieController::class, 'destroy'])->name('movie.destroy');
    Route::get('/movie/{movie}/detail',[MovieController::class, 'detail'])->name('movie.detail');
