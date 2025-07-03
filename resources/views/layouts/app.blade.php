<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('images/LOGO.ico') }}">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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

<body class="antialiased text-white bg-gray-900">
    <div x-data="{ sidebarOpen: false }" x-cloak class="main-container">
        <div class="flex flex-1">
            @auth
                <!-- Desktop Sidebar -->
                <aside class="hidden w-64 bg-green-900 shadow-lg md:block">
                    <div class="mt-4">
                        @include('layouts.app.navigation')
                    </div>
                </aside>

                <!-- Mobile Sidebar -->
                <aside x-show="sidebarOpen"
                    class="fixed inset-0 z-50 w-64 transition-all duration-300 bg-green-900 shadow-xl md:hidden">
                    <div class="flex justify-end p-4">
                        <button @click="sidebarOpen = false" class="text-xl text-white">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="px-4">
                        @include('layouts.app.navigation')
                    </div>
                </aside>
            @endauth

            <!-- Main Content Area -->
            <div id="main" class="flex flex-col w-full bg-gray-800">
                @auth
                    <!-- Topbar -->
                    <header class="flex items-center justify-between px-4 py-3 bg-teal-800 shadow-sm">
                        <!-- Mobile menu toggle -->
                        <button @click="sidebarOpen = !sidebarOpen" class="text-white md:hidden">
                            <i class="text-xl fas fa-bars"></i>
                        </button>

                        <!-- Topbar right controls -->
                        <div class="flex items-center ml-auto space-x-3">
                            <livewire:admin.notifications-menu />
                            <livewire:admin.help-menu />
                            <livewire:admin.users.user-menu />
                        </div>
                    </header>
                @endauth

                <!-- Slot Content -->
                <main class="px-4 py-5 text-black bg-gray-300 content">
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

    <script src="//unpkg.com/alpinejs" defer></script>

    @livewireScripts
    @stack('scripts')
</body>

</html>
