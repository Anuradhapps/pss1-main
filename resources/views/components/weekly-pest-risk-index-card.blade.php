@php
    $cards = [
        // [
        //     'title' => 'Weekly Pest Risk Index',
        //     'icon' => 'fas fa-calendar-week',
        //     'iconColor' => 'text-green-400',
        //     'borderColor' => 'border-green-400',
        //     'route' => route('weekly-pest-risk.index'),
        // ],
        [
            'title' => 'Pest & Season Comparison',
            'icon' => 'fas fa-random',
            'iconColor' => 'text-pink-400',
            'borderColor' => 'border-pink-400',
            'route' => route('pest-season-comparison'),
        ],
        // [
        //     'title' => 'Pest & Temperature Comparison',
        //     'icon' => 'fas fa-thermometer-half',
        //     'iconColor' => 'text-yellow-400',
        //     'borderColor' => 'border-yellow-400',
        //     'route' => route('pest-temp-comparison'),
        // ],
        [
            'title' => 'Pest, Rain & Temperature Comparison',
            'icon' => 'fas fa-cloud-rain',
            'iconColor' => 'text-blue-400',
            'borderColor' => 'border-blue-400',
            'route' => route('pest-rain-comparison'),
        ],
        [
            'title' => 'Pest & Rice Variety Comparison',
            'icon' => 'fas fa-seedling',
            'iconColor' => 'text-emerald-400',
            'borderColor' => 'border-emerald-400',
            'route' => route('pest-rice-variety-comparison'),
        ],
    ];
@endphp

<div class="grid md:grid-cols-3 gap-4 my-4">
    @foreach ($cards as $card)
        <a href="{{ $card['route'] }}"
            class="flex flex-col items-center justify-center p-4 bg-gray-900 {{ $card['borderColor'] }} border rounded-xl shadow-md
                   hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1 text-center">

            <!-- Icon & Title -->
            <h2 class="flex flex-col items-center text-white font-semibold text-sm">
                <i class="{{ $card['icon'] }} {{ $card['iconColor'] }} text-3xl mb-2"></i>
                {{ $card['title'] }}
            </h2>

        </a>
    @endforeach
</div>
