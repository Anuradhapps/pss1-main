@props([
    'title' => '',
    'subtitle' => '',
    'icon' => null,
    'class' => '',
    'buttonText' => null,
    'buttonAction' => '#',
    'buttonIcon' => 'fas fa-plus',
    'buttonColor' => 'blue',
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
    class="mb-2 w-full overflow-hidden rounded-xl
           border border-slate-200 bg-white
           shadow-sm
           transition-colors duration-300
           dark:border-slate-700/80 dark:bg-slate-900
           {{ $class }}">
    <div
        class="flex flex-col gap-3 px-3 py-3
               sm:flex-row sm:items-center sm:justify-between
               sm:px-4">

        {{-- ================= HEADER CONTENT ================= --}}
        <div class="min-w-0 flex-1">

            <div class="flex items-center gap-2.5">

                {{-- Icon --}}
                @if ($icon)
                    <div
                        class="flex h-9 w-9 shrink-0 items-center justify-center
                               rounded-lg
                               bg-primary/10 text-primary
                               ring-1 ring-primary/10
                               dark:bg-primary/15 dark:text-indigo-400
                               dark:ring-primary/20">
                        <i class="{{ $icon }} text-sm"></i>
                    </div>
                @endif

                {{-- Title --}}
                <h1
                    class="min-w-0 truncate
                           text-base font-bold leading-tight
                           tracking-tight
                           text-slate-800
                           dark:text-slate-100
                           sm:text-lg">
                    {{ $title }}
                </h1>

            </div>

            {{-- Subtitle --}}
            @if ($subtitle)
                <p
                    class="mt-0 text-xs leading-relaxed
                           text-slate-500
                           dark:text-slate-400
                           sm:text-sm
                           {{ $icon ? 'sm:ml-11' : '' }}">
                    {{ $subtitle }}
                </p>
            @endif

        </div>


        {{-- ================= ACTION BUTTON ================= --}}
        @if ($buttonText)

            <a href="{{ $buttonAction }}"
                class="inline-flex w-full shrink-0 items-center justify-center
                       gap-2 rounded-lg
                       px-4 py-2
                       text-xs font-semibold text-white
                       shadow-sm
                       transition-all duration-200
                       hover:shadow-md
                       focus:outline-none focus:ring-2
                       focus:ring-offset-2
                       dark:focus:ring-offset-slate-900
                       sm:w-auto sm:text-sm
                       {{ $buttonColorClasses }}">
                @if ($buttonIcon)
                    <i class="{{ $buttonIcon }} text-xs"></i>
                @endif

                <span>{{ $buttonText }}</span>
            </a>

        @endif

    </div>
</div>
