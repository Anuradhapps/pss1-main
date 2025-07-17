@props([
    'route' => '',
    'icon' => '',
])

<a href="{{ route($route) }}"
    class="flex items-center gap-2 px-4 py-2  transition-all duration-200
          {{ url()->current() == route($route)
              ? 'bg-gradient-to-r from-green-700 to-green-800 text-white'
              : 'text-gray-300 hover:bg-white hover:text-green-900' }}
          ">

    @if ($icon)
        <i
            class="{{ $icon }} w-6 text-lg {{ url()->current() == route($route) ? ' text-white' : 'text-gray-500' }}"></i>
    @endif

    <span class="text-sm font-medium">{{ $slot }}</span>
</a>
