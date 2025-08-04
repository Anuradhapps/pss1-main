<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('images/LOGO.ico') }}">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Add inside your HTML head or before the map script -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

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

<body class="antialiased text-white">
    <div>
        <!-- Modern Full Screen Loader -->
        <div id="modernPageLoader"
            class="fixed inset-0 z-50 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 bg-opacity-95 flex flex-col items-center justify-center transition-opacity duration-500 opacity-0 pointer-events-none">

            <!-- Complex spinner wrapper -->
            <div class="relative w-24 h-24 mb-8">
                <!-- Outer rotating ring -->
                <div
                    class="absolute inset-0 border-4 border-t-transparent border-b-transparent border-l-red-500 border-r-red-500 rounded-full animate-spin-slow">
                </div>

                <!-- Inner rotating ring -->
                <div
                    class="absolute inset-4 border-4 border-t-transparent border-b-transparent border-l-yellow-400 border-r-yellow-400 rounded-full animate-spin-fast">
                </div>

                <!-- Center circle -->
                <div class="absolute inset-10 bg-red-600 rounded-full"></div>
            </div>

            <!-- Text -->
            <h2 class="text-white text-3xl font-extrabold mb-2 tracking-wide animate-pulse">Loading, please wait...</h2>
            <p class="text-gray-300 text-lg tracking-wide max-w-xs text-center">We're preparing your experience. Thanks
                for your patience!</p>
        </div>

        <style>
            /* Custom animations for spinner speeds */
            @keyframes spin-slow {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(360deg);
                }
            }

            @keyframes spin-fast {
                from {
                    transform: rotate(360deg);
                }

                to {
                    transform: rotate(0deg);
                }
            }

            .animate-spin-slow {
                animation: spin-slow 4s linear infinite;
            }

            .animate-spin-fast {
                animation: spin-fast 2s linear infinite;
            }
        </style>

        <script>
            const loader = document.getElementById('modernPageLoader');
            const exportRoutes = [
                '/admin/report'
            ];

            function isExportRoute(url) {
                return exportRoutes.some(route => url.includes(route));
            }
            // Show loader on page unload (navigation)
            window.addEventListener('beforeunload', () => {
                if (!isExportRoute(window.location.pathname)) {
                    loader.classList.remove('opacity-0', 'pointer-events-none');
                }

            });

            // Hide loader on page load
            window.addEventListener('load', () => {

                setTimeout(() => {
                    loader.classList.add('opacity-0', 'pointer-events-none');
                }, 400);
            });
        </script>

    </div>

    <div x-data="{ sidebarOpen: false }" x-cloak class="main-container">
        <div class="flex flex-1 ">
            @auth
                <!-- Desktop Sidebar -->
                <aside class="hidden w-auto md:block bg-teal-950">
                    @include('layouts.app.navigation')
                </aside>

                <!-- Mobile Sidebar -->
                <aside x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-x-full"
                    x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 -translate-x-full"
                    class="fixed inset-0 z-50 w-64 shadow-xl md:hidden transform bg-gradient-to-r from-teal-900 to-teal-700">
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
                    <header class="sticky top-0 z-40 flex items-center justify-between px-4 py-2 bg-teal-900 shadow-lg">



                        <!-- Mobile Sidebar Toggle -->
                        <button @click="sidebarOpen = !sidebarOpen"
                            class="text-white md:hidden hover:text-teal-400 focus:outline-none">
                            <i class="fas fa-bars text-2xl"></i>
                        </button>

                        <!-- Topbar right controls -->
                        <div class="flex items-center ml-auto space-x-3">
                            <livewire:admin.notifications-menu />
                            {{-- <livewire:admin.help-menu /> --}}
                            <livewire:admin.users.user-menu />
                        </div>
                    </header>
                @endauth

                <!-- Slot Content -->
                <main class="content bg-gray-900">
                    {{ $slot ?? '' }}
                </main>

                <!-- Footer -->
                <footer class="w-full px-4 py-3 text-xs text-center text-gray-300 bg-teal-800 footer">
                    &copy; {{ date('Y') }} {{ config('app.name') }} —
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
