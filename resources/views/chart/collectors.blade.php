<x-app-layout>
    <div class="flex items-center justify-between px-3">
        <h1 class="mb-4 text-2xl font-bold text-white">Collectors</h1>
        <a href="{{ route('chart.index') }}"
            class="px-4 py-2 mr-1 text-sm font-bold text-white bg-red-800 rounded hover:bg-red-900">Back</a>
    </div>

    <x-error-massage />
    <div class="container px-2 mx-auto ">


        @foreach ($collectors as $collector)
            <div class="flex items-center justify-between px-5 py-2 m-2 bg-orange-500 rounded-md">
                <div>{{ $collector->user->name }}</div>
                <a href="{{ route('chart.ai.show', $collector->id) }}"
                    class="px-4 py-2 text-sm font-bold text-white bg-green-800 rounded hover:bg-green-900">
                    View
                </a>
            </div>
        @endforeach
    </div>



</x-app-layout>
