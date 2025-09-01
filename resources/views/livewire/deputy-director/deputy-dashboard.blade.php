@section('title', 'DD-Dashboard')

<div>
    <x-headings.topHeading title="{{ $district->name }} District Dashboard" icon="fas fa-clipboard"
        class="bg-gradient-to-r from-green-900 to-green-900 shadow-md" />


    <div class="mt-3 space-y-3">

        <div class="m-2 p-2 bg-gray-800/90 rounded-md shadow-lg backdrop-blur-sm border border-gray-700">
            <!-- Header -->
            <div class="flex items-center mb-4">
                <div
                    class="flex items-center justify-center w-10 h-10 rounded-full bg-yellow-500/20 text-yellow-400 mr-3">
                    <i class="fas fa-bug text-lg"></i>
                </div>
                <h2 class="text-lg font-semibold text-gray-100">
                    Pest Density in {{ $district->name }} for This Week
                </h2>
            </div>

            <!-- Nested Livewire Component -->
            <livewire:pest-memo-card :districtId="$district->id" :days="7" :key="'pest-' . $district->id" />
        </div>
    </div>



    <div class="p-2 space-y-2 bg-gray-900 text-white min-h-screen text-sm">

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
            <x-dd.stat-box color="green" title="Total Users Count" :value="$totalUsersCount" />
            <x-dd.stat-box color="yellow" title="This Season Users" :value="$seasonUserCount" />
        </div>

        <!-- Filter + User Table -->
        <div class="bg-gray-800 p-2 shadow-md">
            <div class="flex flex-col  justify-between items-center gap-2">
                <h2 class="text-xl font-semibold text-white m-0 p-0 w-full"><i
                        class="fa-solid fa-users text-green-500 me-2"></i>Users
                    in
                    {{ $district->name }} District</h2>

                <div class="flex flex-wrap sm:justify-end gap-3 w-full sm:w-auto">
                    <input type="text" wire:model.debounce.500ms="search" placeholder="Search by name"
                        class="w-full sm:w-[25ch] px-4 py-2 bg-gray-700 border border-gray-600  text-white placeholder-gray-400" />
                    <input type="number" wire:model.debounce.500ms="searchNumber" placeholder="Search by Phone Number"
                        class="w-full sm:w-[31ch] px-4 py-2 bg-gray-700 border border-gray-600  text-white placeholder-gray-400" />

                    <select wire:model="selectedAiRange"
                        class="w-full sm:w-fit px-4 py-2 bg-gray-700 border border-gray-600  text-white">
                        <option value="">All AI Ranges</option>
                        @foreach ($aiRanges as $ai)
                            <option value="{{ $ai->id }}">{{ $ai->name }}</option>
                        @endforeach
                    </select>

                    <select wire:model="selectedSeason"
                        class="w-full sm:w-fit px-4 py-2 bg-gray-700 border border-gray-600  text-white">
                        <option value="">All Seasons</option>
                        @foreach ($seasons as $season)
                            <option value="{{ $season->id }}">{{ $season->name }}</option>
                        @endforeach
                    </select>
                    <!-- Reset button -->
                    <button wire:click="resetFilters"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white ">Reset</button>
                </div>


            </div>


            <!-- Table for desktop (sm and up) -->

            <div class="hidden sm:block overflow-x-auto mt-2">
                <table class="min-w-full  text-sm">
                    <thead class="bg-gray-900 text-gray-200 uppercase text-xs font-semibold tracking-wider">
                        <tr>
                            <th scope="col" class="px-2 py-2 text-left bg-gray-900">Name</th>
                            <th scope="col" class="px-2 py-2 text-left bg-gray-900">AI Range</th>
                            <th scope="col" class="px-2 py-2 text-left bg-gray-900">Season</th>
                            <th scope="col" class="px-2 py-2 text-left bg-gray-900">Phone Number</th>
                            <th scope="col" class="px-2 py-2 text-left bg-gray-900">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($filteredCollectors as $collector)
                            <tr class="hover:bg-teal-800 transition-colors duration-150 bg-cyan-900">

                                <td class="px-2 py-1 whitespace-nowrap ">
                                    {{ $collector->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-2  py-1 whitespace-nowrap ">
                                    {{ $collector->getAiRange->name ?? 'N/A' }}
                                </td>
                                <td class="px-2  py-1 whitespace-nowrap ">
                                    {{ $collector->riceSeason->name ?? 'N/A' }}
                                </td>
                                <td class="px-2  py-1 whitespace-nowrap ">
                                    {{ $collector->phone_no ?? 'N/A' }}
                                </td>
                                <td class="px-2  py-1 whitespace-nowrap ">
                                    <!-- View Button -->
                                    <button wire:click="viewCollector({{ $collector->id }})"
                                        class="flex items-center gap-2 px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold  transition duration-200 ease-in-out transform hover:scale-105">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
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
                        class="text-center text-red-400 italic py-4  duration-700 ease-in-out transform transition-transform flex items-center justify-center gap-2"
                        role="alert" aria-live="polite">
                        <!-- Icon: Exclamation Circle -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0 text-red-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v2m0 4h.01M12 3.75a8.25 8.25 0 100 16.5 8.25 8.25 0 000-16.5z" />
                        </svg>
                        <span>No collectors found.</span>
                    </div>
                @endif


                <div class="mt-2">
                    {{ $filteredCollectors->links() }}
                </div>
            </div>


            @include('livewire.deputy-director.collectorModel')


            <!-- Cards for mobile (below sm) -->
            <div class="sm:hidden space-y-4 mt-4">
                @foreach ($filteredCollectors as $collector)
                    <div
                        class="bg-gradient-to-r from-teal-900 to-sky-900 shadow-lg  p-4 text-white flex flex-col justify-between h-full min-h-[180px] transform transition duration-300  hover:shadow-2xl cursor-pointer">

                        <!-- Card content -->
                        <div>
                            <h3 class="font-bold text-xl mb-0 truncate text-white">{{ $collector->user->name }}
                            </h3>
                            <p class="text-sky-200 mb-1">
                                <span class="font-semibold">AI Range :</span>
                                {{ $collector->getAiRange->name ?? 'N/A' }}
                            </p>
                            <p class="text-sky-200 mb-1">
                                <span class="font-semibold">Season :</span>
                                {{ $collector->riceSeason->name ?? 'N/A' }}
                            </p>
                            <p class="text-sky-200">
                                <span class="font-semibold">Phone :</span> {{ $collector->phone_no ?? 'N/A' }}
                            </p>
                        </div>

                        <!--  view Button -->
                        <div class="flex justify-end mt-0">
                            <button wire:click="viewCollector({{ $collector->id }})"
                                class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded shadow-md transition duration-200 ease-in-out transform hover:scale-105">
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


                    </div>
                @endforeach

                <div>
                    {{ $filteredCollectors->links() }}
                </div>
            </div>


        </div>

        <!-- Charts and Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <x-dd.card title="🏆 Top Collectors" class="bg-gray-800 text-white border border-gray-700">
                <h2 class="text-lg font-semibold text-green-400 mb-4 flex items-center justify-between">
                    <div>
                        By Data Count > 0

                        <div class="text-sm text-gray-300 mt-1">
                            @if ($filteredCollectorsBy->isNotEmpty())
                                <span class="font-semibold text-white">
                                    {{ $filteredCollectorsBy->first()->riceSeason->name ?? 'N/A' }} |
                                    {{ $district->name ?? 'N/A' }}
                                </span>
                            @else
                                <span class="font-semibold text-white">No collectors available</span>
                            @endif
                        </div>
                    </div>
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

            <x-dd.card title="📌 All Collectors in {{ $district->name }}">
                <livewire:map-view :collectors="$this->collectors" />
            </x-dd.card>

            <x-dd.card title="📝 Recent Activities">
                <ul class="space-y-2 text-gray-300 text-sm">
                    @forelse ($recentActivities as $activity)
                        <li>🕒 <strong class="text-white">{{ $activity->user->name ?? 'N/A' }}</strong>
                            {{ $activity->title }} – <span
                                class="text-gray-500">{{ $activity->created_at->diffForHumans() }}</span></li>
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
