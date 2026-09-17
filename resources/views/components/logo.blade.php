<div {{ $attributes->merge(['class' => 'flex items-center gap-3 w-full']) }}>

    {{-- Logo --}}
    <div
        class="flex-shrink-0 flex items-center justify-center
                h-10 w-10 sm:h-12 sm:w-12
                rounded-xl
                bg-white dark:bg-slate-800
                border border-slate-200 dark:border-slate-700
                shadow-sm dark:shadow-slate-950/30
                transition-colors duration-300">

        <img src="{{ asset('images/LOGO.webp') }}" alt="National Pest Surveillance System Logo"
            class="h-8 w-8 sm:h-10 sm:w-10 object-contain" />
    </div>

    {{-- System Name --}}
    <div class="flex flex-col justify-center min-w-0 leading-snug">

        <h1
            class="text-[16px] sm:text-[15px]
                   font-bold tracking-tight
                   text-slate-800 dark:text-white
                   leading-[1.2]
                   transition-colors duration-300">
            NPSS
        </h1>

        <span
            class="mt-0.5 text-[8px] hidden sm:block
                     font-medium uppercase tracking-wider
                     text-slate-500 dark:text-slate-400">
            National Pest
            Surveillance System
        </span>

    </div>

</div>
