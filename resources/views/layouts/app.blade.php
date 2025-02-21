<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/LOGO.ico') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')
    @stack('scripts')
    <livewire:styles />
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

<body class=":bg-gray-800">
    <div x-data="{ sidebarOpen: false }" x-cloak class="main-container">
        <div class="flex flex-1">
            @auth
                <!-- Sidebar -->
                <div class="hidden bg-green-900 w-60 md:block">
                    <div class="mt-2">
                        @include('layouts.app.navigation')
                    </div>

                </div>
                <!-- Mobile Sidebar -->
                <div x-show="sidebarOpen"
                    class="fixed inset-0 z-50 bg-gradient-to-r from-green-800 to-green-950 w-60 md:hidden">
                    <button @click="sidebarOpen = false" class="absolute text-white top-1 right-1">✖</button>
                    <div class="mt-10">
                        @include('layouts.app.navigation')
                    </div>

                </div>
            @endauth

            <div id="main" class="flex flex-col w-full bg-gray-700">
                @auth
                    <!-- Topbar -->
                    <div class="flex items-center justify-between px-3 bg-teal-800">
                        <button @click="sidebarOpen = !sidebarOpen" class="md:hidden">
                            <svg class="w-6 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h8m-8 6h16" />
                            </svg>
                        </button>
                        <div class="flex justify-end gap-3 ml-auto">
                            <livewire:admin.notifications-menu />
                            <livewire:admin.help-menu />
                            <livewire:admin.users.user-menu />
                        </div>
                    </div>
                @endauth

                <!-- Main Content -->
                <div class="px-2 py-2 content bg-slate-500">
                    {{ $slot ?? '' }}
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="w-full p-4 text-xs text-center text-gray-300 bg-teal-900 footer">
            {{ __('Copyright') }} &copy; {{ date('Y') }} {{ config('app.name') }}
        </footer>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
    <livewire:scripts />
</body>

</html>
