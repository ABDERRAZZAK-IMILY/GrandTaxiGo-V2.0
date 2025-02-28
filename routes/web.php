<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TripController;

use App\Http\Controllers\ReservationController;
use App\Models\Trip;
use App\Models\User;
use PHPUnit\Framework\Attributes\Group;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboarddriver', [TripController::class, 'index'])->middleware(['auth', 'verified'])->middleware('role:driver')->name('dashboard');

Route::get(('/dashboardpassenger') , [ReservationController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('/lop', [TripController::class, 'index'])->name('trip.index')->middleware('auth');
Route::get('/lop/create', [TripController::class, 'create'])->name('trip.create')->middleware('auth');
Route::post('/lop', [TripController::class, 'store'])->name('trip.store')->middleware('auth');



Route::post('/trip/update-availability', [TripController::class, 'updateAvailability'])->name('trip.updateAvailability');

Route::get('/trip/history', [TripController::class, 'showHistoryTrip'])->middleware('role:driver')->name('history');


Route::get('/trip/driverProfile/{id}', [TripController::class, 'showDriverProfile'])->name('trip.driverProfile');


Route::post('/trajet' , [ReservationController::class , 'store'])->name('reservation.store');

Route::post('/accept', [ReservationController::class, 'acceptReservation'])->name('accept');

Route::post('/reject' , [ReservationController::class , 'rejectReservation'])->name('reject');

Route::get('/trajet/show/{id}' , [ReservationController::class , 'show'])->name('show');



Route::post('/search' , [TripController::class , 'search'])->name('search');

Route::get('/searchpage/{id}' , [ReservationController::class , 'search'])->name('recheche');

use Carbon\Carbon;

Route::get('/test' , function() {

    $current = Carbon::now();

    echo $current;

});


Route::get('/a/{id}' , function($id) {

$user = Trip::find($id);

dd($user->reservations);

});