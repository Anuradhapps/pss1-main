@props([
    'label' => '',
    'icon' => '',
    'route' => '',
])

@php
    $openState = Route::is($route . '*') ? '{ isOpen: true }' : '{ isOpen: false }';
@endphp

<div x-data="{{ $openState }}" class="block w-full">
    <!-- Toggle Button -->
    <div @click="isOpen = !isOpen"
        class="flex items-center justify-between px-4 py-2 cursor-pointer transition-all duration-200
                text-gray-100 hover:bg-gray-100 hover:text-gray-900 ">

        <div class="flex items-center gap-2">
            @if ($icon)
                <i class="{{ $icon }} text-lg text-green-600"></i>
            @endif
            <span class="text-sm font-medium">{{ $label }}</span>
        </div>

        <!-- Icons: Up & Down -->
        <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-transform duration-200"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
        </svg>
        <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-transform duration-200"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>

    <!-- Dropdown Content -->
    <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-screen"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 max-h-screen"
        x-transition:leave-end="opacity-0 max-h-0" class="mt-1 ml-3 space-y-1 overflow-hidden text-sm text-gray-700 ">
        {{ $slot }}
    </div>
</div>
