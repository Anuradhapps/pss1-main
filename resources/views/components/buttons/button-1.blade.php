@props([
    'type' => 'button',
    'color' => 'blue', // customize colors like 'red', 'green', etc.
    'href' => null,
    'icon' => null, // optional icon class, e.g. 'fas fa-plus'
])

@php
    $baseClasses =
        'inline-flex items-center justify-center py-2 px-1 text-sm font-medium focus:shadow-xl transition-shadow duration-300 ease-in-out';
    $colors = [
        'blue' => 'text-white bg-blue-600 hover:bg-blue-800',
        'red' => 'text-white bg-red-600 hover:bg-red-800',
        'green' => 'text-white bg-green-600 hover:bg-green-800',
        'gray' => 'text-gray-700 bg-gray-200 hover:bg-gray-300',
    ];
    $colorClasses = $colors[$color] ?? $colors['blue'];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "$baseClasses $colorClasses"]) }}>
        @if ($icon)
            <i class="{{ $icon }} mr-2"></i>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "$baseClasses $colorClasses"]) }}>
        @if ($icon)
            <i class="{{ $icon }} mr-2"></i>
        @endif
        {{ $slot }}
    </button>
@endif
