<x-ui.card padding="p-2.5"
    class="relative group cursor-pointer border-l-2 overflow-hidden
           {{ str_replace('from-', 'border-', explode(' ', $color)[0]) }}">
    {{-- Background decoration --}}
    <div
        class="absolute right-0 top-0 w-14 h-14
               bg-gradient-to-br {{ $color }}
               opacity-10 rounded-bl-full
               -mr-3 -mt-3
               transition-transform duration-300
               group-hover:scale-110">
    </div>

    <div class="relative z-10 flex items-center justify-between gap-2" wire:key="{{ $cardName }}">
        <div class="min-w-0 flex-1">
            <p
                class="text-[9px] sm:text-[10px]
                       font-semibold uppercase tracking-wide
                       text-slate-500 dark:text-slate-400
                       truncate">
                {{ preg_replace('/(?<!\ )[A-Z]/', ' $0', $cardName) }}
            </p>

            <h3
                class="mt-1 text-xl sm:text-2xl
                       font-bold leading-none
                       text-slate-900 dark:text-white">
                {{ $userCount }}
            </h3>
        </div>

        <div
            class="shrink-0 w-7 h-7 sm:w-8 sm:h-8
                   rounded-md flex items-center justify-center
                   bg-gradient-to-br {{ $color }}
                   text-white shadow-sm
                   group-hover:shadow-md
                   transition-shadow duration-300">
            <i class="{{ $iconName }} text-xs"></i>
        </div>
    </div>
</x-ui.card>
