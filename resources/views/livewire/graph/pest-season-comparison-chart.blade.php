<div class="mx-auto p-4 md:p-6 bg-white rounded-xl shadow-lg">
    <!-- Header & Filters -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">📊 Pest Season Comparison</h2>
            <p class="text-sm text-gray-500 mt-1">Compare pest incidence across different seasons</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
            <!-- Pest Selector -->
            <div class="relative w-full sm:w-56">
                <label for="pestSelect" class="block text-sm font-medium text-gray-700 mb-1">Select Pest</label>
                <select wire:model.live="selectedPest" id="pestSelect"
                    class="text-gray-800 block w-full p-2.5 text-sm border border-gray-300 rounded-lg bg-white
                    focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                    @foreach ($pests as $key => $pest)
                        <option value="{{ $key }}">{{ $pest }}</option>
                    @endforeach
                </select>
            </div>

            <!-- District Selector -->
            <div class="relative w-full sm:w-56">
                <label for="districtSelect" class="block text-sm font-medium text-gray-700 mb-1">Select District</label>
                <select wire:model.live="districtId" id="districtSelect"
                    class="text-gray-800 block w-full p-2.5 text-sm border border-gray-300 rounded-lg bg-white
                    focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                    <option value="0">All Districts</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>
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

            // Modern color palette
            const colors = [
                '#4F46E5', // indigo
                '#DC2626', // red
                '#059669', // emerald
                '#D97706', // amber
                '#7C3AED', // purple
                '#DB2777', // pink
                '#0D9488', // teal
                '#EA580C' // orange
            ];

            function initChart(pestData) {
                if (chart) {
                    // Update existing chart instead of destroying
                    const {
                        datasets,
                        labels
                    } = prepareChartData(pestData);
                    chart.data.labels = labels;
                    chart.data.datasets = datasets;
                    chart.update();
                    return;
                }

                const {
                    datasets,
                    labels
                } = prepareChartData(pestData);

                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    font: {
                                        family: 'Inter',
                                        size: 13
                                    },
                                    padding: 20,
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                backgroundColor: 'rgba(17, 24, 39, 0.97)',
                                titleFont: {
                                    size: 13,
                                    weight: '600',
                                    family: 'Inter'
                                },
                                bodyFont: {
                                    size: 13,
                                    family: 'Inter'
                                },
                                padding: 12,
                                cornerRadius: 10,
                                usePointStyle: true,
                                boxPadding: 6,
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + context.parsed.y.toFixed(
                                            2);
                                    }
                                }
                            },
                            zoom: {
                                zoom: {
                                    wheel: {
                                        enabled: true,
                                        modifierKey: 'ctrl'
                                    },
                                    pinch: {
                                        enabled: true
                                    },
                                    mode: 'x',
                                },
                                pan: {
                                    enabled: true,
                                    mode: 'x',
                                    modifierKey: 'shift'
                                },
                                limits: {
                                    x: {
                                        minRange: 5
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Weeks of Season',
                                    font: {
                                        size: 13,
                                        weight: '600',
                                        family: 'Inter'
                                    },
                                    color: '#374151',
                                    padding: {
                                        top: 10,
                                        bottom: 0
                                    }
                                },
                                grid: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    font: {
                                        size: 12,
                                        family: 'Inter'
                                    },
                                    color: '#6B7280',
                                    maxRotation: 45,
                                    minRotation: 0
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Pest Count / Incidence',
                                    font: {
                                        size: 13,
                                        weight: '600',
                                        family: 'Inter'
                                    },
                                    color: '#374151',
                                    padding: {
                                        top: 0,
                                        bottom: 15
                                    }
                                },
                                grid: {
                                    drawBorder: false,
                                    color: 'rgba(229, 231, 235, 0.5)',
                                    drawTicks: false,
                                },
                                ticks: {
                                    font: {
                                        size: 12,
                                        family: 'Inter'
                                    },
                                    color: '#6B7280',
                                    padding: 10,
                                    callback: function(value) {
                                        return value.toFixed(1);
                                    }
                                }
                            }
                        },
                        interaction: {
                            mode: 'nearest',
                            axis: 'x',
                            intersect: false
                        },
                        elements: {
                            line: {
                                borderWidth: 2.5,
                                tension: 0.3,
                            },
                            point: {
                                radius: 4,
                                hoverRadius: 6,
                                hoverBorderWidth: 3,
                            }
                        }
                    }
                });
            }

            function prepareChartData(pestData) {
                const seasonEntries = Object.values(pestData);
                const maxWeeks = Math.max(...seasonEntries.map(season => season.data.length));
                const labels = Array.from({
                    length: maxWeeks
                }, (_, i) => `Week ${i + 1}`);

                const datasets = seasonEntries.map((season, index) => ({
                    label: season.name,
                    data: season.data,
                    borderColor: colors[index % colors.length],
                    backgroundColor: colors[index % colors.length] + '20', // Add opacity
                    borderWidth: 2.5,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: colors[index % colors.length],
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointHoverBorderWidth: 3,
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: colors[index % colors.length],
                    tension: 0.3,
                    fill: true
                }));

                return {
                    datasets,
                    labels
                };
            }

            // Initialize chart with initial data
            initChart(@json($pestData));

            // Listen for Livewire updates
            Livewire.on('updateChart', (pestData) => {
                initChart(pestData);
            });

            // Handle Livewire model updates
            document.addEventListener('livewire:init', () => {
                Livewire.on('selectedPestUpdated', (pestData) => {
                    initChart(pestData);
                });
                Livewire.on('districtIdUpdated', (pestData) => {
                    initChart(pestData);
                });
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
