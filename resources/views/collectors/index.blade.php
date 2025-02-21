<x-app-layout>
    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-white bg-green-600 rounded-md shadow-lg" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mx-auto">
        <!-- Page Header -->
        <div
            class="flex flex-col items-start justify-between p-3 mb-6 space-y-4 rounded-md shadow-md bg-gradient-to-r from-green-800 to-green-600 md:flex-row md:items-center md:space-y-0">
            <h1 class="text-2xl font-bold text-white">My Records</h1>
            <a href="{{ route('collector.newCollector') }}"
                class="px-4 py-2 text-sm font-bold text-white transition bg-gray-900 rounded shadow-sm hover:bg-teal-950 hover:shadow-lg">
                + Add Collector
            </a>
        </div>

        <!-- Collector Cards -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($collectors as $collector)
                <div class="p-4 transition duration-300 rounded-lg shadow-lg bg-slate-800 hover:bg-slate-900">
                    <h2 class="mb-2 text-xl font-semibold text-white">
                        {{ $collector->riceSeason->name }}
                    </h2>
                    <p class="mb-3 text-sm">
                        <span class="text-orange-400">{{ $collector->getDistrict->name }}</span>
                        <i class="text-gray-400 fas fa-arrow-right"></i>
                        <span class="text-pink-400"> {{ $collector->getAsCenter->name }}</span>
                        <i class="text-gray-400 fas fa-arrow-right"></i>
                        <span class="text-yellow-400">{{ $collector->getAiRange->name }}</span>
                    </p>
                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                        <a href="{{ route('collector.edit', $collector->id) }}"
                            class="w-full px-4 py-2 text-sm font-bold text-white transition bg-red-700 rounded shadow-sm hover:bg-red-900 hover:shadow-lg">
                            Edit Collector
                        </a>
                        <a href="{{ route('pestdata.view', $collector->id) }}"
                            class="w-full px-4 py-2 text-sm font-bold text-white transition bg-blue-700 rounded shadow-sm hover:bg-blue-900 hover:shadow-lg">
                            Pest Data
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- JavaScript to Hide Message After 5 Seconds -->
    <script>
        setTimeout(() => {
            const successMessage = document.querySelector('.alert-success');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 5000);
    </script>
</x-app-layout>
