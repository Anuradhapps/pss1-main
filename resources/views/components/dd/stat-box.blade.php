@props(['value', 'title', 'color'])

@php
    $colorClass = match ($color) {
        'green' => 'text-green-400',
        'red' => 'text-red-400',
        'blue' => 'text-blue-400',
        'yellow' => 'text-yellow-400',
        default => 'text-white',
    };
@endphp

<div class="bg-gray-800 p-4 rounded-md text-center shadow">
    <div class="text-xl font-bold {{ $colorClass }}">{{ $value }}</div>
    <div class="text-gray-300">{{ $title }}</div>
</div>
