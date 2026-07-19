@props([
    'icon' => 'fas fa-inbox',
    'title' => 'No Data Found',
    'description' => 'There are currently no records to display.',
])

<div class="flex flex-col items-center justify-center p-12 text-center">
    <div class="inline-flex items-center justify-center w-20 h-20 mb-4 rounded-full bg-slate-50 dark:bg-slate-800/50 text-slate-400 dark:text-slate-500 transition-colors">
        <i class="{{ $icon }} text-4xl"></i>
    </div>
    
    <h3 class="mb-2 text-lg font-semibold text-slate-900 dark:text-white">
        {{ $title }}
    </h3>
    
    <p class="mb-6 max-w-sm text-sm text-slate-500 dark:text-slate-400">
        {{ $description }}
    </p>
    
    @if(isset($action))
        <div class="mt-2">
            {{ $action }}
        </div>
    @endif
</div>
