@props([
    'type' => 'button',
    'color' => 'primary', // customize colors like 'danger', 'success', etc.
    'href' => null,
    'icon' => null, // optional icon class, e.g. 'fas fa-plus'
])

@php
    $baseClasses =
        'inline-flex items-center justify-center py-2 px-4 text-sm font-semibold rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-slate-900 shadow-sm hover:shadow-md transition-all duration-300 ease-in-out';
    $colors = [
        'primary' => 'text-white bg-primary hover:bg-indigo-700 focus:ring-primary',
        'danger' => 'text-white bg-red-600 hover:bg-red-700 focus:ring-red-500',
        'success' => 'text-white bg-accent hover:bg-emerald-600 focus:ring-accent',
        'secondary' => 'text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-700 focus:ring-slate-500',
    ];
    $colorClasses = $colors[$color] ?? $colors['primary'];
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
