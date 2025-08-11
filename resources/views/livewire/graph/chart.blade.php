<div class="p-6 bg-white rounded-lg shadow-md">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">Pest Monitoring Dashboard</h2>

        <!-- Season Selector -->
        <div class="w-full md:w-auto">
            <label class="block text-sm font-medium text-gray-700 mb-2">Select Rice Season:</label>
            <div class="flex flex-wrap gap-3">
                <label
                    class="inline-flex items-center px-3 py-2 bg-gray-100 rounded-lg cursor-pointer hover:bg-gray-200 transition-colors">
                    <input type="radio" wire:model="selectedSeason" name="season" value="0"
                        class="form-radio h-4 w-4 text-blue-600 focus:ring-blue-500" />
                    <span class="ml-2 text-sm text-gray-700">All Seasons</span>
                </label>
                @foreach ($seasons as $season)
                    <label
                        class="inline-flex items-center px-3 py-2 bg-gray-100 rounded-lg cursor-pointer hover:bg-gray-200 transition-colors">
                        <input type="radio" wire:model="selectedSeason" name="season" value="{{ $season->id }}"
                            class="form-radio h-4 w-4 text-blue-600 focus:ring-blue-500" />
                        <span class="ml-2 text-sm text-gray-700">{{ $season->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Loading Indicator -->
    @if ($isLoading)
        <div class="flex justify-center items-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
            <span class="ml-3 text-gray-600">Loading data...</span>
        </div>
    @endif

    <!-- Chart container -->
    <div class="relative bg-gray-50 rounded-lg p-4">
        <div class="h-80">
            <canvas id="pestChart" wire:ignore></canvas>
        </div>

        <!-- Chart Legend -->
        <div class="mt-4 flex flex-wrap justify-center gap-3" id="chartLegend"></div>
    </div>

    <!-- Data Summary -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
            <h3 class="text-sm font-medium text-blue-800">Time Period</h3>
            <p class="mt-1 text-lg font-semibold text-blue-900">
                @if (count($dates) > 0)
                    {{ Carbon\Carbon::parse($dates[0])->format('M d, Y') }} -
                    {{ Carbon\Carbon::parse(end($dates))->addDays(7)->format('M d, Y') }}
                @else
                    No data available
                @endif
            </p>
        </div>
        <div class="bg-green-50 p-4 rounded-lg border border-green-100">
            <h3 class="text-sm font-medium text-green-800">Data Points</h3>
            <p class="mt-1 text-lg font-semibold text-green-900">{{ count($dates) }} weeks</p>
        </div>
        <div class="bg-purple-50 p-4 rounded-lg border border-purple-100">
            <h3 class="text-sm font-medium text-purple-800">Pests Tracked</h3>
            <p class="mt-1 text-lg font-semibold text-purple-900">{{ count($pestData) }}</p>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            const ctx = document.getElementById('pestChart');
            let chart = null;
            const colorPalette = [
                '#3B82F6', // blue-500
                '#EF4444', // red-500
                '#10B981', // green-500
                '#F59E0B', // amber-500
                '#8B5CF6', // violet-500
                '#EC4899', // pink-500
            ];

            function initChart(dates, pestData) {
                if (chart) chart.destroy();

                const datasets = Object.entries(pestData).map(([pest, data], index) => {
                    const pestName = pest.replace(/([A-Z])/g, ' $1').replace(/^./, str => str
                .toUpperCase());
                    return {
                        label: pestName,
                        data: data,
                        backgroundColor: colorPalette[index % colorPalette.length] + '33', // Add opacity
                        borderColor: colorPalette[index % colorPalette.length],
                        borderWidth: 2,
                        pointBackgroundColor: colorPalette[index % colorPalette.length],
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.3,
                        fill: true,
                    };
                });

                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dates.map(date => {
                            const d = new Date(date);
                            return d.toLocaleDateString('en-US', {
                                month: 'short',
                                day: 'numeric'
                            });
                        }),
                        datasets: datasets,
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + context.parsed.y.toFixed(
                                            2);
                                    }
                                }
                            },
                            legend: {
                                display: false // We'll use custom legend
                            }
                        },
                        interaction: {
                            mode: 'nearest',
                            axis: 'x',
                            intersect: false
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    drawBorder: false
                                },
                                ticks: {
                                    precision: 0
                                }
                            },
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false
                                }
                            }
                        }
                    }
                });

                // Update custom legend
                updateLegend(datasets);
            }

            function updateLegend(datasets) {
                const legendContainer = document.getElementById('chartLegend');
                legendContainer.innerHTML = datasets.map(dataset => `
            <div class="flex items-center">
                <div class="w-3 h-3 rounded-full mr-2" style="background-color: ${dataset.borderColor}"></div>
                <span class="text-xs font-medium text-gray-600">${dataset.label}</span>
            </div>
        `).join('');
            }

            // Initialize with initial data
            initChart(@json($dates), @json($pestData));

            // Handle Livewire updates
            window.addEventListener('chartUpdated', event => {
                initChart(event.detail.dates, event.detail.pestData);
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (chart) chart.resize();
            });
        });
    </script>
@endpush
