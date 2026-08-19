<x-app-layout>

    <!-- Header -->
    <x-headings.chart_heading title="Collectors" description="View collector surveillance data" icon="fas fa-users"
        back-route="chart.index" />

    <x-error-massage />

    <!-- Collector Grid -->
    <div class=" px-3 py-4 sm:px-4 sm:py-6">

        @forelse ($collectors as $collector)
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

                <!-- Collector Card -->
                <div
                    class="group flex min-w-0 items-center justify-between gap-3
                           rounded-xl border border-slate-200
                           bg-white p-3 shadow-sm
                           transition-all duration-200
                           hover:-translate-y-0.5 hover:shadow-md
                           dark:border-slate-800 dark:bg-slate-900">

                    <!-- Collector Info -->
                    <div class="flex min-w-0 items-center gap-3">

                        <!-- Avatar -->
                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center
                                   rounded-xl bg-orange-100 text-orange-600
                                   dark:bg-orange-500/10 dark:text-orange-400">

                            <i class="fas fa-user text-sm"></i>

                        </div>

                        <!-- Name -->
                        <div class="min-w-0">

                            <p
                                class="truncate text-sm font-semibold
                                      text-slate-800 dark:text-slate-100">
                                {{ $collector->user->name }}
                            </p>

                            <div class="mt-0.5 flex items-center gap-1.5">

                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                <span class="text-[11px] text-slate-500 dark:text-slate-400">
                                    Collector
                                </span>

                            </div>

                        </div>

                    </div>


                    <!-- View Button -->
                    <a href="{{ route('chart.ai.show', $collector->id) }}"
                        class="inline-flex shrink-0 items-center gap-1.5 rounded-lg
                               bg-emerald-600 px-3 py-2
                               text-xs font-semibold text-white
                               shadow-sm transition-all duration-200
                               hover:bg-emerald-700 hover:shadow
                               focus:outline-none focus:ring-2
                               focus:ring-emerald-500/40
                               active:scale-95">

                        <span>View</span>

                        <i
                            class="fas fa-arrow-right text-[10px]
                                  transition-transform duration-200
                                  group-hover:translate-x-0.5"></i>

                    </a>

                </div>

            </div>

        @empty

            <!-- Empty State -->
            <div
                class="flex min-h-[250px] flex-col items-center justify-center
                       rounded-2xl border border-dashed
                       border-slate-300 bg-white px-4
                       dark:border-slate-700 dark:bg-slate-900">

                <div
                    class="mb-3 flex h-12 w-12 items-center justify-center
                           rounded-full bg-slate-100 text-slate-400
                           dark:bg-slate-800 dark:text-slate-500">

                    <i class="fas fa-users text-lg"></i>

                </div>

                <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                    No collectors found
                </h3>

                <p class="mt-1 text-center text-xs text-slate-500 dark:text-slate-400">
                    There are currently no collectors available to display.
                </p>

            </div>
        @endforelse

    </div>

</x-app-layout>
