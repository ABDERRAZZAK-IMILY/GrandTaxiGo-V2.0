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
                <p><strong>Départ :</strong> {{ $reservation->pickup_location }}</p>
                <p><strong>Destination :</strong> {{ $reservation->dropoff_location }}</p>
                <p><strong>Date :</strong> {{ $reservation->date }}</p>
                <p><strong>Statut :</strong> <span class="font-semibold">{{ ucfirst($reservation->status) }}</span></p>
            </div>

            @if(auth()->id() === $reservation->user_id && $reservation->status == 'pending')
                <form action="{{ route('reservations.cancel', $reservation->id) }}" method="POST" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Annuler la Réservation
                    </button>
                </form>
            @endif
        </div>

        <a href="{{ route('reservations.index') }}" class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mt-4">
            Retour
        </a>
    </div>
</x-app-layout>
