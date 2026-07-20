@if ($showModal && $selectedCollector)
<div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-slate-950/60 backdrop-blur-sm p-0 sm:p-4"
    wire:key="modal-{{ $selectedCollector->id }}">

    <!-- Modal Panel -->
    <div class="flex flex-col w-full sm:w-auto sm:max-w-2xl max-h-[85dvh] sm:max-h-[90dvh] rounded-t-2xl sm:rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-2xl overflow-hidden">

        {{-- Header --}}
        <div class="flex items-center justify-between px-4 sm:px-6 py-3 sm:py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-green-600 text-white shadow-md shadow-green-500/30 flex-shrink-0">
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

        {{-- Scrollable Body --}}
        <div class="flex-1 overflow-y-auto overscroll-contain px-4 sm:px-6 py-5 space-y-5">

            {{-- Profile Card --}}
            <div class="flex items-center gap-4 p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-100 dark:border-slate-800">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white text-xl font-bold shadow-lg shadow-green-500/30 flex-shrink-0">
                    {{ strtoupper(substr($selectedCollector->user->name ?? 'N', 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white truncate">{{ $selectedCollector->user->name ?? 'N/A' }}</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $selectedCollector->user->email ?? 'N/A' }}</p>
                </div>
            </div>

            {{-- Info Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div class="p-4 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-map-marker-alt text-blue-500 text-xs"></i>
                        <span class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">AI Range</span>
                    </div>
                    <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $selectedCollector->getAiRange->name ?? 'N/A' }}</p>
                </div>
                <div class="p-4 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-seedling text-green-500 text-xs"></i>
                        <span class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Season</span>
                    </div>
                    <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $selectedCollector->riceSeason->name ?? 'N/A' }}</p>
                </div>
                <div class="p-4 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-phone text-amber-500 text-xs"></i>
                        <span class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Phone</span>
                    </div>
                    <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $selectedCollector->phone_no ?? 'N/A' }}</p>
                </div>
                <div class="p-4 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-database text-purple-500 text-xs"></i>
                        <span class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Entries</span>
                    </div>
                    <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $selectedCollector->commonDataCollect->count() }}</p>
                </div>
            </div>

            {{-- Data Collection Timeline --}}
            <div>
                @if ($selectedCollector->commonDataCollect->isEmpty())
                <div class="flex items-center gap-3 p-4 bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800 rounded-xl">
                    <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-500/20 flex items-center justify-center text-amber-600 dark:text-amber-400 flex-shrink-0">
                        <i class="fas fa-inbox text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-amber-800 dark:text-amber-300">No Data Submitted</p>
                        <p class="text-xs text-amber-600 dark:text-amber-400 mt-0.5">This collector has not submitted any data for this season.</p>
                    </div>
                </div>
                @else
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-green-100 dark:bg-green-500/20 text-green-600 dark:text-green-400">
                        <i class="fas fa-calendar-days text-sm"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Data Collection Timeline</h3>
                    <span class="ml-auto inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400">
                        {{ $selectedCollector->commonDataCollect->count() }} entries
                    </span>
                </div>
                <div class="space-y-3">
                    @foreach ($selectedCollector->commonDataCollect as $entry)
                    <div class="flex items-start gap-3 p-4 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl hover:border-green-300 dark:hover:border-green-700 transition-all group">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-bold text-xs shadow-md shadow-green-500/20 flex-shrink-0">
                            {{ $loop->iteration }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                                <div class="flex items-center gap-1.5 text-sm text-slate-700 dark:text-slate-300">
                                    <i class="fas fa-seedling text-green-500 text-xs"></i>
                                    <span class="font-medium">Field Date:</span>
                                    <span>{{ $entry->c_date }}</span>
                                </div>
                            </div>
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-1 flex items-center gap-1.5">
                                <i class="fas fa-clock text-[10px]"></i>
                                Submitted {{ \Carbon\Carbon::parse($entry->created_at)->diffForHumans() }} &bull; {{ \Carbon\Carbon::parse($entry->created_at)->format('M d, Y H:i') }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-end px-4 sm:px-6 py-3 sm:py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 flex-shrink-0">
            <button wire:click="closeModal" type="button"
                class="px-5 py-2.5 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">
                Close
            </button>
        </div>
    </div>
</div>
@endif