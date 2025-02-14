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
    </style>
</head>

<body>

    <div x-data="{ sidebarOpen: false }" x-cloak>
        <div class="flex min-h-screen">

            @auth
                <!-- regular sidebar -->
                <div class="flex-none hidden w-full px-4 bg-green-900 sidebar md:block md:w-60 dark:bg-green-900">
                    @include('layouts.app.navigation')
                </div>

                <!--sidebar on mobile-->
                <div x-show.transition.origin.top.left="sidebarOpen"
                    class="min-w-full px-4 bg-green-900 sidebar dark:bg-green-900 md:hidden">
                    @include('layouts.app.navigation')
                </div>
            @endauth

            <div id="main" class="w-full bg-gray-600 dark:bg-gray-700">

                @auth
                    <div class="flex justify-between px-2 py-1 mb-5 bg-gray-400 dark:bg-gray-900">

                        <div class="flex">
                            <button @click.stop="sidebarOpen = !sidebarOpen" class="pl-1 pr-2 md:hidden focus:outline-none">
                                <svg class="w-6 text-gray-900 transition duration-150 ease-in-out dark:text-gray-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h8m-8 6h16" />
                                </svg>
                            </button>

                            {{-- <livewire:admin.search /> --}}
                        </div>

                        <div class="flex">
                            <livewire:admin.notifications-menu />
                            <livewire:admin.help-menu />
                            <livewire:admin.users.user-menu />
                        </div>
                    </div>
                @endauth

                <div class="px-1 py-1 bg-gray-200 dark:bg-slate-700">
                    {{ $slot ?? '' }}
                </div>
            </div>

        </div>

        <div class="flex justify-between p-5 text-xs bg-white dark:bg-gray-900 dark:text-gray-300">
            <div>{{ __('Copyright') }} &copy; {{ date('Y') }} {{ config('app.name') }}</div>
        </div>

    </div>
    <script src="//unpkg.com/alpinejs" defer></script>

    <livewire:scripts />
</body>

</html>
