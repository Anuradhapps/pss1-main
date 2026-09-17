<x-app-layout>
    <div class="space-y-2">

        <!-- Header -->
        <x-headings.basic_heading title="Data Analytics" icon="fas fa-chart-line" />



        {{-- Error Message --}}
        <x-error-massage />

        {{-- Main Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">

            {{-- Left Column: Seasonal Analytics + Weekly Risk --}}
            <div class="space-y-2">

                {{-- Seasonal Analytics Card --}}
                <div
                    class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                    <div class="p-6 pb-0 pt-2 border-b border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex items-center justify-center w-10 h-10 rounded-xl bg-green-100 dark:bg-green-500/20 text-green-600 dark:text-green-400">
                                <i class="fas fa-calendar-alt text-lg"></i>
                            </div>
                            <div>
                                <h3 class="pb-0 mb-0 text-lg font-semibold text-slate-900 dark:text-white">Seasonal
                                    Analytics</h3>
                                <p class="pt-0 mt-0 text-sm text-slate-500 dark:text-slate-400">Generate charts by
                                    season
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 space-y-2">
                        @php
                            $CollectorCount = \App\Models\Collector::count();
                        @endphp

                        {{-- Registered Collectors Stat --}}
                        <div
                            class="flex items-center justify-between px-4 py-2 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700/50">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-green-100 dark:bg-green-500/20 flex items-center justify-center text-green-600 dark:text-green-400">
                                    <i class="fas fa-users text-sm"></i>
                                </div>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Registered
                                    Collectors</span>
                            </div>
                            <span class="text-xl font-bold text-slate-900 dark:text-white">{{ $CollectorCount }}</span>
                        </div>

                        <x-form action="{{ route('chart.show') }}">
                            @csrf
                            @livewire('season-select')
                            <button type="submit"
                                class="w-full flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white transition-all bg-green-600 hover:bg-green-700 rounded-xl shadow-sm hover:shadow-md focus:ring-2 focus:ring-green-500/50">
                                <i class="fas fa-chart-line mr-2"></i> Generate Chart
                            </button>
                        </x-form>
                    </div>
                </div>

                {{-- Weekly Pest Risk Index Card --}}
                <div
                    class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                    <div class="p-6 pt-2 pb-0 border-b border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex items-center justify-center w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400">
                                <i class="fas fa-exclamation-triangle text-lg"></i>
                            </div>
                            <div>
                                <h3 class="pb-0 mb-0 text-lg font-semibold text-slate-900 dark:text-white">Weekly Pest
                                    Risk Index
                                </h3>
                                <p class="mt-0 pt-0 text-sm text-slate-500 dark:text-slate-400">Current risk assessment
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <x-weekly-pest-risk-index-card />
                    </div>
                </div>
            </div>

            {{-- Right Column: Average Analytics --}}
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="px-6 pt-2 pb-0 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400">
                            <i class="fas fa-chart-pie text-lg"></i>
                        </div>
                        <div>
                            <h3 class="pb-0 mb-0 text-lg font-semibold text-slate-900 dark:text-white">Average Analytics
                            </h3>
                            <p class="pt-0 mt-0 text-sm text-slate-500 dark:text-slate-400">View reports by region</p>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-2 space-y-2">

                    {{-- Nationwide Overview --}}
                    <div
                        class="flex items-center justify-between p-2 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700/50">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-green-100 dark:bg-green-500/20 flex items-center justify-center text-green-600 dark:text-green-400">
                                <i class="fas fa-globe text-sm"></i>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Nationwide
                                Overview</span>
                        </div>
                        <a href="{{ route('chart.show.allSeason', ['sort_by' => 'allIsland']) }}"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl shadow-sm hover:shadow-md transition-all">
                            <i class="fas fa-file-alt"></i> National Report
                        </a>
                    </div>

                    {{-- Provincial Data --}}
                    <div class="space-y-3 pt-4 border-t border-slate-200 dark:border-slate-700/50">
                        <div
                            class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-map-marked-alt text-slate-400"></i> Provincial Data
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach ($allProvinces as $province)
                                <a href="{{ in_array($province, $dataHaveProvinces) ? route('chart.show.allSeason', ['sort_by' => 'province', 'province' => $province]) : '#' }}"
                                    class="flex items-center justify-center gap-2 px-2 py-2 text-xs font-semibold text-center transition-all duration-200 rounded-xl border
                                        {{ in_array($province, $dataHaveProvinces)
                                            ? 'bg-white dark:bg-slate-800 border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/30 hover:border-green-300 dark:hover:border-green-700 shadow-sm hover:shadow'
                                            : 'bg-slate-50 dark:bg-slate-950/50 border-slate-100 dark:border-slate-800 text-slate-400 dark:text-slate-600 cursor-not-allowed opacity-70' }}">
                                    <i
                                        class="fas {{ in_array($province, $dataHaveProvinces) ? 'fa-map-marker-alt text-green-500' : 'fa-map-marker text-slate-400' }}"></i>
                                    <span class="truncate">{{ $province }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- District Data --}}
                    <div class="space-y-3 pt-4 border-t border-slate-200 dark:border-slate-700/50">
                        <div
                            class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-500 uppercase tracking-wider">
                            <i class="fas fa-map text-slate-400"></i> District Data
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                            @foreach ($allDistricts as $district)
                                <a href="{{ in_array($district, $dataHaveDistricts) ? route('chart.show.allSeason', ['sort_by' => 'district', 'district' => $district]) : '#' }}"
                                    class="flex items-center justify-center gap-2 px-2 py-2 text-xs font-semibold text-center transition-all duration-200 rounded-xl border
                                        {{ in_array($district, $dataHaveDistricts)
                                            ? 'bg-white dark:bg-slate-800 border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/30 hover:border-green-300 dark:hover:border-green-700 shadow-sm hover:shadow'
                                            : 'bg-slate-50 dark:bg-slate-950/50 border-slate-100 dark:border-slate-800 text-slate-400 dark:text-slate-600 cursor-not-allowed opacity-70' }}">
                                    <i
                                        class="fas {{ in_array($district, $dataHaveDistricts) ? 'fa-location-dot text-green-500' : 'fa-location-pin text-slate-400' }}"></i>
                                    <span class="truncate">{{ $district }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</x-app-layout>
