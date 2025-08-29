<div class="grid md:grid-cols-2 gap-6 my-6">

    @php
        $cards = [
            [
                'title' => 'Weekly Pest Risk Index',
                'icon' => 'fas fa-calendar-week',
                'iconColor' => 'text-green-400',
                'description' =>
                    'Stay informed about weekly pest risk levels to take timely preventive actions. Explore detailed charts and insights derived from field data.',
                'route' => route('weekly-pest-risk.index'),
                'btnColor' => 'bg-green-600 hover:bg-green-700 focus:ring-green-400',
                'btnIcon' => 'fas fa-chart-line',
            ],
            [
                'title' => 'Pest & Season Comparison',
                'icon' => 'fas fa-random',
                'iconColor' => 'text-pink-400',
                'description' =>
                    'Compare seasonal trends by visualizing weekly averages of pest damage intensity using a coded risk index (0–9 scale).',
                'route' => route('pest-season-comparison'),
                'btnColor' => 'bg-pink-600 hover:bg-pink-700 focus:ring-pink-400',
                'btnIcon' => 'fas fa-chart-area',
            ],
            [
                'title' => 'Pest & Temperature Comparison',
                'icon' => 'fas fa-thermometer-half',
                'iconColor' => 'text-yellow-400',
                'description' =>
                    'Analyze how weekly pest damage intensity (0–9 risk index scale) correlates with temperature variations.',
                'route' => route('pest-temp-comparison'),
                'btnColor' => 'bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-400',
                'btnIcon' => 'fas fa-chart-bar',
            ],
            [
                'title' => 'Pest, Rain & Temperature Comparison',
                'icon' => 'fas fa-cloud-rain',
                'iconColor' => 'text-blue-400',
                'description' =>
                    'Analyze how weekly pest damage intensity (0–9 risk index scale) correlates with rainfall and temperature variations.',
                'route' => route('pest-rain-comparison'),
                'btnColor' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-400',
                'btnIcon' => 'fas fa-chart-bar',
            ],
            [
                'title' => 'Pest & Rice Variety Comparison',
                'icon' => 'fas fa-seedling',
                'iconColor' => 'text-emerald-400',
                'description' =>
                    'Analyze how weekly pest damage intensity (0–9 risk index scale) correlates with rice variety.',
                'route' => route('pest-rice-variety-comparison'),
                'btnColor' => 'bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-400',
                'btnIcon' => 'fas fa-chart-bar',
            ],
        ];
    @endphp

    @foreach ($cards as $card)
        <div
            class="p-6 bg-gray-900 border border-gray-700 rounded-2xl shadow-md hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
            <!-- Header -->
            <div class="flex flex-col items-center justify-between mb-4 text-center">
                <h2 class="flex items-center text-lg font-semibold text-white mb-1">
                    <i class="{{ $card['icon'] }} mr-2 {{ $card['iconColor'] }}"></i>
                    {{ $card['title'] }}
                </h2>
                <span class="text-xs text-gray-400 italic">Last updated: {{ now()->format('M d, Y') }}</span>
            </div>

            <!-- Description -->
            <p class="text-gray-300 text-sm mb-6 leading-relaxed">
                {{ $card['description'] }}
            </p>

            <!-- Action Button -->
            <div class="flex justify-center">
                <a href="{{ $card['route'] }}"
                    class="inline-flex items-center px-6 py-2 text-sm font-medium text-white {{ $card['btnColor'] }} rounded-lg
                          focus:ring-2 focus:outline-none shadow-md transition-all duration-200 hover:scale-105">
                    <i class="{{ $card['btnIcon'] }} mr-2"></i> View Report
                </a>
            </div>
        </div>
    @endforeach

</div>
