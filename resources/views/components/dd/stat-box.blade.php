@props(['value', 'title', 'color' => 'blue'])

@php
    $styles = [
        'green' => [
            'text' => 'text-emerald-700 dark:text-emerald-400',
            'bg' => 'bg-emerald-100 dark:bg-emerald-900/30',
            'border' => 'border-emerald-200 dark:border-emerald-800',
            'accent' => 'bg-emerald-500',
            'icon' => 'fa-user-check',
        ],
        'red' => [
            'text' => 'text-red-700 dark:text-red-400',
            'bg' => 'bg-red-100 dark:bg-red-900/30',
            'border' => 'border-red-200 dark:border-red-800',
            'accent' => 'bg-red-500',
            'icon' => 'fa-user-slash',
        ],
        'blue' => [
            'text' => 'text-blue-700 dark:text-blue-400',
            'bg' => 'bg-blue-100 dark:bg-blue-900/30',
            'border' => 'border-blue-200 dark:border-blue-800',
            'accent' => 'bg-blue-500',
            'icon' => 'fa-users',
        ],
        'yellow' => [
            'text' => 'text-amber-700 dark:text-amber-400',
            'bg' => 'bg-amber-100 dark:bg-amber-900/30',
            'border' => 'border-amber-200 dark:border-amber-800',
            'accent' => 'bg-amber-500',
            'icon' => 'fa-user-clock',
        ],
    ];

    $style = $styles[$color] ?? $styles['blue'];
@endphp


<div
    class="overflow-hidden rounded-xl border {{ $style['border'] }}
            bg-white shadow-sm transition-all duration-300
            hover:shadow-md dark:bg-slate-900">

    <div class="h-1 {{ $style['accent'] }}"></div>

    <div class="flex items-center gap-3 px-3 py-2.5">

        {{-- Icon --}}
        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg {{ $style['bg'] }}">
            <i class="fas {{ $style['icon'] }} text-sm {{ $style['text'] }}"></i>
        </div>

        {{-- Title + Value --}}
        <div class="flex min-w-0 flex-1 items-center justify-between gap-2">

            <p
                class="truncate text-[11px] font-semibold uppercase tracking-wide
                      text-slate-500 dark:text-slate-400">
                {{ $title }}
            </p>

            <h2 class="text-xl font-black tracking-tight {{ $style['text'] }}">
                {{ $value }}
            </h2>

        </div>

    </div>

</div>
