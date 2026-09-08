<x-app-layout>
    <div class="space-y-2">
        <!-- Header -->
        <x-headings.top-heading title="Pest Data Overview" subtitle="Detailed collected records" icon="fas fa-file-alt"
            buttonText="Back" :buttonAction="has_role('collector')
                ? route('pestdata.view', $commonData->collector_id)
                : route('pestdata.index')" buttonIcon="fas fa-arrow-left" buttonColor="red" class="bg-red-700" />

        <!-- Meta Information Cards -->
        <div class="grid grid-cols-2 gap-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
            @php
                $items = [
                    [
                        'label' => 'Created At',
                        'value' => $commonData->created_at,
                        'icon' => 'fa-clock',
                        'bgClass' => 'bg-indigo-100 dark:bg-indigo-500/20',
                        'textClass' => 'text-indigo-600 dark:text-indigo-400',
                    ],
                    [
                        'label' => 'Collected Date',
                        'value' => $commonData->c_date,
                        'icon' => 'fa-calendar-day',
                        'bgClass' => 'bg-blue-100 dark:bg-blue-500/20',
                        'textClass' => 'text-blue-600 dark:text-blue-400',
                    ],
                    [
                        'label' => 'Temperature',
                        'value' => $commonData->temperature . ' °C',
                        'icon' => 'fa-temperature-high',
                        'bgClass' => 'bg-rose-100 dark:bg-rose-500/20',
                        'textClass' => 'text-rose-600 dark:text-rose-400',
                    ],
                    [
                        'label' => 'Rainy Days',
                        'value' => $commonData->numbrer_r_day,
                        'icon' => 'fa-cloud-rain',
                        'bgClass' => 'bg-cyan-100 dark:bg-cyan-500/20',
                        'textClass' => 'text-cyan-600 dark:text-cyan-400',
                    ],
                    [
                        'label' => 'Growth Stage Code',
                        'value' => $commonData->growth_s_c,
                        'icon' => 'fa-seedling',
                        'bgClass' => 'bg-emerald-100 dark:bg-emerald-500/20',
                        'textClass' => 'text-emerald-600 dark:text-emerald-400',
                    ],
                ];
            @endphp

            @foreach ($items as $item)
                <div
                    class="bg-white dark:bg-slate-800 rounded-xl p-3 border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div
                        class="w-10 h-10 rounded-lg {{ $item['bgClass'] }} {{ $item['textClass'] }} flex items-center justify-center flex-shrink-0 text-xl">
                        <i class="fas {{ $item['icon'] }}"></i>
                    </div>
                    <div>
                        <p class="text-sm my-0 py-0 font-medium text-slate-500 dark:text-slate-400">{{ $item['label'] }}
                        </p>
                        <p class="text-base my-0 py-0 font-bold text-slate-900 dark:text-white">{{ $item['value'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pest Table Card -->
        <div
            class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm rounded-xl overflow-hidden">
            <div class="p-5 border-b border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                    <i class="fas fa-bug text-amber-500"></i> Pest Observations
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead
                        class="text-xs text-slate-500 dark:text-slate-400 uppercase bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                        <tr>
                            <th class="px-6 py-4 font-bold">Pest Name</th>
                            @for ($i = 1; $i <= 10; $i++)
                                <th class="hidden px-2 py-4 text-center sm:table-cell">SP-{{ $i }}</th>
                            @endfor
                            <th class="px-6 py-4 text-center font-bold">Total</th>
                            <th class="px-6 py-4 text-center font-bold">Severity Code</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @foreach ($pestsData as $pestData)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">
                                    {{ str_replace('_', ' ', $pestData->pest_name) }}</td>
                                @for ($i = 1; $i <= 10; $i++)
                                    <td
                                        class="hidden px-2 py-4 text-center text-slate-600 dark:text-slate-300 sm:table-cell">
                                        {{ $pestData->pest_name == 'Thrips' ? '-' : $pestData->{'location_' . $i} }}
                                    </td>
                                @endfor
                                <td class="px-6 py-4 text-center font-bold text-slate-700 dark:text-slate-200">
                                    {{ $pestData->pest_name == 'Thrips' ? '-' : $pestData->total }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $colorClass = match ($pestData->code) {
                                            0
                                                => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-400',
                                            1 => 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400',
                                            3
                                                => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-400',
                                            5
                                                => 'bg-orange-100 text-orange-800 dark:bg-orange-500/20 dark:text-orange-400',
                                            7 => 'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-400',
                                            9 => 'bg-rose-100 text-rose-800 dark:bg-rose-500/20 dark:text-rose-400',
                                            default
                                                => 'bg-slate-100 text-slate-800 dark:bg-slate-500/20 dark:text-slate-400',
                                        };
                                    @endphp
                                    <span
                                        class="inline-flex items-center justify-center px-3 py-1 text-xs font-bold rounded-full {{ $colorClass }}">
                                        {{ $pestData->code }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Other Info Card -->
        @if ($commonData->otherinfo)
            <div
                class="bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-100 dark:border-indigo-500/20 rounded-xl p-5 shadow-sm">
                <h3 class="text-lg font-bold text-indigo-900 dark:text-indigo-400 flex items-center gap-2 mb-3">
                    <i class="fas fa-clipboard-list"></i> Other Information
                </h3>
                <p class="text-indigo-800 dark:text-indigo-300 whitespace-pre-line">{{ $commonData->otherinfo }}</p>
            </div>
        @endif
    </div>
</x-app-layout>
