<x-app-layout>




    <div>
        <!-- Page Header -->
        <x-headings.top-heading title="My Records" subtitle="" icon="fas fa-folder-open" buttonText="New Collector"
            buttonAction="{{ route('collector.newCollector') }}" buttonIcon="fas fa-plus" buttonColor="blue"
            class="bg-green-700" />

        @if (session('success'))
            <div class="alert-success flex items-start gap-3 p-4 my-3 text-sm font-medium text-white border border-emerald-500 bg-emerald-600  shadow-md"
                role="alert">
                <i class="fas fa-check-circle mt-1 text-white text-lg"></i>
                <div class="flex-1">
                    {{ session('success') }}
                </div>
                <button onclick="this.parentElement.remove()"
                    class="ml-auto text-white hover:text-emerald-300 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Button to Show/Hide Filters -->
        <div x-data="{ showFilters: false }" class="mb-4">
            <button @click="showFilters = !showFilters"
                class="bg-emerald-800 hover:bg-emerald-900 text-white font-semibold px-4 py-2 transition w-full sm:w-auto">
                <i class="fas fa-filter mr-2"></i> Toggle Filters
            </button>

            <!-- Filter Form -->
            <div x-show="showFilters" x-transition class="mt-4 bg-emerald-900 text-white p-4">
                <form method="GET" action="{{ route('collector.index') }}"
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

                    <!-- Rice Season -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Rice Season</label>
                        <select name="season"
                            class="w-full bg-emerald-800 border border-emerald-600 p-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-400">
                            <option value="">All</option>
                            @foreach ($seasons as $season)
                                <option value="{{ $season->name }}"
                                    {{ request('season') == $season->name ? 'selected' : '' }}>
                                    {{ $season->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- District -->
                    <div>
                        <label class="block text-sm font-medium mb-1">District</label>
                        <select name="district"
                            class="w-full bg-emerald-800 border border-emerald-600 p-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-400">
                            <option value="">All</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->name }}"
                                    {{ request('district') == $district->name ? 'selected' : '' }}>
                                    {{ $district->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Established Date -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Established Date</label>
                        <input type="date" name="established" value="{{ request('established') }}"
                            class="w-full bg-emerald-800 border border-emerald-600 p-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-400">
                    </div>

                    <!-- Created At -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Created At</label>
                        <input type="date" name="created" value="{{ request('created') }}"
                            class="w-full bg-emerald-800 border border-emerald-600 p-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-400">
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col gap-2 justify-end">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 transition">
                            Apply Filters
                        </button>
                        <a href="{{ route('collector.index') }}"
                            class="bg-gray-700 hover:bg-gray-800 text-white font-semibold py-2 px-4 text-center transition">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>


        <!-- Collector Cards -->
        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-3 p-2">
            @foreach ($collectors as $collector)
                <div class="p-2 transition duration-300 bg-emerald-900">
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

                        @if (Auth::user()->name == 'npssoldata')
                            <form action="{{ route('collector.destroy', $collector->id) }}" method="POST"
                                onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="confirmDelete(event)"
                                    class="text-red-500 transition duration-150 hover:text-red-700">
                                    <i class="text-lg fas fa-trash-alt"></i>
                                </button>
                            </form>
                        @endif
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
                    <div class="mb-4 text-xs leading-snug text-slate-100">
                        <div class="grid grid-cols-[auto,1fr] gap-x-2 gap-y-1">
                            <div class="font-semibold text-slate-300">Created at:</div>
                            <div>{{ $collector->created_at }}</div>

                            <div class="font-semibold text-slate-300">Updated at:</div>
                            <div>{{ $collector->updated_at }}</div>

                            <div class="font-semibold text-slate-300">Rice Variety:</div>
                            <div>{{ $collector->rice_variety }}</div>

                            <div class="font-semibold text-slate-300">Rice Established Date:</div>
                            <div>{{ $collector->date_establish }}</div>

                            <div class="font-semibold text-slate-300">Established Method:</div>
                            <div>{{ $collector->established_method ?? 'N/A' }}</div>

                            <div class="font-semibold text-slate-300">Pest Dataset Count:</div>
                            <div>{{ $collector->commonDataCollect->count() }}</div>
                        </div>
                    </div>


                    <!-- Action Buttons -->
                    <div class="grid grid-cols-2 gap-3">
                        <x-buttons.button-1 color="red" href="{{ route('collector.edit', $collector->id) }}"
                            icon="fas fa-edit">
                            Edit Collector
                            </x-button>
                            <x-buttons.button-1 color="green" href="{{ route('pestdata.view', $collector->id) }}"
                                icon="fas fa-bug">
                                Pest Data
                                </x-button>
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
<script>
    setTimeout(() => {
        const successMessage = document.querySelector('.alert-success');
        if (successMessage) {
            successMessage.style.display = 'none';
        }
    }, 5000);
</script>
