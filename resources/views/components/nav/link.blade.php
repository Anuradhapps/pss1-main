@props([
    'route' => '',
    'icon' => '',
    'class' => '', // Allow external class merging
])

@php
    $isActive = Route::is($route)
        ? 'bg-gradient-to-r from-green-700 to-green-800 text-white'
        : 'text-gray-300 hover:bg-gray-800 hover:text-white';
@endphp

<a href="{{ route($route) }}" @class([
    'flex items-center w-full px-4 py-2 text-md font-medium rounded-lg transition-all duration-200',
    $isActive,
    $class, // Merge externally passed classes
])>
    @if ($icon)
        <i class="{{ $icon }} w-5 mr-3 text-green-400"></i>
    @endif
    <span class="truncate">{{ $slot }}</span>
</a>
