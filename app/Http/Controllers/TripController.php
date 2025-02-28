<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\User;


class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     
         return view('trip.index');
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

        return redirect()->back()->with('success', 'Trip created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
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

         $pendingReservations = Reservation::all();
         $tripHistory = Trip::all();

        return view('trip.history' , compact('pendingReservations') , compact('tripHistory'));
    }

    public function showDriverProfile($id)
    {
         $driver = \App\Models\User::find($id);
        return view('trip.profile', compact('driver'));
    }




public function updateAvailability(Request $request)
{
     /** @var \App\Models\User $user */
    $user = Auth::user();
    $user->is_available = $request->is_available;
    $user->save();

    return response()->json(['success' => true, 'status' => $user->is_available]);

}


public function search(Request $request)
{
    $drivers = User::where('role', 'driver')
        ->whereHas('trips', function($query) use ($request) {
            $query->where('departur_location', 'LIKE', "%{$request->location}%")
                  ->where('destination', 'LIKE' , "%{$request->destination}%");
        })->get();

    return view('search', compact('drivers'));
}

}
