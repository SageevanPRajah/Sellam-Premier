<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ShowController;

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

    //Route Show
    Route::get('/show',[ShowController::class, 'index'])->name('show.index');
    Route::get('/show/create',[ShowController::class, 'create'])->name('show.create');
    Route::post('/show',[ShowController::class, 'store'])->name('show.store');
    Route::get('/show/{show}/edit',[ShowController::class, 'edit'])->name('show.edit');
    Route::put('/show/{show}/update',[ShowController::class, 'update'])->name('show.update');
    Route::delete('/show/{show}/destroy',[ShowController::class, 'destroy'])->name('show.destroy');
    Route::get('/show/{show}/detail',[ShowController::class, 'detail'])->name('show.detail');
