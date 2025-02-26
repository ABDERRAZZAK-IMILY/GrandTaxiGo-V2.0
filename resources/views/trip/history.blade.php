<script src="https://cdn.tailwindcss.com"></script>
<!-- Pending Reservations -->
 <div class="mb-6">
                <h2 class="text-lg font-semibold mb-3">Pending Reservations</h2>
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="divide-y divide-gray-200">
                        @forelse($pendingReservations as $reservation)
                            <div class="p-4 flex justify-between items-center">
                                <div>
                                    <p class="font-medium">Pickup: {{ $reservation->departure_location }}</p>
                                    <p class="text-sm text-gray-600">Destination: {{ $reservation->destination }}</p>
                                    <p class="text-sm text-gray-600">Date: {{ $reservation->departure_time}}</p>
                                    <p class="text-sm text-gray-600">: {{ $reservation->status}}</p>

                                </div>
                                <div class="space-x-2">
                                <form action="{{ route('accept') }}" method="POST" class="inline">                                     
                                       @csrf
                                        @method('PATCH')
                                        <input type="hidden" , name="reservation_id" value="{{$reservation->id}}">
                                        <input type="hidden" name="status" value="accepted">
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Accept</button>
                                    </form>
                                    <form action="" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="declined">
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Decline</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-gray-500">No pending reservations</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Trip History -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-3">Trip History</h2>
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">From</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">To</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($tripHistory as $trip)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $trip->departure_time }}</td>
                                    <td class="px-6 py-4">{{ $trip->departure_location }}</td>
                                    <td class="px-6 py-4">{{ $trip->destination }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $trip->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($trip->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No trip history found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>