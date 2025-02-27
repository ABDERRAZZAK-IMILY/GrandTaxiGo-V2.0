<script src="https://cdn.tailwindcss.com"></script>

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
                    <input type="date" name="" id="date" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <input type="hidden" name="departure_time" id="timestamp">
                
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">Time</label>
                    <input type="time" name="" id="time" required
                        class=" focus:ring-yellow-500 focus:border-yellow-500  mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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


    document.getElementById('date').addEventListener('change', updateTimestamp);
    document.getElementById('time').addEventListener('change', updateTimestamp);

    function updateTimestamp() {
        const date = document.getElementById('date').value;
        const time = document.getElementById('time').value;
        if (date && time) {
            document.getElementById('timestamp').value = date + ' ' + time;
        }
    }
</script>

</x-app-layout>