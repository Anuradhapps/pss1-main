<x-app-layout>
    <!-- Header -->
    <x-headings.top-heading title="AI Chart" subtitle="" icon="fas fa-chart-line" buttonText="Back"
        buttonAction="{{ has_role('collector') ? route('chart.index') : route('admin.collector.records') }}"
        buttonIcon="	fas fa-arrow-left" buttonColor="red" class="bg-green-700" />

    <div class="m-2 space-y-3">
        <!-- Messages -->
        <x-success-massage />
        <x-error-massage />

        <!-- Chart Display -->
        <div class="container mx-auto">
            <div class="p-4 bg-white">
                {!! $chart->container() !!}
            </div>
        </div>

        <!-- Collector Info -->
        <div
            class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-slate-800 shadow-sm dark:border-emerald-800/70 dark:bg-emerald-900/80 dark:text-slate-100">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div><strong>Name:</strong> <span
                        class="text-slate-600 dark:text-slate-300">{{ $collector->user->name }}</span></div>
                <div><strong>E-Mail:</strong> <span
                        class="text-slate-600 dark:text-slate-300">{{ $collector->user->email }}</span></div>
                <div><strong>Phone Number:</strong> <span
                        class="text-slate-600 dark:text-slate-300">{{ $collector->phone_no }}</span></div>
                <div><strong>Season:</strong> <span
                        class="text-slate-600 dark:text-slate-300">{{ $collector->riceSeason->name }}</span></div>
            </div>
        </div>

        <!-- Pest Data -->
        @foreach ($collector->commonDataCollect as $commonData)
            <div class="container mx-auto">
                <div class="p-2 text-white bg-gray-600 rounded shadow">
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
                        <table class="min-w-full text-sm text-white">
                            <thead class="text-xs text-gray-300 bg-gray-800 sm:text-sm">
                                <tr>
                                    <th class="px-4 py-3 text-left">🐞 Pest Name</th>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <th class="hidden px-4 py-3 text-center sm:table-cell">SP-{{ $i }}
                                        </th>
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
                                <div class="p-3 mt-1 text-gray-200 bg-gray-800 rounded">{{ $commonData->otherinfo }}
                                </div>
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
    </div>



    <!-- Chart Script -->
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
</x-app-layout>
