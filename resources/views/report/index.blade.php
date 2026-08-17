<x-app-layout>
    <div class="space-y-2">
        <!-- Header -->
        <x-headings.basic_heading title="Reports" icon="fas fa-file-alt" />
        {{-- Last Week's Pest Damage Levels --}}
        <div
            class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
            <div x-data="{ open: false }" wire:ignore.self>
                {{-- Header --}}
                <div @click="open = !open"
                    class="flex items-center justify-between bg-slate-50 dark:bg-slate-800/50 px-6 py-2 cursor-pointer select-none transition-all duration-300 hover:bg-slate-100 dark:hover:bg-slate-800 group">

                    <div class="flex items-center gap-4">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-xl bg-orange-100 dark:bg-orange-500/20 text-orange-600 dark:text-orange-400 group-hover:bg-orange-200 dark:group-hover:bg-orange-500/30 transition-colors">
                            <i class="fas fa-chart-bar text-lg"></i>
                        </div>
                        <div class="flex flex-col">
                            <h2 class="mb-0 pb-0 text-lg font-bold text-slate-800 dark:text-slate-200 tracking-tight">
                                Last Week's
                                Pest Damage Levels by Province</h2>
                            <p class="mt-0 pt-0 text-xs text-slate-500 dark:text-slate-400 font-medium"
                                x-text="open ? 'Click to collapse' : 'Click to expand'"></p>
                        </div>
                    </div>

                    <div
                        class="w-8 h-8 rounded-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300 group-hover:border-slate-300 dark:group-hover:border-slate-600 transition-all">
                        <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                {{-- Content --}}
                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2" x-cloak
                    class="p-6 border-t border-slate-200 dark:border-slate-800">
                    <div class="space-y-6">
                        @php $districts = App\Models\district::all(); @endphp
                        @foreach ($districts as $district)
                            <div
                                class="bg-slate-50 dark:bg-slate-950/50 border border-slate-200 dark:border-slate-800 rounded-xl p-5 transition-all hover:border-slate-300 dark:hover:border-slate-700">
                                <div class="flex items-center mb-4">
                                    <div
                                        class="flex items-center justify-center w-8 h-8 rounded-lg bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 mr-3">
                                        <i class="fas fa-bug text-sm"></i>
                                    </div>
                                    <h3 class="text-base font-semibold text-slate-800 dark:text-slate-200">
                                        <span
                                            class="text-orange-600 dark:text-orange-400 mr-1">{{ $district->name }}</span>
                                        <span class="text-slate-500 dark:text-slate-400 font-medium text-sm">| Pest
                                            Density This Week</span>
                                    </h3>
                                </div>
                                <livewire:pest-memo-card :districtId="$district->id" :days="7" :key="'pest-' . $district->id" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        {{-- Flash Messages --}}
        {{-- Reports Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-2">

            {{-- Full Data Export Card --}}
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="p-6 pb-0 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-3 mb-2">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-xl bg-green-100 dark:bg-green-500/20 text-green-600 dark:text-green-400">
                            <i class="fas fa-database text-lg"></i>
                        </div>
                        <div>
                            <h3 class="my-0 py-0 text-lg font-semibold text-slate-900 dark:text-white">Full Data Export
                            </h3>
                            <p class="my-0 py-0 text-sm text-slate-500 dark:text-slate-400">Export comprehensive pest
                                data</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <x-form id="export-form" class="space-y-4" action="{{ route('export.allpestdata') }}"
                        method="post">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Start
                                    Date</label>
                                <input type="date" name="start_date" required
                                    class="w-full px-4 py-2.5 text-slate-900 dark:text-white bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all outline-none shadow-sm">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">End
                                    Date</label>
                                <input type="date" name="end_date" required
                                    class="w-full px-4 py-2.5 text-slate-900 dark:text-white bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all outline-none shadow-sm">
                            </div>
                        </div>
                        <button type="submit"
                            class="w-full flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white transition-all bg-green-600 hover:bg-green-700 rounded-xl shadow-sm hover:shadow-md focus:ring-2 focus:ring-green-500/50">
                            <i class="mr-2 fas fa-file-excel"></i> Export Excel
                        </button>
                    </x-form>
                </div>
            </div>

            {{-- Recent Memos Card --}}
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="p-6 pb-0 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-3 mb-1">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400">
                            <i class="fas fa-clock text-lg"></i>
                        </div>
                        <div>
                            <h3 class="my-0 py-0 text-lg font-semibold text-slate-900 dark:text-white">Recent Memos</h3>
                            <p class="my-0 py-0 text-sm text-slate-500 dark:text-slate-400">Last 2 weeks by province</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Generated memos for each province:</p>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach ($provinces as $province)
                            @php
                                $hasData = in_array($province->id, $dataHaveProvinces);
                            @endphp
                            <a href="{{ $hasData ? route('export.last2weeksDataexportToPDF', ['id' => $province->id]) : '#' }}"
                                class="flex items-center justify-center px-3 py-2.5 text-xs font-semibold transition-all rounded-xl border {{ $hasData
                                    ? 'text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 hover:border-slate-300 dark:hover:border-slate-600 shadow-sm hover:shadow'
                                    : 'text-slate-400 dark:text-slate-600 bg-slate-50 dark:bg-slate-950 border-slate-100 dark:border-slate-800 cursor-not-allowed opacity-70' }}">
                                <i
                                    class="mr-2 fas {{ $hasData ? 'fa-file-pdf text-red-500' : 'fa-file text-slate-400 dark:text-slate-600' }} text-base"></i>
                                <span class="truncate">{{ $province->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- Quick Exports Section --}}
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="p-6 pb-0 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-500/20 text-purple-600 dark:text-purple-400">
                            <i class="fas fa-file-export text-lg"></i>
                        </div>
                        <div>
                            <h3 class="my-0 py-0 text-lg font-semibold text-slate-900 dark:text-white">Quick Exports
                            </h3>
                            <p class="my-0 py-0 text-sm text-slate-500 dark:text-slate-400">One-click downloads for
                                common
                                datasets
                            </p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <a href="{{ route('export.reportOfOtherInfo') }}"
                            class="flex items-center justify-between p-4 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl hover:border-blue-300 dark:hover:border-blue-500/30 transition-all group">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">Collectors Other
                                        Info</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Additional collector details
                                    </p>
                                </div>
                            </div>
                            <div
                                class="flex items-center justify-center w-10 h-10 rounded-full text-slate-400 group-hover:text-blue-600 dark:group-hover:text-blue-400 group-hover:bg-blue-50 dark:group-hover:bg-blue-500/20 transition-all">
                                <i class="fas fa-download"></i>
                            </div>
                        </a>

                        <a href="{{ route('export.collectorsList') }}"
                            class="flex items-center justify-between p-4 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl hover:border-indigo-300 dark:hover:border-indigo-500/30 transition-all group">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">Collectors
                                        Registry
                                    </p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Full collector list export
                                    </p>
                                </div>
                            </div>
                            <div
                                class="flex items-center justify-center w-10 h-10 rounded-full text-slate-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 group-hover:bg-indigo-50 dark:group-hover:bg-indigo-500/20 transition-all">
                                <i class="fas fa-download"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>





    </div>

    {{-- JS Export Script --}}
    <script>
        document.getElementById('export-form')?.addEventListener('submit', function(e) {
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
