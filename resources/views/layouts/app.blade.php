<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('images/LOGO.ico') }}">

    <!-- Set theme before first paint to avoid a flash of the wrong theme -->
    <script>
        if (localStorage.getItem('color-theme') === 'dark' ||
            (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
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

        /* Consistent, visible keyboard focus everywhere, in both themes */
        a:focus-visible,
        button:focus-visible {
            outline: 2px solid theme('colors.emerald.500');
            outline-offset: 2px;
            border-radius: 0.375rem;
        }
    </style>
</head>

<body
    class="font-sans antialiased text-slate-700 bg-slate-50 dark:text-slate-200 dark:bg-slate-950 transition-colors duration-300">

    <x-loader />

    <!-- Skip link: first focusable element, only visible on keyboard focus -->
    <a href="#main-content"
        class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-[100] focus:rounded-lg focus:bg-emerald-600 focus:px-4 focus:py-2 focus:text-sm focus:font-semibold focus:text-white">
        Skip to main content
    </a>

    <div x-data="{ sidebarOpen: false }" x-cloak
        class="h-screen bg-slate-50 dark:bg-slate-950 flex overflow-hidden font-sans text-slate-700 dark:text-slate-200 transition-colors duration-300">

        @auth
            <!-- Desktop Sidebar (Full Height) -->
            <aside
                class="hidden md:flex flex-col w-56 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 transition-colors duration-300 z-40 flex-shrink-0">
                <!-- Sidebar Header (Logo) -->
                <div class="h-16 flex items-center px-6 border-b border-slate-200 dark:border-slate-800 flex-shrink-0">
                    <a href="{{ route('dashboard') }}" class="block w-full">
                        <x-logo-light class="flex dark:hidden"></x-logo-light>
                        <x-logo-dark class="hidden dark:flex"></x-logo-dark>
                    </a>
                </div>
                <!-- Navigation -->
                <nav aria-label="Primary" class="flex-1 overflow-y-auto p-4 custom-scrollbar">
                    @include('layouts.app.navigation')
                </nav>
            </aside>

            <!-- Mobile Sidebar Backdrop & Drawer -->
            <div x-show="sidebarOpen" x-cloak class="md:hidden">
                <!-- Backdrop -->
                <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
                    class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm z-40"></div>

                <!-- Drawer -->
                <aside x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform"
                    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in-out duration-300 transform"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                    class="fixed inset-y-0 left-0 z-50 w-72 bg-white dark:bg-slate-900 shadow-2xl flex flex-col h-full">

                    <div
                        class="h-16 flex items-center justify-between px-6 border-b border-slate-200 dark:border-slate-800 flex-shrink-0">
                        <a href="{{ route('dashboard') }}" class="block">
                            <div class = 'flex items-center gap-2.5 sm:gap-3 min-w-0'>

                                {{-- Logo --}}
                                <div class="shrink-0 flex items-center justify-center">
                                    <img src="{{ asset('images/LOGO.webp') }}" alt="National Pest Surveillance System"
                                        width="45" height="45" loading="eager" decoding="async"
                                        class="h-10 w-9 sm:h-10 sm:w-10 object-contain">
                                </div>

                                {{-- Name --}}
                                <div class="min-w-0 leading-tight font-bold">
                                    <span class="block">National Pest</span>
                                    <span class="block">Surveillance System</span>
                                </div>

                            </div>

                        </a>
                        <button @click="sidebarOpen = false" aria-label="Close menu"
                            class="text-slate-500 hover:text-red-600 dark:text-slate-400 dark:hover:text-red-400 p-2 -mr-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            <i class="fas fa-times text-xl" aria-hidden="true"></i>
                        </button>
                    </div>

                    <nav aria-label="Primary" class="flex-1 overflow-y-auto p-4 custom-scrollbar">
                        @include('layouts.app.navigation')
                    </nav>
                </aside>
            </div>
        @endauth

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            @auth
                <!-- Top Navbar (Right Side Only) -->
                <header
                    class="sticky top-0 z-30 flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 shadow-sm transition-colors duration-300 flex-shrink-0">
                    <!-- Left side: Mobile Toggle & Mobile Logo -->
                    <div class="flex items-center">
                        <button @click="sidebarOpen = !sidebarOpen" aria-label="Open menu" :aria-expanded="sidebarOpen"
                            class="md:hidden text-slate-500 hover:text-emerald-600 dark:text-slate-400 dark:hover:text-emerald-400 p-2 -ml-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            <i class="fas fa-bars text-xl" aria-hidden="true"></i>
                        </button>
                        <!-- Mobile Logo in Header when Drawer is closed -->
                        <a href="{{ route('dashboard') }}" class="md:hidden ml-2 block w-48">
                            <x-logo-light class="flex dark:hidden"></x-logo-light>
                            <x-logo-dark class="hidden dark:flex"></x-logo-dark>
                        </a>
                    </div>

                    <!-- Right side: Controls & Profile -->
                    <div class="flex items-center gap-2 sm:gap-3">
                        <!-- Theme Toggle -->
                        <button id="theme-toggle" type="button" aria-label="Toggle dark mode"
                            class="text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-600 dark:hover:text-emerald-400 rounded-lg text-sm p-2 transition-colors">
                            <i id="theme-toggle-dark-icon" class="hidden fas fa-moon text-lg" aria-hidden="true"></i>
                            <i id="theme-toggle-light-icon" class="hidden fas fa-sun text-lg" aria-hidden="true"></i>
                        </button>
                        <script>
                            (function() {
                                var darkIcon = document.getElementById('theme-toggle-dark-icon');
                                var lightIcon = document.getElementById('theme-toggle-light-icon');
                                var toggleBtn = document.getElementById('theme-toggle');
                                var root = document.documentElement;

                                function syncIcons() {
                                    var isDark = root.classList.contains('dark');
                                    // Icon shown = action the button performs next.
                                    lightIcon.classList.toggle('hidden', !isDark);
                                    darkIcon.classList.toggle('hidden', isDark);
                                    toggleBtn.setAttribute('aria-pressed', String(isDark));
                                }

                                toggleBtn.addEventListener('click', function() {
                                    var goingDark = !root.classList.contains('dark');
                                    root.classList.toggle('dark', goingDark);
                                    localStorage.setItem('color-theme', goingDark ? 'dark' : 'light');
                                    syncIcons();
                                });

                                syncIcons();
                            })
                            ();
                        </script>

                        <livewire:admin.notifications-menu />
                        <div class="h-6 w-px bg-slate-200 dark:bg-slate-700 mx-1 sm:mx-2 hidden sm:block"></div>
                        <livewire:admin.users.user-menu />
                    </div>
                </header>
            @endauth

            <!-- Scrollable Main Content -->
            <main id="main-content" tabindex="-1"
                class="flex-1 overflow-y-auto bg-slate-50 dark:bg-slate-950 transition-colors duration-300 custom-scrollbar flex flex-col focus:outline-none">
                <!-- Page Content -->
                <div class="flex-1 w-full max-w-[1800px] mx-auto p-4 sm:p-0 lg:p-1">
                    {{ $slot ?? '' }}
                </div>

                <!-- Footer -->
                <footer
                    class="w-full mt-auto py-6 border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 transition-colors duration-300 flex-shrink-0">
                    <div
                        class="w-full max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 flex flex-col sm:flex-row justify-between items-center text-sm text-slate-500 dark:text-slate-400 gap-4">
                        <div class="text-center sm:text-left leading-relaxed">
                            &copy; {{ date('Y') }}
                            <span class="font-semibold text-emerald-700 dark:text-emerald-400">National Pest
                                Surveillance System</span>. {{ __('All rights reserved.') }}<br>
                            <span class="text-xs">National Plant Protection Service, Sri Lanka</span>
                        </div>
                        <div class="flex gap-4">

                            <a href="{{ route('help') }}"
                                class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Help
                                Center</a>
                        </div>
                    </div>
                </footer>
            </main>
        </div>
    </div>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
