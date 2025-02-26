<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TripController;
use App\Models\Reservation;
use App\Models\Trip;

use App\Http\Controllers\ReservationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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

Route::get('/trip/histrory' , [TripController::class , 'showHistoryTrip']);

Route::get('/trip/driverProfile/{id}', [TripController::class, 'showDriverProfile'])->name('trip.driverProfile');

Route::get(('trajet') , [ReservationController::class, 'index'])->name('reservation.index');

Route::post('/reservation' , [ReservationController::class , 'store'])->name('reservation.store');

Route::patch('/trip/history', [ReservationController::class, 'acceptReservation'])->name('accept');

Route::post('/reservation' , [ReservationController::class , 'rejectResevation'])->name('reservation.reject');