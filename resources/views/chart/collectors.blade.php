<x-app-layout>
    <!-- Header -->
    <div class="flex items-center justify-between px-6 py-4 mb-6 shadow bg-sky-950 border border-sky-800">
        <h1 class="text-2xl font-semibold text-white tracking-tight">📋 Collectors</h1>
        <a href="{{ route('chart.index') }}"
            class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 transition duration-200">
            ← Back
        </a>
    </div>

    <x-error-massage />

    <!-- Collector Grid -->
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($collectors as $collector)
                <div
                    class="flex items-center justify-between px-5 py-4 bg-gradient-to-br from-orange-600 to-orange-700 shadow-sm hover:shadow-md border border-orange-800">
                    <div class="text-white font-medium truncate">
                        {{ $collector->user->name }}
                    </div>
                    <a href="{{ route('chart.ai.show', $collector->id) }}"
                        class="px-3 py-1.5 text-xs font-semibold text-white bg-green-600 hover:bg-green-700 transition duration-200">
                        View →
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-400 py-6">
                    No collectors found.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
