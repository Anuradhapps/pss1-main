@section('title', 'DD-Dashboard')

@php
    $displayLocationName = $selectedDistrict
        ? $districts->firstWhere('id', $selectedDistrict)->name . ' District'
        : $province->name . ' Province';

    $activeDistricts = $selectedDistrict ? [$districts->firstWhere('id', $selectedDistrict)] : $districts;
@endphp

<div
    class="min-h-screen bg-slate-50 text-slate-800 transition-colors duration-300 dark:bg-slate-950 dark:text-slate-100">

    <x-headings.top-heading title="{{ $province->name }} Province Dashboard" icon="fas fa-clipboard"
        class="bg-gradient-to-r from-emerald-400 to-teal-200 dark:from-slate-900 dark:via-emerald-900 dark:to-slate-800 dark:text-white border border-emerald-200 dark:border-slate-700 shadow-lg rounded-lg" />

    <div class="mx-auto max-w-screen-2xl space-y-4">

        {{-- ============================= PEST DENSITY ============================= --}}
        <section aria-label="Pest monitoring"
            class="bg-white/80 transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900/60">
            <p class="text-[11px] ps-1 font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                Pest Monitoring : <span class="text-[10px] text-slate-500 dark:text-slate-400">Last 7 days</span>
            </p>

            @foreach ($activeDistricts as $dst)
                <div
                    class="mb-2 rounded-lg border border-slate-200 bg-white/80 p-3 shadow-sm transition-colors duration-300 last:mb-0 dark:border-slate-800 dark:bg-slate-900/60">
                    <div
                        class="mb-3 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-100 px-3 py-2.5 dark:border-emerald-900/50 dark:bg-emerald-950/40">
                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-500 text-white shadow-sm">
                            <i class="fas fa-bug text-sm"></i>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-emerald-900 dark:text-emerald-100">{{ $dst->name }}
                            </h2>
                        </div>
                    </div>
                    <livewire:pest-memo-card :districtId="$dst->id" :days="7" :key="'pest-' . $dst->id" />
                </div>
            @endforeach
        </section>

        {{-- ============================= QUICK STATS ============================= --}}
        <section aria-labelledby="stats-heading">
            <p id="stats-heading"
                class="mb-3 ps-1 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                Overview
            </p>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-dd.stat-box color="green" title="Total Users Count" :value="$totalUsersCount" />
                <x-dd.stat-box color="yellow" title="This Season Users" :value="$seasonUserCount" />
            </div>
        </section>

        {{-- ============================= FILTERS + USER TABLE ============================= --}}
        <section aria-labelledby="collectors-heading"
            class="rounded-2xl border border-slate-200/80 bg-white/90 p-4 shadow-xl shadow-slate-200/50 backdrop-blur-md transition-colors duration-300 dark:border-slate-800/80 dark:bg-slate-900/80 dark:shadow-none sm:p-5">

            <div class="flex flex-col gap-4">
                <div class="flex items-center gap-3 shrink-0">
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400">
                        <i class="fa-solid fa-users text-lg"></i>
                    </div>
                    <div class="flex items-center gap-2">
                        <h2 id="collectors-heading"
                            class="truncate text-sm font-bold tracking-tight text-slate-900 dark:text-slate-100 sm:text-base">
                            Users in {{ ucfirst(strtolower($displayLocationName)) }}
                        </h2>
                        <span class="hidden text-xs text-slate-400 dark:text-slate-500 sm:inline">
                            • Filter and manage records
                        </span>
                    </div>
                </div>

                <div
                    class="flex flex-col gap-3 rounded-xl border border-slate-200 bg-white/60 p-3 dark:border-slate-700/60 dark:bg-slate-800/30 lg:flex-row lg:flex-wrap lg:items-end">
                    <div class="grid flex-1 grid-cols-1 gap-2.5 sm:grid-cols-2 lg:min-w-[280px] lg:basis-[280px]">
                        <div>
                            <label for="search-name"
                                class="mb-1 block text-[11px] font-medium text-slate-600 dark:text-slate-300">Name</label>
                            <div class="relative">
                                <span
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2.5 text-slate-400">
                                    <i class="fas fa-search text-[10px]"></i>
                                </span>
                                <input id="search-name" type="text" wire:model.live.debounce.500ms="search"
                                    placeholder="Search name..."
                                    class="h-9 w-full rounded-lg border border-slate-200 bg-slate-50/50 pl-7 pr-2.5 text-xs text-slate-800 placeholder-slate-400 outline-none transition duration-150 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 dark:border-slate-700/80 dark:bg-slate-800/50 dark:text-slate-100 dark:placeholder-slate-500 dark:focus:border-emerald-500 dark:focus:bg-slate-800" />
                            </div>
                        </div>

                        <div>
                            <label for="search-phone"
                                class="mb-1 block text-[11px] font-medium text-slate-600 dark:text-slate-300">Phone</label>
                            <div class="relative">
                                <span
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2.5 text-slate-400">
                                    <i class="fas fa-phone text-[10px]"></i>
                                </span>
                                <input id="search-phone" type="number" inputmode="numeric"
                                    wire:model.live.debounce.500ms="searchNumber" placeholder="Search phone..."
                                    class="h-9 w-full rounded-lg border border-slate-200 bg-slate-50/50 pl-7 pr-2.5 text-xs text-slate-800 placeholder-slate-400 outline-none transition duration-150 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 dark:border-slate-700/80 dark:bg-slate-800/50 dark:text-slate-100 dark:placeholder-slate-500 dark:focus:border-emerald-500 dark:focus:bg-slate-800" />
                            </div>
                        </div>
                    </div>

                    <div class="hidden h-9 w-px shrink-0 bg-slate-200 dark:bg-slate-700 lg:block"></div>

                    <div class="grid flex-1 grid-cols-1 gap-2.5 sm:grid-cols-3 lg:min-w-[360px] lg:basis-[360px]">
                        <div>
                            <label for="filter-district"
                                class="mb-1 block text-[11px] font-medium text-slate-600 dark:text-slate-300">District</label>
                            <select id="filter-district" wire:model.live="selectedDistrict"
                                class="h-9 w-full rounded-lg border border-slate-200 bg-slate-50/50 px-2.5 text-xs text-slate-800 outline-none transition duration-150 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 dark:border-slate-700/80 dark:bg-slate-800/50 dark:text-slate-100 dark:focus:border-emerald-500 dark:focus:bg-slate-800">
                                <option value="">All Districts</option>
                                @foreach ($districts as $dst)
                                    <option value="{{ $dst->id }}">{{ $dst->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="filter-ai-range"
                                class="mb-1 block text-[11px] font-medium text-slate-600 dark:text-slate-300">AI
                                Range</label>
                            <select id="filter-ai-range" wire:model.live="selectedAiRange"
                                class="h-9 w-full rounded-lg border border-slate-200 bg-slate-50/50 px-2.5 text-xs text-slate-800 outline-none transition duration-150 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 dark:border-slate-700/80 dark:bg-slate-800/50 dark:text-slate-100 dark:focus:border-emerald-500 dark:focus:bg-slate-800">
                                <option value="">All AI Ranges</option>
                                @foreach ($aiRanges as $ai)
                                    <option value="{{ $ai->id }}">{{ $ai->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="filter-season"
                                class="mb-1 block text-[11px] font-medium text-slate-600 dark:text-slate-300">Season</label>
                            <select id="filter-season" wire:model.live="selectedSeason"
                                class="h-9 w-full rounded-lg border border-slate-200 bg-slate-50/50 px-2.5 text-xs text-slate-800 outline-none transition duration-150 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 dark:border-slate-700/80 dark:bg-slate-800/50 dark:text-slate-100 dark:focus:border-emerald-500 dark:focus:bg-slate-800">
                                <option value="">All Seasons</option>
                                @foreach ($seasons as $season)
                                    <option value="{{ $season->id }}">{{ $season->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="hidden h-9 w-px shrink-0 bg-slate-200 dark:bg-slate-700 lg:block"></div>

                    <div class="flex shrink-0 gap-1.5 sm:w-auto">
                        <button wire:click="resetFilters" title="Reset all filters"
                            class="flex h-9 flex-1 items-center justify-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 text-xs font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-400/20 sm:flex-none dark:border-slate-700/80 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700/80 dark:hover:text-white">
                            <i class="fas fa-rotate-left text-[10px] text-slate-400"></i>
                            <span>Reset</span>
                        </button>

                        <div class="group relative flex-1 sm:flex-none">
                            <button wire:click="downloadCollectorsList" aria-label="Export collector list"
                                class="flex h-9 w-full items-center justify-center gap-1.5 rounded-lg bg-emerald-600 px-3 text-xs font-semibold text-white shadow-sm shadow-emerald-600/20 transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 active:scale-95 sm:w-auto">
                                <i class="fas fa-download text-[10px]"></i>
                                <span>Export</span>
                            </button>
                            <span
                                class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 hidden w-44 -translate-x-1/2 rounded-lg border border-slate-200 bg-white p-2 text-center text-[10px] leading-relaxed text-slate-600 opacity-0 shadow-xl transition-all duration-200 group-hover:opacity-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 lg:block">
                                Download filtered collector list.
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Desktop Table --}}
            <div
                class="relative mt-5 overflow-x-auto rounded-xl border border-slate-200/80 dark:border-slate-800/80 hidden sm:block">
                <div wire:loading.flex
                    wire:target="search, searchNumber, selectedDistrict, selectedAiRange, selectedSeason"
                    class="absolute inset-0 z-10 items-center justify-center bg-white/50 backdrop-blur-[1px] dark:bg-slate-900/50">
                    <div
                        class="flex items-center gap-2 rounded-full bg-slate-900/80 px-3 py-1.5 text-xs font-medium text-white shadow-lg backdrop-blur dark:bg-slate-100 dark:text-slate-900">
                        <i class="fas fa-spinner fa-spin text-emerald-400 dark:text-emerald-600"></i>
                        Updating...
                    </div>
                </div>

                <table class="w-full text-left text-xs text-slate-600 dark:text-slate-300 min-w-[750px]">
                    <thead
                        class="border-b border-slate-200/80 bg-slate-50/80 text-[11px] font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800/80 dark:bg-slate-900/60 dark:text-slate-400">
                        <tr>
                            <th scope="col" class="px-4 py-2.5">Name</th>
                            <th scope="col" class="px-4 py-2.5">District</th>
                            <th scope="col" class="px-4 py-2.5">AI Range</th>
                            <th scope="col" class="px-4 py-2.5">Season</th>
                            <th scope="col" class="px-4 py-2.5">Phone Number</th>
                            <th scope="col" class="px-4 py-2.5 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200/60 dark:divide-slate-800/60">
                        @foreach ($filteredCollectors as $collector)
                            <tr class="transition-colors hover:bg-slate-50/80 dark:hover:bg-slate-800/40">
                                <td
                                    class="whitespace-nowrap px-4 py-2.5 font-medium text-slate-900 dark:text-slate-100">
                                    <div class="flex items-center gap-2.5">
                                        <span
                                            class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-emerald-500/10 text-[11px] font-bold text-emerald-600 ring-1 ring-emerald-500/20 dark:bg-emerald-500/20 dark:text-emerald-400">
                                            {{ strtoupper(substr($collector->user->name ?? 'N', 0, 1)) }}
                                        </span>
                                        <div>
                                            <div class="font-semibold text-slate-900 dark:text-slate-100">
                                                {{ $collector->user->name ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2.5">
                                    <span
                                        class="inline-flex items-center rounded-md bg-slate-100 px-2 py-0.5 text-[11px] font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                        {{ $districts->firstWhere('id', $collector->district)->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2.5 text-slate-600 dark:text-slate-300">
                                    {{ $collector->getAiRange->name ?? 'N/A' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2.5">
                                    <span
                                        class="inline-flex items-center rounded-full bg-emerald-500/10 px-2 py-0.5 text-[10px] font-medium text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">
                                        {{ $collector->riceSeason->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td
                                    class="whitespace-nowrap px-4 py-2.5 text-slate-500 dark:text-slate-400 font-mono text-[11px]">
                                    {{ $collector->phone_no ?? 'N/A' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2.5 text-right">
                                    <button wire:click="viewCollector({{ $collector->id }})"
                                        class="inline-flex items-center gap-1 rounded-md bg-sky-500/10 px-2.5 py-1 text-xs font-semibold text-sky-600 transition hover:bg-sky-600 hover:text-white dark:bg-sky-500/20 dark:text-sky-400 dark:hover:bg-sky-500 dark:hover:text-white">
                                        <i class="fa-regular fa-eye text-[11px]"></i>
                                        View
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($filteredCollectors->count() === 0)
                    <div
                        class="flex flex-col items-center justify-center gap-1.5 py-8 text-center text-slate-400 dark:text-slate-500">
                        <i class="fas fa-user-slash text-base"></i>
                        <p class="text-xs font-medium text-slate-600 dark:text-slate-300">No collectors found</p>
                    </div>
                @endif
            </div>

            <div class="mt-3 hidden sm:block">
                {{ $filteredCollectors->links() }}
            </div>

            {{-- Mobile Cards --}}
            <div class="mt-4 space-y-2.5 sm:hidden">
                @forelse ($filteredCollectors as $collector)
                    <div
                        class="rounded-xl border border-slate-200/80 bg-white/90 p-3.5 shadow-sm dark:border-slate-800/80 dark:bg-slate-900/90">
                        <div class="mb-2.5 flex items-center gap-2.5">
                            <span
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-emerald-500/10 text-xs font-bold text-emerald-600 ring-1 ring-emerald-500/20 dark:bg-emerald-500/20 dark:text-emerald-400">
                                {{ strtoupper(substr($collector->user->name ?? 'N', 0, 1)) }}
                            </span>
                            <div class="min-w-0 flex-1">
                                <h3 class="truncate text-xs font-bold text-slate-900 dark:text-white">
                                    {{ $collector->user->name ?? 'N/A' }}
                                </h3>
                                <p class="truncate font-mono text-[11px] text-slate-500 dark:text-slate-400">
                                    {{ $collector->phone_no ?? 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <div
                            class="grid grid-cols-2 gap-1.5 rounded-lg bg-slate-50/80 p-2.5 text-[11px] dark:bg-slate-800/40">
                            <div>
                                <span class="text-[9px] uppercase tracking-wider text-slate-400">District</span>
                                <p class="font-medium text-slate-700 dark:text-slate-200">
                                    {{ $districts->firstWhere('id', $collector->district)->name ?? 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <span class="text-[9px] uppercase tracking-wider text-slate-400">AI Range</span>
                                <p class="font-medium text-slate-700 dark:text-slate-200">
                                    {{ $collector->getAiRange->name ?? 'N/A' }}
                                </p>
                            </div>
                            <div class="col-span-2 pt-1 border-t border-slate-200/60 dark:border-slate-700/60">
                                <span class="text-[9px] uppercase tracking-wider text-slate-400">Season</span>
                                <p class="font-medium text-emerald-600 dark:text-emerald-400">
                                    {{ $collector->riceSeason->name ?? 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <button wire:click="viewCollector({{ $collector->id }})"
                            class="mt-2.5 flex h-8 w-full items-center justify-center gap-1.5 rounded-lg bg-sky-600 text-xs font-semibold text-white shadow-sm transition hover:bg-sky-500 focus:outline-none">
                            <i class="fa-regular fa-eye text-xs"></i>
                            View Collector
                        </button>
                    </div>
                @empty
                    <div
                        class="flex flex-col items-center justify-center gap-1.5 rounded-xl border border-dashed border-slate-300 bg-slate-50/50 py-8 text-center text-slate-400 dark:border-slate-800 dark:bg-slate-900/40">
                        <i class="fas fa-user-slash text-base"></i>
                        <p class="text-xs font-medium text-slate-600 dark:text-slate-300">No collectors found</p>
                    </div>
                @endforelse

                <div class="pt-1">
                    {{ $filteredCollectors->links() }}
                </div>
            </div>
        </section>

        {{-- ============================= CHARTS AND CARDS ============================= --}}
        <section aria-labelledby="insights-heading" class="space-y-4">
            <p id="insights-heading" class="text-xs font-semibold uppercase tracking-wider text-slate-500 ps-1">
                Insights
            </p>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

                <x-dd.card title="🏆 Top Collectors"
                    class="border border-slate-200 bg-white/80 text-slate-800 transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900/60 dark:text-white">
                    <div class="mb-4">
                        <h2 class="text-base font-semibold text-emerald-400">By Data Count &gt; 0</h2>
                        <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            @if ($filteredCollectorsBy->isNotEmpty())
                                <span class="font-medium text-slate-700 dark:text-slate-200">
                                    {{ \App\Models\RiceSeason::find($selectedSeason)->name ?? 'All Seasons' }} &middot;
                                    {{ $displayLocationName }}
                                </span>
                            @else
                                <span class="font-medium text-slate-700 dark:text-slate-200">No collectors
                                    available</span>
                            @endif
                        </div>
                    </div>

                    <ul class="divide-y divide-slate-200 text-sm dark:divide-slate-800">
                        @forelse ($filteredCollectorsBy as $collector)
                            <li class="flex items-center justify-between gap-2 py-2.5">
                                <div class="flex min-w-0 items-center gap-2.5">
                                    <span @class([
                                        'flex h-6 w-6 shrink-0 items-center justify-center rounded-full text-xs font-bold',
                                        'bg-amber-400/20 text-amber-700 dark:text-amber-300' =>
                                            $loop->iteration === 1,
                                        'bg-slate-300/20 text-slate-700 dark:text-slate-200' =>
                                            $loop->iteration === 2,
                                        'bg-orange-700/25 text-orange-600 dark:text-orange-400' =>
                                            $loop->iteration === 3,
                                        'bg-slate-200/70 text-slate-600 dark:bg-slate-700/40 dark:text-slate-400' =>
                                            $loop->iteration > 3,
                                    ])>
                                        {{ $loop->iteration }}
                                    </span>
                                    <span class="truncate text-slate-700 dark:text-slate-200">
                                        {{ $collector->user->name ?? 'Unnamed Collector' }}
                                        <span class="text-slate-500 dark:text-slate-400">&middot;
                                            {{ $collector->getAiRange->name ?? 'Unnamed Ai' }}</span>
                                    </span>
                                </div>
                                <span
                                    class="shrink-0 rounded-full bg-emerald-500/15 px-2.5 py-1 text-xs font-medium text-emerald-600 dark:text-emerald-400">
                                    {{ $collector->common_data_collect_count ?? 0 }} entries
                                </span>
                            </li>
                        @empty
                            <li class="py-3 text-rose-500 dark:text-rose-400">No data found.</li>
                        @endforelse
                    </ul>
                </x-dd.card>

                <x-dd.card title="📝 Recent Activities"
                    class="border border-slate-200 bg-white/80 text-slate-800 transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900/60 dark:text-white">
                    <ul class="divide-y divide-slate-200 text-sm dark:divide-slate-800">
                        @forelse ($recentActivities as $activity)
                            <li class="flex items-start gap-3 py-2.5">
                                <span
                                    class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-sky-500/15 text-sky-400">
                                    <i class="fas fa-clock text-xs"></i>
                                </span>
                                <p class="min-w-0 text-slate-600 dark:text-slate-300">
                                    <strong
                                        class="text-slate-900 dark:text-white">{{ $activity->user->name ?? 'N/A' }}</strong>
                                    {{ $activity->title }}
                                    <span
                                        class="block text-xs text-slate-500 dark:text-slate-400">{{ $activity->created_at->diffForHumans() }}</span>
                                </p>
                            </li>
                        @empty
                            <li class="py-3 text-slate-500 dark:text-slate-400">No recent activities found.</li>
                        @endforelse
                    </ul>
                </x-dd.card>

                <div class="lg:col-span-2">
                    <x-dd.card title="📌 All Collectors in {{ $displayLocationName }}"
                        class="border border-slate-200 bg-white/80 text-slate-800 transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900/60 dark:text-white">
                        <div class="overflow-hidden rounded-lg">
                            <livewire:map-view :collectors="$this->collectors" />
                        </div>
                    </x-dd.card>
                </div>
            </div>
        </section>

    </div>

    {{-- ============================= COLLECTOR MODAL ============================= --}}
    {{-- Moved OUTSIDE the filters/collectors <section> (which has backdrop-blur-md) --}}
    {{-- and outside the overflow-x-auto table wrapper. A `backdrop-filter`/`filter`/  --}}
    {{-- `transform` on an ancestor creates a new containing block for `position: fixed` --}}
    {{-- children, which was trapping this modal inside the table's box instead of the  --}}
    {{-- full viewport. Living here, as a direct child of the outermost div, fixes it.  --}}
    @if ($showModal && $selectedCollector)
        <div class="fixed inset-0 z-[9999] flex items-end sm:items-center justify-center bg-slate-950/60 backdrop-blur-sm p-0 sm:p-4"
            wire:key="modal-{{ $selectedCollector->id }}">

            <div
                class="flex flex-col w-full sm:w-auto sm:max-w-2xl max-h-[85dvh] sm:max-h-[90dvh] rounded-t-2xl sm:rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-2xl overflow-hidden">

                <div
                    class="flex items-center justify-between px-4 sm:px-6 py-3 sm:py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-green-600 text-white shadow-md shadow-green-500/30 flex-shrink-0">
                            <i class="fas fa-user text-sm"></i>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white truncate">
                                Collector Profile
                            </h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                {{ $selectedCollector->user->name ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                    <button wire:click="closeModal" type="button"
                        class="w-9 h-9 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all flex-shrink-0 ml-2">
                        <i class="fas fa-xmark text-lg"></i>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto overscroll-contain px-4 sm:px-6 py-5 space-y-5">

                    <div
                        class="flex items-center gap-4 p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-100 dark:border-slate-800">
                        <div
                            class="w-16 h-16 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white text-xl font-bold shadow-lg shadow-green-500/30 flex-shrink-0">
                            {{ strtoupper(substr($selectedCollector->user->name ?? 'N', 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white truncate">
                                {{ $selectedCollector->user->name ?? 'N/A' }}</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">
                                {{ $selectedCollector->user->email ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div
                            class="p-4 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fas fa-map-marker-alt text-blue-500 text-xs"></i>
                                <span
                                    class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">AI
                                    Range</span>
                            </div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">
                                {{ $selectedCollector->getAiRange->name ?? 'N/A' }}</p>
                        </div>
                        <div
                            class="p-4 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fas fa-seedling text-green-500 text-xs"></i>
                                <span
                                    class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Season</span>
                            </div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">
                                {{ $selectedCollector->riceSeason->name ?? 'N/A' }}</p>
                        </div>
                        <div
                            class="p-4 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fas fa-phone text-amber-500 text-xs"></i>
                                <span
                                    class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Phone</span>
                            </div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">
                                {{ $selectedCollector->phone_no ?? 'N/A' }}</p>
                        </div>
                        <div
                            class="p-4 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fas fa-database text-purple-500 text-xs"></i>
                                <span
                                    class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Entries</span>
                            </div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">
                                {{ $selectedCollector->commonDataCollect->count() }}</p>
                        </div>
                    </div>

                    <div>
                        @if ($selectedCollector->commonDataCollect->isEmpty())
                            <div
                                class="flex items-center gap-3 p-4 bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800 rounded-xl">
                                <div
                                    class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-500/20 flex items-center justify-center text-amber-600 dark:text-amber-400 flex-shrink-0">
                                    <i class="fas fa-inbox text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-amber-800 dark:text-amber-300">No Data
                                        Submitted</p>
                                    <p class="text-xs text-amber-600 dark:text-amber-400 mt-0.5">This collector has not
                                        submitted any data for this season.</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-3 mb-4">
                                <div
                                    class="flex items-center justify-center w-8 h-8 rounded-lg bg-green-100 dark:bg-green-500/20 text-green-600 dark:text-green-400">
                                    <i class="fas fa-calendar-days text-sm"></i>
                                </div>
                                <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                                    Data Collection Timeline</h3>
                                <span
                                    class="ml-auto inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400">
                                    {{ $selectedCollector->commonDataCollect->count() }} entries
                                </span>
                            </div>
                            <div class="space-y-3">
                                @foreach ($selectedCollector->commonDataCollect as $entry)
                                    <div
                                        class="flex items-start gap-3 p-4 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl hover:border-green-300 dark:hover:border-green-700 transition-all group">
                                        <div
                                            class="w-8 h-8 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-bold text-xs shadow-md shadow-green-500/20 flex-shrink-0">
                                            {{ $loop->iteration }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                                                <div
                                                    class="flex items-center gap-1.5 text-sm text-slate-700 dark:text-slate-300">
                                                    <i class="fas fa-seedling text-green-500 text-xs"></i>
                                                    <span class="font-medium">Field Date:</span>
                                                    <span>{{ $entry->c_date }}</span>
                                                </div>
                                            </div>
                                            <p
                                                class="text-xs text-slate-400 dark:text-slate-500 mt-1 flex items-center gap-1.5">
                                                <i class="fas fa-clock text-[10px]"></i>
                                                Submitted
                                                {{ \Carbon\Carbon::parse($entry->created_at)->diffForHumans() }}
                                                &bull;
                                                {{ \Carbon\Carbon::parse($entry->created_at)->format('M d, Y H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div
                    class="flex items-center justify-end px-4 sm:px-6 py-3 sm:py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 flex-shrink-0">
                    <button wire:click="closeModal" type="button"
                        class="px-5 py-2.5 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
