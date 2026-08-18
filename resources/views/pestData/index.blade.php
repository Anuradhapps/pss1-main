<x-app-layout>
    <div class="w-full mx-auto space-y-2 2xl:space-y-4">
        <!-- Header -->
        <div
            class="mb-2 w-full overflow-hidden rounded-xl
           border border-slate-200 bg-white
           shadow-sm
           transition-colors duration-300
           dark:border-slate-700/80 dark:bg-slate-900">

            <div
                class="flex flex-col gap-3 px-3 py-3
               sm:flex-row sm:items-center sm:justify-between
               sm:px-4">

                {{-- ================= HEADER CONTENT ================= --}}
                <div class="min-w-0 flex-1">

                    <div class="flex items-center gap-2.5">

                        {{-- Icon --}}
                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center
                           rounded-lg
                           bg-primary/10 text-primary
                           ring-1 ring-primary/10
                           dark:bg-primary/15 dark:text-indigo-400
                           dark:ring-primary/20">
                            <i class="fas fa-bug text-sm"></i>
                        </div>

                        {{-- Title --}}
                        <h1
                            class="min-w-0 truncate
                           text-base font-bold leading-tight
                           tracking-tight
                           text-slate-800
                           dark:text-slate-100
                           sm:text-lg">
                            Pest Data Overview
                        </h1>

                    </div>


                </div>


                {{-- ================= ACTION BUTTONS ================= --}}
                <div class="flex w-full flex-col gap-2.5 sm:w-auto sm:flex-row">

                    {{-- Add Pest Data --}}
                    <a href="{{ route('pestdata.create', $collectorId) }}"
                        class="inline-flex min-h-12 w-full shrink-0 items-center justify-center
               gap-2 rounded-lg
               bg-primary px-5 py-3
               text-sm font-semibold text-white
               shadow-sm
               transition-all duration-200
               hover:bg-indigo-700 hover:shadow-md
               active:scale-[0.98]
               focus:outline-none focus:ring-2
               focus:ring-primary focus:ring-offset-2
               dark:focus:ring-offset-slate-900
               sm:min-h-0 sm:w-auto sm:px-4 sm:py-2
               sm:text-sm">

                        <i class="fas fa-plus text-sm"></i>

                        <span>Add Pest Data</span>
                    </a>


                    {{-- Back --}}
                    <a href="{{ route('collector.index') }}"
                        class="inline-flex min-h-12 w-full shrink-0 items-center justify-center
               gap-2 rounded-lg
               border border-slate-300
               bg-white px-5 py-3
               text-sm font-semibold
               text-slate-700
               shadow-sm
               transition-all duration-200
               hover:bg-slate-50 hover:shadow-md
               active:scale-[0.98]
               focus:outline-none focus:ring-2
               focus:ring-slate-400 focus:ring-offset-2
               dark:border-slate-700
               dark:bg-slate-800
               dark:text-slate-200
               dark:hover:bg-slate-700
               dark:focus:ring-offset-slate-900
               sm:min-h-0 sm:w-auto sm:px-4 sm:py-2
               sm:text-sm">

                        <i class="fas fa-arrow-left text-sm"></i>

                        <span>Back</span>
                    </a>

                </div>

            </div>
        </div>
        <x-success-massage />
        <x-error-massage />

        <!-- Collector Info Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2">
            @foreach ([['fas fa-user', 'text-red-500 bg-red-100 dark:bg-red-500/20', 'Collector Name', $collector->user->name], ['fas fa-map-marker-alt', 'text-blue-500 bg-blue-100 dark:bg-blue-500/20', 'Location', $collector->getAiRange->name], ['fas fa-seedling', 'text-green-500 bg-green-100 dark:bg-green-500/20', 'Rice Variety', $collector->rice_variety], ['fas fa-database', 'text-amber-500 bg-amber-100 dark:bg-amber-500/20', 'Uploads This Season', $CommonData->count()]] as [$icon, $iconColor, $label, $value])
                <div
                    class="flex items-center gap-4 p-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300">
                    <div
                        class="flex items-center justify-center w-10 h-10 {{ $iconColor }} rounded-full flex-shrink-0">
                        <i class="{{ $icon }} text-xl"></i>
                    </div>
                    <div class="flex flex-col min-w-0">
                        <div
                            class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider truncate">
                            {{ $label }}</div>
                        <div class="text-md font-bold text-slate-900 dark:text-white mt-0.5 truncate">
                            {{ $value }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Main Content -->
        <div class="flex flex-col lg:flex-row gap-2">
            <!-- Pest Data Uploads -->
            <div class="w-full lg:w-1/2 flex flex-col gap-2">
                <div class="flex items-center gap-2  p-3">
                    <i class="fas fa-history text-slate-400 dark:text-slate-500"></i>
                    <h2 class="text-lg font-bold text-slate-800 dark:text-slate-100">Data Uploads History</h2>
                    {{-- down arrow icon --}}
                    <i class="fas fa-chevron-down text-slate-400 dark:text-slate-500"></i>
                </div>

                <div class="space-y-3">
                    @forelse ($CommonData as $row)
                        <div
                            class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-3 rounded-2xl shadow-sm hover:shadow-md hover:border-primary/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 transition-all duration-300">
                            <!-- Date Info -->
                            <div class="flex flex-col gap-2">
                                <div
                                    class="flex items-center gap-2.5 text-sm font-medium text-slate-700 dark:text-slate-300">
                                    <div
                                        class="flex items-center justify-center w-6 h-6 rounded-md bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400">
                                        <i class="fas fa-calendar-alt text-xs"></i>
                                    </div>
                                    <span>Created: {{ $row->created_at }}</span>
                                </div>
                                <div
                                    class="flex items-center gap-2.5 text-sm font-medium text-slate-700 dark:text-slate-300">
                                    <div
                                        class="flex items-center justify-center w-6 h-6 rounded-md bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400">
                                        <i class="fas fa-calendar-check text-xs"></i>
                                    </div>
                                    <span>Collected: {{ $row->c_date }}</span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-wrap gap-2 w-full sm:w-auto mt-2 sm:mt-0">
                                <!-- View Button -->
                                <a href="{{ route('pestdata.show', $row->id) }}"
                                    class="flex-1 sm:flex-none inline-flex justify-center items-center gap-1.5 px-4 py-2 text-sm font-semibold text-green-600 bg-green-100 hover:bg-green-200 dark:bg-green-500/20 dark:hover:bg-green-500/30 dark:text-green-400 rounded-lg transition-colors duration-200">
                                    <i class="fas fa-eye"></i> View
                                </a>

                                <!-- Edit Button -->
                                <a href="{{ route('pestdata.edit', $row->id) }}"
                                    class="flex-1 sm:flex-none inline-flex justify-center items-center gap-1.5 px-4 py-2 text-sm font-semibold text-amber-600 bg-amber-100 hover:bg-amber-200 dark:bg-amber-500/20 dark:hover:bg-amber-500/30 dark:text-amber-400 rounded-lg transition-colors duration-200">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <!-- Delete Button with Alpine Modal -->
                                <div x-data="{ showConfirm: false }" class="flex-1 sm:flex-none">
                                    <button @click="showConfirm = true" type="button"
                                        class="w-full inline-flex justify-center items-center gap-1.5 px-4 py-2 text-sm font-semibold text-red-600 bg-red-100 hover:bg-red-200 dark:bg-red-500/20 dark:hover:bg-red-500/30 dark:text-red-400 rounded-lg transition-colors duration-200">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>

                                    <!-- Beautiful Delete Modal -->
                                    <template x-teleport="body">
                                        <div x-show="showConfirm" x-cloak
                                            class="fixed inset-0 z-[100] flex items-center justify-center p-4">
                                            <!-- Backdrop -->
                                            <div x-show="showConfirm"
                                                x-transition:enter="transition ease-out duration-300"
                                                x-transition:enter-start="opacity-0"
                                                x-transition:enter-end="opacity-100"
                                                x-transition:leave="transition ease-in duration-200"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0" @click="showConfirm = false"
                                                class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

                                            <!-- Modal Content -->
                                            <div x-show="showConfirm"
                                                x-transition:enter="transition ease-out duration-300 transform"
                                                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                x-transition:leave="transition ease-in duration-200 transform"
                                                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                class="relative w-full max-w-sm bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-700 p-6 overflow-hidden">

                                                <div class="flex flex-col items-center text-center">
                                                    <div
                                                        class="w-16 h-16 bg-red-100 dark:bg-red-500/20 text-red-600 dark:text-red-400 rounded-full flex items-center justify-center mb-4 border-4 border-white dark:border-slate-800 shadow-sm">
                                                        <i class="fas fa-exclamation-triangle text-2xl"></i>
                                                    </div>
                                                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">
                                                        Delete Record?</h3>
                                                    <p class="text-slate-500 dark:text-slate-400 mb-6 text-sm">This
                                                        action cannot be undone. Are you sure you want to permanently
                                                        delete this pest data record?</p>
                                                    <div class="flex gap-3 w-full">
                                                        <button @click="showConfirm = false" type="button"
                                                            class="flex-1 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-xl font-semibold transition-colors">Cancel</button>
                                                        <form action="{{ route('pestdata.destroy', $row->id) }}"
                                                            method="POST" class="flex-1 m-0">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="w-full px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition-colors shadow-sm shadow-red-600/30">Yes,
                                                                Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div
                            class="flex flex-col items-center justify-center bg-slate-50 dark:bg-slate-800/50 border-2 border-dashed border-slate-200 dark:border-slate-700 p-10 rounded-2xl text-center">
                            <div
                                class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-folder-open text-2xl text-slate-400 dark:text-slate-500"></i>
                            </div>
                            <h3 class="text-lg font-medium text-slate-900 dark:text-slate-100 mb-1">No Data Uploads Yet
                            </h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mb-4 max-w-sm">There are currently no
                                pest data records associated with this collector for the selected season.</p>
                            <a href="{{ route('pestdata.create', $collectorId) }}"
                                class="inline-flex items-center gap-2 px-4 py-2 font-semibold text-white bg-primary hover:bg-indigo-700 rounded-lg shadow-sm transition-colors duration-200">
                                <i class="fas fa-plus"></i> Add First Record
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Chart Section -->
            <div class="w-full lg:w-1/2">
                <x-charts.collector-pest-chart
                    title="{{ $collector->getAiRange->name }} - {{ $collector->riceSeason->name }} Season"
                    :labels="$pestLabels" :data="$pestCode" icon="fas fa-chart-bar" id="weeklyPestChart" />
            </div>
        </div>
    </div>
</x-app-layout>
