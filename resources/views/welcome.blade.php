<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>GrandTaxiGo - Réservation de Grands Taxis</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <!-- Hero Section with improved gradient -->
        <div class="relative min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
            <!-- Enhanced Header -->
            <header class="fixed w-full z-50 backdrop-blur-md bg-white/90 dark:bg-gray-900/90 shadow-lg">
                <div class="container mx-auto px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto">
                            <span class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 text-transparent bg-clip-text hover:scale-105 transition-transform">
                                GrandTaxiGo
                            </span>
                        </div>
                        
                        <!-- Improved Navigation -->
                        <nav class="hidden md:flex space-x-8">
                            <a href="#" class="text-gray-600 hover:text-indigo-600 dark:text-gray-300 dark:hover:text-indigo-400 transition-colors duration-300 font-medium">Accueil</a>
                            <a href="#services" class="text-gray-600 hover:text-indigo-600 dark:text-gray-300 dark:hover:text-indigo-400 transition-colors duration-300 font-medium">Services</a>
                            <a href="#about" class="text-gray-600 hover:text-indigo-600 dark:text-gray-300 dark:hover:text-indigo-400 transition-colors duration-300 font-medium">À propos</a>
                            <a href="#contact" class="text-gray-600 hover:text-indigo-600 dark:text-gray-300 dark:hover:text-indigo-400 transition-colors duration-300 font-medium">Contact</a>
                        </nav>

                        <!-- Enhanced Auth Buttons -->
                        <div class="flex items-center space-x-4">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="btn-primary">
                                        Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn-secondary">
                                        Connexion
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn-primary">
                                            Inscription
                                        </a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            <!-- Enhanced Hero Section -->
            <div class="relative pt-32 pb-32 flex content-center items-center justify-center min-h-screen">
                <div class="container mx-auto px-4">
                    <div class="flex flex-wrap items-center">
                        <div class="w-full md:w-6/12 px-4 animate-fade-in-left">
                            <h1 class="text-5xl font-bold mb-6 bg-gradient-to-r from-indigo-900 to-purple-900 dark:from-indigo-400 dark:to-purple-400 text-transparent bg-clip-text leading-tight">
                                Réservez votre Grand Taxi en quelques clics
                            </h1>
                            <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                                Voyagez en toute simplicité avec GrandTaxiGo. 
                                Une nouvelle façon de réserver votre taxi, plus rapide et plus sûre.
                            </p>
                            <div class="flex space-x-4">
                                <a href="#reserver" class="btn-primary animate-bounce">
                                    Réserver maintenant
                                </a>
                                <a href="#services" class="btn-secondary">
                                    En savoir plus
                                </a>
                            </div>
                        </div>
                        <div class="w-full md:w-6/12 px-4 animate-fade-in-right">
                            <div class="relative">
                                <img src="{{ asset('images/taxi-hero.jpg') }}" alt="Taxi" class="rounded-2xl shadow-2xl hover:scale-105 transition-transform duration-500 object-cover">
                                <div class="absolute -bottom-4 -right-4 bg-indigo-600 text-white px-6 py-3 rounded-lg shadow-lg">
                                    24/7 Disponible
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Features Section -->
        <section id="services" class="py-20 bg-gradient-to-b from-white to-blue-50 dark:from-gray-800 dark:to-gray-900">
            <div class="container mx-auto px-4">
                <h2 class="text-4xl font-bold text-center mb-16 bg-gradient-to-r from-indigo-900 to-purple-900 dark:from-indigo-400 dark:to-purple-400 text-transparent bg-clip-text">
                    Pourquoi choisir GrandTaxiGo ?
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Enhanced Feature Cards -->
                    <div class="feature-card">
                        <div class="text-indigo-600 mb-4">
                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                <!-- Add your SVG path here -->
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-4 text-indigo-600 dark:text-indigo-400">Réservation Facile</h3>
                        <p class="text-gray-600 dark:text-gray-300">Réservez votre trajet en quelques clics depuis notre plateforme intuitive.</p>
                    </div>
                    <!-- Add more feature cards similarly -->
                </div>
            </div>
        </section>

        <style>
            /* Enhanced Animations */
            @keyframes fade-in-left {
                0% { opacity: 0; transform: translateX(-20px); }
                100% { opacity: 1; transform: translateX(0); }
            }
            @keyframes fade-in-right {
                0% { opacity: 0; transform: translateX(20px); }
                100% { opacity: 1; transform: translateX(0); }
            }
            .animate-fade-in-left {
                animation: fade-in-left 1s ease-out;
            }
            .animate-fade-in-right {
                animation: fade-in-right 1s ease-out;
            }
            
            /* Custom Classes */
            .btn-primary {
                @apply inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition-all duration-300 hover:scale-105 transform focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-md;
            }
            .btn-secondary {
                @apply inline-flex items-center px-6 py-3 border border-indigo-200 text-base font-medium rounded-lg text-indigo-700 bg-white hover:bg-indigo-50 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 hover:scale-105 shadow-md;
            }
            .feature-card {
                @apply bg-white dark:bg-gray-700 rounded-xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2;
            }
        </style>
    </body>
</html>
