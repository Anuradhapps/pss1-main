@props(['title'])

<div
    class="bg-gray-900/90 backdrop-blur-sm border border-gray-700 rounded-2xl p-6 shadow-md hover:shadow-lg transition-shadow duration-300">
    <!-- Title -->
    <h2 class="text-lg md:text-xl font-semibold text-white mb-4 border-b border-gray-700 pb-2">
        {{ $title }}
    </h2>

    <!-- Content Slot -->
    <div class="space-y-4 text-gray-300">
        {{ $slot }}
    </div>
</div>
