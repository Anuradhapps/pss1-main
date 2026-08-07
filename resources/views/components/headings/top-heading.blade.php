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
        'blue' => 'bg-primary hover:bg-indigo-700 focus:ring-primary',
        'red' => 'bg-red-600 hover:bg-red-700 focus:ring-red-500',
        'green' => 'bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500',
        'gray' => 'bg-slate-600 hover:bg-slate-700 focus:ring-slate-500',
        'purple' => 'bg-purple-600 hover:bg-purple-700 focus:ring-purple-500',
    ];

    $buttonColorClasses = $buttonColors[$buttonColor] ?? $buttonColors['blue'];
@endphp

<div
    class="px-4 py-3 mb-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm rounded-2xl transition-colors duration-300 {{ $class }}">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                @if ($icon)
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-700 text-primary">
                        <i class="{{ $icon }} text-xl"></i>
                    </div>
                @endif
                <h1 class="text-2xl font-bold tracking-tight text-slate-50 dark:text-white">{{ $title }}</h1>
            </div>
            @if ($subtitle)
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mt-2 sm:ml-13">{{ $subtitle }}</p>
            @endif
        </div>

        @if ($buttonText)
            <a href="{{ $buttonAction }}"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 font-semibold text-white {{ $buttonColorClasses }} rounded-xl shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-slate-900 transition-all duration-300">
                @if ($buttonIcon)
                    <i class="{{ $buttonIcon }}"></i>
                @endif
                {{ $buttonText }}
            </a>
        @endif
    </div>
</div>
