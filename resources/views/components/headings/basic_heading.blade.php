@props(['title', 'description' => null, 'icon' => null])

<div
    class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-slate-900 p-1 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute -right-10 -top-10 w-40 h-40 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-10 right-20 w-32 h-32 bg-secondary/10 rounded-full blur-2xl pointer-events-none"></div>

    <div class="flex items-center  relative z-10">
        <div
            class="w-12 h-12 rounded-xl bg-primary/10 dark:bg-primary/20 flex items-center justify-center text-primary dark:text-primary-light">


            @if ($icon)
                <i class="{{ $icon }} text-xl"></i>
            @endif
        </div>
        <div>
            <h1 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">{{ $title }}</h1>
            @if ($description)
                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $description }}</p>
            @endif
        </div>
    </div>
</div>
