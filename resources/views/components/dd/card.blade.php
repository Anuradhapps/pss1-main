@props(['title'])

<div class="bg-gray-800  px-6 py-3 shadow">
    <h2 class="text-lg font-semibold text-white mb-2">{{ $title }}</h2>
    {{ $slot }}
</div>
