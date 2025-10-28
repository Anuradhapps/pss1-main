<x-app-layout>
    <div class="space-y-4">
        {{-- Header --}}
        <x-headings.top-heading title="Reports Dashboard" icon="fas fa-chart-line"
            class="bg-gradient-to-r from-green-800 to-green-600 shadow" />

        {{-- Cards Grid --}}
        <div class="grid grid-cols-1 m-2 gap-2 sm:grid-cols-2 md:grid-cols-3 ">

            {{-- All Data Export Card --}}
            <div class="border border-gray-700 bg-gray-900 shadow">
                <div class="p-4 border-b border-gray-700 bg-gray-800">
                    <h5 class="flex items-center text-lg font-semibold text-green-400">
                        <i class="mr-2 text-green-500 fas fa-database"></i> Full Data Export
                    </h5>
                </div>
                <div class="p-4">
                    <x-form class="space-y-3" action="{{ route('export.allpestdata') }}" method="post">
                        @csrf
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-400">Start Date</label>
                            <input type="date" name="start_date" required
                                class="w-full px-3 py-2 text-white bg-gray-800 border border-gray-700 focus:border-green-500 focus:ring-1 focus:ring-green-500">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-400">End Date</label>
                            <input type="date" name="end_date" required
                                class="w-full px-3 py-2 text-white bg-gray-800 border border-gray-700 focus:border-green-500 focus:ring-1 focus:ring-green-500">
                        </div>
                        <button type="submit"
                            class="flex items-center justify-center w-full px-4 py-2 mt-3 text-sm font-semibold text-white transition bg-green-700 hover:bg-green-600 border border-green-600">
                            <i class="mr-2 fas fa-file-excel"></i> Export Excel
                        </button>
                    </x-form>
                </div>
            </div>

            {{-- Recent Memos Card --}}
            <div class="border border-gray-700 bg-gray-900 shadow">
                <div class="p-4 border-b border-gray-700 bg-gray-800">
                    <h5 class="flex items-center text-lg font-semibold text-green-400">
                        <i class="mr-2 text-green-500 fas fa-clock"></i> Recent Memos
                    </h5>
                </div>
                <div class="p-4">
                    <p class="mb-3 text-sm text-gray-400">Last 2 weeks by province:</p>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach ($provinces as $province)
                            @php
                                $hasData = in_array($province->id, $dataHaveProvinces);
                            @endphp
                            <a href="{{ $hasData ? route('export.last2weeksDataexportToPDF', ['id' => $province->id]) : '#' }}"
                                class="flex items-center justify-center px-3 py-2 text-xs font-medium transition border
                                    {{ $hasData
                                        ? 'text-white bg-gray-800 border-gray-700 hover:bg-gray-700 hover:border-gray-600'
                                        : 'text-gray-500 bg-gray-900 border-gray-800 cursor-not-allowed' }}">
                                <i
                                    class="mr-1 fas {{ $hasData ? 'fa-file-pdf text-red-400' : 'fa-file text-gray-600' }}"></i>
                                {{ $province->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Quick Exports Card --}}
            <div class="border border-gray-700 bg-gray-900 shadow">
                <div class="p-4 border-b border-gray-700 bg-gray-800">
                    <h5 class="flex items-center text-lg font-semibold text-green-400">
                        <i class="mr-2 text-green-500 fas fa-file-export"></i> Quick Exports
                    </h5>
                </div>
                <div class="space-y-2 p-4">
                    <div class="flex items-center justify-between p-3 bg-gray-800 border border-gray-700">
                        <div class="flex items-center">
                            <i class="mr-2 text-blue-400 fas fa-info-circle"></i>
                            <span class="text-sm font-medium text-gray-300">Collectors Other Info</span>
                        </div>
                        <a href="{{ route('export.reportOfOtherInfo') }}"
                            class="p-2 text-xs font-medium text-white transition bg-gray-700 border border-gray-600 hover:bg-gray-600">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-800 border border-gray-700">
                        <div class="flex items-center">
                            <i class="mr-2 text-purple-400 fas fa-users"></i>
                            <span class="text-sm font-medium text-gray-300">Collectors Registry</span>
                        </div>
                        <a href="{{ route('export.collectorsList') }}"
                            class="p-2 text-xs font-medium text-white transition bg-gray-700 border border-gray-600 hover:bg-gray-600">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>
            </div>



        </div>
        <!-- Last Week’s Pest Damage Levels by Province -->
        <div class="bg-gray-900 border border-gray-700  shadow-xl p-5 m-2">
            <div x-data="{ open: false }" wire:ignore.self class="m-0">

                <!-- Header -->
                <div @click="open = !open"
                    class="flex items-center justify-between bg-gray-800 text-gray-100 px-4 py-3 rounded-lg cursor-pointer 
                   select-none transition-all duration-300 hover:bg-gray-700 hover:shadow-md hover:scale-[1.01] group">

                    <div class="flex items-center gap-3">
                        <div
                            class="flex items-center justify-center w-9 h-9 rounded-full bg-green-500/20 text-green-400 group-hover:bg-green-500/30 transition">
                            <i class="fas fa-chart-bar text-lg"></i>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-2">
                            <h2 class="text-lg font-semibold text-white">Last Week’s Pest Damage Levels by Province</h2>
                            <p class="text-sm text-gray-400 italic"
                                x-text="open ? '(Click here to hide)' : '(Click here to show)'"></p>
                        </div>
                    </div>

                    <svg :class="{ 'rotate-180': open }"
                        class="w-5 h-5 text-gray-300 group-hover:text-green-400 transition-transform duration-300"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                <!-- Content -->
                <div x-show="open" x-transition x-cloak class="mt-4 space-y-4">
                    @php $districts = App\Models\district::all(); @endphp
                    @foreach ($districts as $district)
                        <div
                            class="p-4 bg-gray-800/60 border border-gray-700 rounded-xl shadow-md hover:shadow-lg hover:bg-gray-750 transition-all duration-300">
                            <div class="flex items-center mb-3">
                                <div
                                    class="flex items-center justify-center w-10 h-10 rounded-full bg-yellow-500/20 text-yellow-400 mr-3">
                                    <i class="fas fa-bug text-lg"></i>
                                </div>
                                <h2 class="text-lg font-semibold text-gray-100">
                                    <span class="text-orange-500 italic">{{ $district->name }}</span> – Pest Density
                                    This
                                    Week
                                </h2>
                            </div>
                            <livewire:pest-memo-card :districtId="$district->id" :days="7" :key="'pest-' . $district->id" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    {{-- JS Export Script --}}
    <script>
        document.getElementById('export-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.blob())
                .then(blob => {
                    const link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'pest_data_export.xlsx';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
</x-app-layout>
