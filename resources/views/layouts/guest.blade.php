<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/LOGO.ico') }}" />
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts (Optional, Dark-Friendly Fonts like Inter or JetBrains Mono) -->
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

    <!-- Vite -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="min-h-screen text-gray-100 bg-gray-900">
    <div class="font-sans antialiased">
        {{ $slot }}
    </div>
</body>

</html>
