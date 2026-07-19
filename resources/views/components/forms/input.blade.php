@props([
    'disabled' => false,
    'label' => null,
    'error' => null,
    'help' => null,
    'icon' => null,
])

<div class="w-full">
    @if($label)
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
            {{ $label }}
        </label>
    @endif
    
    <div class="relative">
        @if($icon)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <i class="{{ $icon }}"></i>
            </div>
        @endif
        
        <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
            'class' => 'w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary/20 dark:focus:border-primary dark:focus:ring-primary/20 transition-colors duration-200 disabled:opacity-60 disabled:bg-slate-50 dark:disabled:bg-slate-900' . ($icon ? ' pl-10' : '') . ($error ? ' border-danger focus:border-danger focus:ring-danger/20' : '')
        ]) !!}>
        
        @if($error)
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-danger">
                <i class="fas fa-exclamation-circle"></i>
            </div>
        @endif
    </div>
    
    @if($error)
        <p class="mt-1.5 text-sm text-danger animate-pulse">{{ $error }}</p>
    @elseif($help)
        <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">{{ $help }}</p>
    @endif
</div>
