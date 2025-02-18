<x-app-layout>

    <h1 class="px-1 py-3 mb-3 text-2xl font-bold text-gray-300 bg-gray-700 dark:bg-gray-900">Chart</h1>


    {{-- Check if an error message is set in the session and display it --}}
    <x-error-massage />
    <div class="gap-5 mx-5 sm:flex">
        <div class="p-5 mb-3 bg-gray-800 rounded-xl">
            <div class="px-2 py-2 mb-3 text-white bg-green-900 rounded-xl">Chart by each season</div>
            @php
                $CollectorCount = \App\Models\Collector::all()->count();
            @endphp
            <div class="mb-3 text-white">&#x2705; : Collector Registered
                {{ $CollectorCount > 0 ? ' (' . $CollectorCount . ')' : '' }}</div>
            <x-form action="{{ route('chart.show') }}">
                @csrf
                @livewire('season-select')
                <x-form.submit>View Chart</x-form.submit>
            </x-form>
        </div>
        <div class="p-5 mb-3 bg-gray-800 rounded-xl">
            <div class="px-2 py-2 mb-3 text-white bg-green-900 rounded-xl">Chart by all seasons</div>
            <div class="gap-3 p-6 mb-3 bg-gray-700 sm:flex">
                <div class="w-24 mb-3 text-white">All Island</div>
                <div>
                    <a href="{{ route('chart.show.allSeason', ['sort_by' => 'allIsland']) }}"
                        class="px-4 py-2 text-sm text-white transition duration-300 bg-blue-500 rounded hover:bg-blue-600">
                        View All Island
                    </a>
                </div>
            </div>
            <div class="gap-3 p-6 mb-3 bg-gray-700 sm:flex">
                <div class="w-24 mb-3 text-white">By Province</div>
                <div class="grid grid-cols-2 gap-1">
                    @foreach ($allProvinces as $allProvince)
                        @if (in_array($allProvince, $dataHaveProvinces))
                            <a href="{{ route('chart.show.allSeason', ['sort_by' => 'province', 'province' => $allProvince]) }}"
                                class="px-4 py-2 text-sm text-white transition duration-300 bg-blue-500 rounded hover:bg-blue-700">
                                {{ $allProvince }}
                            </a>
                        @else
                            <a href="{{ route('chart.show.allSeason', ['sort_by' => 'province', 'province' => $allProvince]) }}"
                                class="px-4 py-2 text-sm text-white transition duration-300 bg-red-500 rounded hover:bg-red-700">
                                {{ $allProvince }}
                            </a>
                        @endif
                    @endforeach

                </div>
            </div>
            <div class="gap-3 p-6 mb-3 bg-gray-700 sm:flex">
                <div class="w-24 mb-3 text-white">By District</div>
                <div class="grid grid-cols-3 gap-1">
                    @foreach ($allDistricts as $allDistrict)
                        @if (in_array($allDistrict, $dataHaveDistricts))
                            <a href="{{ route('chart.show.allSeason', ['sort_by' => 'district', 'district' => $allDistrict]) }}"
                                class="px-4 py-2 text-sm text-white transition duration-300 bg-blue-500 rounded hover:bg-blue-700">
                                {{ $allDistrict }}
                            </a>
                        @else
                            <a href="{{ route('chart.show.allSeason', ['sort_by' => 'district', 'district' => $allDistrict]) }}"
                                class="px-4 py-2 text-sm text-white transition duration-300 bg-red-500 rounded hover:bg-red-700">
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
