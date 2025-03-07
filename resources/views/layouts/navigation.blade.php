<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}">
                        <span class="text-2xl font-bold text-yellow-500">GrandTaxiGo</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 rtl:space-x-reverse sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                            </x-nav-link>
                            <x-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users')">
                                <i class="fas fa-users mr-1"></i> Users
                            </x-nav-link>
                            <x-nav-link :href="route('admin.trips')" :active="request()->routeIs('admin.trips')">
                                <i class="fas fa-route mr-1"></i> Trips
                            </x-nav-link>
                            <x-nav-link :href="route('admin.reservations')" :active="request()->routeIs('admin.reservations')">
                                <i class="fas fa-ticket-alt mr-1"></i> Reservations
                            </x-nav-link>
                        @elseif(Auth::user()->role === 'driver')
                            <x-nav-link :href="route('dashboarddriver')" :active="request()->routeIs('dashboard')">
                                <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                            </x-nav-link>
                            <x-nav-link :href="route('trip.create')" :active="request()->routeIs('trip.create')">
                                <i class="fas fa-plus-circle mr-1"></i> Create Trip
                            </x-nav-link>
                            <x-nav-link :href="route('history')" :active="request()->routeIs('history')">
                                <i class="fas fa-history mr-1"></i> Trip History
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                <i class="fas fa-search mr-1"></i> Available Trips
                            </x-nav-link>
                            <x-nav-link :href="route('myreservations')" :active="request()->routeIs('dashboard')">
                                <i class="fas fa-ticket-alt mr-1"></i> My Reservations
                            </x-nav-link>
                        @endif
                    @endauth
                    
                    @guest
                        <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                            <i class="fas fa-sign-in-alt mr-1"></i> Login
                        </x-nav-link>
                        <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                            <i class="fas fa-user-plus mr-1"></i> Register
                        </x-nav-link>
                    @endguest
                </div>
            </div>

            <!-- Settings Dropdown -->
            @auth
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fas fa-user mr-1"></i> Profile
                        </x-dropdown-link>
                        
                        <x-dropdown-link :href="route('ratings.user', Auth::id())">
                            <i class="fas fa-star mr-1"></i> My Ratings
                        </x-dropdown-link>
                        
                        @if(Auth::user()->role === 'passenger')
                            <x-dropdown-link :href="route('dashboard')">
                                <i class="fas fa-ticket-alt mr-1"></i> My Reservations
                            </x-dropdown-link>
                        @endif

                        @if(Auth::user()->role === 'driver')
                            <x-dropdown-link :href="route('history')">
                                <i class="fas fa-history mr-1"></i> Trip History
                            </x-dropdown-link>
                        @endif

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt mr-1"></i> Logout
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @endauth

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if(Auth::user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users')">
                        <i class="fas fa-users mr-1"></i> Users
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.trips')" :active="request()->routeIs('admin.trips')">
                        <i class="fas fa-route mr-1"></i> Trips
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.reservations')" :active="request()->routeIs('admin.reservations')">
                        <i class="fas fa-ticket-alt mr-1"></i> Reservations
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.revenue')" :active="request()->routeIs('admin.revenue')">
                        <i class="fas fa-chart-line mr-1"></i> Revenue
                    </x-responsive-nav-link>
                @elseif(Auth::user()->role === 'driver')
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('trip.create')" :active="request()->routeIs('trip.create')">
                        <i class="fas fa-plus-circle mr-1"></i> Create Trip
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('history')" :active="request()->routeIs('history')">
                        <i class="fas fa-history mr-1"></i> Trip History
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <i class="fas fa-search mr-1"></i> Available Trips
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <i class="fas fa-ticket-alt mr-1"></i> My Reservations
                    </x-responsive-nav-link>
                @endif
            @endauth
            
            @guest
                <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                    <i class="fas fa-sign-in-alt mr-1"></i> Login
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                    <i class="fas fa-user-plus mr-1"></i> Register
                </x-responsive-nav-link>
            @endguest
        </div>

        <!-- Responsive Settings Options -->
        @auth
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    <i class="fas fa-user mr-1"></i> Profile
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('ratings.user', Auth::id())">
                    <i class="fas fa-star mr-1"></i> My Ratings
                </x-responsive-nav-link>
                
                @if(Auth::user()->role === 'passenger')
                    <x-responsive-nav-link :href="route('dashboard')">
                        <i class="fas fa-ticket-alt mr-1"></i> My Reservations
                    </x-responsive-nav-link>
                @endif

                @if(Auth::user()->role === 'driver')
                    <x-responsive-nav-link :href="route('history')">
                        <i class="fas fa-history mr-1"></i> Trip History
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt mr-1"></i> Logout
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>
