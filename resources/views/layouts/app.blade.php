<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'GrandTaxiGo') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Figtree', 'Tajawal', sans-serif;
            }
            
            html[dir="rtl"] body {
                font-family: 'Tajawal', 'Figtree', sans-serif;
            }
            
            .rtl-flip {
                transform: scaleX(-1);
            }
            
            html[dir="rtl"] .ltr-only {
                display: none;
            }
            
            html[dir="ltr"] .rtl-only {
                display: none;
            }

            /* تحسينات إضافية */
            .page-transition {
                transition: all 0.3s ease-in-out;
            }
            
            .hover-scale:hover {
                transform: scale(1.02);
            }
        </style>
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
                <div class="bg-white/90 rounded-lg shadow-xl p-6 page-transition">
                    @include('components.flash-messages')
                    @hasSection('content')
                        @yield('content')
                    @else
                        {{ $slot ?? '' }}
                    @endif
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-black/80 text-yellow-400 py-6 mt-8">
                <div class="container mx-auto px-4">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="mb-4 md:mb-0">
                            <div class="flex items-center">
                                <span class="text-2xl font-bold mr-2">GrandTaxiGo</span>
                                <span>&copy; {{ date('Y') }} {{ app()->getLocale() == 'ar' ? 'جميع الحقوق محفوظة' : 'All rights reserved' }}.</span>
                            </div>
                        </div>
                        <div class="flex space-x-6 rtl:space-x-reverse">
                            <a href="#" class="hover:text-white transition flex items-center">
                                <i class="fas fa-file-contract ml-1"></i>
                                {{ app()->getLocale() == 'ar' ? 'الشروط والأحكام' : 'Terms' }}
                            </a>
                            <a href="#" class="hover:text-white transition flex items-center">
                                <i class="fas fa-shield-alt ml-1"></i>
                                {{ app()->getLocale() == 'ar' ? 'سياسة الخصوصية' : 'Privacy' }}
                            </a>
                            <a href="#" class="hover:text-white transition flex items-center">
                                <i class="fas fa-envelope ml-1"></i>
                                {{ app()->getLocale() == 'ar' ? 'اتصل بنا' : 'Contact' }}
                            </a>
                        </div>
                    </div>
                    <div class="mt-4 text-center text-yellow-300 text-sm">
                        <p>{{ app()->getLocale() == 'ar' ? 'تطبيق GrandTaxiGo - الحل الأمثل للتنقل في المغرب' : 'GrandTaxiGo App - The best transportation solution in Morocco' }}</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
