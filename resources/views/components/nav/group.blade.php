@props([
    'label' => '',
    'icon' => '',
    'route' => '',
    'activeRoutes' => null,
])

@php
    $activeRoutes = $activeRoutes ?: $route . '*';
    $openState = collect(explode('|', $activeRoutes))->contains(fn($pattern) => Route::is(trim($pattern)))
        ? '{ isOpen: true }'
        : '{ isOpen: false }';
@endphp

<div x-data="{{ $openState }}" class="block w-full mb-1">
    <!-- Toggle Button -->
    <div @click="isOpen = !isOpen"
        class="flex items-center justify-between px-4 py-3 cursor-pointer transition-all duration-200 group rounded-l-lg
               text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200">

        <div class="flex items-center gap-2">
            @if ($icon)
                <i class="{{ $icon }} text-lg w-5 mr-1 text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300 transition-colors"></i>
            @endif
            <span class="text-sm font-medium">{{ $label }}</span>
        </div>

        <!-- Icons: Up & Down -->
        <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform duration-200"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
        </svg>
        <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform duration-200"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>

    <!-- Dropdown Content -->
    <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-screen"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 max-h-screen"
        x-transition:leave-end="opacity-0 max-h-0" class="mt-1 ml-4 border-l border-slate-200 dark:border-slate-700 pl-2 space-y-1 overflow-hidden">
        {{ $slot }}
    </div>
</div>
