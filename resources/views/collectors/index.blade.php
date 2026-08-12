<x-app-layout>




    <div>
        <!-- Page Header -->
        <x-headings.top-heading title="My Records" subtitle="" icon="fas fa-folder-open" buttonText="New Collector"
            buttonAction="{{ route('collector.newCollector') }}" buttonIcon="fas fa-plus" buttonColor="blue" />

        @if (session('success'))
            <div class="alert-success flex items-start gap-3 p-4 my-3 text-sm font-medium text-white border border-emerald-500 bg-emerald-600  shadow-md"
                role="alert">
                <i class="fas fa-check-circle mt-1 text-white text-lg"></i>
                <div class="flex-1">
                    {{ session('success') }}
                </div>
                <button onclick="this.parentElement.remove()"
                    class="ml-auto text-white hover:text-emerald-300 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Filter Toolbar -->
        <div x-data="{ showFilters: false }" class=" px-2">
            <div class="flex items-center justify-between">
                <button @click="showFilters = !showFilters"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-sm hover:bg-slate-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all w-full sm:w-auto group">
                    <div
                        class="w-6 h-6 rounded bg-slate-100 dark:bg-slate-900 flex items-center justify-center text-slate-500 dark:text-slate-400 group-hover:text-primary transition-colors">
                        <i class="fas fa-filter text-xs" :class="{ 'text-primary': showFilters }"></i>
                    </div>
                    <span x-text="showFilters ? 'Hide Filters' : 'Filter Records'"></span>
                    <i class="fas fa-chevron-down text-xs text-slate-400 ml-1 transition-transform duration-300"
                        :class="{ 'rotate-180': showFilters }"></i>
                </button>
            </div>

            <!-- Expandable Filter Panel -->
            <div x-show="showFilters" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                class="mt-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm overflow-hidden"
                style="display: none;">

                <form method="GET" action="{{ route('collector.index') }}" class="p-5 flex flex-col gap-5">

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        <!-- Rice Season -->
                        <div class="flex flex-col">
                            <label
                                class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Rice
                                Season</label>
                            <div class="relative">
                                <i
                                    class="fas fa-leaf absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                                <select name="season"
                                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-900 dark:text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors appearance-none">
                                    <option value="">All Seasons</option>
                                    @foreach ($seasons as $season)
                                        <option value="{{ $season->name }}"
                                            {{ request('season') == $season->name ? 'selected' : '' }}>
                                            {{ $season->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <i
                                    class="fas fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] pointer-events-none"></i>
                            </div>
                        </div>

                        <!-- District -->
                        <div class="flex flex-col">
                            <label
                                class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">District</label>
                            <div class="relative">
                                <i
                                    class="fas fa-map-marker-alt absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                                <select name="district"
                                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-900 dark:text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors appearance-none">
                                    <option value="">All Districts</option>
                                    @foreach ($districts as $district)
                                        <option value="{{ $district->name }}"
                                            {{ request('district') == $district->name ? 'selected' : '' }}>
                                            {{ $district->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <i
                                    class="fas fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] pointer-events-none"></i>
                            </div>
                        </div>

                        <!-- Established Date -->
                        <div class="flex flex-col">
                            <label
                                class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Established
                                Date</label>
                            <div class="relative">
                                <i
                                    class="far fa-calendar-alt absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm z-10"></i>
                                <input type="date" name="established" value="{{ request('established') }}"
                                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-900 dark:text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors [color-scheme:light] dark:[color-scheme:dark]">
                            </div>
                        </div>

                        <!-- Created At -->
                        <div class="flex flex-col">
                            <label
                                class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Created
                                At</label>
                            <div class="relative">
                                <i
                                    class="far fa-calendar-plus absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm z-10"></i>
                                <input type="date" name="created" value="{{ request('created') }}"
                                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-900 dark:text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors [color-scheme:light] dark:[color-scheme:dark]">
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div
                        class="flex flex-col sm:flex-row gap-3 justify-end items-center pt-5 mt-2 border-t border-slate-100 dark:border-slate-700/50">
                        <a href="{{ route('collector.index') }}"
                            class="w-full sm:w-auto inline-flex justify-center items-center gap-2 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white py-2 px-4 rounded-lg transition-colors focus:outline-none">
                            <i class="fas fa-undo opacity-70 text-xs"></i> Reset
                        </a>
                        <button type="submit"
                            class="w-full sm:w-auto inline-flex justify-center items-center gap-2 bg-primary hover:bg-emerald-600 dark:hover:bg-emerald-500 text-white text-sm font-semibold py-2.5 px-6 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all">
                            <i class="fas fa-search text-xs"></i> Apply Filters
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Collector Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3 p-2">
            @foreach ($collectors as $collector)
                <div
                    class="flex flex-col p-5 transition-all duration-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm hover:shadow-lg group relative overflow-hidden">

                    <!-- Top Ribbon & Actions -->
                    <div class="flex items-center justify-between mb-5 gap-3">
                        <!-- Number Badge -->
                        <span
                            class="flex items-center justify-center w-12 h-10 text-base font-black text-white bg-slate-800 dark:bg-slate-700 rounded-xl shadow-sm flex-shrink-0 border border-slate-700 dark:border-slate-600">
                            #{{ $collectors->count() - $loop->index }}
                        </span>

                        <!-- High Contrast Season Badge -->
                        <div
                            class="flex-1 flex items-center justify-center px-4 py-2 text-sm font-black tracking-wider uppercase text-white bg-gradient-to-r from-emerald-600 to-teal-500 rounded-xl shadow-md border border-emerald-500/50">
                            <i class="fas fa-seedling mr-2 opacity-90"></i>
                            {{ $collector->riceSeason->name }} Season
                        </div>

                        <!-- Admin Delete Action -->
                        @if (Auth::user()->name == 'npssoldata')
                            <form action="{{ route('collector.destroy', $collector->id) }}" method="POST"
                                onsubmit="return confirmDelete(event)" class="z-10 flex-shrink-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="flex items-center justify-center w-10 h-10 text-slate-400 hover:text-white hover:bg-red-500 dark:hover:bg-red-600 rounded-xl transition-all shadow-sm border border-transparent hover:border-red-600 focus:outline-none">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        @endif
                    </div>

                    <!-- Location Path -->
                    <div class="mb-4 flex flex-wrap items-center gap-2 text-sm">
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 font-semibold">
                            <i class="fas fa-map-marker-alt text-xs opacity-70"></i>
                            {{ $collector->getDistrict->name }}
                        </span>
                        <i class="fas fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 font-semibold">
                            {{ $collector->getAsCenter->name }}
                        </span>
                        <i class="fas fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 font-semibold">
                            {{ $collector->getAiRange->name }}
                        </span>
                    </div>

                    <!-- Metadata Grid -->
                    <div
                        class="flex-1 bg-slate-50 dark:bg-slate-900/50 rounded-xl p-4 border border-slate-100 dark:border-slate-700/50 mb-5">
                        <div class="grid grid-cols-2 gap-y-3 gap-x-4 text-sm">
                            <div class="flex flex-col">
                                <span
                                    class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Created
                                    At</span>
                                <span
                                    class="font-medium text-slate-700 dark:text-slate-200">{{ \Carbon\Carbon::parse($collector->created_at)->format('Y-m-d H:i') }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span
                                    class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Updated
                                    At</span>
                                <span
                                    class="font-medium text-slate-700 dark:text-slate-200">{{ \Carbon\Carbon::parse($collector->updated_at)->format('Y-m-d H:i') }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Rice
                                    Variety</span>
                                <span class="font-medium text-slate-700 dark:text-slate-200 flex items-center gap-1.5">
                                    <i class="fas fa-seedling text-emerald-500"></i> {{ $collector->rice_variety }}
                                </span>
                            </div>
                            <div class="flex flex-col">
                                <span
                                    class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Established
                                    Date</span>
                                <span
                                    class="font-medium text-slate-700 dark:text-slate-200">{{ $collector->date_establish }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span
                                    class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Method</span>
                                <span
                                    class="font-medium text-slate-700 dark:text-slate-200">{{ $collector->established_method ?? 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Pest
                                    Data Count</span>
                                <span class="font-bold text-primary flex items-center gap-1.5">
                                    <i class="fas fa-database text-primary opacity-70"></i>
                                    {{ $collector->commonDataCollect->count() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div
                        class="grid grid-cols-2 gap-3 mt-auto pt-4 border-t border-slate-100 dark:border-slate-700/50">
                        <a href="{{ route('collector.edit', $collector->id) }}"
                            class="flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-rose-600 bg-rose-50 border border-rose-200 rounded-lg hover:bg-rose-100 hover:text-rose-700 dark:bg-rose-500/10 dark:border-rose-500/20 dark:text-rose-400 dark:hover:bg-rose-500/20 dark:hover:text-rose-300 transition-colors focus:ring-2 focus:ring-rose-500/50 focus:outline-none w-full text-center">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('pestdata.view', $collector->id) }}"
                            class="flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-primary border border-primary rounded-lg hover:bg-emerald-600 dark:hover:bg-emerald-500 shadow-sm transition-all focus:ring-2 focus:ring-primary/50 focus:outline-none w-full text-center">
                            <i class="fas fa-bug"></i> Pest Data
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- JavaScript to Hide Message After 5 Seconds -->
    <script>
        setTimeout(() => {
            const successMessage = document.querySelector('.alert-success');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 5000);

        function confirmDelete(event) {
            if (!confirm('Are you sure you want to delete this collector?')) {
                event.preventDefault();
            }
        }
    </script>
</x-app-layout>
<script>
    setTimeout(() => {
        const successMessage = document.querySelector('.alert-success');
        if (successMessage) {
            successMessage.style.display = 'none';
        }
    }, 5000);
</script>
