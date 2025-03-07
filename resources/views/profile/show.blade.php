@extends('layouts.app')

@section('content')

<script src="https://cdn.tailwindcss.com"></script>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-yellow-500 text-white px-6 py-4">
                <h2 class="text-xl font-bold">Profile</h2>
            </div>
            
            <div class="p-6">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/3 mb-6 md:mb-0 md:mr-6">
                        <div class="bg-gray-100 rounded-lg p-6 text-center">
                            <div class="w-24 h-24 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-500 mx-auto mb-4">
                                <i class="fas fa-user text-4xl"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-2">{{ $user->name }}</h3>
                            
                            @if($user->role === 'driver')
                                <div class="bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full inline-block mb-2">
                                    <i class="fas fa-car mr-1"></i> Driver
                                </div>
                            @elseif($user->role === 'passenger')
                                <div class="bg-green-100 text-green-800 text-sm font-semibold px-3 py-1 rounded-full inline-block mb-2">
                                    <i class="fas fa-user mr-1"></i> Passenger
                                </div>
                            @elseif($user->role === 'admin')
                                <div class="bg-purple-100 text-purple-800 text-sm font-semibold px-3 py-1 rounded-full inline-block mb-2">
                                    <i class="fas fa-user-shield mr-1"></i> Admin
                                </div>
                            @endif
                            
                            <p class="text-gray-500 mb-4">{{ $user->email }}</p>
                            
                            <div class="mb-4">
                                <div class="text-lg font-medium mb-1">Average Rating</div>
                                <div class="flex justify-center mb-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= ($user->average_rating ?? 0) ? 'text-yellow-400' : 'text-gray-300' }} mx-0.5"></i>
                                    @endfor
                                </div>
                                <div class="text-gray-500">{{ number_format($user->average_rating ?? 0, 1) }}/5</div>
                            </div>
                            
                            <div class="text-gray-500 text-sm">
                                <i class="fas fa-calendar-alt mr-1"></i> Joined {{ $user->created_at->format('Y/m/d') }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="md:w-2/3">
                        @if($user->role === 'driver')
                            <div class="mb-6">
                                <h4 class="text-lg font-semibold mb-3 flex items-center">
                                    <i class="fas fa-car mr-2 text-yellow-500"></i> Driver Information
                                </h4>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-gray-600">Phone Number:</p>
                                            <p class="font-medium">{{ $user->driver->phone ?? 'Not provided' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Car Type:</p>
                                            <p class="font-medium">{{ $user->driver->car_model ?? 'Not provided' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">License Plate:</p>
                                            <p class="font-medium">{{ $user->driver->license_plate ?? 'Not provided' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Years of Experience:</p>
                                            <p class="font-medium">{{ $user->driver->years_experience ?? 'Not provided' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="text-lg font-semibold flex items-center">
                                    <i class="fas fa-star mr-2 text-yellow-500"></i> Ratings
                                </h4>
                                <a href="{{ route('ratings.user', $user->id) }}" class="text-yellow-500 hover:text-yellow-700">
                                    View All <i class="fas fa-arrow-right mr-1"></i>
                                </a>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-4">
                                @if($latestRatings->count() > 0)
                                    <div class="space-y-4">
                                        @foreach($latestRatings as $rating)
                                            <div class="border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
                                                <div class="flex items-start">
                                                    <div class="flex-shrink-0 mr-3">
                                                        <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-500">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="flex items-center">
                                                            <h5 class="font-medium">{{ $rating->ratedBy->name }}</h5>
                                                            <div class="ml-2 flex">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <i class="fas fa-star {{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-300' }} text-xs ml-0.5"></i>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                        <p class="text-gray-500 text-sm my-1">{{ $rating->created_at->format('Y/m/d') }}</p>
                                                        @if($rating->comment)
                                                            <p class="text-gray-700 text-sm">{{ $rating->comment }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500 text-center py-4">No ratings yet</p>
                                @endif
                            </div>
                        </div>
                        
                        @if($user->role === 'driver' && isset($trips) && count($trips) > 0)
                            <div>
                                <h4 class="text-lg font-semibold mb-3 flex items-center">
                                    <i class="fas fa-route mr-2 text-yellow-500"></i> Available Trips
                                </h4>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="space-y-3">
                                        @foreach($trips as $trip)
                                            <a href="{{ route('trip.show', $trip->id) }}" class="block border border-gray-200 rounded-lg p-3 hover:shadow-md transition">
                                                <div class="flex justify-between items-center">
                                                    <div>
                                                        <div class="font-medium">{{ $trip->departure_location }} to {{ $trip->destination }}</div>
                                                        <div class="text-gray-500 text-sm mt-1">
                                                            <i class="far fa-calendar-alt mr-1"></i> {{ $trip->departure_time->format('Y/m/d H:i') }}
                                                            <span class="mx-2">•</span>
                                                            <i class="fas fa-user mr-1"></i> {{ $trip->available_seats }} seats available
                                                        </div>
                                                    </div>
                                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                                        {{ ucfirst($trip->status) }}
                                                    </span>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 