<div class="m-2">
    <!-- Main Title Container -->
    <div class="bg-white/90 backdrop-blur-sm border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <!-- Gradient Header Bar -->
        <div class="bg-gradient-to-r from-pink-600 to-emerald-600 py-2 px-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <!-- Main Title -->
                <h1 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                    Pest Season Comparison
                </h1>

                <!-- Subtitle Badge -->
                <div class="flex items-center gap-2">
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-sm font-semibold text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Damage Severity Coded / Rapid update
                    </span>

                    <a href="{{ url('/') }}"
                        class="inline-flex items-center px-3 py-1 rounded-full bg-red-500 hover:bg-red-600 transition-colors duration-200 text-sm font-semibold text-white">
                        <i class="fas fa-home mr-2"></i> Home
                    </a>
                </div>
            </div>
        </div>

        <!-- Description Box -->
        <div class="px-4  bg-gray-50 border-t border-gray-100">
            <div class="prose prose-indigo max-w-none">
                <p class="text-gray-700 text-sm italic">
                    Visualize the weekly averages of each pest’s damage intensity using a coded risk index (0–9 scale)
                    to enable comparison between seasons
                </p>
            </div>
        </div>

        <!-- Key Metrics Ribbon -->
        <!-- Pest Damage Risk Guide - Modern Accordion -->
        <div class="px-2">
            <x-pest-damage-risk-guide />
        </div>

    </div>
    <!-- Header & Filters -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between m-3 gap-4">

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
