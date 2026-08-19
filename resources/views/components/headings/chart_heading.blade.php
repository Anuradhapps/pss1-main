@props(['title', 'description' => null, 'icon' => 'fas fa-chart-line', 'backRoute' => null, 'backText' => 'Back'])

<div
    {{ $attributes->merge([
        'class' => 'border-b mb-1 rounded-lg border-slate-200 bg-white
                    dark:border-slate-800 dark:bg-slate-900',
    ]) }}>

    <div class="px-3 sm:px-4">
        <div class="flex items-center justify-between gap-3 py-2.5 sm:py-3">

            <!-- Title -->
            <div class="flex min-w-0 items-center gap-2.5">

                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg
                            bg-emerald-100 text-emerald-600
                            dark:bg-emerald-500/10 dark:text-emerald-400">

                    <i class="{{ $icon }} text-sm"></i>

                </div>

                <div class="min-w-0">

                    <h1
                        class="truncate text-base font-bold leading-tight
                               text-slate-900 dark:text-white sm:text-lg">
                        {{ $title }}
                    </h1>

                    @if ($description)
                        <p class="hidden text-xs text-slate-500 dark:text-slate-400 sm:block">
                            {{ $description }}
                        </p>
                    @endif

                </div>
            </div>


            <!-- Back Button -->
            @if ($backRoute)
                <a href="{{ route($backRoute) }}"
                    class="inline-flex shrink-0 items-center justify-center gap-1.5
                           rounded-lg border border-slate-200 bg-white
                           px-3 py-2 text-xs font-semibold text-slate-700
                           shadow-sm transition-colors
                           hover:bg-slate-50
                           focus:outline-none focus:ring-2 focus:ring-emerald-500/30
                           dark:border-slate-700 dark:bg-slate-800
                           dark:text-slate-200 dark:hover:bg-slate-700">

                    <i class="fas fa-arrow-left text-[10px]"></i>

                    <span>{{ $backText }}</span>

                </a>
            @endif

        </div>
    </div>
</div>
