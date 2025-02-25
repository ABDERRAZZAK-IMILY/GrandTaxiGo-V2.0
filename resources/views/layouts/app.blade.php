<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gradient-to-b from-yellow-400 via-yellow-300 to-yellow-200">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-black/80 shadow-lg">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        <div class="text-yellow-400 font-bold text-xl">
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="container mx-auto px-4 py-8">
                <div class="bg-white/90 rounded-lg shadow-xl p-6">
                    {{ $slot }}
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-black/80 text-yellow-400 py-4 mt-8">
                <div class="container mx-auto text-center">
                    <p>&copy; {{ date('Y') }} GrandTaxiGo. All rights reserved.</p>
                </div>
            </footer>
        </div>
    </body>
</html>
