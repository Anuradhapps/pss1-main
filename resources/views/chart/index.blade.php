<x-app-layout>
    <!-- Page Header -->
    <div
        class="flex flex-col items-start justify-between px-4 py-3 mb-3 rounded-lg shadow bg-gradient-to-r from-green-800 to-green-600 md:flex-row md:items-center md:space-y-0">
        <h1 class="text-3xl font-bold text-white">📊 Data / Charts Overview</h1>
    </div>

    <!-- Error Message -->
    <x-error-massage />

    <!-- Grid Wrapper -->
    <div class="grid gap-6 md:grid-cols-2">
        <!-- Chart by Each Season -->
        <div class="p-6 bg-gray-800 shadow rounded-xl">
            <div class="px-4 py-2 mb-4 text-sm font-semibold text-white bg-green-700 rounded-xl">Chart by Each Season
            </div>
            @php
                $CollectorCount = \App\Models\Collector::count();
            @endphp
            <div class="mb-4 text-white">
                ✅ <strong>Collector Registered:</strong>
                <span class="font-semibold text-yellow-300">{{ $CollectorCount }}</span>
            </div>

            <x-form action="{{ route('chart.show') }}">
                @csrf
                @livewire('season-select')
                <x-form.submit class="w-full mt-4">📈 View Chart</x-form.submit>
            </x-form>
        </div>

        <!-- Chart by All Seasons -->
        <div class="p-6 bg-gray-800 shadow rounded-xl">
            <div class="px-4 py-2 mb-4 text-sm font-semibold text-white bg-green-700 rounded-xl">Chart by All Seasons
            </div>

            <!-- All Island -->
            <div class="flex flex-col mb-5 space-y-2 sm:flex-row sm:items-center sm:space-x-4 sm:space-y-0">
                <div class="w-32 text-sm font-semibold text-white">All Island:</div>
                <a href="{{ route('chart.show.allSeason', ['sort_by' => 'allIsland']) }}"
                    class="px-4 py-2 text-sm font-medium text-white transition bg-blue-600 rounded hover:bg-blue-700">
                    🌍 View
                </a>
            </div>

            <!-- By Province -->
            <div class="mb-5">
                <div class="mb-2 text-sm font-semibold text-white">By Province:</div>
                <div class="grid grid-cols-2 gap-2 sm:grid-cols-3">
                    @foreach ($allProvinces as $province)
                        <a href="{{ route('chart.show.allSeason', ['sort_by' => 'province', 'province' => $province]) }}"
                            class="px-3 py-2 text-xs font-semibold text-white rounded text-center transition
                                {{ in_array($province, $dataHaveProvinces) ? 'bg-blue-600 hover:bg-blue-700' : 'bg-red-500 hover:bg-red-600 cursor-not-allowed pointer-events-none opacity-80' }}">
                            {{ $province }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- By District -->
            <div>
                <div class="mb-2 text-sm font-semibold text-white">By District:</div>
                <div class="grid grid-cols-2 gap-2 sm:grid-cols-3 md:grid-cols-4">
                    @foreach ($allDistricts as $district)
                        <a href="{{ route('chart.show.allSeason', ['sort_by' => 'district', 'district' => $district]) }}"
                            class="px-3 py-2 text-xs font-semibold text-white rounded text-center transition
                                {{ in_array($district, $dataHaveDistricts) ? 'bg-blue-600 hover:bg-blue-700' : 'bg-red-500 hover:bg-red-600 cursor-not-allowed pointer-events-none opacity-80' }}">
                            {{ $district }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
