
<script src="https://cdn.tailwindcss.com"></script>


<div class="py-4 px-6">
        <h2 class="text-2xl font-bold">Find Your Perfect Trip</h2>
        <p class="text-blue-100 text-sm">Discover amazing destinations and book your next adventure</p>
      </div>

      <!-- Search Form - Horizontal Layout -->
      <div class="bg-red p-6 rounded-t-3xl -mt-4">
        <form id="tripSearchForm" class="space-y-4 md:space-y-0">
          <!-- All fields in a single row on desktop -->
          <div class="flex flex-col md:flex-row md:items-end md:space-x-4">
            <!-- Departure City -->
            <div class="w-full md:w-1/5 mb-4 md:mb-0">
              <label for="departure" class="block text-sm font-medium text-gray-700 mb-1">
                Departure City
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                  </svg>
                </div>
                <input
                  type="text"
                  id="departure"
                  name="departure"
                  placeholder="From where?"
                  class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900"
                  required
                />
              </div>
            </div>

            <!-- Destination City -->
            <div class="w-full md:w-1/5 mb-4 md:mb-0">
              <label for="destination" class="block text-sm font-medium text-gray-700 mb-1">
                Destination City
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                  </svg>
                </div>
                <input
                  type="text"
                  id="destination"
                  name="destination"
                  placeholder="Where to?"
                  class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900"
                  required
                />
              </div>
            </div>

            <!-- Departure Date -->
            <div class="w-full md:w-1/5 mb-4 md:mb-0">
              <label for="date" class="block text-sm font-medium text-gray-700 mb-1">
                Departure Date
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                  </svg>
                </div>
                <input
                  type="date"
                  id="date"
                  name="date"
                  class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900"
                  required
                />
              </div>
            </div>

            <!-- Departure Time -->
            <div class="w-full md:w-1/5 mb-4 md:mb-0">
              <label for="time" class="block text-sm font-medium text-gray-700 mb-1">
                Departure Time
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                  </svg>
                </div>
                <input
                  type="time"
                  id="time"
                  name="time"
                  class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900"
                  required
                />
              </div>
            </div>

            <!-- Search Button -->
            <div class="w-full md:w-1/5">
              <button
                type="submit"
                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                style="height: 42px;" 
              >
                <div class="flex items-center justify-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                  </svg>
                  Search Trips
                </div>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

