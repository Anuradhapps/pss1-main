@props([
    'route' => '',
    'icon' => '',
])

<a href="{{ route($route) }}"
    class="flex items-center gap-2 px-4 py-2 rounded-lg transition-all duration-200
          {{ url()->current() == route($route)
              ? 'bg-gray-200 text-gray-900 dark:bg-gray-700 dark:text-white'
              : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white' }}
          focus:outline-none">

    @if ($icon)
        <i class="{{ $icon }} text-lg"></i>
    @endif

    <span class="text-sm font-medium">{{ $slot }}</span>
</a>
