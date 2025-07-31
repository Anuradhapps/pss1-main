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

<div
    {{ $attributes->merge(['class' => 'bg-gray-900 p-3 rounded-md text-center shadow-sm border border-gray-700 hover:shadow-md transition duration-300 ease-in-out cursor-default select-none']) }}>
    <div class="text-3xl font-extrabold {{ $colorClass }} leading-tight">{{ $value }}</div>
    <div class="mt-2 text-sm text-gray-400 font-semibold uppercase tracking-wide">
        {{ $title }}
    </div>
</div>
