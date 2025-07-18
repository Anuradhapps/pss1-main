@props([
    'title' => '',
    'subtitle' => '',
    'icon' => null,
    'class' => '',
    'buttonText' => null,
    'buttonAction' => '#',
    'buttonIcon' => 'fas fa-plus', // optional
    'buttonColor' => 'blue', // default button color
])

@php
    $buttonColors = [
        'blue' => 'bg-blue-700 hover:bg-blue-900 hover:shadow-lg',
        'red' => 'bg-red-700 hover:bg-red-900 hover:shadow-lg',
        'green' => 'bg-green-700 hover:bg-green-900 hover:shadow-lg',
        'gray' => 'bg-gray-700 hover:bg-gray-900 hover:shadow-lg',
        'purple' => 'bg-purple-700 hover:bg-purple-900 hover:shadow-lg',
        // add more colors if you want
    ];

    $buttonColorClasses = $buttonColors[$buttonColor] ?? $buttonColors['blue'];
@endphp

<div class="p-2 {{ $class }}">
    <div class="flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            @if ($icon)
                <i class="{{ $icon }} text-2xl"></i>
            @endif
            <h1 class="text-2xl font-bold text-white">{{ $title }}</h1>
        </div>

        @if ($buttonText)
            <a href="{{ $buttonAction }}"
                class="inline-flex items-center px-3 py-2 text-sm font-semibold text-white {{ $buttonColorClasses }} transition">
                @if ($buttonIcon)
                    <i class="{{ $buttonIcon }} mr-1"></i>
                @endif
                {{ $buttonText }}
            </a>
        @endif
    </div>

    @if ($subtitle)
        <p class="text-sm text-gray-300">{{ $subtitle }}</p>
    @endif
</div>
