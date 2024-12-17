<x-app-layout>
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="container p-6 mx-auto">
        <h1 class="p-3 mb-6 text-3xl font-bold text-gray-200 bg-orange-900">My Collectors</h1>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($collectors as $collector)
                <div class="transition duration-300 rounded-lg shadow-2xl hover:bg-green-900 bg-slate-800">
                    <a href="{{ route('collector.edit', $collector->id) }}" class="block p-6">
                        <h2 class="mb-2 text-xl font-semibold text-white">
                            {{ $collector->riceSeason->name }}
                        </h2>
                        <p class="text-orange-500">
                            {{ $collector->getDistrict->name }}>
                            {{ $collector->getAsCenter->name }}>
                            {{ $collector->getAiRange->name }}

                        </p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>



</x-app-layout>
