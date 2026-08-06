@section('title', 'DD-Dashboard')

@php
    // Determine what location name to display based on whether a district is selected
    $displayLocationName = $selectedDistrict
        ? $districts->firstWhere('id', $selectedDistrict)->name . ' District'
        : $province->name . ' Province';

    // Determine which districts to render memo cards for
    $activeDistricts = $selectedDistrict ? [$districts->firstWhere('id', $selectedDistrict)] : $districts;
@endphp

<div
    class="min-h-screen bg-slate-50 text-slate-800 transition-colors duration-300 dark:bg-slate-950 dark:text-slate-100">

    <x-headings.top-heading title="{{ $province->name }} Province Dashboard" icon="fas fa-clipboard"
        class="bg-gradient-to-r from-emerald-600 via-emerald-500 to-slate-100 text-slate-900 shadow-md dark:from-emerald-800 dark:via-emerald-800 dark:to-slate-900 dark:text-slate-100" />

    <div class="mx-auto max-w-screen-2xl space-y-8 px-4 py-5 sm:px-6 sm:py-6 lg:px-8">

        {{-- ============================= PEST DENSITY ============================= --}}
        <section aria-label="Pest monitoring"
            class="rounded-xl border border-slate-200 bg-white/80 p-4 shadow-lg transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900/60 sm:p-5">
            <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Pest
                Monitoring</p>

            @foreach ($activeDistricts as $dst)
                <div class="mb-6 last:mb-0">
                    <!-- Header -->
                    <div class="mb-4 flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-amber-500/15 text-amber-600 dark:text-amber-400">
                            <i class="fas fa-bug text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-slate-800 dark:text-slate-100 sm:text-lg">
                                Pest Density &middot; {{ $dst->name }}
                            </h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Last 7 days</p>
                        </div>
                    </div>

                    <!-- Nested Livewire Component -->
                    <livewire:pest-memo-card :districtId="$dst->id" :days="7" :key="'pest-' . $dst->id" />
                </div>
            @endforeach
        </section>

        {{-- ============================= QUICK STATS ============================= --}}
        <section aria-labelledby="stats-heading">
            <p id="stats-heading"
                class="mb-3 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Overview
            </p>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-dd.stat-box color="green" title="Total Users Count" :value="$totalUsersCount" />
                <x-dd.stat-box color="yellow" title="This Season Users" :value="$seasonUserCount" />
            </div>
        </section>

        {{-- ============================= FILTERS + USER TABLE ============================= --}}
        <section aria-labelledby="collectors-heading"
            class="rounded-xl border border-slate-200 bg-white/80 p-4 shadow-lg transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900/60 sm:p-5">

            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between lg:gap-6">
                <h2 id="collectors-heading"
                    class="shrink-0 text-lg font-semibold text-slate-800 dark:text-slate-100 sm:text-xl">
                    <i class="fa-solid fa-users mr-2 text-emerald-500"></i>
                    Users in {{ $displayLocationName }}
                </h2>

                <div class="grid w-full grid-cols-1 gap-3 sm:grid-cols-2 lg:w-auto lg:grid-cols-3 xl:grid-cols-6">
                    <div>
                        <label for="search-name"
                            class="mb-1 block text-xs font-medium text-slate-500 dark:text-slate-400">Name</label>
                        <input id="search-name" type="text" wire:model.debounce.500ms="search"
                            placeholder="Search by name"
                            class="h-10 w-full rounded-lg border border-slate-300 bg-white px-3 text-sm text-slate-800 placeholder-slate-400 outline-none transition-colors focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder-slate-500" />
                    </div>

                    <div>
                        <label for="search-phone"
                            class="mb-1 block text-xs font-medium text-slate-500 dark:text-slate-400">Phone
                            Number</label>
                        <input id="search-phone" type="number" wire:model.debounce.500ms="searchNumber"
                            placeholder="Search by phone"
                            class="h-10 w-full rounded-lg border border-slate-300 bg-white px-3 text-sm text-slate-800 placeholder-slate-400 outline-none transition-colors focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder-slate-500" />
                    </div>

                    <div>
                        <label for="filter-district"
                            class="mb-1 block text-xs font-medium text-slate-500 dark:text-slate-400">District</label>
                        <select id="filter-district" wire:model="selectedDistrict"
                            class="h-10 w-full rounded-lg border border-slate-300 bg-white px-3 text-sm text-slate-800 outline-none transition-colors focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                            <option value="">All Districts</option>
                            @foreach ($districts as $dst)
                                <option value="{{ $dst->id }}">{{ $dst->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="filter-ai-range"
                            class="mb-1 block text-xs font-medium text-slate-500 dark:text-slate-400">AI
                            Range</label>
                        <select id="filter-ai-range" wire:model="selectedAiRange"
                            class="h-10 w-full rounded-lg border border-slate-300 bg-white px-3 text-sm text-slate-800 outline-none transition-colors focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                            <option value="">All AI Ranges</option>
                            @foreach ($aiRanges as $ai)
                                <option value="{{ $ai->id }}">{{ $ai->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="filter-season"
                            class="mb-1 block text-xs font-medium text-slate-500 dark:text-slate-400">Season</label>
                        <select id="filter-season" wire:model="selectedSeason"
                            class="h-10 w-full rounded-lg border border-slate-300 bg-white px-3 text-sm text-slate-800 outline-none transition-colors focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                            <option value="">All Seasons</option>
                            @foreach ($seasons as $season)
                                <option value="{{ $season->id }}">{{ $season->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button wire:click="resetFilters" title="Reset all filters"
                            class="flex h-10 flex-1 items-center justify-center gap-1.5 rounded-lg border border-slate-300 px-2 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-500 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white">
                            <i class="fas fa-rotate-left text-xs"></i>
                            <span>Reset</span>
                        </button>

                        <div class="group relative flex-1">
                            <button wire:click="downloadCollectorsList" aria-label="Export collector list"
                                class="flex h-10 w-full items-center justify-center gap-1.5 rounded-lg bg-emerald-600 px-2 text-sm font-medium text-white shadow transition-colors hover:bg-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-400">
                                <i class="fas fa-download text-xs"></i>
                                <span>Export</span>
                            </button>
                            <span
                                class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-2 hidden w-52 -translate-x-1/2 rounded-md bg-white px-3 py-2 text-center text-xs leading-relaxed text-slate-700 opacity-0 shadow-lg transition duration-200 group-hover:opacity-100 dark:bg-slate-800 dark:text-slate-200 lg:block">
                                Downloads the list for the selected season &amp; location, or all collectors if none are
                                selected.
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table for tablet/desktop (sm and up) -->
            <div class="mt-5 hidden overflow-x-auto rounded-lg border border-slate-200 dark:border-slate-800 sm:block">
                <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                    <thead
                        class="bg-slate-100 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:bg-slate-900 dark:text-slate-400">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left">Name</th>
                            <th scope="col" class="px-4 py-3 text-left">District</th>
                            <th scope="col" class="px-4 py-3 text-left">AI Range</th>
                            <th scope="col" class="px-4 py-3 text-left">Season</th>
                            <th scope="col" class="px-4 py-3 text-left">Phone Number</th>
                            <th scope="col" class="px-4 py-3 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200/70 dark:divide-slate-800/60">
                        @foreach ($filteredCollectors as $collector)
                            <tr
                                class="transition-colors odd:bg-slate-50/70 even:bg-slate-100/50 hover:bg-emerald-500/10 dark:odd:bg-slate-900/40 dark:even:bg-slate-900/10">
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-800 dark:text-slate-100">
                                    <div class="flex items-center gap-2.5">
                                        <span
                                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-500/15 text-xs font-semibold text-emerald-400">
                                            {{ strtoupper(substr($collector->user->name ?? 'NA', 0, 1)) }}
                                        </span>
                                        {{ $collector->user->name ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-slate-600 dark:text-slate-300">
                                    {{ $districts->firstWhere('id', $collector->district)->name ?? 'N/A' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-slate-600 dark:text-slate-300">
                                    {{ $collector->getAiRange->name ?? 'N/A' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-slate-600 dark:text-slate-300">
                                    {{ $collector->riceSeason->name ?? 'N/A' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-slate-600 dark:text-slate-300">
                                    {{ $collector->phone_no ?? 'N/A' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3">
                                    <button wire:click="viewCollector({{ $collector->id }})"
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-sky-600 px-3 py-1.5 text-xs font-semibold text-white transition-colors hover:bg-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        View
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($filteredCollectors->count() === 0)
                    <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 500)"
                        :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-4'"
                        class="flex items-center justify-center gap-2 py-8 text-center italic text-slate-500 transition-transform duration-700 ease-in-out dark:text-slate-400"
                        role="alert" aria-live="polite">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 text-slate-500"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v2m0 4h.01M12 3.75a8.25 8.25 0 100 16.5 8.25 8.25 0 000-16.5z" />
                        </svg>
                        <span>No collectors found.</span>
                    </div>
                @endif
            </div>

            <div class="mt-3 hidden sm:block">
                {{ $filteredCollectors->links() }}
            </div>

            @include('livewire.deputy-director.collectorModel')

            <!-- Cards for mobile (below sm) -->
            <div class="mt-5 space-y-3 sm:hidden">
                @forelse ($filteredCollectors as $collector)
                    <div
                        class="rounded-xl border border-slate-200 border-l-4 border-l-emerald-500 bg-white/80 p-4 shadow-md transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900/70">
                        <div class="mb-3 flex items-center gap-3">
                            <span
                                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-emerald-500/15 text-base font-semibold text-emerald-400">
                                {{ strtoupper(substr($collector->user->name ?? 'NA', 0, 1)) }}
                            </span>
                            <div class="min-w-0">
                                <h3 class="truncate text-base font-semibold text-slate-900 dark:text-white">
                                    {{ $collector->user->name ?? 'N/A' }}</h3>
                                <p class="truncate text-xs text-slate-500 dark:text-slate-400">
                                    {{ $collector->phone_no ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <dl class="grid grid-cols-2 gap-x-3 gap-y-2 text-xs">
                            <div>
                                <dt class="text-slate-500 dark:text-slate-400">District</dt>
                                <dd class="text-slate-700 dark:text-slate-200">
                                    {{ $districts->firstWhere('id', $collector->district)->name ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-slate-500 dark:text-slate-400">AI Range</dt>
                                <dd class="text-slate-700 dark:text-slate-200">
                                    {{ $collector->getAiRange->name ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-slate-500 dark:text-slate-400">Season</dt>
                                <dd class="text-slate-700 dark:text-slate-200">
                                    {{ $collector->riceSeason->name ?? 'N/A' }}</dd>
                            </div>
                        </dl>

                        <button wire:click="viewCollector({{ $collector->id }})"
                            class="mt-4 flex h-11 w-full items-center justify-center gap-2 rounded-lg bg-sky-600 text-sm font-semibold text-white transition-colors hover:bg-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View Collector
                        </button>
                    </div>
                @empty
                    <div
                        class="flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-slate-50/80 py-8 text-center italic text-slate-500 dark:border-slate-800 dark:bg-slate-900/60 dark:text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 text-slate-500"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v2m0 4h.01M12 3.75a8.25 8.25 0 100 16.5 8.25 8.25 0 000-16.5z" />
                        </svg>
                        <span>No collectors found.</span>
                    </div>
                @endforelse

                <div class="pt-1">
                    {{ $filteredCollectors->links() }}
                </div>
            </div>
        </section>

        {{-- ============================= CHARTS AND CARDS ============================= --}}
        <section aria-labelledby="insights-heading" class="space-y-6">
            <p id="insights-heading" class="text-xs font-semibold uppercase tracking-wider text-slate-500">Insights
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
</div>
