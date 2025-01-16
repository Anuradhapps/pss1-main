<x-app-layout>
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    {{-- @if (isset($success))
        <div id="success-message" class="alert alert-success" role="alert">
            {{ $success }}
        </div>
    @endif --}}


    <div class="container p-6 mx-auto">
        <div class="flex items-center justify-between px-2 py-4 mb-4 bg-gray-900">
            <h1 class="text-2xl font-bold ">My Records</h1>
            <a href="{{ route('collector.newCollector') }}"
                class="px-4 py-2 text-sm font-bold bg-blue-800 rounded shadow-sm hover:bg-blue-900 hover:shadow-2xl">
                Add Collector +
            </a>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($collectors as $collector)
                <div class="transition duration-300 rounded-lg shadow-2xl hover:bg-slate-900 bg-slate-800">
                    <div class="block p-4">
                        <h2 class="text-xl font-semibold text-white ">
                            {{ $collector->riceSeason->name }}
                        </h2>
                        <p>
                            <span class="text-orange-700">{{ $collector->getDistrict->name }}</span>
                            <i class="fas fa-arrow-right"></i>
                            <span class="text-pink-500"> {{ $collector->getAsCenter->name }}</span>
                            <i class="fas fa-arrow-right"></i>
                            <span class="text-yellow-500">{{ $collector->getAiRange->name }}</span>
                        </p>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('collector.edit', $collector->id) }}"
                                class="px-4 py-2 text-sm font-bold text-white bg-red-700 rounded shadow-sm hover:bg-red-900 hover:shadow-2xl">Edit
                                Collector</a>
                            <a href="{{ route('pestdata.view', $collector->id) }}"
                                class="px-4 py-2 text-sm font-bold text-white bg-blue-700 rounded shadow-sm hover:bg-blue-900 hover:shadow-2xl">
                                Pest Data</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>



    <!-- JavaScript to Hide Message After 5 Seconds -->
    <script>
        setTimeout(() => {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none'; // Hide message
            }
        }, 5000); // 5000ms = 5 seconds
    </script>
</x-app-layout>
