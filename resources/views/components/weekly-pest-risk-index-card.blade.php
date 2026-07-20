@php
$cards = [
[
'title' => 'Combined Seasons',
'icon' => 'fas fa-layer-group',
'color' => 'emerald',
'route' => route('pest-both-season-combined'),
],
[
'title' => 'Season Comparison',
'icon' => 'fas fa-balance-scale-left',
'color' => 'teal',
'route' => route('pest-season-comparison'),
],
[
'title' => 'Weather Matrix',
'icon' => 'fas fa-cloud-sun-rain',
'color' => 'sky',
'route' => route('pest-rain-comparison'),
],
[
'title' => 'Rice Variety Data',
'icon' => 'fas fa-seedling',
'color' => 'green',
'route' => route('pest-rice-variety-comparison'),
],
];

$colorMap = [
'green' => [
'bg' => 'bg-green-100 dark:bg-green-500/20',
'text' => 'text-green-600 dark:text-green-400',
'border' => 'border-green-200 dark:border-green-800',
'hoverBg' => 'group-hover:bg-green-50 dark:group-hover:bg-green-900/30',
'hoverBorder' => 'group-hover:border-green-300 dark:group-hover:border-green-700',
'shadow' => 'group-hover:shadow-green-500/20',
'progress' => 'bg-green-500',
],
'emerald' => [
'bg' => 'bg-emerald-100 dark:bg-emerald-500/20',
'text' => 'text-emerald-600 dark:text-emerald-400',
'border' => 'border-emerald-200 dark:border-emerald-800',
'hoverBg' => 'group-hover:bg-emerald-50 dark:group-hover:bg-emerald-900/30',
'hoverBorder' => 'group-hover:border-emerald-300 dark:group-hover:border-emerald-700',
'shadow' => 'group-hover:shadow-emerald-500/20',
'progress' => 'bg-emerald-500',
],
'teal' => [
'bg' => 'bg-teal-100 dark:bg-teal-500/20',
'text' => 'text-teal-600 dark:text-teal-400',
'border' => 'border-teal-200 dark:border-teal-800',
'hoverBg' => 'group-hover:bg-teal-50 dark:group-hover:bg-teal-900/30',
'hoverBorder' => 'group-hover:border-teal-300 dark:group-hover:border-teal-700',
'shadow' => 'group-hover:shadow-teal-500/20',
'progress' => 'bg-teal-500',
],
'amber' => [
'bg' => 'bg-amber-100 dark:bg-amber-500/20',
'text' => 'text-amber-600 dark:text-amber-400',
'border' => 'border-amber-200 dark:border-amber-800',
'hoverBg' => 'group-hover:bg-amber-50 dark:group-hover:bg-amber-900/30',
'hoverBorder' => 'group-hover:border-amber-300 dark:group-hover:border-amber-700',
'shadow' => 'group-hover:shadow-amber-500/20',
'progress' => 'bg-amber-500',
],
'sky' => [
'bg' => 'bg-sky-100 dark:bg-sky-500/20',
'text' => 'text-sky-600 dark:text-sky-400',
'border' => 'border-sky-200 dark:border-sky-800',
'hoverBg' => 'group-hover:bg-sky-50 dark:group-hover:bg-sky-900/30',
'hoverBorder' => 'group-hover:border-sky-300 dark:group-hover:border-sky-700',
'shadow' => 'group-hover:shadow-sky-500/20',
'progress' => 'bg-sky-500',
],
];
@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($cards as $card)
    @php $c = $colorMap[$card['color']]; @endphp
    <a href="{{ $card['route'] }}"
        class="group relative flex flex-col items-center justify-center p-4 sm:p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl 
                   transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-lg {{ $c['shadow'] }} {{ $c['hoverBorder'] }} overflow-hidden">

        {{-- Background hover effect --}}
        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 {{ $c['hoverBg'] }}"></div>

        {{-- Icon --}}
        <div class="relative flex items-center justify-center w-12 h-12 mb-3 rounded-xl {{ $c['bg'] }} 
                        group-hover:scale-110 transition-transform duration-300 shadow-sm">
            <i class="{{ $card['icon'] }} {{ $c['text'] }} text-xl"></i>
        </div>

        {{-- Title --}}
        <h2 class="relative text-sm font-semibold text-slate-700 dark:text-slate-300 text-center leading-tight group-hover:text-slate-900 dark:group-hover:text-white transition-colors duration-200">
            {{ $card['title'] }}
        </h2>

        {{-- Active indicator dot --}}
        <div class="absolute top-3 right-3 w-2 h-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 {{ $c['progress'] }}"></div>

    </a>
    @endforeach
</div>