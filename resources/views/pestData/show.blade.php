<x-app-layout>
    <div>
        <!-- Header -->
        <x-headings.topHeading title="Pest Data" subtitle="" icon="fas fa-folder-open" buttonText="Back"
            :buttonAction="has_role('collector')
                ? route('pestdata.view', $commonData->collector_id)
                : route('pestdata.index')" buttonIcon="fas fa-arrow-left" buttonColor="red" class="bg-green-700" />

        <div class=" m-2">
            <!-- Meta Information -->
            <div class="grid grid-cols-1 gap-4 mt-5 text-sm text-white sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
                @php
                    $items = [
                        ['label' => '📅 Created At:', 'value' => $commonData->created_at],
                        ['label' => '🗓️ Collected Date:', 'value' => $commonData->c_date],
                        ['label' => '🌡️ Temperature:', 'value' => $commonData->temperature . ' °C'],
                        ['label' => '🌧️ Rainy Days:', 'value' => $commonData->numbrer_r_day],
                        ['label' => '🌱 Growth Stage Code:', 'value' => $commonData->growth_s_c],
                    ];
                @endphp

                @foreach ($items as $item)
                    <div
                        class="px-4 py-3 bg-gray-800 hover:scale-[1.05] transition-transform duration-300 flex flex-row justify-between sm:flex-col">
                        <strong>{{ $item['label'] }}</strong>
                        <div class="sm:mt-1 text-gray-200">{{ $item['value'] }}</div>
                    </div>
                @endforeach
            </div>


            <!-- Pest Table -->
            <div class="mt-8 overflow-x-auto bg-gray-900 shadow">
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
                        @foreach ($pestsData as $pestData)
                            <tr class="transition hover:bg-gray-600">
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

            <!-- Other Info -->
            @if ($commonData->otherinfo)
                <div class="mt-6 text-white">
                    <h2 class="font-semibold text-green-900 border-b-2 border-gray-700">📝 Other Infomation:</h2>
                    <div class="p-3 mt-1 text-gray-200 bg-gray-800 rounded">{{ $commonData->otherinfo }}</div>
                </div>
            @endif
        </div>
    </div>



</x-app-layout>
