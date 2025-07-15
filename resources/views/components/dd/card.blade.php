@props(['title'])

<div class="bg-gray-800 rounded-xl p-6 shadow">
    <h2 class="text-lg font-semibold text-white mb-4">{{ $title }}</h2>
    {{ $slot }}
</div>
