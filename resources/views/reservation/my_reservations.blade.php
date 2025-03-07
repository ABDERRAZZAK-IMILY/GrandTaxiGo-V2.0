@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4" dir="ltr">
    <div class="flex justify-center">
        <div class="w-full">
            <div class="bg-white rounded-lg shadow-md">
                <div class="border-b p-4">
                    <h4 class="text-xl font-bold">My Reservations</h4>
                </div>
                <div class="p-4">
                    @if($reservations->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse border border-gray-200">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="border p-2">Reservation ID</th>
                                        <th class="border p-2">From</th>
                                        <th class="border p-2">To</th>
                                        <th class="border p-2">Date & Time</th>
                                        <th class="border p-2">Seats</th>
                                        <th class="border p-2">Status</th>
                                        <th class="border p-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservations as $reservation)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border p-2">{{ $reservation->id }}</td>
                                        <td class="border p-2">{{ $reservation->trip->departure_location }}</td>
                                        <td class="border p-2">{{ $reservation->trip->destination }}</td>
                                        <td class="border p-2">{{ $reservation->trip->departure_time }}</td>
                                        <td class="border p-2">{{ $reservation->trip->available_seats }}</td>
                                        <td class="border p-2">
                                            @if($reservation->status == 'pending')
                                                <span class="px-2 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @elseif($reservation->status == 'accepted')
                                                <span class="px-2 py-1 text-sm rounded-full bg-green-100 text-green-800">Confirmed</span>
                                            @elseif($reservation->status == 'cancelled')
                                                <span class="px-2 py-1 text-sm rounded-full bg-red-100 text-red-800">Cancelled</span>
                                            @endif
                                        </td>
                                        <td class="border p-2">
                                            @if($reservation->status == 'pending')
                                                <form action="" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm">
                                                        Cancel
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('show', $reservation->id) }}" class="bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded text-sm mr-2">
                                                Details
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-blue-100 text-blue-800 p-4 text-center rounded">
                            No reservations found
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection