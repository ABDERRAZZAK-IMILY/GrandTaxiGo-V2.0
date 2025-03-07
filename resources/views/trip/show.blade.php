@extends('layouts.app')

@section('content')

<script src="https://cdn.tailwindcss.com"></script>

<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 flex justify-between items-center">
            <h2 class="text-xl font-bold text-white">Trip Details</h2>
            <div class="flex space-x-2">
                @if(auth()->user() && auth()->user()->role === 'driver' && $trip->driver_id === auth()->id())
                    <a href="{{ route('dashboard') }}" class="bg-white text-yellow-600 px-4 py-2 rounded-md hover:bg-yellow-50 transition">
                        Return to Dashboard
                    </a>
                @elseif(auth()->user() && auth()->user()->role === 'admin')
                    <a href="{{ route('admin.trips') }}" class="bg-white text-yellow-600 px-4 py-2 rounded-md hover:bg-yellow-50 transition">
                        Back to Trip List
                    </a>
                @else
                    <a href="{{ url()->previous() }}" class="bg-white text-yellow-600 px-4 py-2 rounded-md hover:bg-yellow-50 transition">
                        Back
                    </a>
                @endif
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-yellow-50 rounded-lg p-6 shadow">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Trip Information</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Departure Point:</span>
                            <span class="font-semibold">{{ $trip->departure_location }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Destination:</span>
                            <span class="font-semibold">{{ $trip->destination }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Departure Date & Time:</span>
                            <span class="font-semibold">{{ $trip->departure_time->format('Y-m-d H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Available Seats:</span>
                            <span class="font-semibold">{{ $trip->available_seats }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Trip Status:</span>
                            <span class="font-semibold">
                                @if($trip->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">Pending</span>
                                @elseif($trip->status == 'active')
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Active</span>
                                @elseif($trip->status == 'accepted')
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">Completed</span>
                                @elseif($trip->status == 'cancelled')
                                    <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">Cancelled</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-yellow-50 rounded-lg p-6 shadow">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Driver Information</h3>
                    
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 rounded-full bg-yellow-200 flex items-center justify-center mr-4">
                            <span class="text-2xl font-bold text-yellow-600">{{ substr($trip->driver->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold">{{ $trip->driver->name }}</h4>
                            <div class="flex items-center">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($trip->driver->average_rating ?? 0))
                                            <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-500 ml-1">({{ $trip->driver->average_rating ?? 0 }})</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection 