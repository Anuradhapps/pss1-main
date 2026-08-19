<x-app-layout>

    <div class="mx-auto gap-2">
        <!-- Header -->
        <x-headings.basic_heading title="All Details In Hierarchy" icon="fas fa-fw fa-sitemap" />

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div x-data="{
                search: '',
                matches(element) {
                    return !this.search.trim() || element.textContent.toLowerCase().includes(this.search.trim().toLowerCase());
                }
            }" class="p-4 text-slate-700 dark:text-slate-200 sm:p-6">

                <form method="GET" action="{{ route('all-details') }}"
                    class="mb-5 flex flex-col gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-700 dark:bg-slate-800/60 sm:mb-6 sm:flex-row sm:items-end sm:p-4">
                    <div class="w-full sm:max-w-md">
                        <label for="season_id" class="mb-1 block text-sm font-semibold text-slate-700 dark:text-slate-200">Select
                            season</label>
                        <select id="season_id" name="season_id" required
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-100">
                            <option value="">Choose a season</option>
                            @foreach ($seasons as $season)
                                <option value="{{ $season->id }}" @selected((string) $selectedSeason === (string) $season->id)>
                                    {{ $season->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit"
                        class="inline-flex min-h-11 items-center justify-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 sm:min-h-0">
                        <i class="fas fa-arrow-right" aria-hidden="true"></i>
                        Load details
                    </button>
                </form>

                <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <label for="hierarchy-search" class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                        Search hierarchy
                    </label>
                    <div class="relative w-full sm:w-96">
                        <input id="hierarchy-search" type="search" x-model="search" x-ref="search"
                            placeholder="Search season, location, collector, or pest..."
                            class="w-full rounded-lg border border-slate-300 bg-white py-2.5 pl-10 pr-10 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-100">
                        <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"></path>
                        </svg>
                        <button type="button" x-show="search" x-cloak @click="search = ''; $refs.search.focus()"
                            aria-label="Clear search"
                            class="absolute right-2 top-1/2 -translate-y-1/2 rounded p-1 text-slate-400 hover:text-slate-700 dark:hover:text-slate-200">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                @if (!$selectedSeason)
                    <div
                        class="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-sm text-slate-500 dark:border-slate-700 dark:bg-slate-800/50 dark:text-slate-400">
                        Select a season to load collector and pest details.
                    </div>
                @elseif (count($data) > 0)
                    <div class="space-y-2">
                        <!-- 1. SEASON -->
                        @foreach ($data as $seasonGroup)
                            <div x-data="{ open: false }" x-show="matches($el)" x-cloak
                                class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
                                <button @click="open = !open"
                                    class="flex w-full items-center justify-between bg-slate-50 px-4 py-3 text-left transition-colors duration-150 hover:bg-emerald-50 dark:bg-slate-800/80 dark:hover:bg-slate-800 sm:px-5">
                                    <span class="font-semibold text-base text-slate-800 dark:text-slate-100 sm:text-lg">
                                        <span class="mr-2 text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Season</span>
                                        <span class="text-emerald-700 dark:text-emerald-400">{{ $seasonGroup['season'] ?? 'N/A' }}</span>
                                    </span>
                                    <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200"
                                        :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <div x-show="open || search.trim()" x-collapse
                                    class="border-t border-slate-200 bg-white px-2 py-2 dark:border-slate-700 dark:bg-slate-900 sm:px-4">
                                    <!-- 2. REGION -->
                                    @foreach ($seasonGroup['regions'] as $regionGroup)
                                        <div x-data="{ open: false }" x-show="matches($el)"
                                            class="mt-2 ml-2 border-l-2 border-emerald-200 pl-3 dark:border-emerald-900/70 sm:ml-4 sm:pl-4">
                                            <button @click="open = !open"
                                                class="flex min-h-10 items-center text-left text-sm font-semibold text-slate-700 transition hover:text-emerald-600 dark:text-slate-300 dark:hover:text-emerald-400 sm:text-base">
                                                <svg class="w-4 h-4 mr-1 transform transition-transform duration-200"
                                                    :class="{ 'rotate-90': open }" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                                Region: {{ $regionGroup['region'] ?? 'N/A' }}
                                            </button>

                                            <div x-show="open || search.trim()" x-collapse class="mt-1">
                                                <!-- 3. PROVINCE -->
                                                @foreach ($regionGroup['provinces'] as $provinceGroup)
                                                    <div x-data="{ open: false }" x-show="matches($el)"
                                                        class="ml-2 border-l border-slate-300 pl-3 dark:border-slate-700 sm:ml-6 sm:pl-4">
                                                        <button @click="open = !open"
                                                                class="flex min-h-10 items-center text-left text-sm font-medium text-slate-600 transition hover:text-emerald-600 dark:text-slate-400 dark:hover:text-emerald-400">
                                                            <svg class="w-4 h-4 mr-1 transform transition-transform duration-200"
                                                                :class="{ 'rotate-90': open }" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                            </svg>
                                                            Province: {{ $provinceGroup['province'] ?? 'N/A' }}
                                                        </button>

                                                        <div x-show="open || search.trim()" x-collapse class="mt-1">
                                                            <!-- 4. DISTRICT -->
                                                            @foreach ($provinceGroup['districts'] as $districtGroup)
                                                                <div x-data="{ open: false }" x-show="matches($el)"
                                                                    class="ml-2 border-l border-slate-200 pl-3 dark:border-slate-800 sm:ml-6 sm:pl-4">
                                                                    <button @click="open = !open"
                                                                            class="flex min-h-10 items-center text-left text-sm text-slate-600 transition hover:text-emerald-600 dark:text-slate-400 dark:hover:text-emerald-400">
                                                                        <svg class="w-3 h-3 mr-1 transform transition-transform duration-200"
                                                                            :class="{ 'rotate-90': open }"
                                                                            fill="none" stroke="currentColor"
                                                                            viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                stroke-width="2" d="M9 5l7 7-7 7">
                                                                            </path>
                                                                        </svg>
                                                                        District:
                                                                        {{ $districtGroup['district'] ?? 'N/A' }}
                                                                    </button>

                                                                    <div x-show="open || search.trim()" x-collapse
                                                                        class="mt-1">
                                                                        <!-- 5. ASC -->
                                                                        @foreach ($districtGroup['asc'] as $ascGroup)
                                                                            <div x-data="{ open: false }"
                                                                                x-show="matches($el)"
                                                                                class="ml-2 border-l border-slate-200 pl-3 dark:border-slate-800 sm:ml-6 sm:pl-4">
                                                                                <button @click="open = !open"
                                                                                    class="flex min-h-10 items-center text-left text-sm text-slate-600 transition hover:text-emerald-600 dark:text-slate-400 dark:hover:text-emerald-400">
                                                                                    <svg class="w-3 h-3 mr-1 transform transition-transform duration-200"
                                                                                        :class="{ 'rotate-90': open }"
                                                                                        fill="none"
                                                                                        stroke="currentColor"
                                                                                        viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round"
                                                                                            stroke-linejoin="round"
                                                                                            stroke-width="2"
                                                                                            d="M9 5l7 7-7 7"></path>
                                                                                    </svg>
                                                                                    ASC:
                                                                                    {{ $ascGroup['asc'] ?? 'N/A' }}
                                                                                </button>

                                                                                <div x-show="open || search.trim()"
                                                                                    x-collapse class="mt-1">
                                                                                    <!-- 6. AI RANGE -->
                                                                                    @foreach ($ascGroup['ai_ranges'] as $aiRangeGroup)
                                                                                        <div x-data="{ open: false }"
                                                                                            x-show="matches($el)"
                                                                                            class="ml-2 border-l border-slate-200 pl-3 dark:border-slate-800 sm:ml-6 sm:pl-4">
                                                                                            <button
                                                                                                @click="open = !open"
                                                                                                class="flex min-h-10 items-center text-left text-sm text-slate-600 transition hover:text-emerald-600 dark:text-slate-400 dark:hover:text-emerald-400">
                                                                                                <svg class="w-3 h-3 mr-1 transform transition-transform duration-200"
                                                                                                    :class="{ 'rotate-90': open }"
                                                                                                    fill="none"
                                                                                                    stroke="currentColor"
                                                                                                    viewBox="0 0 24 24">
                                                                                                    <path
                                                                                                        stroke-linecap="round"
                                                                                                        stroke-linejoin="round"
                                                                                                        stroke-width="2"
                                                                                                        d="M9 5l7 7-7 7">
                                                                                                    </path>
                                                                                                </svg>
                                                                                                AI Range:
                                                                                                {{ $aiRangeGroup['ai_range'] ?? 'N/A' }}
                                                                                            </button>

                                                                                            <div x-show="open || search.trim()"
                                                                                                x-collapse
                                                                                                class="mt-2 space-y-3 sm:ml-4">
                                                                                                <!-- 7. COLLECTORS & DATA -->
                                                                                                @foreach ($aiRangeGroup['collectors'] as $collector)
                                                                                                    <div x-show="matches($el)"
                                                                                                        class="rounded-xl border border-slate-200 bg-slate-50 p-3 shadow-sm dark:border-slate-700 dark:bg-slate-800/60 sm:p-4">
                                                                                                        <div
                                                                                                                class="mb-3 flex items-start justify-between gap-3 border-b border-slate-200 pb-3 dark:border-slate-700">
                                                                                                            <h4
                                                                                                                    class="font-semibold text-slate-800 dark:text-slate-100">
                                                                                                                Collector:
                                                                                                                {{ $collector->user?->name ?? 'Unknown' }}
                                                                                                            </h4>
                                                                                                            <p
                                                                                                                class="shrink-0 text-xs text-slate-500 dark:text-slate-400">
                                                                                                                ID:
                                                                                                                {{ $collector->id }}
                                                                                                            </p>
                                                                                                        </div>

                                                                                                        <!-- 8. COMMON DATA -->
                                                                                                        @if ($collector->commonDataCollect && $collector->commonDataCollect->count() > 0)
                                                                                                            <div
                                                                                                                class="space-y-4">
                                                                                                                <div
                                                                                                                    class="grid grid-cols-1 gap-2 border-b border-slate-200 pb-3 text-xs text-slate-600 dark:border-slate-700 dark:text-slate-300 sm:grid-cols-2">
                                                                                                                    <span class="break-words"><strong class="font-medium text-slate-500 dark:text-slate-400">Email:</strong>
                                                                                                                        {{ $collector->user?->email ?? 'N/A' }}</span>
                                                                                                                    <span><strong class="font-medium text-slate-500 dark:text-slate-400">Phone:</strong>
                                                                                                                        {{ $collector->phone_no ?? 'N/A' }}</span>
                                                                                                                    <span><strong class="font-medium text-slate-500 dark:text-slate-400">Village:</strong>
                                                                                                                        {{ $collector->village ?? 'N/A' }}</span>
                                                                                                                    <span><strong class="font-medium text-slate-500 dark:text-slate-400">Rice variety:</strong>
                                                                                                                        {{ $collector->rice_variety ?? 'N/A' }}</span>
                                                                                                                    <span><strong class="font-medium text-slate-500 dark:text-slate-400">Established:</strong>
                                                                                                                        {{ $collector->date_establish ?? 'N/A' }}</span>
                                                                                                                    <span><strong class="font-medium text-slate-500 dark:text-slate-400">Method:</strong>
                                                                                                                        {{ $collector->established_method ?? 'N/A' }}</span>
                                                                                                                    <span class="break-words"><strong class="font-medium text-slate-500 dark:text-slate-400">GPS:</strong>
                                                                                                                        {{ $collector->gps_lati ?? 'N/A' }},
                                                                                                                        {{ $collector->gps_long ?? 'N/A' }}</span>
                                                                                                                </div>
                                                                                                                @foreach ($collector->commonDataCollect as $commonData)
                                                                                                                    <div
                                                                                                                        class="rounded-lg border border-slate-200 bg-white p-3 dark:border-slate-700 dark:bg-slate-900">
                                                                                                                        <h5
                                                                                                                            class="mb-2 text-sm font-semibold text-slate-800 dark:text-slate-100">
                                                                                                                            Common
                                                                                                                            Data
                                                                                                                            (ID:
                                                                                                                            {{ $commonData->id }})
                                                                                                                        </h5>
                                                                                                                        <div
                                                                                                                            class="mb-3 grid grid-cols-1 gap-2 text-xs text-slate-600 dark:text-slate-300 min-[420px]:grid-cols-2">
                                                                                                                            <!-- Output actual common data fields here -->
                                                                                                                            <span><strong class="font-medium text-slate-500 dark:text-slate-400">Date:</strong>
                                                                                                                                {{ $commonData->c_date ? \Carbon\Carbon::parse($commonData->c_date)->format('Y-m-d') : 'N/A' }}</span>
                                                                                                                            <span><strong class="font-medium text-slate-500 dark:text-slate-400">Temperature:</strong>
                                                                                                                                {{ $commonData->temperature ?? 'N/A' }}</span>
                                                                                                                            <span><strong class="font-medium text-slate-500 dark:text-slate-400">Rainy days:</strong>
                                                                                                                                {{ $commonData->numbrer_r_day ?? 'N/A' }}</span>
                                                                                                                            <span><strong class="font-medium text-slate-500 dark:text-slate-400">Growth stage:</strong>
                                                                                                                                {{ $commonData->growth_s_c ?? 'N/A' }}</span>
                                                                                                                            <span class="break-words min-[420px]:col-span-2"><strong class="font-medium text-slate-500 dark:text-slate-400">Other info:</strong>
                                                                                                                                {{ $commonData->otherinfo ?? 'N/A' }}</span>
                                                                                                                        </div>

                                                                                                                        <!-- 9. PEST DATA -->
                                                                                                                        @if ($commonData->pestDataCollect && $commonData->pestDataCollect->count() > 0)
                                                                                                                            <div
                                                                                                                                class="mt-2 rounded-lg border border-emerald-200 bg-emerald-50/70 p-3 dark:border-emerald-900/70 dark:bg-emerald-950/30">
                                                                                                                                <h6
                                                                                                                                    class="mb-2 text-xs font-semibold uppercase tracking-wide text-emerald-700 dark:text-emerald-400">
                                                                                                                                    Pest
                                                                                                                                    Data
                                                                                                                                    Records:
                                                                                                                                </h6>
                                                                                                                                <ul
                                                                                                                                    class="space-y-3 text-xs text-slate-700 dark:text-slate-300">
                                                                                                                                    @foreach ($commonData->pestDataCollect as $pestData)
                                                                                                                                            <li class="border-b border-emerald-200/70 pb-3 last:border-0 last:pb-0 dark:border-emerald-900/60">
                                                                                                                                                <div class="flex flex-wrap items-center gap-x-2 gap-y-1">
                                                                                                                                                <span
                                                                                                                                                    class="font-semibold text-slate-800 dark:text-slate-100">{{ $pestData->pest_name ?? 'N/A' }}</span>
                                                                                                                                                <span
                                                                                                                                                    class="text-slate-500 dark:text-slate-400">Code:
                                                                                                                                                    {{ $pestData->code ?? 'N/A' }}</span>
                                                                                                                                            </div>
                                                                                                                                            <div
                                                                                                                                                class="grid grid-cols-2 gap-x-3 gap-y-1 pl-0 text-[11px] min-[420px]:grid-cols-3">
                                                                                                                                                <span><strong class="font-medium text-slate-500 dark:text-slate-400">Total:</strong>
                                                                                                                                                    {{ $pestData->total ?? 'N/A' }}</span>
                                                                                                                                                <span><strong class="font-medium text-slate-500 dark:text-slate-400">Mean:</strong>
                                                                                                                                                    {{ $pestData->mean ?? 'N/A' }}</span>
                                                                                                                                                @foreach (range(1, 10) as $location)
                                                                                                                                                    <span><strong class="font-medium text-slate-500 dark:text-slate-400">L{{ $location }}:</strong>
                                                                                                                                                        {{ $pestData->{'location_' . $location} ?? 'N/A' }}</span>
                                                                                                                                                @endforeach
                                                                                                                                            </div>
                                                                                                                                        </li>
                                                                                                                                    @endforeach
                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        @else
                                                                                                                            <p
                                                                                                                                class="mt-1 text-xs italic text-slate-500 dark:text-slate-400">
                                                                                                                                No
                                                                                                                                Pest
                                                                                                                                Data
                                                                                                                                recorded.
                                                                                                                            </p>
                                                                                                                        @endif
                                                                                                                    </div>
                                                                                                                @endforeach
                                                                                                            </div>
                                                                                                        @else
                                                                                                            <p
                                                                                                                class="text-sm italic text-slate-500 dark:text-slate-400">
                                                                                                                No
                                                                                                                Common
                                                                                                                Data
                                                                                                                collected
                                                                                                                yet.
                                                                                                            </p>
                                                                                                        @endif
                                                                                                    </div>
                                                                                                @endforeach
                                                                                            </div>
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-6 text-center text-sm text-slate-500 dark:border-slate-700 dark:bg-slate-800/50 dark:text-slate-400">
                        No hierarchical data available to display.
                    </div>
                @endif

            </div>
        </div>
    </div>

</x-app-layout>
