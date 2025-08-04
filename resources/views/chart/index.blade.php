<x-app-layout>
    <!-- Page Header -->
    <x-headings.topHeading title="Data Analytics" icon="fas fa-chart-bar"
        class="bg-gradient-to-r from-green-700 to-green-500 shadow" />

    <!-- Error Message -->
    <x-error-massage />

    <!-- Grid Wrapper -->
    <div class="grid gap-2 m-2 md:grid-cols-2">
        <!-- Chart by Each Season -->
        <div class="p-4 bg-gray-900 border border-gray-700">
            <div class="px-4 py-3 mb-4 text-sm font-semibold text-white bg-green-700 border-b-2 border-green-600">
                <i class="mr-2 fas fa-calendar-alt"></i>SEASONAL ANALYTICS
            </div>

            @php
                $CollectorCount = \App\Models\Collector::count();
            @endphp

            <div class="flex items-center mb-4 text-gray-300">
                <i class="w-4 h-4 mr-2 text-green-400 fas fa-check-circle"></i>
                <span class="text-sm"><strong>Collectors Registered:</strong></span>
                <span class="ml-1 text-sm font-semibold text-green-400">{{ $CollectorCount }}</span>
            </div>

            <x-form action="{{ route('chart.show') }}">
                @csrf
                @livewire('season-select')
                <x-form.submit class="w-full mt-4 bg-green-600 hover:bg-green-700 border-0">
                    <i class="mr-2 fas fa-chart-line"></i>Generate Seasonal Report
                </x-form.submit>
            </x-form>
        </div>

        <!-- Chart by All Seasons -->
        <div class="p-4 bg-gray-900 border border-gray-700">
            <div class="px-4 py-3 mb-4 text-sm font-semibold text-white bg-green-700 border-b-2 border-green-600">
                <i class="mr-2 fas fa-chart-pie"></i>COMPREHENSIVE ANALYTICS
            </div>

            <!-- All Island -->
            <div class="flex items-center mb-5">
                <div class="w-32 text-sm font-semibold text-gray-300">
                    <i class="mr-2 fas fa-globe"></i>Nationwide:
                </div>
                <a href="{{ route('chart.show.allSeason', ['sort_by' => 'allIsland']) }}"
                    class="px-4 py-2 text-sm font-medium text-white transition bg-blue-600 hover:bg-blue-700 border-b-2 border-blue-500 flex items-center">
                    <i class="mr-2 fas fa-file-alt"></i>National Report
                </a>
            </div>

            <!-- By Province -->
            <div class="mb-5">
                <div class="mb-3 text-sm font-semibold text-gray-300 border-b border-gray-700 pb-1">
                    <i class="mr-2 fas fa-map-marked-alt"></i>PROVINCIAL DATA
                </div>
                <div class="grid grid-cols-2 gap-2 sm:grid-cols-3">
                    @foreach ($allProvinces as $province)
                        <a href="{{ route('chart.show.allSeason', ['sort_by' => 'province', 'province' => $province]) }}"
                            class="px-3 py-2 text-xs font-semibold text-white text-center transition flex items-center justify-center
                                {{ in_array($province, $dataHaveProvinces) ? 'bg-blue-600 hover:bg-blue-700 border-b-2 border-blue-500' : 'bg-gray-700 text-gray-500 cursor-not-allowed border-b-2 border-gray-600' }}">
                            <i
                                class="mr-1 fas {{ in_array($province, $dataHaveProvinces) ? 'fa-map-marker-alt' : 'fa-map-marker' }}"></i>
                            {{ $province }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- By District -->
            <div>
                <div class="mb-3 text-sm font-semibold text-gray-300 border-b border-gray-700 pb-1">
                    <i class="mr-2 fas fa-map"></i>DISTRICT DATA
                </div>
                <div class="grid grid-cols-2 gap-2 sm:grid-cols-3 md:grid-cols-4">
                    @foreach ($allDistricts as $district)
                        <a href="{{ route('chart.show.allSeason', ['sort_by' => 'district', 'district' => $district]) }}"
                            class="px-3 py-2 text-xs font-semibold text-white text-center transition flex items-center justify-center
                                {{ in_array($district, $dataHaveDistricts) ? 'bg-blue-600 hover:bg-blue-700 border-b-2 border-blue-500' : 'bg-gray-700 text-gray-500 cursor-not-allowed border-b-2 border-gray-600' }}">
                            <i
                                class="mr-1 fas {{ in_array($district, $dataHaveDistricts) ? 'fa-location-dot' : 'fa-location-pin' }}"></i>
                            {{ $district }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>


    </div>
</x-app-layout>
