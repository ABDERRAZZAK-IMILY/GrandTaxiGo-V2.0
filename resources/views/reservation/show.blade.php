
<script src="https://cdn.tailwindcss.com"></script>


@if(session('success'))
    <p class="text-green-500">{{ session('success') }}</p>
    @else 
    <p class="text-red-500">{{ session('error') }}</p>

@endif

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Détails de la Réservation #{{ $reservation->id }}
        </h2>
    </x-slot>

<div class="container mx-auto px-4 py-2">
    <div class="bg-gray-100 rounded-lg p-4 mb-4">
        <h3 class="text-xl font-semibold mb-2">Information du Chauffeur</h3>
        <div class="flex items-center space-x-4">
            <div class="flex-shrink-0">
                @if($reservation->trip->driver->profile_photo_path)
                    <img class="h-12 w-12 rounded-full" src="{{ Storage::url($reservation->trip->driver->profile_photo_path) }}" alt="Photo du chauffeur">
                @else
                    <div class="h-12 w-12 rounded-full bg-gray-300"></div>
                @endif
            </div>
            <div>
                <p><strong>Nom:</strong> {{ $reservation->trip->driver->name }}</p>
                <p><strong>Email:</strong> {{ $reservation->trip->driver->email }}</p>
            </div>
        </div>
    </div>
</div>


    <div class="container mx-auto p-4">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Détails de la Réservation #{{ $reservation->id }}</h2>
            <div class="mb-4">
                <p><strong>Départ :</strong> {{ $reservation->trip->departure_location}}</p>
                <p><strong>Destination :</strong> {{ $reservation->trip->destination}}</p>
                <p><strong>Date :</strong> {{ $reservation->trip->departure_time }}</p>
                <p><strong>Statut :</strong> <span class="font-semibold">{{ ucfirst($reservation->status) }}</span></p>
            </div>
            @if( $reservation->status == 'pending' || $reservation->status == 'accepted')
                <form action="{{route('cancel')}}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="reservation_id" value="{{$reservation->id}}">
                    <input type="hidden" name="trip_id" value="{{$reservation->trip->id}}">
                    <button type="submit" class="bg-red-500 hover:bg-red-700  font-bold py-2 px-4 rounded">
                        Annuler la Réservation
                    </button>
                </form>
            @endif
            <form action="/session" method="POST" class="mt-4">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type='hidden' name="total" value="200">
                <input type='hidden' name="productname" value=" from {{ $reservation->trip->departure_location}} to  {{ $reservation->trip->destination}} ">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                    </svg>
                    Payer
                </button>
            </form>
        </div>

        <a href="{{route('ratings.rate_driver' , $reservation->trip->id )}}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">
            Évaluer le trajet
        </a>

        <a href="" class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mt-4">
            Retour
        </a>
    </div>
</x-app-layout>
