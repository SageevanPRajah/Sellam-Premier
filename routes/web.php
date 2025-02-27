<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\MovieController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BillingController;



Route::get('/', function () {
    return view('welcome');
});



Route::get('storage/{filename}', function ($filename) {
    $path = storage_path('app/public/' . $filename); // Changed to check in storage/app/public

    if (file_exists($path)) {
        return response()->file($path);
    }
    abort(404);
});

Route::get('storage/posters/{filename}', function ($filename) {
    $path = storage_path('app/public/posters/' . $filename);
    if (file_exists($path)) {
        return response()->file($path);
    }
    abort(404);
});


Route::get('/sellam', function () {
    return view('sellam');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Route Movie
    Route::get('/movie',[MovieController::class, 'index'])->name('movie.index');
    Route::get('/movie/create',[MovieController::class, 'create'])->name('movie.create');
    Route::post('/movie',[MovieController::class, 'store'])->name('movie.store');
    Route::get('/movie/{movie}/edit',[MovieController::class, 'edit'])->name('movie.edit');
    Route::put('/movie/{movie}/update',[MovieController::class, 'update'])->name('movie.update');
    Route::delete('/movie/{movie}/destroy',[MovieController::class, 'destroy'])->name('movie.destroy');
    Route::get('/movie/{movie}/detail',[MovieController::class, 'detail'])->name('movie.detail');
    Route::get('/movie/{movie}/inspect',[MovieController::class, 'inspect'])->name('movie.inspect');

    //Route Show
    Route::get('/show',[ShowController::class, 'index'])->name('show.index');
    Route::get('/show/create',[ShowController::class, 'create'])->name('show.create');
    Route::post('/show',[ShowController::class, 'store'])->name('show.store');
    Route::get('/show/{show}/edit',[ShowController::class, 'edit'])->name('show.edit');
    Route::put('/show/{show}/update',[ShowController::class, 'update'])->name('show.update');
    Route::delete('/show/{show}/destroy',[ShowController::class, 'destroy'])->name('show.destroy');
    Route::get('/show/{show}/detail',[ShowController::class, 'detail'])->name('show.detail');

    //Route Price
    Route::get('/price',[PriceController::class, 'index'])->name('price.index');
    Route::get('/price/create',[PriceController::class, 'create'])->name('price.create');
    Route::post('/price',[PriceController::class, 'store'])->name('price.store');
    Route::get('/price/{price}/edit',[PriceController::class, 'edit'])->name('price.edit');
    Route::put('/price/{price}/update',[PriceController::class, 'update'])->name('price.update');

    //Route Booking
    Route::get('/booking',[BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/create',[BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking',[BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/edit',[BookingController::class, 'edit'])->name('booking.edit');
    Route::post('/bookings/bulk-update', [BookingController::class, 'bulkUpdate'])->name('booking.bulkUpdate');
    Route::delete('/booking/{booking}/destroy',[BookingController::class, 'destroy'])->name('booking.destroy');
    Route::get('/booking/detail',[BookingController::class, 'detail'])->name('booking.detail');
    Route::get('/booking/show',[BookingController::class, 'show'])->name('booking.show');
    Route::post('/bookings/update-selected', [BookingController::class, 'updateSelected'])->name('bookings.updateSelected');

    Route::get('/booking/create/clone',[BookingController::class, 'clone'])->name('booking.clone');

    //Route Booking Get Shows and Seats
    Route::post('/booking/shows', [BookingController::class, 'getShows'])->name('booking.getShows');
    Route::post('/booking/seats', [BookingController::class, 'getSeats'])->name('booking.getSeats');

    // Route for the booking overview page
    Route::get('/booking/overview', [BookingController::class, 'overview'])->name('booking.overview');
    // Route to fetch seat counts for a specific show
    Route::post('/booking/overview/get-seat-counts', [BookingController::class, 'getSeatCounts'])->name('booking.getSeatCounts');

    //Route Billing
    Route::get('/billing',[BillingController::class, 'index'])->name('billing.index');
    Route::get('/billing/create', [BillingController::class, 'create'])->name('billing.create');
    Route::post('/billing', [BillingController::class, 'store'])->name('billing.store');
    

    //Route Billing Generate Tickets
    Route::get('/billing/tickets/{bookingIds}', [BillingController::class, 'printTickets'])->name('billing.printTickets');


    //Route Booking Select Seats
    Route::get('/booking/create/{id}', [BookingController::class, 'selectSeats'])->name('booking.selectSeats');
    Route::get('/booking/create/clone/{id}', [BookingController::class, 'cloneSeats'])->name('booking.cloneSeats');
    Route::get('/booking/create/platinum/{id}', [BookingController::class, 'platinumSeats'])->name('booking.platinumSeats');
    Route::get('/booking/create/gold/{id}', [BookingController::class, 'goldSeats'])->name('booking.goldSeats');

});

Route::get('/admin/dashboard', [AdminController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.dashboard');

Route::middleware(['auth', 'admin'])->group(function (){

    //Only admin and superadmin can access this route

    //Route Seat
    Route::get('/seat',[SeatController::class, 'index'])->name('seat.index');
    Route::get('/seat/create',[SeatController::class, 'create'])->name('seat.create');
    Route::post('/seat',[SeatController::class, 'store'])->name('seat.store');
    Route::get('/seat/{seat}/detail',[SeatController::class, 'detail'])->name('seat.detail');

    // reaction of cancel or reprint
    Route::get('/booking/reaction', [BookingController::class, 'reaction'])->name('booking.reaction');
    Route::post('/booking/action-selected', [BookingController::class, 'actionSelected'])->name('booking.actionSelected');

    //Route Billing 
    Route::get('/billing/{billing}/edit', [BillingController::class, 'edit'])->name('billing.edit');
    Route::put('/billing/{billing}/update', [BillingController::class, 'update'])->name('billing.update');
    Route::delete('/billing/{billing}/destroy', [BillingController::class, 'destroy'])->name('billing.destroy');
    Route::get('/billing/{billing}/detail', [BillingController::class, 'detail'])->name('billing.detail');
    
});

Route::get('/superadmin/dashboard', [SuperadminController::class, 'index'])->middleware(['auth', 'superadmin'])->name('superadmin.dashboard');

Route::middleware(['auth', 'superadmin'])->group(function (){

    //Only superadmin can access this route
    
    
});


require __DIR__.'/auth.php';


