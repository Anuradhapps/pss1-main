@section('title', 'Collector Management')

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-primary/10 dark:bg-primary/20 flex items-center justify-center text-primary dark:text-primary-light">
                <i class="fa-solid fa-chalkboard-user text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Collectors</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Manage field officers and their data collection regions.</p>
            </div>
        </div>
        
        <!-- Search -->
        <div class="w-full sm:w-80 relative">
            <x-forms.input type="search" wire:model.live.debounce.300ms="query" placeholder="Search by name, district or AI range..." icon="fas fa-search" />
            <div wire:loading wire:target="query" class="absolute right-3 top-2.5">
                <i class="fas fa-circle-notch fa-spin text-primary"></i>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    @if($this->collectors()->isEmpty())
        <x-data.empty-state 
            icon="fas fa-users-slash" 
            title="No Collectors Found" 
            description="We couldn't find any collectors matching your search criteria." 
        />
    @else
        <x-data.table>
            <x-slot name="header">
                <th scope="col" class="px-6 py-4 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors" wire:click.prevent="sortBy('name')">
                    <div class="flex items-center justify-between">
                        <span>Collector Details</span>
                        <i class="fas fa-sort text-slate-400"></i>
                    </div>
                </th>
                <th scope="col" class="px-6 py-4 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors hidden md:table-cell" wire:click.prevent="sortBy('districts.name')">
                    <div class="flex items-center justify-between">
                        <span>District & ASC</span>
                        <i class="fas fa-sort text-slate-400"></i>
                    </div>
                </th>
                <th scope="col" class="px-6 py-4 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors hidden lg:table-cell" wire:click.prevent="sortBy('ai_ranges.name')">
                    <div class="flex items-center justify-between">
                        <span>AI Range</span>
                        <i class="fas fa-sort text-slate-400"></i>
                    </div>
                </th>
                <th scope="col" class="px-6 py-4 text-center">Actions</th>
            </x-slot>

            @foreach ($this->collectors() as $collector)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-semibold text-slate-900 dark:text-white">{{ $collector->name }}</div>
                                <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                    {{ $collector->regionName }} &bull; {{ $collector->riceSeasonName }}
                                </div>
                            </div>
                            
                            @php $count = $collector->commonDataCollect->count(); @endphp
                            <x-ui.badge variant="{{ $count == 0 ? 'danger' : ($count >= 7 ? 'success' : 'warning') }}" class="ml-3">
                                {{ $count }} Records
                            </x-ui.badge>
                        </div>
                        
                        <!-- Mobile extra details -->
                        <div class="mt-2 text-xs text-slate-500 dark:text-slate-400 md:hidden">
                            {{ $collector->dname }} &bull; {{ $collector->asname }}
                        </div>
                    </td>

                    <td class="px-6 py-4 hidden md:table-cell">
                        <div class="text-slate-900 dark:text-slate-200 font-medium">{{ $collector->dname }}</div>
                        <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $collector->asname }}</div>
                    </td>
                    
                    <td class="px-6 py-4 hidden lg:table-cell text-slate-600 dark:text-slate-300">
                        {{ $collector->ainame }}
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('admin.collector.edit', $collector->id) }}" class="text-slate-400 hover:text-primary transition-colors" title="Edit Collector">
                                <i class="fas fa-edit text-lg"></i>
                            </a>

                            <a href="{{ route('admin.users.edit', ['user' => $collector->user->id]) }}" class="text-slate-400 hover:text-secondary transition-colors" title="Edit User Account">
                                <i class="fas fa-user-cog text-lg"></i>
                            </a>

                            @php $hasCommonData = $collector->commonDataCollect->count() > 0; @endphp
                            @if($hasCommonData)
                                <a href="{{ route('chart.ai.show', [$collector->id, 'yes']) }}" class="text-slate-400 hover:text-info transition-colors" title="View Pest Data">
                                    <i class="fas fa-chart-line text-lg"></i>
                                </a>
                            @else
                                <span class="text-slate-300 dark:text-slate-700 cursor-not-allowed" title="No Data Available">
                                    <i class="fas fa-chart-line text-lg"></i>
                                </span>
                            @endif

                            <form action="{{ route('admin.collector.destroy', $collector->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" wire:confirm="Are you sure you want to permanently delete this collector?" class="text-slate-400 hover:text-danger transition-colors" title="Delete Collector">
                                    <i class="fas fa-trash-alt text-lg"></i>
                                </button>
                            </form>
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

    <!-- Map Section -->
    @php
        $Collectors = \App\Models\Collector::with(['user', 'getAiRange'])->get();
    @endphp
    
    <x-ui.card padding="p-0" class="mt-8">
        <div class="p-5 border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
            <div class="flex items-center gap-3">
                <i class="fas fa-map-marked-alt text-primary text-xl"></i>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Collectors Geographic Distribution</h3>
            </div>
        </div>
        <div class="w-full relative z-0">
            <livewire:map-view :collectors="$Collectors" height="600px" width="100%" />
        </div>
    </x-ui.card>
</div>
