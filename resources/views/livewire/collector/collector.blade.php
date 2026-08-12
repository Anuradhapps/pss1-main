@section('title', 'Collector Management')

<div x-data="{ deleteModalOpen: false, collectorToDelete: null, collectorName: '' }" class="space-y-2">
    <!-- Header -->
    <x-headings.basic_heading title="Collector Management" icon="fas fa-users" />
    <!-- Filter Toolbar -->
    <div x-data="{ showFilters: {{ request('openFilter') ? 'true' : 'false' }} }" class="mb-6">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
            <button @click="showFilters = !showFilters"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm hover:bg-slate-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all w-full sm:w-auto group">
                <div
                    class="w-6 h-6 rounded border border-slate-100 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 flex items-center justify-center text-slate-500 dark:text-slate-400 group-hover:text-primary transition-colors">
                    <i class="fas fa-filter text-xs" :class="{ 'text-primary': showFilters }"></i>
                </div>
                <span x-text="showFilters ? 'Hide Filters' : 'Filter Collectors'"></span>
                <i class="fas fa-chevron-down text-xs text-slate-400 ml-1 transition-transform duration-300"
                    :class="{ 'rotate-180': showFilters }"></i>
            </button>
        </div>

        <!-- Expandable Filter Panel -->
        <div x-show="showFilters" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="mt-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm overflow-hidden"
            style="display: none;">

            <div class="p-5 flex flex-col gap-5">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <!-- Global Search Filter -->
                    <div class="flex flex-col">
                        <label
                            class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Global
                            Search</label>
                        <div class="relative">
                            <i
                                class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="search" wire:model.live.debounce.300ms="query"
                                placeholder="Search by name, district or AI range..."
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-900 dark:text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                        </div>
                    </div>

                    <!-- Name Search Filter -->
                    <div class="flex flex-col">
                        <label
                            class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Specific
                            Name Search</label>
                        <div class="relative">
                            <i
                                class="fas fa-user absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="text" wire:model.live.debounce.300ms="nameSearch"
                                placeholder="Filter precisely by name..."
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-900 dark:text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                        </div>
                    </div>

                    <!-- District Multi-Select -->
                    <div class="flex flex-col">
                        <label
                            class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Filter
                            by Districts</label>
                        <select wire:model.live="selectedDistricts" multiple
                            class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-900 dark:text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors custom-scrollbar"
                            style="min-height: 100px;">
                            @if (isset($allDistricts))
                                @foreach ($allDistricts as $district)
                                    <option value="{{ $district->id }}"
                                        class="py-1 px-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded">
                                        {{ $district->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="text-[10px] text-slate-400 mt-1"><i class="fas fa-info-circle mr-1"></i>Hold
                            Ctrl/Cmd to select multiple</span>
                    </div>
                </div>

                <!-- Actions -->
                <div
                    class="flex flex-col sm:flex-row gap-3 justify-end items-center pt-5 mt-2 border-t border-slate-100 dark:border-slate-700/50">
                    <button type="button"
                        wire:click="$set('query', ''); $set('nameSearch', ''); $set('selectedDistricts', []);"
                        @click="showFilters = false"
                        class="w-full sm:w-auto inline-flex justify-center items-center gap-2 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white py-2 px-4 rounded-lg transition-colors focus:outline-none">
                        <i class="fas fa-undo opacity-70 text-xs"></i> Clear Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    @if ($this->collectors()->isEmpty())
        <x-data.empty-state icon="fas fa-users-slash" title="No Collectors Found"
            description="We couldn't find any collectors matching your search criteria." />
    @else
        <x-data.table>
            <x-slot name="header">
                <th scope="col"
                    class="px-6 py-4 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors"
                    wire:click.prevent="sortBy('name')">
                    <div class="flex items-center gap-2">
                        <span>Collector Details</span>
                        <i class="fas fa-sort text-slate-400 text-[10px]"></i>
                    </div>
                </th>
                <th scope="col"
                    class="px-6 py-4 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors hidden md:table-cell"
                    wire:click.prevent="sortBy('districts.name')">
                    <div class="flex items-center gap-2">
                        <span>District & ASC</span>
                        <i class="fas fa-sort text-slate-400 text-[10px]"></i>
                    </div>
                </th>
                <th scope="col"
                    class="px-6 py-4 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors hidden lg:table-cell"
                    wire:click.prevent="sortBy('ai_ranges.name')">
                    <div class="flex items-center gap-2">
                        <span>AI Range</span>
                        <i class="fas fa-sort text-slate-400 text-[10px]"></i>
                    </div>
                </th>
                <th scope="col" class="px-6 py-4 text-center">Actions</th>
            </x-slot>

            @foreach ($this->collectors() as $collector)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 flex shrink-0 items-center justify-center rounded-2xl font-black bg-gradient-to-br from-emerald-100 to-emerald-200 text-emerald-800 dark:from-emerald-900/50 dark:to-emerald-800/50 dark:text-emerald-400 ring-1 ring-emerald-300 dark:ring-emerald-700 shadow-sm">
                                {{ strtoupper(substr($collector->name, 0, 2)) }}
                            </div>

                            <div class="flex flex-col">
                                <h3
                                    class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors">
                                    {{ $collector->name }}</h3>
                                <div class="text-[13px] text-slate-500 dark:text-slate-400 mt-0.5">
                                    {{ $collector->regionName }} &bull; {{ $collector->riceSeasonName }}
                                </div>

                                <!-- Mobile extra details -->
                                <div
                                    class="md:hidden flex flex-col gap-1 mt-2 text-[11px] text-slate-500 dark:text-slate-400">
                                    <span class="flex items-center gap-1.5"><i
                                            class="fas fa-map-marker-alt text-slate-400"></i> {{ $collector->dname }}
                                        &bull; {{ $collector->asname }}</span>
                                    <span class="flex items-center gap-1.5"><i
                                            class="fas fa-draw-polygon text-slate-400"></i>
                                        {{ $collector->ainame }}</span>
                                </div>
                            </div>

                            @php $count = $collector->common_data_collect_count ?? $collector->commonDataCollect->count(); @endphp
                            <div class="ml-auto flex shrink-0">
                                <x-ui.badge
                                    variant="{{ $count == 0 ? 'danger' : ($count >= 7 ? 'success' : 'warning') }}"
                                    class="text-[10px] px-2 py-0.5 shadow-sm">
                                    {{ $count }} Records
                                </x-ui.badge>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 hidden md:table-cell">
                        <div class="text-sm font-semibold text-slate-900 dark:text-slate-200">{{ $collector->dname }}
                        </div>
                        <div class="text-[13px] text-slate-500 dark:text-slate-400 mt-0.5">{{ $collector->asname }}
                        </div>
                    </td>

                    <td class="px-6 py-4 hidden lg:table-cell text-sm font-medium text-slate-600 dark:text-slate-300">
                        {{ $collector->ainame }}
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.collector.edit', $collector->id) }}"
                                class="flex items-center justify-center w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-500 hover:text-white hover:bg-primary dark:hover:bg-primary transition-all border border-slate-200 dark:border-slate-700 hover:border-primary shadow-sm"
                                title="Edit Collector">
                                <i class="fas fa-edit text-[13px]"></i>
                            </a>

                            <a href="{{ route('admin.users.edit', ['user' => $collector->user->id]) }}"
                                class="flex items-center justify-center w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-500 hover:text-white hover:bg-secondary dark:hover:bg-secondary transition-all border border-slate-200 dark:border-slate-700 hover:border-secondary shadow-sm"
                                title="Edit User Account">
                                <i class="fas fa-user-cog text-[13px]"></i>
                            </a>

                            @php $hasCommonData = ($collector->common_data_collect_count ?? $collector->commonDataCollect->count()) > 0; @endphp
                            @if ($hasCommonData)
                                <a href="{{ route('chart.ai.show', [$collector->id, 'yes']) }}"
                                    class="flex items-center justify-center w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-500 hover:text-white hover:bg-info dark:hover:bg-info transition-all border border-slate-200 dark:border-slate-700 hover:border-info shadow-sm"
                                    title="View Pest Data">
                                    <i class="fas fa-chart-line text-[13px]"></i>
                                </a>
                            @else
                                <span
                                    class="flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800/50 text-slate-300 dark:text-slate-600 border border-slate-200 dark:border-slate-700 cursor-not-allowed"
                                    title="No Data Available">
                                    <i class="fas fa-chart-line text-[13px]"></i>
                                </span>
                            @endif

                            <button type="button"
                                @click="deleteModalOpen = true; collectorToDelete = '{{ $collector->id }}'; collectorName = '{{ addslashes($collector->name) }}'"
                                class="flex items-center justify-center w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-500 hover:text-white hover:bg-rose-600 dark:hover:bg-rose-500 transition-all border border-slate-200 dark:border-slate-700 hover:border-rose-600 shadow-sm"
                                title="Delete Collector">
                                <i class="fas fa-trash-alt text-[13px]"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach

            <x-slot name="footer">
                <div class="w-full">
                    {{ $this->collectors()->links() }}
                </div>
            </x-slot>
        </x-data.table>
    @endif

    <!-- AlpineJS Delete Confirmation Modal -->
    <div x-show="deleteModalOpen" class="relative z-50" aria-labelledby="modal-title" role="dialog"
        aria-modal="true" x-cloak>
        <div x-show="deleteModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="deleteModalOpen" @click.away="deleteModalOpen = false"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-slate-900 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200 dark:border-slate-800">
                    <div class="bg-white dark:bg-slate-900 px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-rose-100 dark:bg-rose-900/30 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-exclamation-triangle text-rose-600 dark:text-rose-500"></i>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-lg font-bold leading-6 text-slate-900 dark:text-white"
                                    id="modal-title">Delete Collector</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-slate-500 dark:text-slate-400">
                                        Are you sure you want to permanently delete collector <strong
                                            x-text="collectorName" class="text-slate-900 dark:text-white"></strong>?
                                        All of their data will be permanently removed. This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-slate-50 dark:bg-slate-800/50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-200 dark:border-slate-700">
                        <form x-bind:action="`/admin/collector/${collectorToDelete}/destroy`" method="POST"
                            class="inline-block m-0 p-0 w-full sm:w-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex w-full justify-center rounded-xl bg-rose-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-rose-500 sm:ml-3 sm:w-auto transition-colors">Yes,
                                Delete</button>
                        </form>
                        <button type="button" @click="deleteModalOpen = false"
                            class="mt-3 inline-flex w-full justify-center rounded-xl bg-white dark:bg-slate-800 px-3 py-2 text-sm font-semibold text-slate-900 dark:text-slate-300 shadow-sm ring-1 ring-inset ring-slate-300 dark:ring-slate-600 hover:bg-slate-50 dark:hover:bg-slate-700 sm:mt-0 sm:w-auto transition-colors">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <x-ui.card padding="p-0"
        class="mt-8 border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden rounded-2xl">
        <div class="p-5 border-b border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                    <i class="fas fa-map-marked-alt text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Geographic Distribution</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Map view of all collector assigned
                        regions.</p>
                </div>
            </div>
        </div>
        <div class="w-full relative z-0">
            <livewire:map-view :collectors="\App\Models\Collector::with(['user', 'getAiRange'])->get()" height="600px" width="100%" />
        </div>
    </x-ui.card>
</div>
