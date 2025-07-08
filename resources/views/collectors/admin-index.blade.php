<x-app-layout>
    @if (session('success'))
        <div class="p-4 mb-6 text-sm font-medium text-white rounded-lg shadow-lg bg-emerald-600 animate-fade-in-down"
            role="alert">
            🎉 {{ session('success') }}
        </div>
    @endif

    <div class="container mx-auto">
        <!-- Page Header -->
        <div
            class="flex flex-col items-start justify-between p-4 mb-8 space-y-4 shadow-xl rounded-xl bg-gradient-to-r from-sky-900 to-sky-700 md:flex-row md:items-center md:space-y-0">
            <!-- Breadcrumb -->
            <nav class="mb-4 text-sm text-gray-400">
                <a href="{{ route('admin.users.index') }}" class="text-emerald-400 hover:underline">Users</a>
                <span class="mx-2">›</span>
                <span class="text-gray-300">{{ $user->name }}</span>
            </nav>
        </div>

        <!-- Collector Cards -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($collectors as $collector)
                <div
                    class="p-5 transition duration-300 bg-gradient-to-br from-slate-800 via-slate-900 to-gray-900 rounded-2xl shadow-sm hover:shadow-3xl hover:scale-[1.01]">
                    <div class="flex items-center justify-between mb-2">
                        <!-- Arrow Tag -->
                        <span class="inline-flex items-center">
                            <span
                                class="inline-flex items-center py-1 pl-3 pr-3 text-sm font-bold text-white rounded-l-full shadow-md bg-emerald-600">
                                {{ $collectors->count() - $loop->index }}
                            </span>
                            <span
                                class="w-0 h-0 border-t-8 border-b-8 border-l-8 border-t-transparent border-b-transparent border-l-emerald-600"></span>
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold tracking-wide text-white rounded-r-full shadow-md bg-emerald-700">
                                {{ $collector->riceSeason->name }} Season
                            </span>
                        </span>


                        <form action="{{ route('admin.collector.destroy', $collector->id) }}" method="POST"
                            onsubmit="return confirmDelete()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="confirmDelete(event)"
                                class="text-red-500 transition duration-150 hover:text-red-700">
                                <i class="text-lg fas fa-trash-alt"></i>
                            </button>
                        </form>

                    </div>

                    <!-- Location Info -->
                    <p class="mt-1 mb-1 text-sm text-slate-300">
                        <span class="font-medium text-orange-400">{{ $collector->getDistrict->name }}</span>
                        <i class="mx-1 text-slate-400 fas fa-chevron-right"></i>
                        <span class="font-medium text-pink-400">{{ $collector->getAsCenter->name }}</span>
                        <i class="mx-1 text-slate-400 fas fa-chevron-right"></i>
                        <span class="font-medium text-yellow-400">{{ $collector->getAiRange->name }}</span>
                    </p>

                    <!-- Metadata -->
                    <div class="mb-4 space-y-1 text-xs leading-snug text-slate-400">
                        <div><span class="font-semibold text-slate-300">Created at:</span> {{ $collector->created_at }}
                        </div>
                        <div><span class="font-semibold text-slate-300">Updated at:</span> {{ $collector->updated_at }}
                        </div>
                        <div><span class="font-semibold text-slate-300">Rice Varity:</span>
                            {{ $collector->rice_variety }}
                        </div>
                        <div><span class="font-semibold text-slate-300">Rice Established Date:</span>
                            {{ $collector->date_establish }}
                        </div>
                        <div><span class="font-semibold text-slate-300">Established Method:</span>
                            {{ $collector->established_method ? $collector->established_method : 'N/A' }}
                        </div>
                        <div><span class="font-semibold text-slate-300">Pest Dataset Count:</span>
                            {{ $collector->commonDataCollect->count() }}</div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('collector.edit', $collector->id) }}"
                            class="w-full px-4 py-2 text-sm font-bold text-white transition duration-200 rounded-full shadow-md bg-rose-700 hover:bg-rose-900 hover:shadow-lg">
                            ✏️ Edit Collector
                        </a>
                        <a href="{{ route('pestdata.view', $collector->id) }}"
                            class="w-full px-4 py-2 text-sm font-bold text-white transition duration-200 bg-indigo-700 rounded-full shadow-md hover:bg-indigo-900 hover:shadow-lg">
                            🐛Pest Data
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

        function confirmDelete(event) {
            if (!confirm('Are you sure you want to delete this collector?')) {
                event.preventDefault();
            }
        }
    </script>
</x-app-layout>
