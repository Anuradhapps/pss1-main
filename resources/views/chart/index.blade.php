<x-app-layout>
    <div class="flex justify-between">
        <h1 class="text-2xl font-bold mb-2 text-white">Chart</h1>
    </div>

    {{-- Check if an error message is set in the session and display it --}}
    <x-error-massage />
    <div class="mx-5  sm:flex gap-5">
        <div class="bg-gray-800 rounded-xl p-5 mb-3">
            <div class="text-white bg-green-900 px-2 py-1 rounded-xl mb-3">Chart by each season</div>
            <div class="text-white">&#x2705; : Collector Registered</div>
            <x-form action="{{ route('chart.show') }}">
                @csrf
                @livewire('season-select')
                <x-form.submit>View Chart</x-form.submit>
            </x-form>
        </div>
        <div class="bg-gray-800 rounded-xl p-5 mb-3">
            <div class="text-white bg-green-900 px-2 py-1 rounded-xl mb-3">Chart by all seasons</div>
            <div class="bg-gray-700 p-6 sm:flex gap-3 mb-3">
                <div class="text-white w-24">All Island</div>
                <div>
                    <a href="{{ route('chart.show.allSeason', ['sort_by' => 'allIsland']) }}"
                        class="px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600 transition duration-300">
                        View All Island
                    </a>
                </div>
            </div>
            <div class="bg-gray-700 p-6 sm:flex gap-3 mb-3">
                <div class="text-white w-24">By Province</div>
                <div class="grid grid-cols-2 gap-1">
                    @foreach ($allProvinces as $allProvince)
                        @if (in_array($allProvince, $dataHaveProvinces))
                            <a href="{{ route('chart.show.allSeason', ['sort_by' => 'province', 'province' => $allProvince]) }}"
                                class="px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-700 transition duration-300">
                                {{ $allProvince }}
                            </a>
                        @else
                            <a href="{{ route('chart.show.allSeason', ['sort_by' => 'province', 'province' => $allProvince]) }}"
                                class="px-4 py-2 bg-red-500 text-white text-sm rounded hover:bg-red-700 transition duration-300">
                                {{ $allProvince }}
                            </a>
                        @endif
                    @endforeach

                </div>
            </div>
            <div class="bg-gray-700 p-6 sm:flex gap-3 mb-3">
                <div class="text-white w-24">By District</div>
                <div class="grid grid-cols-3 gap-1">
                    @foreach ($allDistricts as $allDistrict)
                        @if (in_array($allDistrict, $dataHaveDistricts))
                            <a href="{{ route('chart.show.allSeason', ['sort_by' => 'district', 'district' => $allDistrict]) }}"
                                class="px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-700 transition duration-300">
                                {{ $allDistrict }}
                            </a>
                        @else
                            <a href="{{ route('chart.show.allSeason', ['sort_by' => 'district', 'district' => $allDistrict]) }}"
                                class="px-4 py-2 bg-red-500 text-white text-sm rounded hover:bg-red-700 transition duration-300">
                                {{ $allDistrict }}
                            </a>
                        @endif
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript to hide the error message after 5 seconds --}}


</x-app-layout>
