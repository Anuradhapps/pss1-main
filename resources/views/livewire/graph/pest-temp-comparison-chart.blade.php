<div class="m-2">
    <!-- Main Title Container -->
    <div class="bg-white/90 backdrop-blur-sm border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <!-- Gradient Header Bar -->
        <div class="bg-gradient-to-r from-pink-600 to-emerald-600 py-2 px-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <h1 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                    Pest & Temparature Comparison
                </h1>
                <div class="flex items-center gap-2">
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-sm font-semibold text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Damage Severity + Temperature
                    </span>

                    <a href="{{ url('/') }}"
                        class="inline-flex items-center px-3 py-1 rounded-full bg-red-500 hover:bg-red-600 transition-colors duration-200 text-sm font-semibold text-white">
                        <i class="fas fa-home mr-2"></i> Home
                    </a>
                </div>
            </div>
        </div>

        <!-- Description Box -->
        <div class="px-4 bg-gray-50 border-t border-gray-100">
            <div class="prose prose-indigo max-w-none">
                <p class="text-gray-700 text-sm italic">
                    Visualize weekly pest severity (0–9 scale) alongside average seasonal temperatures for comparison.
                </p>
            </div>
        </div>

        <!-- Risk Guide -->
        <div class="px-2">
            <x-pest-damage-risk-guide />
        </div>
    </div>

    <!-- Header & Filters -->
    <div class="m-3">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Pest Selector -->
                <div>
                    <label for="pestSelect" class="block text-xs font-medium text-gray-600 mb-1">
                        Select Pest
                    </label>
                    <select wire:model="selectedPest" id="pestSelect"
                        class="w-full rounded-lg border-gray-300 text-gray-800 text-sm p-2.5
                           focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        @foreach ($pests as $key => $pest)
                            <option value="{{ $key }}">{{ $pest }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- District Selector -->
                <div>
                    <label for="districtSelect" class="block text-xs font-medium text-gray-600 mb-1">
                        Select District
                    </label>
                    <select wire:model="districtId" id="districtSelect"
                        class="w-full rounded-lg border-gray-300 text-gray-800 text-sm p-2.5
                           focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <option value="0">All Districts</option>
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}">{{ $district->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Temperature Toggle -->
                <div class="flex items-end">
                    <button id="toggleAllTemp"
                        class="w-full px-3 py-2 text-sm font-medium rounded-lg
                           bg-gradient-to-r from-gray-700 to-gray-800 text-white
                           hover:from-gray-800 hover:to-black shadow-sm transition">
                        Toggle All Temperature
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Loading State -->
    @if ($isLoading)
        <div class="flex flex-col items-center justify-center p-12 bg-gray-50 rounded-xl border border-gray-200">
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-500"></div>
            <p class="mt-4 text-gray-600 font-medium">Loading pest data...</p>
        </div>
    @else
        <!-- Chart Container -->
        <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm overflow-hidden">
            <div class="relative h-96 w-full">
                <canvas id="pestComparisonChart"></canvas>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:load', function() {
            const ctx = document.getElementById('pestComparisonChart');
            let chart = null;

            const colors = [
                '#4F46E5', '#DC2626', '#059669', '#D97706',
                '#7C3AED', '#DB2777', '#0D9488', '#EA580C'
            ];

            function prepareChartData(pestData) {
                const seasonEntries = Object.values(pestData || {});
                const maxWeeks = Math.max(...seasonEntries.map(s => s.data.length), 0);
                const labels = Array.from({
                    length: maxWeeks
                }, (_, i) => `Week ${i + 1}`);

                const datasets = [];

                seasonEntries.forEach((season, index) => {
                    // Pest severity dataset
                    datasets.push({
                        label: season.name + ' (Pest Severity)',
                        data: season.data,
                        borderColor: colors[index % colors.length],
                        backgroundColor: colors[index % colors.length] + '33',
                        borderWidth: 2.5,
                        tension: 0.3,
                        yAxisID: 'y'
                    });

                    // Temperature dataset
                    if (season.temperature) {
                        datasets.push({
                            label: season.name + ' (Temperature °C)',
                            data: season.temperature,
                            borderColor: '#000000', // black line
                            backgroundColor: '#00000055', // semi-transparent black fill
                            borderWidth: 0.4,
                            borderDash: [6, 6],
                            pointStyle: 'cross',
                            tension: 0.,
                            yAxisID: 'y1'
                        });

                    }
                });

                return {
                    labels,
                    datasets
                };
            }

            function initChart(pestData) {
                if (chart) chart.destroy();

                const {
                    labels,
                    datasets
                } = prepareChartData(pestData);

                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels,
                        datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    generateLabels: function(chart) {
                                        const pestSeverity = [];
                                        const temperature = [];

                                        chart.data.datasets.forEach((dataset, i) => {
                                            if (dataset.yAxisID === 'y') {
                                                pestSeverity.push({
                                                    text: dataset.label,
                                                    fillStyle: dataset.borderColor,
                                                    hidden: !chart.isDatasetVisible(i),
                                                    datasetIndex: i,
                                                });
                                            } else if (dataset.yAxisID === 'y1') {
                                                temperature.push({
                                                    text: dataset.label,
                                                    fillStyle: dataset.borderColor,
                                                    hidden: !chart.isDatasetVisible(i),
                                                    datasetIndex: i,
                                                });
                                            }
                                        });

                                        // Combine into two groups (Pest Severity first, then Temperature)
                                        return [{
                                                text: 'Pest Severity',
                                                fontStyle: 'bold',
                                                fillStyle: 'transparent'
                                            },
                                            ...pestSeverity,
                                            {
                                                text: 'Temperature',
                                                fontStyle: 'bold',
                                                fillStyle: 'transparent'
                                            },
                                            ...temperature
                                        ];
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: (ctx) => `${ctx.dataset.label}: ${ctx.parsed.y}`
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                min: 0,
                                max: 10,
                                ticks: {
                                    stepSize: 1,
                                    callback: val => Number.isInteger(val) ? val : null
                                },
                                title: {
                                    display: true,
                                    text: 'Pest Severity Code'
                                }
                            },
                            y1: {
                                position: 'right',
                                grid: {
                                    drawOnChartArea: false
                                },
                                title: {
                                    display: true,
                                    text: 'Temperature (°C)'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Weeks of Season'
                                }
                            }
                        }
                    }
                });

            }

            // Initial chart
            initChart(@json($pestData));

            // Livewire events
            Livewire.on('chartUpdated', pestData => initChart(pestData));
            document.addEventListener('chartUpdated', e => initChart(e.detail.pestData));

            document.getElementById('toggleAllTemp').addEventListener('click', () => {
                if (!chart) return;

                // Find all temperature datasets
                const tempDatasets = chart.data.datasets.filter(ds => ds.yAxisID === 'y1');

                // Determine if we should hide or show
                const anyVisible = tempDatasets.some(ds => !ds.hidden);

                // Toggle each temperature dataset
                tempDatasets.forEach(ds => {
                    ds.hidden = anyVisible; // hide if any visible, show if all hidden
                });

                chart.update();
            });


        });
    </script>
@endpush

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');

    body {
        font-family: 'Inter', sans-serif;
    }
</style>
