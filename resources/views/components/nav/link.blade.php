@props([
    'route' => '',
    'icon' => '',
    'class' => '', // Allow external class merging
])

@php
    $isActive = Route::is($route)
        ? 'bg-primary/10 text-primary dark:bg-primary/20 dark:text-indigo-400 font-semibold border-r-4 border-primary'
        : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200';
@endphp

<a href="{{ route($route) }}" @click="sidebarOpen = false" @class([
    'flex items-center w-full px-4 py-3 text-sm font-medium transition-all duration-200 group rounded-l-lg mb-1',
    $isActive,
    $class, // Merge externally passed classes
])>
    @if ($icon)
        <i
            class="{{ $icon }} w-5 mr-3 text-lg {{ url()->current() == route($route) ? 'text-primary dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300 transition-colors' }}"></i>
    @endif
    <span class="truncate">{{ $slot }}</span>
</a>
