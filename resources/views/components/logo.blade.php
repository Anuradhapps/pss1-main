<div {{ $attributes->merge([
    'class' => 'flex items-center gap-2.5 sm:gap-3 min-w-0',
]) }}>

    {{-- Logo --}}
    <div class="shrink-0 flex items-center justify-center">
        <img src="{{ asset('images/LOGO.webp') }}" alt="National Pest Surveillance System" width="40" height="40"
            loading="eager" decoding="async" class="h-9 w-9 sm:h-10 sm:w-10 object-contain">
    </div>

    {{-- Name --}}
    <div class="min-w-0 leading-tight">
        <h1
            class="text-[12px] sm:text-sm md:text-[15px]
                   font-bold tracking-tight
                   text-slate-800 dark:text-white">
            <span class="block">National Pest</span>
            <span class="block">Surveillance System</span>
        </h1>

        <span
            class="hidden sm:block mt-0.5
                   text-[9px] font-medium uppercase tracking-widest
                   text-slate-400 dark:text-slate-500">
            NPSS
        </span>
    </div>

</div>
