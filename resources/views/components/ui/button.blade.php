@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'loading' => false,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-semibold rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed group';

    $sizeClasses = [
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ][$size];

    $variantClasses = [
        'primary' => 'bg-primary hover:bg-primary-hover text-white shadow-md hover:shadow-lg focus:ring-primary/50 dark:focus:ring-offset-slate-900',
        'secondary' => 'bg-secondary hover:bg-sky-800 text-white shadow-md hover:shadow-lg focus:ring-secondary/50 dark:focus:ring-offset-slate-900',
        'success' => 'bg-success hover:bg-green-700 text-white shadow-md hover:shadow-lg focus:ring-success/50 dark:focus:ring-offset-slate-900',
        'danger' => 'bg-danger hover:bg-red-700 text-white shadow-md hover:shadow-lg focus:ring-danger/50 dark:focus:ring-offset-slate-900',
        'outline' => 'border-2 border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:border-primary hover:text-primary dark:hover:border-primary dark:hover:text-primary focus:ring-primary/50 dark:focus:ring-offset-slate-900',
        'ghost' => 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-200',
    ][$variant];
@endphp

<button {{ $attributes->merge(['type' => $type, 'class' => "$baseClasses $sizeClasses $variantClasses"]) }}
    @if($loading) disabled @endif>
    
    @if($loading)
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @endif

    {{ $slot }}
</button>
