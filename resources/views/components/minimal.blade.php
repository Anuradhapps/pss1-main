<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name'))</title>
    <link rel="icon" href="{{ asset('images/LOGO.ico') }}">

    <!-- Core CSS -->
    @vite(['resources/sass/app.scss'])

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    @stack('styles')
    @livewireStyles

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            @apply min-h-screen bg-gray-900 text-white antialiased;
        }

        .content-wrapper {
            @apply min-h-screen flex flex-col;
        }
    </style>
</head>

<body>
    <!-- Simplified Loader -->
    <div id="pageLoader"
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/90 transition-opacity duration-300">
        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
    </div>

    <div class="content-wrapper">
        <!-- Main Content Only - No Sidebar/Topbar/Footer -->
        <main class="flex-grow">
            {{ $slot }}
        </main>
    </div>

    <!-- Core JS -->
    @vite(['resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <!-- Chart Zoom Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom"></script>

    @livewireScripts
    @stack('scripts')

    <script>
        // Simplified loader control
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.getElementById('pageLoader').style.display = 'none';
            }, 300);
        });
    </script>
</body>

</html>
