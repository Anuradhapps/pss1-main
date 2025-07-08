<x-app-layout>
    <div class="flex items-center justify-between px-4 py-4 mb-6 rounded-lg shadow-md bg-sky-900">
        <h1 class="text-2xl font-bold text-white">📋 Collectors</h1>
        <a href="{{ route('chart.index') }}"
            class="px-4 py-2 text-sm font-semibold text-white bg-red-700 rounded hover:bg-red-800">
            Back
        </a>
    </div>

    <x-error-massage />

    <div class="container mx-auto">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($collectors as $collector)
                <div class="flex items-center justify-between p-4 bg-orange-500 rounded-md shadow">
                    <div class="font-medium text-white">{{ $collector->user->name }}</div>
                    <a href="{{ route('chart.ai.show', $collector->id) }}"
                        class="px-3 py-1 text-sm font-bold text-white bg-green-700 rounded hover:bg-green-800">
                        View
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
