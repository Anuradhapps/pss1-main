<x-app-layout>

    <!-- Header -->
    <x-headings.top-heading title="AI Chart" subtitle="Collector surveillance and pest monitoring details"
        icon="fas fa-chart-line" buttonText="Back"
        buttonAction="{{ has_role('collector') ? route('chart.index') : route('admin.collector.records') }}"
        buttonIcon="fas fa-arrow-left" buttonColor="red" class="bg-green-700" />

    <div class="flex flex-col gap-2">

        <!-- Messages -->
        <x-success-massage />
        <x-error-massage />


        <!-- ==================== CHART ==================== -->
        <section
            class="overflow-hidden rounded-2xl border border-slate-200
                   bg-white shadow-sm
                   dark:border-slate-800 dark:bg-slate-900">

            <!-- Chart -->
            <div class="w-full overflow-x-auto p-2 sm:p-4">
                <div class="min-w-[600px]">
                    {!! $chart->container() !!}
                </div>
            </div>
        </section>


        <!-- ==================== COLLECTOR INFO ==================== -->
        <section
            class="overflow-hidden rounded-2xl border border-slate-200
                   bg-white shadow-sm
                   dark:border-slate-800 dark:bg-slate-900">

            <!-- Header -->
            <div
                class="flex items-center gap-3 border-b border-slate-200
                       px-4 py-3 dark:border-slate-800">

                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg
                           bg-blue-100 text-blue-600
                           dark:bg-blue-500/10 dark:text-blue-400">
                    <i class="fas fa-user"></i>
                </div>

                <div>
                    <h2 class="text-sm font-bold text-slate-800 dark:text-slate-100 sm:text-base">
                        Collector Information
                    </h2>

                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Details of the data collector
                    </p>
                </div>

            </div>


            <!-- Information -->
            <div class="grid grid-cols-1 gap-3 p-4 sm:grid-cols-2 lg:grid-cols-4">

                <!-- Name -->
                <div
                    class="rounded-xl border border-slate-200 bg-slate-50 p-3
                           dark:border-slate-700 dark:bg-slate-800/60">

                    <p
                        class="text-[11px] font-medium uppercase tracking-wide
                               text-slate-500 dark:text-slate-400">
                        Name
                    </p>

                    <p class="mt-1 truncate text-sm font-semibold text-slate-800 dark:text-slate-100">
                        {{ $collector->user->name }}
                    </p>
                </div>


                <!-- Email -->
                <div
                    class="rounded-xl border border-slate-200 bg-slate-50 p-3
                           dark:border-slate-700 dark:bg-slate-800/60">

                    <p
                        class="text-[11px] font-medium uppercase tracking-wide
                               text-slate-500 dark:text-slate-400">
                        E-Mail
                    </p>

                    <p class="mt-1 truncate text-sm font-semibold text-slate-800 dark:text-slate-100">
                        {{ $collector->user->email }}
                    </p>
                </div>


                <!-- Phone -->
                <div
                    class="rounded-xl border border-slate-200 bg-slate-50 p-3
                           dark:border-slate-700 dark:bg-slate-800/60">

                    <p
                        class="text-[11px] font-medium uppercase tracking-wide
                               text-slate-500 dark:text-slate-400">
                        Phone Number
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-100">
                        {{ $collector->phone_no }}
                    </p>
                </div>


                <!-- Season -->
                <div
                    class="rounded-xl border border-slate-200 bg-slate-50 p-3
                           dark:border-slate-700 dark:bg-slate-800/60">

                    <p
                        class="text-[11px] font-medium uppercase tracking-wide
                               text-slate-500 dark:text-slate-400">
                        Season
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-100">
                        {{ $collector->riceSeason->name }}
                    </p>
                </div>

            </div>

        </section>


        <!-- ==================== PEST DATA ==================== -->
        @foreach ($collector->commonDataCollect as $commonData)
            <section
                class="overflow-hidden rounded-2xl border border-slate-200
                       bg-white shadow-sm
                       dark:border-slate-800 dark:bg-slate-900">

                <!-- Data Header -->
                <div
                    class="flex flex-col gap-3 border-b border-slate-200
                           px-4 py-3 sm:flex-row sm:items-center sm:justify-between
                           dark:border-slate-800">

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg
                                   bg-amber-100 text-amber-600
                                   dark:bg-amber-500/10 dark:text-amber-400">
                            <i class="fas fa-bug"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-bold text-slate-800 dark:text-slate-100 sm:text-base">
                                Pest Surveillance Data
                            </h2>

                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Collection and environmental information
                            </p>
                        </div>

                    </div>

                    <!-- Date -->
                    <div
                        class="flex items-center gap-2 text-xs text-slate-500
                               dark:text-slate-400">

                        <i class="far fa-calendar-alt"></i>

                        <span>
                            {{ $commonData->c_date }}
                        </span>

                    </div>

                </div>


                <!-- Environmental Information -->
                <div class="grid grid-cols-2 gap-2 p-3 sm:grid-cols-3 lg:grid-cols-5 sm:gap-3 sm:p-4">

                    <!-- Created -->
                    <div
                        class="rounded-xl border border-slate-200 bg-slate-50 p-3
                               dark:border-slate-700 dark:bg-slate-800/60">

                        <div class="flex items-center gap-2">
                            <i class="fas fa-clock text-xs text-slate-400"></i>

                            <span
                                class="text-[10px] font-medium uppercase
                                         text-slate-500 dark:text-slate-400 sm:text-xs">
                                Created
                            </span>
                        </div>

                        <p class="mt-1 text-xs font-semibold text-slate-700 dark:text-slate-200">
                            {{ $commonData->created_at }}
                        </p>

                    </div>


                    <!-- Collected -->
                    <div
                        class="rounded-xl border border-slate-200 bg-slate-50 p-3
                               dark:border-slate-700 dark:bg-slate-800/60">

                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar-day text-xs text-blue-500"></i>

                            <span
                                class="text-[10px] font-medium uppercase
                                         text-slate-500 dark:text-slate-400 sm:text-xs">
                                Collected
                            </span>
                        </div>

                        <p class="mt-1 text-xs font-semibold text-slate-700 dark:text-slate-200">
                            {{ $commonData->c_date }}
                        </p>

                    </div>


                    <!-- Temperature -->
                    <div
                        class="rounded-xl border border-slate-200 bg-slate-50 p-3
                               dark:border-slate-700 dark:bg-slate-800/60">

                        <div class="flex items-center gap-2">
                            <i class="fas fa-temperature-high text-xs text-red-500"></i>

                            <span
                                class="text-[10px] font-medium uppercase
                                         text-slate-500 dark:text-slate-400 sm:text-xs">
                                Temperature
                            </span>
                        </div>

                        <p class="mt-1 text-xs font-semibold text-slate-700 dark:text-slate-200">
                            {{ $commonData->temperature }} °C
                        </p>

                    </div>


                    <!-- Rainy Days -->
                    <div
                        class="rounded-xl border border-slate-200 bg-slate-50 p-3
                               dark:border-slate-700 dark:bg-slate-800/60">

                        <div class="flex items-center gap-2">
                            <i class="fas fa-cloud-rain text-xs text-blue-500"></i>

                            <span
                                class="text-[10px] font-medium uppercase
                                         text-slate-500 dark:text-slate-400 sm:text-xs">
                                Rainy Days
                            </span>
                        </div>

                        <p class="mt-1 text-xs font-semibold text-slate-700 dark:text-slate-200">
                            {{ $commonData->numbrer_r_day }}
                        </p>

                    </div>


                    <!-- Growth Stage -->
                    <div
                        class="col-span-2 rounded-xl border border-slate-200 bg-slate-50 p-3
                               dark:border-slate-700 dark:bg-slate-800/60
                               sm:col-span-1">

                        <div class="flex items-center gap-2">
                            <i class="fas fa-seedling text-xs text-emerald-500"></i>

                            <span
                                class="text-[10px] font-medium uppercase
                                         text-slate-500 dark:text-slate-400 sm:text-xs">
                                Growth Stage
                            </span>
                        </div>

                        <p class="mt-1 text-xs font-semibold text-slate-700 dark:text-slate-200">
                            {{ $commonData->growth_s_c }}
                        </p>

                    </div>

                </div>


                <!-- Pest Table -->
                <div class="px-3 pb-3 sm:px-4 sm:pb-4">

                    <div
                        class="overflow-hidden rounded-xl border border-slate-200
                               dark:border-slate-700">

                        <div class="overflow-x-auto">

                            <table class="min-w-[700px] w-full text-sm">

                                <!-- Table Header -->
                                <thead
                                    class="bg-slate-100 text-xs uppercase tracking-wide
                                           text-slate-600
                                           dark:bg-slate-800 dark:text-slate-300">

                                    <tr>

                                        <th
                                            class="sticky left-0 z-10 text-black dark:text-white bg-slate-100 px-4 py-3 text-left
                                                   dark:bg-slate-800">
                                            Pest
                                        </th>

                                        @for ($i = 1; $i <= 10; $i++)
                                            <th class="px-3 py-3 text-center">
                                                SP-{{ $i }}
                                            </th>
                                        @endfor

                                        <th class="px-4 py-3 text-center">
                                            Total
                                        </th>

                                        <th class="px-4 py-3 text-center">
                                            Code
                                        </th>

                                    </tr>

                                </thead>


                                <!-- Table Body -->
                                <tbody
                                    class="divide-y divide-slate-200
                                           dark:divide-slate-700">

                                    @foreach ($commonData->pestDataCollect as $pestData)
                                        <tr
                                            class="transition-colors hover:bg-slate-50
                                                   dark:hover:bg-slate-800/60">

                                            <!-- Pest -->
                                            <td
                                                class="sticky left-0 z-10 whitespace-nowrap
                                                       bg-white px-4 py-3 font-semibold
                                                       text-slate-700
                                                       dark:bg-slate-900 dark:text-slate-200">

                                                <div class="flex items-center gap-2">

                                                    <span
                                                        class="flex h-7 w-7 items-center justify-center
                                                               rounded-lg bg-amber-100 text-amber-600
                                                               dark:bg-amber-500/10 dark:text-amber-400">
                                                        <i class="fas fa-bug text-xs"></i>
                                                    </span>

                                                    {{ $pestData->pest_name }}

                                                </div>

                                            </td>


                                            <!-- Locations -->
                                            @for ($i = 1; $i <= 10; $i++)
                                                <td
                                                    class="px-3 py-3 text-center text-slate-600
                                                           dark:text-slate-300">

                                                    {{ $pestData->pest_name == 'Thrips' ? '-' : $pestData->{'location_' . $i} }}

                                                </td>
                                            @endfor


                                            <!-- Total -->
                                            <td
                                                class="px-4 py-3 text-center font-bold
                                                       text-slate-800 dark:text-white">

                                                {{ $pestData->pest_name == 'Thrips' ? '-' : $pestData->total }}

                                            </td>


                                            <!-- Code -->
                                            <td class="px-4 py-3 text-center">

                                                @php
                                                    $colorClass = match ($pestData->code) {
                                                        0
                                                            => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-200',
                                                        1
                                                            => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400',
                                                        3
                                                            => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/20 dark:text-yellow-400',
                                                        5
                                                            => 'bg-orange-100 text-orange-700 dark:bg-orange-500/20 dark:text-orange-400',
                                                        7
                                                            => 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400',
                                                        9
                                                            => 'bg-red-200 text-red-900 dark:bg-red-900/60 dark:text-red-200',
                                                        default
                                                            => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-200',
                                                    };
                                                @endphp

                                                <span
                                                    class="inline-flex min-w-[32px] items-center justify-center
                                                           rounded-full px-2 py-1 text-xs font-bold
                                                           {{ $colorClass }}">

                                                    {{ $pestData->code }}

                                                </span>

                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>

                    <!-- Mobile Table Hint -->
                    <p class="mt-2 text-[11px] text-slate-400 sm:hidden">
                        <i class="fas fa-arrows-alt-h mr-1"></i>
                        Swipe horizontally to view all pest data.
                    </p>

                </div>


                <!-- Footer -->
                <div
                    class="flex flex-col gap-4 border-t border-slate-200
                           px-3 py-4 sm:px-4
                           md:flex-row md:items-end md:justify-between
                           dark:border-slate-800">

                    <!-- Other Information -->
                    @if ($commonData->otherinfo)
                        <div class="min-w-0 flex-1">

                            <div class="mb-2 flex items-center gap-2">

                                <i class="fas fa-sticky-note text-xs text-emerald-500"></i>

                                <h3
                                    class="text-xs font-bold uppercase tracking-wide
                                           text-slate-600 dark:text-slate-300">
                                    Other Information
                                </h3>

                            </div>

                            <div
                                class="rounded-xl border border-slate-200
                                       bg-slate-50 px-3 py-2.5
                                       text-sm leading-relaxed text-slate-600
                                       dark:border-slate-700 dark:bg-slate-800/60
                                       dark:text-slate-300">

                                {{ $commonData->otherinfo }}

                            </div>

                        </div>
                    @endif


                    <!-- Delete -->
                    <form action="{{ route('admin.pestdata.destroy', $commonData->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this record?')" class="shrink-0">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="inline-flex w-full items-center justify-center gap-2
                                   rounded-lg bg-red-600 px-4 py-2.5
                                   text-xs font-semibold text-white
                                   shadow-sm transition-all
                                   hover:bg-red-700
                                   focus:outline-none focus:ring-2
                                   focus:ring-red-500/40
                                   active:scale-95
                                   sm:w-auto">

                            <i class="fas fa-trash-alt text-xs"></i>

                            <span>Delete Record</span>

                        </button>

                    </form>

                </div>

            </section>
        @endforeach

    </div>

    <!-- ==================== CHART SCRIPTS & THEME HANDLER ==================== -->

    <!-- 1. Intercept global Apex configuration before script renders to avoid styling flash -->
    <script>
        (function() {
            const isDark = document.documentElement.classList.contains('dark');
            window.Apex = {
                chart: {
                    background: isDark ? '#0f172a' : '#ffffff',
                    foreColor: isDark ? '#cbd5e1' : '#475569',
                },
                theme: {
                    mode: isDark ? 'dark' : 'light'
                },
                grid: {
                    borderColor: isDark ? '#334155' : '#e2e8f0'
                },
                tooltip: {
                    theme: isDark ? 'dark' : 'light'
                }
            };
        })();
    </script>

    <!-- 2. Load dependencies and Chart Script -->
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}

    <!-- 3. Handle live dynamic theme changes via DOM Observation -->
    <script>
        function updateChartTheme() {
            if (typeof ApexCharts === 'undefined') return;

            const isDark = document.documentElement.classList.contains('dark');
            const newThemeOptions = {
                chart: {
                    background: isDark ? '#0f172a' : '#ffffff',
                    foreColor: isDark ? '#cbd5e1' : '#475569',
                },
                theme: {
                    mode: isDark ? 'dark' : 'light'
                },
                grid: {
                    borderColor: isDark ? '#334155' : '#e2e8f0'
                },
                tooltip: {
                    theme: isDark ? 'dark' : 'light'
                }
            };

            // Update the global defaults for any subsequent chart re-renders
            window.Apex = newThemeOptions;

            // Robustly find every ApexCharts instance registered on the window and apply changes
            // This safely bypasses DOM ID lookup issues common with package wrappers
            Object.keys(window).forEach(key => {
                if (window[key] instanceof ApexCharts) {
                    try {
                        window[key].updateOptions(newThemeOptions, false, false);
                    } catch (error) {
                        console.error('Failed to update chart theme:', error);
                    }
                }
            });
        }

        // Detect your application's dark/light toggle
        const themeObserver = new MutationObserver(() => {
            // Apply slight timeout to ensure classes are fully applied to DOM
            setTimeout(updateChartTheme, 50);
        });

        themeObserver.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });
    </script>

</x-app-layout>
