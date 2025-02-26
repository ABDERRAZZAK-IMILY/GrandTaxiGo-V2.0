<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Reservation;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;
class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trips =   Trip::all();
        return view('reservation.index' , compact('trips'));
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
            'trip_id' => 'required|integer'
        ]);

        $data['user_id'] = Auth::id();
        
        Reservation::create($data);

        return redirect()->back()->with('success', 'Reservation created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Reservation::find($id);

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
}
