<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Driver Dashboard</h1>
            </div>
            <!-- Add Trip Form -->
       <div class="mb-6">
    <h2 class="text-lg font-semibold mb-3">Add New Trip</h2>
    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{route('trip.store')}}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pickup Location -->
                <div>
                    <label for="pickup" class="block text-sm font-medium text-gray-700">Pickup Location</label>
                    <input type="text" name="departure_location" id="pickup" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <!-- Destination -->
                <div>
                    <label for="destination" class="block text-sm font-medium text-gray-700">Destination</label>
                    <input type="text" name="destination" id="destination" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <!-- Date -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" name="departure_time" id="date" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <!-- Number of Seats -->
                <div>
                    <label for="seats" class="block text-sm font-medium text-gray-700">Available Seats</label>
                    <input type="number" name="available_seats" id="seats" min="1" max="8" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            <div class="mt-6">
                <button type="submit"
                    class="w-full bg-indigo-600 px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Add Trip
                </button>
            </div>
        </form>
    </div>
</div>


            <!-- Status Toggle -->
            <div class="mb-6 p-4 bg-white rounded-lg shadow">
    <h2 class="text-lg font-semibold mb-3">Availability Status</h2>
    <label class="relative inline-flex items-center cursor-pointer">
        <input type="checkbox" value="" class="sr-only peer" id="availabilityToggle" 
            @if(auth()->user()->is_available) checked @endif>
        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-green-600 after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
        <span class="ml-3 text-sm font-medium text-gray-900" id="statusText">
            {{ auth()->user()->is_available ? 'Online' : 'Offline' }}
        </span>
    </label>
</div>
            <!-- Pending Reservations -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-3">Pending Reservations</h2>
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="divide-y divide-gray-200">
                        <!-- Reservation items will be dynamically loaded here -->
                        <div class="p-4 flex justify-between items-center">
                            <div>
                                <p class="font-medium">Pickup: Central Station</p>
                                <p class="text-sm text-gray-600">Destination: Airport</p>
                                <p class="text-sm text-gray-600">Date: 2024-01-20 14:30</p>
                            </div>
                            <div class="space-x-2">
                                <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Accept</button>
                                <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Decline</button>
                            </div>
                        </div>
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
                            <!-- Trip history items will be dynamically loaded here -->
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">2024-01-19</td>
                                <td class="px-6 py-4">Downtown</td>
                                <td class="px-6 py-4">Shopping Mall</td>
                                <td class="px-6 py-4"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const availabilityToggle = document.getElementById('availabilityToggle');
        const statusText = document.getElementById('statusText');

        availabilityToggle.addEventListener('change', function() {
            let isAvailable = this.checked ? 1 : 0;

            fetch("{{ route('trip.updateAvailability') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ is_available: isAvailable })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    statusText.textContent = isAvailable ? 'Online' : 'Offline';
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
</script>

</x-app-layout>