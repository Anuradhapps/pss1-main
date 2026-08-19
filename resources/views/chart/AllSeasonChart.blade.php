<x-app-layout>
    <div class=" bg-slate-50 dark:bg-slate-950 transition-colors duration-300">

        <!-- Compact Page Header -->
        <x-headings.chart_heading title="All Season Chart" description="View seasonal data and trends"
            icon="fas fa-chart-line" back-route="chart.index" />
        <!-- Chart Card -->
        <div
            class="overflow-hidden rounded-2xl border border-slate-200
                        bg-white shadow-sm
                        dark:border-slate-800 dark:bg-slate-900">




            <!-- Chart -->
            <div
                class="overflow-hidden rounded-lg border border-slate-200
            bg-white shadow-sm
            dark:border-slate-800 dark:bg-slate-900">

                <div class="w-full overflow-x-auto">
                    <div class="p-2 sm:p-8">
                        {!! $chart->container() !!}
                    </div>
                </div>

            </div>

            <script src="{{ $chart->cdn() }}"></script>
            {{ $chart->script() }}

        </div>



    </div>


    <!-- Chart Scripts -->
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
    <script>
        function updateApexChartTheme() {
            const isDark = document.documentElement.classList.contains('dark');

            const textColor = isDark ? '#cbd5e1' : '#475569';
            const mutedColor = isDark ? '#94a3b8' : '#64748b';
            const gridColor = isDark ? '#334155' : '#e2e8f0';

            // Axis labels
            document.querySelectorAll(
                '.apexcharts-xaxis-label, .apexcharts-yaxis-label'
            ).forEach(label => {
                label.style.fill = textColor;
            });

            // X/Y axis titles
            document.querySelectorAll(
                '.apexcharts-xaxis-title, .apexcharts-yaxis-title'
            ).forEach(title => {
                title.style.fill = mutedColor;
            });

            // Legend
            document.querySelectorAll(
                '.apexcharts-legend-text'
            ).forEach(label => {
                label.style.color = textColor;
            });

            // Grid
            document.querySelectorAll(
                '.apexcharts-gridline'
            ).forEach(line => {
                line.style.stroke = gridColor;
            });

            // Chart title
            document.querySelectorAll(
                '.apexcharts-title-text'
            ).forEach(title => {
                title.style.fill = textColor;
            });
        }

        // Initial theme
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(updateApexChartTheme, 100);
        });

        // Watch Tailwind dark/light toggle
        const themeObserver = new MutationObserver(() => {
            setTimeout(updateApexChartTheme, 50);
        });

        themeObserver.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });
    </script>
</x-app-layout>
