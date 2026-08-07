@props(['title'])

<div
    class="rounded-2xl border border-slate-200/80 
           bg-white/90 
           p-5 
           shadow-sm 
           backdrop-blur-sm
           transition-all duration-300

           dark:border-slate-800
           dark:bg-slate-900/80
           dark:shadow-none">

    {{-- Header --}}
    @if (isset($title))
        <div class="mb-4 flex items-center justify-between">
            <h2
                class="text-lg font-semibold tracking-tight
                       text-slate-900
                       dark:text-slate-100">
                {{ $title }}
            </h2>
        </div>
    @endif


    {{-- Content Slot --}}
    <div
        class="space-y-4 
                text-sm 
                leading-relaxed
                text-slate-600
                
                dark:text-slate-300">
        {{ $slot }}
    </div>

</div>
