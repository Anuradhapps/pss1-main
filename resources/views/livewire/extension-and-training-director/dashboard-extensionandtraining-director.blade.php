@section('title', 'Extension And Training Director - Dashboard')

<div>
    <x-headings.topHeading title="Inter-Provincial Dashboard" icon="fas fa-clipboard"
        class="bg-gradient-to-r from-green-900 to-green-900 shadow-md" />

    <div class="p-2 space-y-2 bg-gray-900 text-white min-h-screen text-sm">
        <!-- Quick Stats -->
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-2 mt-2">
            <x-dd.stat-box color="green" title="Total Users" :value="$totalUsersCount" class="rounded-none" />
            <x-dd.stat-box color="yellow" title="This Season" :value="$seasonUserCount" class="rounded-none" />
            @if ($selectedSeason || $selectedDistrict || $searchNumber)
                <div
                    class="col-span-2 lg:col-span-1 bg-gray-800 p-3 flex items-center justify-between border border-gray-700">
                    <div class="flex flex-col text-xs sm:text-sm text-gray-300 font-medium leading-tight">
                        <span class="truncate max-w-[120px] sm:max-w-none">
                            {{ \App\Models\District::find($selectedDistrict)?->name ?? '' }}
                        </span>
                        <span class="truncate text-gray-400">
                            {{ $selectedSeasonName }} Collectors
                        </span>
                    </div>
                    <div
                        class="ml-3 bg-green-600 w-10 h-10 sm:w-11 sm:h-11 flex items-center justify-center text-white text-sm sm:text-base font-bold border border-green-700">
                        {{ $selectedSeasonUserCount }}
                    </div>
                </div>
            @endif

        </div>

        <!-- Filter + User Table -->
        <div>
            <!-- Filter -->
            <div class="flex flex-col justify-between items-center gap-2">
                <div class="flex flex-wrap sm:justify-end gap-3 w-full sm:w-auto items-center">
                    <input type="text" wire:model.debounce.500ms="search" placeholder="Search by name"
                        class="rounded-none px-4 py-2 bg-gray-800 border border-gray-700 text-gray-300 placeholder-gray-500 focus:ring-2 focus:ring-blue-600 transition" />

                    <input type="number" wire:model.debounce.500ms="searchNumber" placeholder="Search by Phone Number"
                        class="rounded-none px-4 py-2 bg-gray-800 border border-gray-700 text-gray-300 placeholder-gray-500 focus:ring-2 focus:ring-blue-600 transition" />

                    <select wire:model="selectedDistrict"
                        class="rounded-none px-4 py-2 bg-gray-800 border border-gray-700 text-gray-300 focus:ring-2 focus:ring-blue-600 transition">
                        <option value="">All IP</option>
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}">{{ $district->name }}</option>
                        @endforeach
                    </select>

                    <select wire:model="selectedSeason"
                        class="rounded-none px-4 py-2 bg-gray-800 border border-gray-700 text-gray-300 focus:ring-2 focus:ring-blue-600 transition">
                        <option value="">All Seasons</option>
                        @foreach ($seasons as $season)
                            <option value="{{ $season->id }}">{{ $season->name }}</option>
                        @endforeach
                    </select>

                    <button wire:click="resetFilters"
                        class="rounded-none px-4 py-2 bg-red-700 hover:bg-red-800 text-white shadow transition transform hover:scale-105">
                        Reset
                    </button>
                </div>
            </div>
            <!--  User table-->
            <div>
                <!-- Table for desktop (sm and up) -->
                <div class="hidden sm:block overflow-x-auto mt-3">
                    @if ($filteredCollectors->isEmpty())
                        <div
                            class="flex items-center justify-center gap-3 px-4 py-3 mt-4 rounded-md border border-red-700 bg-red-900/20 text-red-400 text-sm font-medium shadow-sm animate-fade-in">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v2m0 4h.01M12 3.75a8.25 8.25 0 100 16.5 8.25 8.25 0 000-16.5z" />
                            </svg>
                            <span>No collectors found. Try adjusting your filters.</span>
                        </div>
                    @else
                        <table class="min-w-full bg-gray-950 border border-green-900 rounded-sm shadow-sm">
                            <thead
                                class="bg-green-950 text-green-200 text-xs font-semibold tracking-wider uppercase border-b border-green-800">
                                <tr>
                                    <th class="px-4 py-3 text-left">Name</th>
                                    <th class="px-4 py-3 text-left">AI Range</th>
                                    <th class="px-4 py-3 text-left">Season</th>
                                    <th class="px-4 py-3 text-left">Phone</th>
                                    <th class="px-4 py-3 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-green-100">
                                @foreach ($filteredCollectors as $collector)
                                    <tr
                                        class="border-b border-green-900 hover:bg-green-950 transition duration-200 ease-in-out cursor-pointer">
                                        <td class="px-4 py-2 font-medium whitespace-nowrap">
                                            {{ $collector->user->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $collector->getAiRange->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $collector->riceSeason->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $collector->phone_no ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-2 text-right">
                                            <button wire:click="viewCollector({{ $collector->id }})"
                                                class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold rounded transition transform hover:scale-105">
                                                View
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{ $filteredCollectors->links() }}
                        </div>
                    @endif

                </div>

                <!-- Ultra-Compact Cards for mobile (below sm) -->
                <div class="sm:hidden space-y-1 mt-2">
                    @foreach ($filteredCollectors as $collector)
                        <div wire:click="viewCollector({{ $collector->id }})"
                            class="bg-gray-900 border border-gray-700 px-3 py-2 text-white text-sm flex items-center justify-between cursor-pointer hover:bg-gray-800 transition duration-150 ease-in-out">
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold truncate">{{ $collector->user->name }}</div>
                                <div class="truncate text-gray-400 text-xs">
                                    {{ $collector->getAiRange->name ?? 'N/A' }} |
                                    {{ $collector->riceSeason->name ?? 'N/A' }}
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    @endforeach

                    <div class="pt-2 text-xs">
                        {{ $filteredCollectors->links() }}
                    </div>
                </div>
                @include('livewire.extension-and-training-director.collectorModel')
            </div>
        </div>

        <!-- Charts and Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-6">

            <x-dd.card title="🏆 Top Collectors" class="bg-gray-800 text-white border border-gray-700">
                <h2 class="text-lg font-semibold text-green-400 mb-4 flex items-center justify-between">
                    <div>
                        By Data Count > 0

                        <div class="text-sm text-gray-300 mt-1">
                            @if ($selectedSeasonName || $selectedDistrict)
                                @if ($selectedSeasonName)
                                    Season: <span class="font-semibold text-white">{{ $selectedSeasonName }}</span>
                                @endif

                                @if ($selectedSeasonName && $selectedDistrict)
                                    |
                                @endif

                                @if ($selectedDistrict)
                                    District: <span class="font-semibold text-white">
                                        {{ \App\Models\District::find($selectedDistrict)?->name ?? '' }}
                                    </span>
                                @endif
                            @else
                                <span class="font-semibold text-white">All Inter Provinces</span>
                            @endif
                        </div>
                    </div>

                    <button wire:click="toggleSortDirection"
                        class="ml-2 bg-green-800 hover:bg-green-900 px-2 py-1 rounded text-xs font-semibold">
                        Sort: {{ strtoupper($sortDirection) }}
                        @if ($sortDirection === 'asc')
                            &uarr;
                        @else
                            &darr;
                        @endif
                    </button>
                </h2>

                <ul class="divide-y divide-gray-700 text-sm">
                    @forelse ($filteredCollectorsBy as $collector)
                        <li class="py-2 flex justify-between items-center">
                            <span class="truncate">
                                {{ $collector->user->name ?? 'Unnamed Collector' }} -
                                {{ $collector->getAiRange->name ?? 'Unnamed Ai' }}
                            </span>
                            <span class="bg-orange-700 text-white px-3 py-1 rounded text-xs font-medium">
                                {{ $collector->common_data_collect_count ?? 0 }} entries
                            </span>
                        </li>
                    @empty
                        <li class="text-red-400 py-2">No data found.</li>
                    @endforelse
                </ul>
            </x-dd.card>
            <x-dd.card title="📌 All Collector Locations" class="bg-gray-800 text-white border border-gray-700">
                <livewire:map-view :collectors="$this->collectors" />
            </x-dd.card>
            <x-dd.card title="📝 Recent Activities" class="bg-gray-800 text-gray-300 border border-gray-700">
                <ul class="space-y-2 text-sm">
                    @forelse ($recentActivities as $activity)
                        <li>
                            🕒 <strong class="text-white">{{ $activity->user->name ?? 'N/A' }}</strong>
                            {{ $activity->title }} –
                            <span class="text-gray-500">{{ $activity->created_at->diffForHumans() }}</span>
                        </li>
                    @empty
                        <li>No recent activities found.</li>
                    @endforelse
                </ul>
            </x-dd.card>
            <x-dd.card title="Pest Data Comparisons" class="bg-gray-800 text-gray-300 border border-gray-700">
                <x-weekly-pest-risk-index-card />
            </x-dd.card>


        </div>

    </div>
</div>
{{-- @section('title', 'Extension And Training Director - Dashboard')

<div class="min-h-screen bg-gray-900 text-white px-4 py-6 space-y-6">

    <!-- Top Heading -->
    <x-headings.topHeading title="Inter-Provincial Dashboard" icon="fas fa-clipboard"
        class="bg-gradient-to-r from-green-800 to-green-900 shadow-lg rounded-2xl text-white p-4" />

    <!-- Quick Stats -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-dd.stat-box color="green" title="Total Users" :value="$totalUsersCount"
            class="rounded-2xl shadow-md hover:shadow-lg transition" />
        <x-dd.stat-box color="yellow" title="This Season" :value="$seasonUserCount"
            class="rounded-2xl shadow-md hover:shadow-lg transition" />
        @if ($selectedSeason || $selectedDistrict || $searchNumber)
            <div
                class="col-span-2 lg:col-span-1 bg-gray-800/90 backdrop-blur-sm border border-gray-700 p-4 rounded-2xl flex items-center justify-between shadow hover:shadow-lg transition">
                <div class="flex flex-col text-xs sm:text-sm text-gray-300 font-medium truncate">
                    <span>{{ \App\Models\District::find($selectedDistrict)?->name ?? 'All Districts' }}</span>
                    <span class="text-gray-400">{{ $selectedSeasonName }} Collectors</span>
                </div>
                <div
                    class="ml-3 bg-green-600 w-12 h-12 sm:w-14 sm:h-14 flex items-center justify-center text-white font-bold text-lg rounded-xl border border-green-700">
                    {{ $selectedSeasonUserCount }}
                </div>
            </div>
        @endif
    </div>

    <!-- Filters -->
    <div
        class="bg-gray-800/80 backdrop-blur-sm border border-gray-700 rounded-2xl p-4 shadow-md flex flex-wrap gap-3 items-center">
        <input type="text" wire:model.debounce.500ms="search" placeholder="Search by name"
            class="rounded-2xl px-4 py-2 bg-gray-900 border border-gray-700 placeholder-gray-500 focus:ring-2 focus:ring-blue-600 transition w-full sm:w-auto" />

        <input type="number" wire:model.debounce.500ms="searchNumber" placeholder="Search by Phone Number"
            class="rounded-2xl px-4 py-2 bg-gray-900 border border-gray-700 placeholder-gray-500 focus:ring-2 focus:ring-blue-600 transition w-full sm:w-auto" />

        <select wire:model="selectedDistrict"
            class="rounded-2xl px-4 py-2 bg-gray-900 border border-gray-700 focus:ring-2 focus:ring-blue-600 transition">
            <option value="">All IP</option>
            @foreach ($districts as $district)
                <option value="{{ $district->id }}">{{ $district->name }}</option>
            @endforeach
        </select>

        <select wire:model="selectedSeason"
            class="rounded-2xl px-4 py-2 bg-gray-900 border border-gray-700 focus:ring-2 focus:ring-blue-600 transition">
            <option value="">All Seasons</option>
            @foreach ($seasons as $season)
                <option value="{{ $season->id }}">{{ $season->name }}</option>
            @endforeach
        </select>

        <button wire:click="resetFilters"
            class="rounded-2xl px-4 py-2 bg-red-700 hover:bg-red-800 shadow transition transform hover:scale-105">
            Reset
        </button>
    </div>

    <!-- User Table -->
    <div class="overflow-x-auto rounded-2xl shadow-md border border-gray-700 bg-gray-800/80 backdrop-blur-sm">
        @if ($filteredCollectors->isEmpty())
            <div class="flex items-center justify-center p-4 text-red-400 text-sm font-medium gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v2m0 4h.01M12 3.75a8.25 8.25 0 100 16.5 8.25 8.25 0 000-16.5z" />
                </svg>
                No collectors found. Try adjusting your filters.
            </div>
        @else
            <table class="min-w-full bg-gray-950 text-sm text-green-100">
                <thead class="bg-green-950 text-green-200 uppercase text-xs font-semibold border-b border-green-800">
                    <tr>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">AI Range</th>
                        <th class="px-4 py-3 text-left">Season</th>
                        <th class="px-4 py-3 text-left">Phone</th>
                        <th class="px-4 py-3 text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach ($filteredCollectors as $collector)
                        <tr class="hover:bg-green-950 transition cursor-pointer">
                            <td class="px-4 py-2 font-medium">{{ $collector->user->name ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ $collector->getAiRange->name ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ $collector->riceSeason->name ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ $collector->phone_no ?? 'N/A' }}</td>
                            <td class="px-4 py-2 text-right">
                                <button wire:click="viewCollector({{ $collector->id }})"
                                    class="px-3 py-1.5 bg-green-600 hover:bg-green-700 rounded-2xl text-xs font-semibold shadow transition transform hover:scale-105">
                                    View
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3 px-4">{{ $filteredCollectors->links() }}</div>
        @endif
    </div>

    <!-- Dashboard Cards + Charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
        <x-dd.card title="🏆 Top Collectors"
            class="bg-gray-800/90 border border-gray-700 rounded-2xl shadow-md hover:shadow-lg">
            <ul class="space-y-2 text-sm">
                @forelse ($filteredCollectorsBy as $collector)
                    <li class="flex justify-between items-center">
                        <span>{{ $collector->user->name ?? 'Unnamed Collector' }} -
                            {{ $collector->getAiRange->name ?? 'N/A' }}</span>
                        <span
                            class="bg-orange-700 text-white px-3 py-1 rounded-2xl text-xs font-medium">{{ $collector->common_data_collect_count ?? 0 }}
                            entries</span>
                    </li>
                @empty
                    <li class="text-red-400">No data found.</li>
                @endforelse
            </ul>
        </x-dd.card>

        <x-dd.card title="📌 All Collector Locations"
            class="bg-gray-800/90 border border-gray-700 rounded-2xl shadow-md hover:shadow-lg">
            <livewire:map-view :collectors="$this->collectors" />
        </x-dd.card>

        <x-dd.card title="📝 Recent Activities"
            class="bg-gray-800/90 border border-gray-700 rounded-2xl shadow-md hover:shadow-lg">
            <ul class="space-y-2 text-sm text-gray-300">
                @forelse ($recentActivities as $activity)
                    <li>🕒 <strong class="text-white">{{ $activity->user->name ?? 'N/A' }}</strong>
                        {{ $activity->title }} – <span
                            class="text-gray-500">{{ $activity->created_at->diffForHumans() }}</span></li>
                @empty
                    <li>No recent activities found.</li>
                @endforelse
            </ul>
        </x-dd.card>

        <x-weekly-pest-risk-index-card />
    </div>

</div> --}}
