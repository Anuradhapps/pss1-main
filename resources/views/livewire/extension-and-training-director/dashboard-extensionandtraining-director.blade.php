@section('title', 'Extension And Training Director - Dashboard')

<div
    class="min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 transition-colors duration-300 p-3 sm:p-4 space-y-4">

    <!-- Top Heading -->
    <x-headings.top-heading title="Inter-Provincial Dashboard" icon="fas fa-clipboard"
        class="bg-gradient-to-r from-emerald-50 via-green-50 to-teal-50
           text-emerald-900
           border border-emerald-200
           dark:from-slate-900 dark:via-emerald-900 dark:to-slate-800
           dark:text-emerald-100
           dark:border-slate-700
           shadow-sm rounded-xl" />

    <!-- Inter Provinces Pest Damage Level (Collapsible) -->
    <div x-data="{ open: false }" wire:ignore.self
        class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/60 overflow-hidden">

        <button type="button" @click="open = !open" :aria-expanded="open" aria-controls="pest-damage-panel"
            class="flex w-full items-center justify-between px-4 py-3 text-left text-slate-700 dark:text-slate-100 transition duration-150 hover:bg-slate-50 dark:hover:bg-slate-800/60 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-500 focus-visible:outline-offset-[-2px]">

            <div class="flex items-center gap-2.5">
                <div
                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400">
                    <i class="fas fa-bug text-sm" aria-hidden="true"></i>
                </div>
                <h2 class="text-base font-bold text-slate-900 dark:text-slate-100">
                    Inter Provinces Pest Damage Level
                </h2>
                <span class="hidden sm:inline text-xs italic text-slate-400 dark:text-slate-500"
                    x-text="open ? '(click to hide)' : '(click to show)'"></span>
            </div>

            <svg :class="{ 'rotate-180': open }"
                class="h-5 w-5 flex-shrink-0 text-slate-400 transition-transform duration-200" fill="none"
                stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div id="pest-damage-panel" x-show="open" x-cloak x-transition
            class="space-y-3 border-t border-slate-200 dark:border-slate-800 p-3">
            @foreach ($districts as $district)
                <div
                    class="rounded-lg border border-slate-200 bg-white/80 p-3 shadow-sm dark:border-slate-800 dark:bg-slate-900/60">
                    <!-- Header -->
                    <div
                        class="mb-3 flex items-center gap-3 rounded-lg border border-amber-200 bg-amber-50 px-3 py-2.5 dark:border-amber-900/40 dark:bg-amber-950/30">
                        <div
                            class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-lg bg-amber-500 text-white shadow-sm">
                            <i class="fas fa-bug text-sm" aria-hidden="true"></i>
                        </div>
                        <h2 class="text-sm sm:text-base font-bold text-slate-900 dark:text-slate-100">
                            Pest Density in <span
                                class="text-amber-700 dark:text-amber-400">{{ $district->name }}</span> — This Week
                        </h2>
                    </div>

                    <!-- Nested Livewire Component -->
                    <livewire:pest-memo-card :districtId="$district->id" :days="7" :key="'pest-' . $district->id" />
                </div>
            @endforeach
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3">
        <x-dd.stat-box color="green" title="Total Collectors" :value="$totalUsersCount" />
        <x-dd.stat-box color="yellow" title="This Season" :value="$seasonUserCount" />

        @if ($selectedSeason || $selectedDistrict || $searchNumber)
            <div
                class="col-span-2 lg:col-span-2 flex items-center justify-between gap-3 rounded-xl border border-slate-200 bg-white/90 p-3.5 shadow-sm dark:border-slate-800 dark:bg-slate-900/80">
                <div class="min-w-0 flex flex-col text-sm font-medium leading-tight text-slate-600 dark:text-slate-300">
                    <span class="truncate font-semibold text-slate-800 dark:text-slate-100">
                        {{ \App\Models\District::find($selectedDistrict)?->name ?? 'All Provinces' }}
                    </span>
                    <span class="truncate text-xs text-slate-400 dark:text-slate-500">
                        {{ $selectedSeasonName }} Collectors
                    </span>
                </div>
                <div
                    class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-lg bg-emerald-500 text-lg font-bold tabular-nums text-white shadow-sm">
                    {{ $selectedSeasonUserCount }}
                </div>
            </div>
        @endif
    </div>

    <!-- Filters -->
    <div class="rounded-xl border border-slate-200 bg-white/60 p-3 dark:border-slate-700/60 dark:bg-slate-800/30">
        <div class="grid grid-cols-1 gap-2.5 sm:grid-cols-2 lg:grid-cols-6">

            <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search by name"
                class="h-10 rounded-lg border border-slate-200 bg-slate-50/50 px-3 text-sm text-slate-800 placeholder-slate-400 outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 dark:border-slate-700/80 dark:bg-slate-800/50 dark:text-slate-100 dark:placeholder-slate-500 dark:focus:bg-slate-800 lg:col-span-2" />

            <input type="number" inputmode="numeric" wire:model.live.debounce.500ms="searchNumber"
                placeholder="Search by phone"
                class="h-10 rounded-lg border border-slate-200 bg-slate-50/50 px-3 text-sm text-slate-800 placeholder-slate-400 outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 dark:border-slate-700/80 dark:bg-slate-800/50 dark:text-slate-100 dark:placeholder-slate-500 dark:focus:bg-slate-800" />

            <select wire:model.live="selectedDistrict"
                class="h-10 rounded-lg border border-slate-200 bg-slate-50/50 px-3 text-sm text-slate-800 outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 dark:border-slate-700/80 dark:bg-slate-800/50 dark:text-slate-100 dark:focus:bg-slate-800">
                <option value="">All Provinces</option>
                @foreach ($districts as $district)
                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                @endforeach
            </select>

            <select wire:model.live="selectedSeason"
                class="h-10 rounded-lg border border-slate-200 bg-slate-50/50 px-3 text-sm text-slate-800 outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 dark:border-slate-700/80 dark:bg-slate-800/50 dark:text-slate-100 dark:focus:bg-slate-800">
                <option value="">All Seasons</option>
                @foreach ($seasons as $season)
                    <option value="{{ $season->id }}">{{ $season->name }}</option>
                @endforeach
            </select>

            <div class="flex gap-2 lg:col-span-2">
                <button wire:click="resetFilters"
                    class="flex h-10 flex-1 items-center justify-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 text-xs font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 active:scale-[0.98] dark:border-slate-700/80 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700/80">
                    <i class="fas fa-rotate-left text-[10px] text-slate-400" aria-hidden="true"></i>
                    Reset
                </button>

                <div class="group relative flex-1">
                    <button wire:click="downloadCollectorsList"
                        class="flex h-10 w-full items-center justify-center gap-1.5 rounded-lg bg-emerald-600 px-3 text-xs font-semibold text-white shadow-sm shadow-emerald-600/20 transition hover:bg-emerald-500 active:scale-[0.98]">
                        <i class="fas fa-download text-[10px]" aria-hidden="true"></i>
                        Export
                    </button>
                    <span
                        class="pointer-events-none absolute bottom-full left-1/2 z-20 mb-2 hidden w-52 -translate-x-1/2 rounded-lg border border-slate-200 bg-white p-2 text-center text-xs leading-relaxed text-slate-600 opacity-0 shadow-xl transition-all duration-200 group-hover:opacity-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 lg:block">
                        Downloads the collector list for the selected season. With no season selected, all seasons are
                        included.
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- User Table -->
    <div
        class="rounded-xl border border-slate-200/80 bg-white/90 shadow-sm dark:border-slate-800/80 dark:bg-slate-900/80">
        <!-- Desktop Table -->
        <div class="relative hidden overflow-x-auto rounded-t-xl sm:block">

            <div wire:loading.flex wire:target="search, searchNumber, selectedDistrict, selectedSeason"
                class="absolute inset-0 z-10 items-center justify-center bg-white/50 backdrop-blur-[1px] dark:bg-slate-900/50">
                <div
                    class="flex items-center gap-2 rounded-full bg-slate-900/80 px-3 py-1.5 text-xs font-medium text-white shadow-lg dark:bg-slate-100 dark:text-slate-900">
                    <i class="fas fa-spinner fa-spin text-emerald-400 dark:text-emerald-600" aria-hidden="true"></i>
                    Updating...
                </div>
            </div>

            @if ($filteredCollectors->isEmpty())
                <div
                    class="flex flex-col items-center justify-center gap-1.5 py-10 text-center text-slate-400 dark:text-slate-500">
                    <i class="fas fa-user-slash text-lg" aria-hidden="true"></i>
                    <p class="text-sm font-medium text-slate-600 dark:text-slate-300">No collectors found</p>
                    <p class="text-xs text-slate-400 dark:text-slate-500">Try adjusting your filters</p>
                </div>
            @else
                <table class="w-full min-w-[700px] text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead
                        class="border-b border-slate-200/80 bg-slate-50/80 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800/80 dark:bg-slate-900/60 dark:text-slate-400">
                        <tr>
                            <th scope="col" class="px-4 py-2.5">Name</th>
                            <th scope="col" class="px-4 py-2.5">AI Range</th>
                            <th scope="col" class="px-4 py-2.5">Season</th>
                            <th scope="col" class="px-4 py-2.5">Phone</th>
                            <th scope="col" class="px-4 py-2.5 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200/60 dark:divide-slate-800/60">
                        @foreach ($filteredCollectors as $collector)
                            <tr class="transition-colors hover:bg-slate-50/80 dark:hover:bg-slate-800/40">
                                <td
                                    class="whitespace-nowrap px-4 py-2.5 font-semibold text-slate-900 dark:text-slate-100">
                                    {{ $collector->user->name ?? 'N/A' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2.5">
                                    {{ $collector->getAiRange->name ?? 'N/A' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2.5">
                                    <span
                                        class="inline-flex items-center rounded-full bg-emerald-500/10 px-2 py-0.5 text-xs font-medium text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">
                                        {{ $collector->riceSeason->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td
                                    class="whitespace-nowrap px-4 py-2.5 font-mono text-xs text-slate-500 dark:text-slate-400">
                                    {{ $collector->phone_no ?? 'N/A' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2.5 text-right">
                                    <button wire:click="viewCollector({{ $collector->id }})"
                                        class="inline-flex items-center gap-1 rounded-md bg-sky-500/10 px-2.5 py-1 text-xs font-semibold text-sky-600 transition hover:bg-sky-600 hover:text-white dark:bg-sky-500/20 dark:text-sky-400 dark:hover:bg-sky-500 dark:hover:text-white">
                                        <i class="fa-regular fa-eye text-xs" aria-hidden="true"></i>
                                        View
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="border-t border-slate-200/80 p-3 dark:border-slate-800/80">
                    {{ $filteredCollectors->links() }}
                </div>
            @endif
        </div>

        <!-- Mobile Cards -->
        <div class="space-y-2 p-3 sm:hidden">
            @forelse ($filteredCollectors as $collector)
                <button type="button" wire:click="viewCollector({{ $collector->id }})"
                    class="flex w-full items-center justify-between rounded-lg border border-slate-200 bg-white p-3 text-left shadow-sm transition active:scale-[0.98] hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:hover:bg-slate-800/60">
                    <div class="min-w-0 flex-1">
                        <div class="truncate text-sm font-bold text-slate-900 dark:text-white">
                            {{ $collector->user->name ?? 'N/A' }}</div>
                        <div class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400">
                            {{ $collector->getAiRange->name ?? 'N/A' }} &middot;
                            {{ $collector->riceSeason->name ?? 'N/A' }}
                        </div>
                        <div class="mt-0.5 truncate font-mono text-xs text-slate-400 dark:text-slate-500">
                            {{ $collector->phone_no ?? 'N/A' }}
                        </div>
                    </div>
                    <i class="fas fa-chevron-right ml-3 flex-shrink-0 text-xs text-slate-300 dark:text-slate-600"
                        aria-hidden="true"></i>
                </button>
            @empty
                <div
                    class="flex flex-col items-center justify-center gap-1.5 rounded-lg border border-dashed border-slate-300 bg-slate-50/50 py-8 text-center text-slate-400 dark:border-slate-800 dark:bg-slate-900/40">
                    <i class="fas fa-user-slash text-base" aria-hidden="true"></i>
                    <p class="text-xs font-medium text-slate-600 dark:text-slate-300">No collectors found</p>
                </div>
            @endforelse
            <div class="pt-1 text-xs">{{ $filteredCollectors->links() }}</div>
        </div>

        @include('livewire.extension-and-training-director.collectorModel')
    </div>

    <!-- Dashboard Cards + Charts -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <x-dd.card title="🏆 Top Collectors"
            class="border border-slate-200 bg-white/80 text-slate-800 transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900/60 dark:text-white">
            <div class="mb-4">
                <h2 class="text-base font-bold text-emerald-600 dark:text-emerald-400">By Data Count &gt; 0</h2>
                <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    @if ($filteredCollectorsBy->isNotEmpty())
                        <span class="font-semibold text-slate-700 dark:text-slate-200">
                            {{ $selectedSeasonName ?? 'All Seasons' }} &middot;
                            {{ \App\Models\District::find($selectedDistrict)?->name ?? 'All Provinces' }}
                        </span>
                    @else
                        <span class="font-semibold text-slate-700 dark:text-slate-200">No collectors available</span>
                    @endif
                </div>
            </div>
            <ul class="divide-y divide-slate-200 text-sm dark:divide-slate-800">
                @forelse ($filteredCollectorsBy as $collector)
                    <li class="flex items-center justify-between gap-2 py-2.5">
                        <span class="truncate text-slate-700 dark:text-slate-200">
                            {{ $collector->user->name ?? 'Unnamed Collector' }}
                            <span class="text-slate-500 dark:text-slate-400">&middot;
                                {{ $collector->getAiRange->name ?? 'Unnamed Ai' }}</span>
                        </span>
                        <span
                            class="shrink-0 rounded-full bg-orange-500/15 px-2.5 py-1 text-xs font-medium text-orange-700 dark:text-orange-400">
                            {{ $collector->common_data_collect_count ?? 0 }} entries
                        </span>
                    </li>
                @empty
                    <li class="py-3 text-sm text-rose-500 dark:text-rose-400">No data found.</li>
                @endforelse
            </ul>
        </x-dd.card>

        <x-dd.card title="📌 All Collector Locations"
            class="border border-slate-200 bg-white/80 text-slate-800 transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900/60 dark:text-white">
            <div class="overflow-hidden rounded-lg">
                <livewire:map-view :collectors="$this->collectors" :key="'map-view'" />
            </div>
        </x-dd.card>

        <x-dd.card title="📝 Recent Activities"
            class="md:col-span-2 border border-slate-200 bg-white/80 text-slate-800 transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900/60 dark:text-white">
            <ul class="divide-y divide-slate-200 text-sm dark:divide-slate-800">
                @forelse ($recentActivities as $activity)
                    <li class="flex items-start gap-3 py-2.5">
                        <span
                            class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-sky-500/15 text-sky-500 dark:text-sky-400">
                            <i class="fas fa-clock text-xs" aria-hidden="true"></i>
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
                    <li class="py-3 text-sm text-slate-500 dark:text-slate-400">No recent activities found.</li>
                @endforelse
            </ul>
        </x-dd.card>

        {{-- <x-dd.card title="All Island Pest Data Comparisons" class="...">
            <x-weekly-pest-risk-index-card />
        </x-dd.card> --}}
    </div>
</div>
