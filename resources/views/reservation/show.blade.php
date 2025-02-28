
<script src="https://cdn.tailwindcss.com"></script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Détails de la Réservation #{{ $reservation->id }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Détails de la Réservation #{{ $reservation->id }}</h2>
            <div class="mb-4">
                <p><strong>Départ :</strong> {{ $trip->departure_location}}</p>
                <p><strong>Destination :</strong> {{ $trip->destination}}</p>
                <p><strong>Date :</strong> {{ $trip->departure_time }}</p>
                <p><strong>Statut :</strong> <span class="font-semibold">{{ ucfirst($reservation->status) }}</span></p>
            </div>
            @if( $reservation->status == 'pending' || $reservation->status == 'accepted')
                <form action="" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-700  font-bold py-2 px-4 rounded">
                        Annuler la Réservation
                    </button>
                </form>
            @endif
        </div>

        <a href="" class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mt-4">
            Retour
        </a>
    </div>
</x-app-layout>
