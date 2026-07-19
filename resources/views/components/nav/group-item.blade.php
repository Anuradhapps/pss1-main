@props([
    'route' => '',
    'icon' => '',
])

<a href="{{ route($route) }}"
    class="flex items-center gap-2 px-4 py-2 text-sm font-medium transition-all duration-200 group rounded-l-lg mb-1
          {{ url()->current() == route($route)
              ? 'bg-primary/10 text-primary dark:bg-primary/20 dark:text-indigo-400 font-semibold'
              : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-800 dark:hover:text-slate-200' }}
          ">

    @if ($icon)
        <i
            class="{{ $icon }} w-5 mr-1 text-base {{ url()->current() == route($route) ? 'text-primary dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300 transition-colors' }}"></i>
    @endif

    <span class="truncate">{{ $slot }}</span>
</a>
