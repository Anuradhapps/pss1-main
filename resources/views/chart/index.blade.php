<x-app-layout>
    <!-- Page Header -->
    <x-headings.top-heading title="Data Analytics" icon="fas fa-chart-bar"
        class="bg-gradient-to-r from-primary-800 to-primary shadow-lg text-white" />

    <!-- Error Message -->
    <x-error-massage />

    <!-- Grid Wrapper -->
    <div class="grid gap-6 m-4 md:grid-cols-2">

        <!-- Seasonal Analytics Card -->
        <div class="space-y-6">

            <!-- Seasonal Analytics -->
            <x-ui.card padding="p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                        <i class="fas fa-calendar-alt text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">Seasonal Analytics</h3>
                </div>

                @php
                    $CollectorCount = \App\Models\Collector::count();
                @endphp
                
                <div class="flex items-center justify-between p-4 mb-6 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700/50">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check-circle text-success text-lg"></i>
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Registered Collectors</span>
                    </div>
                    <span class="text-lg font-bold text-slate-900 dark:text-white">{{ $CollectorCount }}</span>
                </div>

                <x-form action="{{ route('chart.show') }}">
                    @csrf
                    @livewire('season-select')
                    <x-ui.button variant="primary" type="submit" class="w-full mt-4">
                        <i class="fas fa-chart-line mr-2"></i> Generate Chart
                    </x-ui.button>
                </x-form>
            </x-ui.card>

            <!-- Weekly Pest Risk Index -->
            <x-ui.card padding="p-6">
                <x-weekly-pest-risk-index-card />
            </x-ui.card>
        </div>

        <!-- Average Analytics Card -->
        <x-ui.card padding="p-6" class="space-y-6">

            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-lg bg-info/10 flex items-center justify-center text-info">
                    <i class="fas fa-chart-pie text-lg"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">Average Analytics</h3>
            </div>

            <!-- Nationwide Analytics -->
            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700/50 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3 text-slate-700 dark:text-slate-300 font-semibold">
                    <i class="fas fa-globe text-primary"></i> Nationwide Overview
                </div>
                <a href="{{ route('chart.show.allSeason', ['sort_by' => 'allIsland']) }}"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary hover:bg-primary-hover text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                    <i class="fas fa-file-alt"></i> National Report
                </a>
            </div>

            <!-- Provincial Data -->
            <div class="space-y-4 pt-4 border-t border-slate-200 dark:border-slate-700/50">
                <div class="flex items-center gap-2 text-sm font-semibold text-slate-800 dark:text-slate-200 uppercase tracking-wider">
                    <i class="fas fa-map-marked-alt text-slate-400"></i> Provincial Data
                </div>
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                    @foreach ($allProvinces as $province)
                        <a href="{{ route('chart.show.allSeason', ['sort_by' => 'province', 'province' => $province]) }}"
                            class="flex items-center justify-center gap-2 px-3 py-2.5 text-xs font-semibold text-center transition-all duration-200 rounded-lg border
                                {{ in_array($province, $dataHaveProvinces) 
                                    ? 'bg-white dark:bg-slate-800 border-primary/30 text-primary dark:text-primary-light hover:bg-primary hover:text-white shadow-sm hover:shadow-md hover:-translate-y-0.5' 
                                    : 'bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-slate-800 text-slate-400 dark:text-slate-600 cursor-not-allowed' }}">
                            <i class="fas {{ in_array($province, $dataHaveProvinces) ? 'fa-map-marker-alt' : 'fa-map-marker' }}"></i>
                            <span class="truncate">{{ $province }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- District Data -->
            <div class="space-y-4 pt-4 border-t border-slate-200 dark:border-slate-700/50">
                <div class="flex items-center gap-2 text-sm font-semibold text-slate-800 dark:text-slate-200 uppercase tracking-wider">
                    <i class="fas fa-map text-slate-400"></i> District Data
                </div>
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4">
                    @foreach ($allDistricts as $district)
                        <a href="{{ route('chart.show.allSeason', ['sort_by' => 'district', 'district' => $district]) }}"
                            class="flex items-center justify-center gap-2 px-3 py-2.5 text-xs font-semibold text-center transition-all duration-200 rounded-lg border
                                {{ in_array($district, $dataHaveDistricts) 
                                    ? 'bg-white dark:bg-slate-800 border-primary/30 text-primary dark:text-primary-light hover:bg-primary hover:text-white shadow-sm hover:shadow-md hover:-translate-y-0.5' 
                                    : 'bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-slate-800 text-slate-400 dark:text-slate-600 cursor-not-allowed' }}">
                            <i class="fas {{ in_array($district, $dataHaveDistricts) ? 'fa-location-dot' : 'fa-location-pin' }}"></i>
                            <span class="truncate">{{ $district }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </x-ui.card>
    </div>
</x-app-layout>
