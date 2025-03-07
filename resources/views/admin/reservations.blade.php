@extends('layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 flex justify-between items-center">
            <h2 class="text-xl font-bold text-white">Reservations</h2>
            <a href="{{ route('admin.dashboard') }}" class="bg-white text-blue-600 px-4 py-2 rounded-md hover:bg-blue-50 transition">
                Back to Dashboard
            </a>
        </div>
        
        <div class="p-6">
            <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                <form method="GET" action="{{ route('admin.reservations') }}" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Filter by Status</label>
                        <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="all" {{ $status == 'all' ? 'selected' : '' }}>All Reservations</option>
                            <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="accepted" {{ $status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="rejected" {{ $status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            @if($reservations->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Reservation ID
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    User
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Trip
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Booking Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($reservations as $reservation)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $reservation->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $reservation->user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $reservation->trip->from_city }} to {{ $reservation->trip->to_city }}
                                    <div class="text-xs text-gray-400">{{ $reservation->trip->departure_time->format('Y-m-d H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($reservation->status == 'pending')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Pending</span>
                                    @elseif($reservation->status == 'accepted')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Accepted</span>
                                    @elseif($reservation->status == 'rejected')
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Rejected</span>
                                    @elseif($reservation->status == 'cancelled')
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">Cancelled</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $reservation->created_at->format('Y-m-d H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        @if($reservation->status == 'pending')
                                            <form action="{{ route('admin.reservation.accept', $reservation->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded text-xs">Accept</button>
                                            </form>
                                            <form action="{{ route('admin.reservation.reject', $reservation->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-xs">Reject</button>
                                            </form>
                                        @else
                                            <a href="{{ route('admin.user', $reservation->user_id) }}" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded text-xs">View User</a>
                                            <a href="{{ route('trip.show', $reservation->trip_id) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white py-1 px-3 rounded text-xs">View Trip</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $reservations->links() }}
                </div>
            @else
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                No reservations found.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 