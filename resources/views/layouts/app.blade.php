<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('images/LOGO.ico') }}">
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Add inside your HTML head or before the map script -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')
    @livewireStyles

    <style>
        [x-cloak] {
            display: none !important;
        }

        html,
        body {
            height: 100%;
        }

        .main-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content {
            flex-grow: 1;
        }

        .footer {
            flex-shrink: 0;
        }
    </style>
</head>

<body class="font-sans antialiased text-slate-800 bg-surface-light dark:text-slate-100 dark:bg-surface-dark transition-colors duration-300">

    <x-loader />

    <div x-data="{ sidebarOpen: false }" x-cloak class="main-container">
        <div class="flex flex-1 ">
            @auth
                <!-- Desktop Sidebar -->
                <aside class="hidden w-64 md:flex flex-col bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 transition-colors duration-300 shadow-xl z-50">
                    @include('layouts.app.navigation')
                </aside>

                <!-- Mobile Sidebar -->
                <aside x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-x-full"
                    x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 -translate-x-full"
                    class="fixed inset-0 z-50 w-64 shadow-2xl md:hidden transform bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800">
                    <div class="flex justify-end p-1">
                        <button @click="sidebarOpen = false"
                            class="text-white bg-red-600 hover:bg-red-700 transition duration-200 ease-in-out
               px-3 py-1.5 shadow-md hover:shadow-lg focus:outline-none"
                            aria-label="Close sidebar">
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </div>

                    <div class="px-1">
                        @include('layouts.app.navigation')
                    </div>


                </aside>
            @endauth

            <!-- Main Content Area -->
            <div id="main" class="flex flex-col w-full">
                @auth
                    <!-- Topbar -->
                    <header class="sticky top-0 z-40 flex items-center justify-between px-4 py-3 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 shadow-sm transition-colors duration-300">

                        <!-- Mobile Sidebar Toggle -->
                        <button @click="sidebarOpen = !sidebarOpen"
                            class="text-slate-500 dark:text-slate-400 md:hidden hover:text-primary focus:outline-none transition-colors">
                            <i class="fas fa-bars text-2xl"></i>
                        </button>

                        <!-- Topbar right controls -->
                        <div class="flex items-center ml-auto space-x-3">
                            <!-- Dark Mode Toggle -->
                            <button id="theme-toggle" type="button" class="text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-primary/50 rounded-lg text-sm p-2.5 transition-colors">
                                <i id="theme-toggle-dark-icon" class="hidden fas fa-moon text-lg"></i>
                                <i id="theme-toggle-light-icon" class="hidden fas fa-sun text-lg"></i>
                            </button>
                            <script>
                                var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
                                var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

                                if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                                    themeToggleLightIcon.classList.remove('hidden');
                                } else {
                                    themeToggleDarkIcon.classList.remove('hidden');
                                }

                                var themeToggleBtn = document.getElementById('theme-toggle');
                                themeToggleBtn.addEventListener('click', function() {
                                    themeToggleDarkIcon.classList.toggle('hidden');
                                    themeToggleLightIcon.classList.toggle('hidden');
                                    if (localStorage.getItem('color-theme')) {
                                        if (localStorage.getItem('color-theme') === 'light') {
                                            document.documentElement.classList.add('dark');
                                            localStorage.setItem('color-theme', 'dark');
                                        } else {
                                            document.documentElement.classList.remove('dark');
                                            localStorage.setItem('color-theme', 'light');
                                        }
                                    } else {
                                        if (document.documentElement.classList.contains('dark')) {
                                            document.documentElement.classList.remove('dark');
                                            localStorage.setItem('color-theme', 'light');
                                        } else {
                                            document.documentElement.classList.add('dark');
                                            localStorage.setItem('color-theme', 'dark');
                                        }
                                    }
                                });
                            </script>

                            <livewire:admin.notifications-menu />
                            {{-- <livewire:admin.help-menu /> --}}
                            <livewire:admin.users.user-menu />
                        </div>
                    </header>
                @endauth

                <!-- Slot Content -->
                <main class="content p-4 md:p-6 bg-surface-light dark:bg-surface-dark transition-colors duration-300">
                    {{ $slot ?? '' }}
                </main>

                <!-- Footer -->
                <footer class="w-full px-4 py-4 text-sm text-center text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 transition-colors duration-300 footer">
                    &copy; {{ date('Y') }} <span class="font-semibold text-primary">{{ config('app.name') }}</span> —
                    {{ __('National Plant Protection Service, Sri Lanka') }}.
                    <br>{{ __('All rights reserved.') }}
                </footer>
            </div>
        </div>
    </div>

    {{-- <script>
        alert('Download starting...');
        const loader = document.getElementById('fullScreenLoader');
        const mapContainer = document.getElementById('map-container');
        // Listen when page is unloading (show loader, hide map)
        window.addEventListener('beforeunload', () => {
            loader.classList.remove('hidden');
            mapContainer.classList.add('hidden');
        });

        // When page is loaded
        window.addEventListener('load', () => {
            setTimeout(() => {
                loader.classList.add('hidden');
                mapContainer.classList.remove('hidden');

                // ✅ Only initialize map AFTER it's visible
                initMap();
            }, 300);
        });
    </script> --}}

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    @livewireScripts
    @stack('scripts')
</body>

</html>
