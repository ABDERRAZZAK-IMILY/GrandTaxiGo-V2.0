<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TripController;

use App\Http\Controllers\ReservationController;
use App\Models\Trip;
use App\Models\User;
use PHPUnit\Framework\Attributes\Group;

use App\Http\Controllers\SocialiteController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboarddriver', [TripController::class, 'index'])->middleware(['auth', 'verified'])->middleware('role:driver')->name('dashboarddriver');

Route::get(('/dashboardpassenger') , [ReservationController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('/lop', [TripController::class, 'index'])->name('trip.index')->middleware('auth');
Route::get('/lop/create', [TripController::class, 'create'])->name('trip.create')->middleware('auth');
Route::post('/lop', [TripController::class, 'store'])->name('trip.store')->middleware('role:driver')->middleware('auth');



Route::post('/trip/update-availability', [TripController::class, 'updateAvailability'])->name('trip.updateAvailability');

Route::get('/trip/history', [TripController::class, 'showHistoryTrip'])->middleware('role:driver')->name('history');


Route::get('/trip/driverProfile/{id}', [TripController::class, 'showDriverProfile'])->name('trip.driverProfile');


Route::post('/trajet' , [ReservationController::class , 'store'])->name('reservation.store');

Route::post('/accept', [ReservationController::class, 'acceptReservation'])->name('accept');

Route::post('/reject' , [ReservationController::class , 'rejectReservation'])->name('reject');

Route::get('/trajet/show/{id}' , [ReservationController::class , 'show'])->name('show');

Route::get('/myreservations' , [ReservationController::class , 'myreservations'])->name('myreservations');


Route::post('/cancel' , [ReservationController::class , 'cancel'])->name('cancel');

Route::post('/search' , [TripController::class , 'search'])->name('search');

Route::get('/searchpage/{id}' , [ReservationController::class , 'search'])->name('recheche');





Route::post('/session', 'App\Http\Controllers\StripeController@session')->name('session');
Route::get('/success', 'App\Http\Controllers\StripeController@success')->name('success');










    Route::get('auth/{provider}/redirect', [SocialiteController::class, 'redirect'])
    ->name('socialite.redirect');
Route::get('auth/{provider}/callback', [SocialiteController::class, 'callback'])
    ->name('socialite.callback');






Route::get('/admin' , [AdminController::class , 'index'])->name("admin.dashboard");

Route::get('/admin/users' , [AdminController::class , 'users'])->name("admin.users");

Route::get('/admin/user/{id}' , [AdminController::class , 'user'])->name("admin.user");

Route::delete('/admin/user/{id}' , [AdminController::class , 'deleteUser'])->name("admin.deleteUser");

Route::get('/trips' , [AdminController::class , 'trips'])->name('admin.trips');

Route::get('/admin/reservations' , [AdminController::class , 'reservations'])->name('admin.reservations');

Route::get('/admin/revenue' , [AdminController::class , 'revenueReport'])->name('admin.revenue');


use Carbon\Carbon;

Route::get('/test' , function() {

    $current = Carbon::now();

    echo $current;

});


Route::get('/a/{id}' , function($id) {

$user = Trip::find($id);

dd($user->reservations);

});


use App\Http\Controllers\RatingController;


Route::middleware(['auth'])->group(function () {
    Route::get('/rate-driver/{trip_id}', [RatingController::class, 'rateDriver'])->name('ratings.rate_driver');
    Route::get('/rate-passenger/{trip_id}/{user_id}', [RatingController::class, 'ratePassenger'])->name('ratings.rate_passenger');
    Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');
    Route::put('/ratings/{id}', [RatingController::class, 'update'])->name('ratings.update');
    Route::delete('/ratings/{id}', [RatingController::class, 'destroy'])->name('ratings.destroy');
    Route::get('/user/{user_id}/ratings', [RatingController::class, 'userRatings'])->name('ratings.user');
});

Route::get('/user/{id}/profile', [ProfileController::class, 'show'])->name('users.profile');

Route::get('/trip/{id}', [TripController::class, 'show'])->name('trip.show');
Route::get('/trips/{id}', [TripController::class, 'show'])->name('trips.show');




use App\Events\Notification_platform;

Route::get('/notfy' , function(){

    event(new Notification_platform());             

} );



