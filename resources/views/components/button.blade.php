@props(['type' => 'submit', 'variant' => 'primary'])

@php
    $baseClasses = 'inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-semibold transition-all duration-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-slate-900 shadow-sm hover:shadow-md disabled:opacity-50 disabled:cursor-not-allowed';
    
    $variants = [
        'primary' => 'text-white bg-primary hover:bg-indigo-700 focus:ring-primary',
        'secondary' => 'text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-700 focus:ring-slate-500',
        'danger' => 'text-white bg-red-600 hover:bg-red-700 focus:ring-red-500',
        'ghost' => 'text-slate-600 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 shadow-none hover:shadow-none',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
