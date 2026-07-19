@props([
    'variant' => 'info',
])

@php
    $variantClasses = [
        'primary' => 'bg-primary/10 text-primary dark:bg-primary/20 dark:text-primary-light border-primary/20',
        'secondary' => 'bg-secondary/10 text-secondary dark:bg-secondary/20 dark:text-sky-300 border-secondary/20',
        'success' => 'bg-success/10 text-success dark:bg-success/20 dark:text-green-300 border-success/20',
        'warning' => 'bg-warning/10 text-warning dark:bg-warning/20 dark:text-amber-300 border-warning/20',
        'danger' => 'bg-danger/10 text-danger dark:bg-danger/20 dark:text-red-300 border-danger/20',
        'info' => 'bg-info/10 text-info dark:bg-info/20 dark:text-sky-300 border-info/20',
        'gray' => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300 border-slate-200 dark:border-slate-700',
    ][$variant];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border $variantClasses"]) }}>
    {{ $slot }}
</span>
