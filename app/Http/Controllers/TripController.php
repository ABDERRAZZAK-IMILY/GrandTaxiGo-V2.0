<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\User;


class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $trips = Cache::remember('driver_trips_' . $userId, 60 * 5, function () use ($userId) {
            return Trip::where('driver_id', $userId)
                ->with(['reservations', 'reservations.user'])
                ->orderBy('departure_time', 'desc')
                ->get();
        });
     
        return view('trip.index', compact('trips'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'departure_location' => 'required|string',
            'destination' => 'required|string',
            'departure_time' => 'required|date',
            'available_seats' => 'required|integer',
        ]);

        $data['driver_id'] = Auth::id();
        Trip::create($data);

        Cache::forget('driver_trips_' . Auth::id());

        return redirect()->back()->with('success', 'Trip created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $trip = Trip::findOrFail($id);
        
        $pendingReservations = $trip->reservations()->where('status', 'pending')->get();
        
        return view('trip.show', compact('trip', 'pendingReservations'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function showHistoryTrip(){
        $userId = Auth::id();
        $tripHistory = Cache::remember('driver_history_' . $userId, 60 * 10, function () use ($userId) {
            return Trip::where('driver_id', $userId)
                ->with(['reservations', 'reservations.user'])
                ->orderBy('departure_time', 'desc')
                ->get();
        });
        
        $pendingReservations = Reservation::whereHas('trip', function($query) use ($userId) {
            $query->where('driver_id', $userId);
        })->where('status', 'pending')
          ->with(['trip', 'user'])
          ->orderBy('created_at', 'desc')
          ->get();
        
        return view('trip.history', compact('tripHistory', 'pendingReservations'));
    }

    public function showDriverProfile($id)
    {
        $driver = Cache::remember('driver_profile_' . $id, 60 * 30, function () use ($id) {
            return User::with(['ratings', 'trips'])
                ->where('id', $id)
                ->where('role', 'driver')
                ->firstOrFail();
        });
        
        return view('trip.driver_profile', compact('driver'));
    }

    public function updateAvailability(Request $request)
    {
        $trip = Trip::findOrFail($request->trip_id);
        $trip->available_seats = $request->available_seats;
        $trip->save();
        
        Cache::forget('driver_trips_' . $trip->driver_id);
        
        return redirect()->back()->with('success', 'Availability updated successfully');
    }

    public function search(Request $request)
    {
        $cacheKey = 'search_results_' . md5($request->location . '_' . $request->destination);
        
        $drivers = Cache::remember($cacheKey, 60 * 5, function () use ($request) {
            return User::where('role', 'driver')
                ->whereHas('trips', function($query) use ($request) {
                    $query->where('departure_location', 'LIKE', "%{$request->location}%")
                          ->where('destination', 'LIKE', "%{$request->destination}%");
                })
                ->with(['trips' => function($query) use ($request) {
                    $query->where('departure_location', 'LIKE', "%{$request->location}%")
                          ->where('destination', 'LIKE', "%{$request->destination}%")
                          ->where('departure_time', '>', now())
                          ->where('available_seats', '>', 0)
                          ->orderBy('departure_time', 'asc');
                }, 'ratings'])
                ->get();
        });

        return view('search', compact('drivers'));
    }

}
