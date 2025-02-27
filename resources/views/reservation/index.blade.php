
<script src="https://cdn.tailwindcss.com"></script>
<x-app-layout>

@if(session('success'))
    <p class="text-green-500">{{ session('success') }}</p>
    @else 
    <p class="text-red-500">{{ session('error') }}</p>

@endif

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-red-300">
            {{ __('Réservations') }}
        </h2>
    </x-slot>
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">Trajets Disponibles</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($trips as $trip)
            <form action="{{route('reservation.store')}}" method="POST">
                @csrf
                <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                <input type="hidden" name="available_seats" value="{{ $trip->available_seats }}">


            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm text-gray-500" name="trip_id">Trajet #{{ $trip->id }}</span>

                                 @if ( $trip->available_seats > 0 )
                                 <span class="px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800" name="seats_available">disponibles</span>
                                 @else 
                                 <span class="px-3 py-1 rounded-full text-sm bg-red-100 text-red-800" name="seats_available">indisponibles</span>
                          
                               @endif
                            </div>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-gray-700">De: {{ $trip->departure_location }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-gray-700">À: {{ $trip->destination }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-gray-700">{{ $trip->departure_time }}</span>
                        </div>
                    </div>
                    <div class="flex items-center">
                    <svg  class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M4 18v3h3v-3h10v3h3v-6H4zm15-8h3v3h-3zM2 10h3v3H2zm15 3H7V5c0-1.1.9-2 2-2h6c1.1 0 2 .9 2 2v8z"/></svg>
                    <span  name="available_seats"  class="text-gray-700">{{ $trip->available_seats}}</span>
                </div>
                    <div class="mt-4">
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600  font-semibold py-2 px-4 rounded-lg transition duration-300">
                        Réserver
                    </button>
                    </div>
                </div>
            </form>
        @endforeach
        </div>
    </div>
</x-app-layout>
