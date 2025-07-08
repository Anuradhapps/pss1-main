<x-app-layout>
    <!-- Header -->
    <div
        class="flex items-center justify-between px-4 py-3 mb-4 rounded shadow bg-gradient-to-r from-blue-900 to-gray-700">
        <h1 class="text-xl font-bold text-white">📊 AI Chart</h1>

        <div>
            @if (has_role('collector'))
                <a href="{{ route('chart.index') }}"
                    class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded hover:bg-red-700">Back</a>
            @else
                <a href="{{ route('admin.collector.records') }}"
                    class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded hover:bg-red-700">Back</a>
            @endif
        </div>
    </div>

    <!-- Messages -->
    <x-success-massage />
    <x-error-massage />

    <!-- Chart Display -->
    <div class="container px-2 mx-auto mb-6">
        <div class="p-4 bg-white rounded shadow">
            {!! $chart->container() !!}
        </div>
    </div>

    <!-- Collector Info -->
    <div class="p-4 mx-3 text-white bg-gray-900 rounded-lg shadow">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div><strong>Name:</strong> <span class="text-gray-300">{{ $collector->user->name }}</span></div>
            <div><strong>E-Mail:</strong> <span class="text-gray-300">{{ $collector->user->email }}</span></div>
            <div><strong>Phone Number:</strong> <span class="text-gray-300">{{ $collector->phone_no }}</span></div>
            <div><strong>Season:</strong> <span class="text-gray-300">{{ $collector->riceSeason->name }}</span></div>
        </div>
    </div>

    <!-- Pest Data -->
    @foreach ($collector->commonDataCollect as $commonData)
        <div class="container px-2 mx-auto">
            <div class="p-2 mt-4 text-white bg-gray-600 rounded shadow">
                <div class="grid grid-cols-1 gap-4 mt-5 text-sm text-white sm:grid-cols-2 md:grid-cols-3">
                    <div class="px-3 py-2 bg-gray-800 rounded-lg">
                        <strong>📅 Created At:</strong>
                        <span class="mt-1 text-gray-200"> {{ $commonData->created_at }}</span>
                    </div>
                    <div class="px-3 py-2 bg-gray-800 rounded-lg">
                        <strong>🗓️ Collected Date:</strong>
                        <span class="mt-1 text-gray-200"> {{ $commonData->c_date }}</span>
                    </div>
                    <div class="px-3 py-2 bg-gray-800 rounded-lg">
                        <strong>🌡️ Temperature:</strong>
                        <span class="mt-1 text-gray-200"> {{ $commonData->temperature }} °C</span>
                    </div>
                    <div class="px-3 py-2 bg-gray-800 rounded-lg">
                        <strong>🌧️ Rainy Days:</strong>
                        <span class="mt-1 text-gray-200"> {{ $commonData->numbrer_r_day }}</span>
                    </div>
                    <div class="px-3 py-2 bg-gray-800 rounded-lg">
                        <strong>🌱 Growth Stage Code:</strong>
                        <span class="mt-1 text-gray-200"> {{ $commonData->growth_s_c }}</span>
                    </div>
                </div>
                <hr class="mb-4 border-gray-600">

                <div class="overflow-x-auto">
                    {{-- <table class="w-full text-sm text-left text-white table-auto">
                        <thead class="bg-gray-700">
                            <tr>
                                <th class="px-2 py-2">Pest Name</th>
                                @for ($i = 1; $i <= 10; $i++)
                                    <th class="hidden px-2 py-2 sm:table-cell">SP-{{ $i }}</th>
                                @endfor
                                <th class="px-2 py-2">Total</th>
                                <th class="px-2 py-2">Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($commonData->pestDataCollect as $pestData)
                                <tr class="border-t border-gray-600">
                                    <td class="px-2 py-1">{{ $pestData->pest_name }}</td>

                                    @if ($pestData->pest_name == 'Thrips')
                                        @for ($i = 1; $i <= 10; $i++)
                                            <td class="hidden sm:table-cell">-</td>
                                        @endfor
                                        <td>-</td>
                                        <td class="{{ $pestData->code > 5 ? 'bg-red-600' : '' }} px-2">
                                            {{ $pestData->code }}</td>
                                    @else
                                        <td class="hidden sm:table-cell">{{ $pestData->location_1 }}</td>
                                        <td class="hidden sm:table-cell">{{ $pestData->location_2 }}</td>
                                        <td class="hidden sm:table-cell">{{ $pestData->location_3 }}</td>
                                        <td class="hidden sm:table-cell">{{ $pestData->location_4 }}</td>
                                        <td class="hidden sm:table-cell">{{ $pestData->location_5 }}</td>
                                        <td class="hidden sm:table-cell">{{ $pestData->location_6 }}</td>
                                        <td class="hidden sm:table-cell">{{ $pestData->location_7 }}</td>
                                        <td class="hidden sm:table-cell">{{ $pestData->location_8 }}</td>
                                        <td class="hidden sm:table-cell">{{ $pestData->location_9 }}</td>
                                        <td class="hidden sm:table-cell">{{ $pestData->location_10 }}</td>
                                        <td>{{ $pestData->total }}</td>
                                        <td class="{{ $pestData->code > 5 ? 'bg-red-600' : '' }} px-2">
                                            {{ $pestData->code }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table> --}}
                    <table class="min-w-full text-sm text-white">
                        <thead class="text-xs text-gray-300 bg-gray-800 sm:text-sm">
                            <tr>
                                <th class="px-4 py-3 text-left">🐞 Pest Name</th>
                                @for ($i = 1; $i <= 10; $i++)
                                    <th class="hidden px-4 py-3 text-center sm:table-cell">SP-{{ $i }}</th>
                                @endfor
                                <th class="px-4 py-3 text-center">📊 Total</th>
                                <th class="px-4 py-3 text-center">⚠️ Code</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach ($commonData->pestDataCollect as $pestData)
                                <tr class="transition hover:bg-gray-100">
                                    <td class="px-4 py-3">{{ $pestData->pest_name }}</td>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <td class="hidden px-4 py-3 text-center sm:table-cell">
                                            {{ $pestData->pest_name == 'Thrips' ? '-' : $pestData->{'location_' . $i} }}
                                        </td>
                                    @endfor
                                    <td class="px-4 py-3 font-semibold text-center">
                                        {{ $pestData->pest_name == 'Thrips' ? '-' : $pestData->total }}</td>
                                    <td class="px-4 py-3 text-center">
                                        @php
                                            $colorClass = match ($pestData->code) {
                                                0 => 'bg-white text-black', // Light green
                                                1 => 'bg-green-600 text-white', // Green
                                                3 => 'bg-yellow-400 text-black', // Yellow
                                                5 => 'bg-orange-500 text-white', // Orange
                                                7 => 'bg-red-600 text-white', // Red
                                                9 => 'bg-red-900 text-white', // Dark red
                                                default => 'bg-gray-300 text-black', // Default/unknown codes
                                            };
                                        @endphp

                                        <span
                                            class="inline-block px-2 py-1 text-xs font-bold rounded-full {{ $colorClass }}">
                                            {{ $pestData->code }}
                                        </span>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Footer row -->
                <div class="flex flex-col justify-between mt-4 space-y-2 md:flex-row md:space-y-0">
                    @if ($commonData->otherinfo)
                        <div class="mt-6 text-white">
                            <h2 class="font-semibold text-green-100 border-b-2 border-gray-700">📝 Other Infomation:
                            </h2>
                            <div class="p-3 mt-1 text-gray-200 bg-gray-800 rounded">{{ $commonData->otherinfo }}</div>
                        </div>
                    @endif
                    <form action="{{ route('admin.pestdata.destroy', $commonData->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this record?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-3 py-1 text-sm font-semibold text-white bg-red-600 rounded hover:bg-red-700">
                            🗑️ Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Chart Script -->
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
</x-app-layout>
