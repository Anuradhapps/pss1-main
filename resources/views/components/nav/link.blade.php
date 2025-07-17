@props([
    'route' => '',
    'icon' => '',
    'class' => '', // Allow external class merging
])

@php
    $isActive = Route::is($route)
        ? 'bg-gradient-to-r from-green-700 to-green-800 text-white'
        : 'text-gray-300 hover:bg-white hover:text-green-900';
@endphp

<a href="{{ route($route) }}" @class([
    'flex items-center w-full px-4 py-2 text-md font-medium transition-all duration-200',
    $isActive,
    $class, // Merge externally passed classes
])>
    @if ($icon)
        <i
            class="{{ $icon }} w-5 mr-3  {{ url()->current() == route($route) ? ' text-white' : 'text-green-600' }}"></i>
    @endif
    <span class="truncate">{{ $slot }}</span>
</a>
