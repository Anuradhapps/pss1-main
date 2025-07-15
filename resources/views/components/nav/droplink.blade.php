@php
    use Illuminate\Support\Str;
@endphp

@props(['href' => '', 'icon' => ''])

<a href="{{ $href }}"
    class="block w-full px-4 py-2 border-l-4 transition-all duration-200
          {{ Str::endsWith(request()->url(), $href)
              ? 'bg-gray-200 text-gray-900 border-indigo-500 dark:bg-gray-700 dark:text-white'
              : 'text-gray-500 border-transparent hover:bg-gray-100 hover:text-gray-900 hover:border-gray-300 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white' }}
          text-base font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">

    <div class="flex items-center gap-2">
        @if ($icon)
            <i class="{{ $icon }} text-lg"></i>
        @endif
        <span>{{ $slot }}</span>
    </div>
</a>
