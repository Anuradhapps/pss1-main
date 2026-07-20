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

    <div x-data="{ sidebarOpen: false }" x-cloak class="h-screen bg-background dark:bg-slate-900 flex overflow-hidden font-sans text-slate-800 dark:text-slate-100 transition-colors duration-300">

        @auth
        <!-- Desktop Sidebar (Full Height) -->
        <aside class="hidden md:flex flex-col w-64 bg-surface dark:bg-card border-r border-slate-200 dark:border-slate-800 transition-colors duration-300 z-40 flex-shrink-0">
            <!-- Sidebar Header (Logo) -->
            <div class="h-16 flex items-center px-6 border-b border-slate-200 dark:border-slate-800 flex-shrink-0">
                <a href="{{ route('dashboard') }}" class="block w-full">
                    <x-logo-light class="flex dark:hidden"></x-logo-light>
                    <x-logo-dark class="hidden dark:flex"></x-logo-dark>
                </a>
            </div>
            <!-- Navigation -->
            <div class="flex-1 overflow-y-auto p-4 custom-scrollbar">
                @include('layouts.app.navigation')
            </div>
        </aside>

        <!-- Mobile Sidebar Backdrop & Drawer -->
        <div x-show="sidebarOpen" x-cloak class="md:hidden">
            <!-- Backdrop -->
            <div x-show="sidebarOpen"
                x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="sidebarOpen = false"
                class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-40"></div>

            <!-- Drawer -->
            <aside x-show="sidebarOpen"
                x-transition:enter="transition ease-in-out duration-300 transform"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in-out duration-300 transform"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="fixed inset-y-0 left-0 z-50 w-72 bg-white dark:bg-slate-900 shadow-2xl flex flex-col h-full">

                <div class="h-16 flex items-center justify-between px-6 border-b border-slate-200 dark:border-slate-800 flex-shrink-0">
                    <a href="{{ route('dashboard') }}" class="block">
                        <x-logo-light class="flex dark:hidden"></x-logo-light>
                        <x-logo-dark class="hidden dark:flex"></x-logo-dark>
                    </a>
                    <button @click="sidebarOpen = false" class="text-slate-500 hover:text-red-600 dark:text-slate-400 p-2 -mr-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors focus:outline-none">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto p-4 custom-scrollbar">
                    @include('layouts.app.navigation')
                </div>
            </aside>
        </div>
        @endauth

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            @auth
            <!-- Top Navbar (Right Side Only) -->
            <header class="sticky top-0 z-30 flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 shadow-sm transition-colors duration-300 flex-shrink-0">
                <!-- Left side: Mobile Toggle & Mobile Logo -->
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-slate-500 hover:text-primary dark:text-slate-400 p-2 -ml-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <!-- Optional Mobile Logo in Header if Drawer is closed -->
                    <a href="{{ route('dashboard') }}" class="md:hidden ml-2 block w-48">
                        <x-logo-light class="flex dark:hidden"></x-logo-light>
                        <x-logo-dark class="hidden dark:flex"></x-logo-dark>
                    </a>
                </div>

                <!-- Right side: Controls & Profile -->
                <div class="flex items-center gap-3">
                    <!-- Theme Toggle -->
                    <button id="theme-toggle" type="button" class="text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-primary/50 rounded-lg text-sm p-2 transition-colors">
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
                    <div class="h-6 w-px bg-slate-200 dark:bg-slate-700 mx-2 hidden sm:block"></div>
                    <livewire:admin.users.user-menu />
                </div>
            </header>
            @endauth

            <!-- Scrollable Main Content -->
            <main class="flex-1 overflow-y-auto bg-background dark:bg-[#0F172A] transition-colors duration-300 custom-scrollbar flex flex-col">
                <!-- Page Content -->
                <div class="flex-1 w-full max-w-[1800px] mx-auto p-2 sm:p-2 lg:p-2 xl:px-2">
                    {{ $slot ?? '' }}
                </div>

                <!-- Footer -->
                <footer class="w-full mt-auto py-6 border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 transition-colors duration-300 flex-shrink-0">
                    <div class="w-full max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 flex flex-col sm:flex-row justify-between items-center text-sm text-slate-500 dark:text-slate-400 gap-4">
                        <div class="text-center sm:text-left leading-relaxed">
                            &copy; {{ date('Y') }} <span class="font-semibold text-primary dark:text-emerald-400">National Pest Surveillance System</span>. {{ __('All rights reserved.') }}<br>
                            <span class="text-xs">National Plant Protection Service, Sri Lanka</span>
                        </div>
                        <div class="flex gap-4">
                            <a href="#" class="hover:text-primary transition-colors">Privacy Policy</a>
                            <a href="#" class="hover:text-primary transition-colors">Terms of Service</a>
                            <a href="/help" class="hover:text-primary transition-colors">Help Center</a>
                        </div>
                    </div>
                </footer>
            </main>
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

    <!-- Toast Notification System -->
    <x-ui.toast />

    @livewireScripts
    @stack('scripts')
</body>

</html>