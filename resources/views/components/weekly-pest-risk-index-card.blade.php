@php
    $cards = [
        [
            'title' => 'Weekly Risk Index',
            'icon' => 'fas fa-chart-line',
            'textColor' => 'text-indigo-400',
            'iconBg' => 'bg-indigo-400/10',
            'hoverBorder' => 'group-hover:border-indigo-500/50',
            'hoverShadow' => 'group-hover:shadow-[0_0_15px_rgba(99,102,241,0.15)]',
            'route' => route('weekly-pest-risk.index'),
        ],
        [
            'title' => 'Combined Seasons',
            'icon' => 'fas fa-layer-group',
            'textColor' => 'text-teal-400',
            'iconBg' => 'bg-teal-400/10',
            'hoverBorder' => 'group-hover:border-teal-500/50',
            'hoverShadow' => 'group-hover:shadow-[0_0_15px_rgba(20,184,166,0.15)]',
            'route' => route('pest-both-season-combined'),
        ],
        [
            'title' => 'Season Comparison',
            'icon' => 'fas fa-balance-scale-left',
            'textColor' => 'text-purple-400',
            'iconBg' => 'bg-purple-400/10',
            'hoverBorder' => 'group-hover:border-purple-500/50',
            'hoverShadow' => 'group-hover:shadow-[0_0_15px_rgba(168,85,247,0.15)]',
            'route' => route('pest-season-comparison'),
        ],
        [
            'title' => 'Temp Correlation',
            'icon' => 'fas fa-temperature-high',
            'textColor' => 'text-orange-400',
            'iconBg' => 'bg-orange-400/10',
            'hoverBorder' => 'group-hover:border-orange-500/50',
            'hoverShadow' => 'group-hover:shadow-[0_0_15px_rgba(249,115,22,0.15)]',
            'route' => route('pest-temp-comparison'),
        ],
        [
            'title' => 'Weather Matrix',
            'icon' => 'fas fa-cloud-sun-rain',
            'textColor' => 'text-sky-400',
            'iconBg' => 'bg-sky-400/10',
            'hoverBorder' => 'group-hover:border-sky-500/50',
            'hoverShadow' => 'group-hover:shadow-[0_0_15px_rgba(14,165,233,0.15)]',
            'route' => route('pest-rain-comparison'),
        ],
        [
            'title' => 'Rice Variety Data',
            'icon' => 'fas fa-seedling',
            'textColor' => 'text-emerald-400',
            'iconBg' => 'bg-emerald-400/10',
            'hoverBorder' => 'group-hover:border-emerald-500/50',
            'hoverShadow' => 'group-hover:shadow-[0_0_15px_rgba(16,185,129,0.15)]',
            'route' => route('pest-rice-variety-comparison'),
        ],
    ];
@endphp

<div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-3 my-4">
    @foreach ($cards as $card)
        <a href="{{ $card['route'] }}"
            class="group flex flex-col items-center justify-center p-4 bg-gray-800 border border-gray-700 rounded-xl 
                   transition-all duration-300 ease-in-out transform hover:-translate-y-1 {{ $card['hoverBorder'] }} {{ $card['hoverShadow'] }}">

            <div
                class="flex items-center justify-center w-10 h-10 mb-3 rounded-lg {{ $card['iconBg'] }} 
                        group-hover:scale-110 transition-transform duration-300">
                <i class="{{ $card['icon'] }} {{ $card['textColor'] }} text-lg"></i>
            </div>

            <h2
                class="text-gray-300 font-medium text-xs text-center leading-tight group-hover:text-white transition-colors duration-200">
                {{ $card['title'] }}
            </h2>

        </a>
    @endforeach
</div>
