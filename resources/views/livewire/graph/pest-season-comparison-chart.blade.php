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
                <select wire:model="selectedPest" id="pestSelect"
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
                <select wire:model="districtId" id="districtSelect"
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

                const datasets = seasonEntries.map((season, index) => ({
                    label: season.name,
                    data: season.data,
                    borderColor: colors[index % colors.length],
                    backgroundColor: colors[index % colors.length] + '20',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: colors[index % colors.length],
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.3
                }));

                return {
                    labels,
                    datasets
                };
            }

            function initChart(pestData) {
                // Destroy old chart if exists
                if (chart !== null) {
                    chart.destroy();
                }

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
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    font: {
                                        family: 'Inter',
                                        size: 13
                                    },
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                callbacks: {
                                    label: (ctx) => `${ctx.dataset.label}: ${ctx.parsed.y.toFixed(2)}`
                                }
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Weeks of Season'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                max: 10, // Fixed maximum value
                                min: 0, // Fixed minimum value
                                ticks: {
                                    stepSize: 1, // Show integer values only
                                    callback: function(value) {
                                        // Only show integer values on Y-axis
                                        if (value % 1 === 0) {
                                            return value;
                                        }
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Pest Code'
                                }
                            }
                        }
                    }
                });
            }

            // Initial
            initChart(@json($pestData));

            // Update from Livewire
            Livewire.on('chartUpdated', pestData => initChart(pestData));

            document.addEventListener('chartUpdated', e => {
                initChart(e.detail.pestData);
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
