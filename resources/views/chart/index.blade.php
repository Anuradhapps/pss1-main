<x-app-layout>
    <!-- Page Header -->
    <x-headings.topHeading title="Data Analytics" icon="fas fa-chart-bar"
        class="bg-gradient-to-r from-green-700 to-green-500 shadow-lg text-white" />

    <!-- Error Message -->
    <x-error-massage />

    <!-- Grid Wrapper -->
    <div class="grid gap-6 m-2 md:grid-cols-2">

        <!-- Seasonal Analytics Card -->
        <div class="space-y-6">

            <!-- Seasonal Analytics -->
            <div class="bg-gray-900 border border-gray-700 rounded-2xl shadow-lg p-5">
                <div
                    class="flex items-center justify-between px-4 py-2 mb-4 text-white bg-gradient-to-r from-green-950 to-green-950 rounded-xl shadow">
                    <div class="flex items-center gap-2 font-semibold text-sm">
                        <i class="fas fa-calendar-alt"></i> SEASONAL ANALYTICS
                    </div>
                </div>

                @php
                    $CollectorCount = \App\Models\Collector::count();
                @endphp
                <div class="flex items-center gap-2 mb-4 text-gray-300">
                    <i class="fas fa-check-circle text-green-400"></i>
                    <span class="text-sm font-medium">Registered Collectors:</span>
                    <span class="ml-1 text-sm font-semibold text-green-400">{{ $CollectorCount }}</span>
                </div>

                <x-form action="{{ route('chart.show') }}">
                    @csrf
                    @livewire('season-select')
                    <x-form.submit
                        class="w-full mt-4 bg-green-800 hover:bg-green-900 text-white font-semibold rounded-lg transition duration-300 shadow">
                        <i class="fas fa-chart-line mr-2"></i> Generate Chart
                    </x-form.submit>
                </x-form>
            </div>

            <!-- Weekly Pest Risk Index -->
            <div class="bg-gray-900 border border-gray-700 rounded-2xl shadow-lg p-5">
                <x-weekly-pest-risk-index-card />
            </div>
        </div>

        <!-- Average Analytics Card -->
        <div class="bg-gray-900 border border-gray-700 rounded-2xl shadow-lg p-5 space-y-6">

            <div
                class="flex items-center px-4 py-2 mb-4 text-white bg-gradient-to-r from-green-950 to-green-950 rounded-xl shadow font-semibold text-sm">
                <i class="fas fa-chart-pie mr-2"></i> AVERAGE ANALYTICS
            </div>

            <!-- Nationwide Analytics -->
            <div class="flex items-center gap-3 mb-4">
                <div class="w-36 text-sm font-semibold text-gray-300 flex items-center gap-2">
                    <i class="fas fa-globe"></i> Nationwide:
                </div>
                <a href="{{ route('chart.show.allSeason', ['sort_by' => 'allIsland']) }}"
                    class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow transition duration-300 transform hover:scale-105">
                    <i class="fas fa-file-alt"></i> View National Report
                </a>
            </div>

            <!-- Provincial Data -->
            <div class="space-y-2">
                <div class="flex items-center gap-2 text-sm font-semibold text-gray-300 border-b border-gray-700 pb-1">
                    <i class="fas fa-map-marked-alt"></i> Provincial Data
                </div>
                <div class="grid grid-cols-2 gap-2 sm:grid-cols-3">
                    @foreach ($allProvinces as $province)
                        <a href="{{ route('chart.show.allSeason', ['sort_by' => 'province', 'province' => $province]) }}"
                            class="flex items-center justify-center gap-1 px-3 py-2 text-xs font-semibold text-center transition rounded-lg
                                {{ in_array($province, $dataHaveProvinces) ? 'bg-blue-600 hover:bg-blue-700 text-white shadow hover:scale-105' : 'bg-gray-700 text-gray-500 cursor-not-allowed' }}">
                            <i
                                class="fas {{ in_array($province, $dataHaveProvinces) ? 'fa-map-marker-alt' : 'fa-map-marker' }}"></i>
                            {{ $province }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- District Data -->
            <div class="space-y-2">
                <div class="flex items-center gap-2 text-sm font-semibold text-gray-300 border-b border-gray-700 pb-1">
                    <i class="fas fa-map"></i> District Data
                </div>
                <div class="grid grid-cols-2 gap-2 sm:grid-cols-3 md:grid-cols-4">
                    @foreach ($allDistricts as $district)
                        <a href="{{ route('chart.show.allSeason', ['sort_by' => 'district', 'district' => $district]) }}"
                            class="flex items-center justify-center gap-1 px-3 py-2 text-sm font-semibold text-center transition rounded-lg
                                {{ in_array($district, $dataHaveDistricts) ? 'bg-blue-600 hover:bg-blue-700 text-white shadow hover:scale-105' : 'bg-gray-700 text-gray-500 cursor-not-allowed' }}">
                            <i
                                class="fas {{ in_array($district, $dataHaveDistricts) ? 'fa-location-dot' : 'fa-location-pin' }}"></i>
                            {{ $district }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Last Week’s Pest Damage Levels by Province -->
    <div class="bg-gray-900 border border-gray-700 rounded-2xl shadow-lg p-5 m-2">
        <div x-data="{ open: true }" wire:ignore.self class="m-0">
            <div @click="open = !open"
                class="flex items-center justify-between bg-gray-800 text-gray-100 px-3 py-2 rounded-md cursor-pointer select-none transition-all hover:bg-gray-600">
                <h2 class="text-lg font-semibold text-white">Last Week’s Pest Damage Levels by Province</h2>
                <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transition-transform duration-300" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            <div x-show="!open" x-transition x-cloak class="mt-4 space-y-4">
                @php $districts = App\Models\District::all(); @endphp
                @foreach ($districts as $district)
                    <div
                        class="p-4 bg-gray-800 border border-gray-700 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center mb-3">
                            <div
                                class="flex items-center justify-center w-10 h-10 rounded-full bg-yellow-500/20 text-yellow-400 mr-3">
                                <i class="fas fa-bug text-lg"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-100">
                                <span class="text-orange-500 italic">{{ $district->name }}</span> – Pest Density This
                                Week
                            </h2>
                        </div>
                        <livewire:pest-memo-card :districtId="$district->id" :days="7" :key="'pest-' . $district->id" />
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
