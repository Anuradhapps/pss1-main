@section('title', 'DD-Dashboard')

<div class="space-y-2">

    {{-- Page Header --}}

    <x-headings.top-heading title="{{ $district->name }} District Dashboard" icon="fas fa-clipboard"
        class="bg-gradient-to-r from-emerald-400 to-teal-200 dark:from-slate-900 dark:via-emerald-900 dark:to-slate-800 dark:text-white border border-emerald-200 dark:border-slate-700 shadow-lg rounded-lg" />

    {{-- Pest Density Card --}}
    <div
        class="mt-0 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="py-0 px-6 border-b border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-3">
                <div
                    class="flex items-center justify-center w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400">
                    <i class="fas fa-bug text-lg"></i>
                </div>
                <div class='my-2'>
                    <h3 class="my-0 py-0 text-lg font-semibold text-slate-900 dark:text-white">Pest Density This Week
                    </h3>
                    <p class="my-0 py-0 text-sm text-slate-500 dark:text-slate-400">{{ $district->name }} district
                        overview</p>
                </div>
            </div>
        </div>
        <div class="p-2">
            <livewire:pest-memo-card :districtId="$district->id" :days="7" :key="'pest-' . $district->id" />
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
        <div
            class="bg-white dark:bg-slate-900 rounded-2xl p-2 ps-4 border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center gap-4">
                <div
                    class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400">
                    <i class="fas fa-users text-lg"></i>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total
                        Users</p>
                    <p class="text-2xl font-bold text-slate-900 dark:text-white mt-0.5">{{ $totalUsersCount }}</p>
                </div>
            </div>
        </div>
        <div
            class="bg-white dark:bg-slate-900 rounded-2xl p-2 ps-4 border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center gap-4">
                <div
                    class="flex items-center justify-center w-10 h-10 rounded-xl bg-green-100 dark:bg-green-500/20 text-green-600 dark:text-green-400">
                    <i class="fas fa-seedling text-lg"></i>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">This
                        Season</p>
                    <p class="text-2xl font-bold text-slate-900 dark:text-white mt-0.5">{{ $seasonUserCount }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters + User Table --}}
    <div
        class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-xl bg-green-100 dark:bg-green-500/20 text-green-600 dark:text-green-400">
                        <i class="fas fa-users text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Collectors</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $district->name }} district</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50">
            <div class="flex flex-col lg:flex-row gap-3">
                <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="text" wire:model.debounce.500ms="search" placeholder="Search by name"
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-sm text-slate-900 dark:text-white shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all outline-none" />
                    </div>
                    <div class="relative">
                        <i class="fas fa-phone absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="number" wire:model.debounce.500ms="searchNumber" placeholder="Search by phone"
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-sm text-slate-900 dark:text-white shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all outline-none" />
                    </div>
                    <select wire:model="selectedAiRange"
                        class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 px-4 py-2.5 text-sm text-slate-900 dark:text-white shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all outline-none">
                        <option value="">All AI Ranges</option>
                        @foreach ($aiRanges as $ai)
                            <option value="{{ $ai->id }}">{{ $ai->name }}</option>
                        @endforeach
                    </select>
                    <select wire:model="selectedSeason"
                        class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 px-4 py-2.5 text-sm text-slate-900 dark:text-white shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all outline-none">
                        <option value="">All Seasons</option>
                        @foreach ($seasons as $season)
                            <option value="{{ $season->id }}">{{ $season->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2 flex-shrink-0">
                    <button wire:click="resetFilters"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">
                        <i class="fas fa-rotate-left text-xs"></i>
                        Reset
                    </button>
                    <div class="relative group">
                        <button wire:click="downloadCollectorsList"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium text-white bg-green-600 hover:bg-green-700 transition-all shadow-md shadow-green-500/30">
                            <i class="fas fa-download text-xs"></i>
                            Export
                        </button>
                        <div
                            class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max px-3 py-2 rounded-xl bg-slate-900 dark:bg-slate-700 text-xs text-white opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 pointer-events-none z-10">
                            Download collector list for selected season
                            <div
                                class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-slate-900 dark:border-t-slate-700">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Desktop Table --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="min-w-full text-left">
                <thead>
                    <tr class="bg-slate-50/80 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th
                            class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                            Name</th>
                        <th
                            class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                            AI Range</th>
                        <th
                            class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                            Season</th>
                        <th
                            class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                            Phone</th>
                        <th
                            class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach ($filteredCollectors as $collector)
                        <tr
                            class="group bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-bold text-sm shadow-md shadow-green-500/20">
                                        {{ strtoupper(substr($collector->user->name ?? 'N', 0, 1)) }}
                                    </div>
                                    <span
                                        class="text-sm font-semibold text-slate-900 dark:text-white">{{ $collector->user->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-blue-50 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400">
                                    {{ $collector->getAiRange->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-green-50 text-green-700 dark:bg-green-500/20 dark:text-green-400">
                                    {{ $collector->riceSeason->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">
                                {{ $collector->phone_no ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-1">
                                    <button wire:click="viewCollector({{ $collector->id }})"
                                        class="w-9 h-9 rounded-lg flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-500/10 transition-all"
                                        title="View">
                                        <i class="fas fa-eye text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($filteredCollectors->count() === 0)
                <div class="text-center py-12">
                    <div class="flex flex-col items-center gap-3">
                        <div
                            class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                            <i class="fas fa-search text-slate-400 dark:text-slate-600 text-2xl"></i>
                        </div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">No collectors found</p>
                        <button wire:click="resetFilters"
                            class="text-sm text-green-600 hover:text-green-700 font-medium">Reset filters</button>
                    </div>
                </div>
            @endif
            <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-800">
                {{ $filteredCollectors->links() }}
            </div>
        </div>

        {{-- Mobile Cards --}}
        <div class="sm:hidden p-4 space-y-3">
            @foreach ($filteredCollectors as $collector)
                <div
                    class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl p-4 transition-all hover:border-green-300 dark:hover:border-green-700">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-bold text-sm shadow-md shadow-green-500/20 flex-shrink-0">
                                {{ strtoupper(substr($collector->user->name ?? 'N', 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-slate-900 dark:text-white">
                                    {{ $collector->user->name ?? 'N/A' }}</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                    {{ $collector->phone_no ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <button wire:click="viewCollector({{ $collector->id }})"
                            class="w-9 h-9 rounded-lg flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-500/10 transition-all flex-shrink-0">
                            <i class="fas fa-eye text-sm"></i>
                        </button>
                    </div>
                    <div class="flex gap-2 mt-3">
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-medium bg-blue-50 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400">
                            {{ $collector->getAiRange->name ?? 'N/A' }}
                        </span>
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-medium bg-green-50 text-green-700 dark:bg-green-500/20 dark:text-green-400">
                            {{ $collector->riceSeason->name ?? 'N/A' }}
                        </span>
                    </div>
                </div>
            @endforeach
            @if ($filteredCollectors->count() === 0)
                <div class="text-center py-12">
                    <div class="flex flex-col items-center gap-3">
                        <div
                            class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                            <i class="fas fa-search text-slate-400 dark:text-slate-600 text-2xl"></i>
                        </div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">No collectors found</p>
                        <button wire:click="resetFilters"
                            class="text-sm text-green-600 hover:text-green-700 font-medium">Reset filters</button>
                    </div>
                </div>
            @endif
            <div class="pt-2">
                {{ $filteredCollectors->links() }}
            </div>
        </div>
    </div>

    @include('livewire.deputy-director.collectorModel')

    {{-- Charts and Cards Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Top Collectors --}}
        <div
            class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-3">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400">
                        <i class="fas fa-trophy text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Top Collectors</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">By data collection count</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                @if ($filteredCollectorsBy->isNotEmpty())
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">
                        {{ \App\Models\RiceSeason::find($selectedSeason)->name ?? 'All Seasons' }} |
                        {{ $district->name ?? 'N/A' }}
                    </p>
                @endif
                <ul class="space-y-3">
                    @forelse ($filteredCollectorsBy as $collector)
                        <li
                            class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-100 dark:border-slate-800">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white font-bold text-xs shadow-md">
                                    {{ $loop->iteration }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900 dark:text-white">
                                        {{ $collector->user->name ?? 'Unnamed' }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">
                                        {{ $collector->getAiRange->name ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400">
                                {{ $collector->common_data_collect_count ?? 0 }} entries
                            </span>
                        </li>
                    @empty
                        <div class="text-center py-8">
                            <div
                                class="w-14 h-14 mx-auto mb-3 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                                <i class="fas fa-trophy text-slate-400 dark:text-slate-600 text-xl"></i>
                            </div>
                            <p class="text-sm text-slate-500 dark:text-slate-400">No data found</p>
                        </div>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- Map View --}}
        <div
            class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-3">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400">
                        <i class="fas fa-map-marked-alt text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Collector Locations</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $district->name }} district map</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <livewire:map-view :collectors="$this->collectors" />
            </div>
        </div>

        {{-- Recent Activities --}}
        <div
            class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden lg:col-span-2">
            <div class="p-6 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-3">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-500/20 text-purple-600 dark:text-purple-400">
                        <i class="fas fa-clock-rotate-left text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Recent Activities</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Latest district updates</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <ul class="space-y-3">
                    @forelse ($recentActivities as $activity)
                        <li
                            class="flex items-start gap-3 p-3 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-100 dark:border-slate-800">
                            <div
                                class="w-8 h-8 rounded-full bg-purple-100 dark:bg-purple-500/20 flex items-center justify-center text-purple-600 dark:text-purple-400 flex-shrink-0">
                                <i class="fas fa-user text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-slate-900 dark:text-white">
                                    <span class="font-semibold">{{ $activity->user->name ?? 'N/A' }}</span>
                                    {{ $activity->title }}
                                </p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                    {{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                        </li>
                    @empty
                        <div class="text-center py-8">
                            <div
                                class="w-14 h-14 mx-auto mb-3 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                                <i class="fas fa-inbox text-slate-400 dark:text-slate-600 text-xl"></i>
                            </div>
                            <p class="text-sm text-slate-500 dark:text-slate-400">No recent activities</p>
                        </div>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

</div>
