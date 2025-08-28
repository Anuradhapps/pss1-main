<div class="m-2 space-y-3">

    <!-- Title & Info -->
    <div class="bg-white/90 backdrop-blur-sm border border-gray-200 rounded-2xl shadow-md overflow-hidden">
        <div
            class="bg-gradient-to-r from-blue-600 to-green-600 py-1 px-5 flex flex-col md:flex-row md:justify-between md:items-center gap-2">
            <h1 class="text-2xl md:text-3xl font-bold text-white tracking-tight">
                Pest, Temperature & Rainy Days Comparison
            </h1>
            <a href="{{ url('/') }}"
                class="px-4 py-2 text-sm rounded-full bg-red-500 hover:bg-red-600 text-white font-medium shadow-sm transition">
                Home
            </a>
        </div>
        <div class="px-5 py-0 bg-gray-50 border-t">
            <p class="text-gray-700 text-sm italic">
                Visualize pest severity (0–9), average weekly temperature, and rainy days for selected filters. Compare
                multiple seasons easily.
            </p>
        </div>
        <div class="px-4 py-0">
            <x-pest-damage-risk-guide />
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-4 md:p-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">

            <!-- Pest Selector -->
            <div class="flex flex-col">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Select Pest</label>
                <select wire:model="selectedPest"
                    class="w-full rounded-xl border-gray-300 text-sm p-2.5 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 shadow-sm transition">
                    <option value="">-- Choose Pest --</option>
                    @foreach ($pests as $key => $pest)
                        <option value="{{ $key }}">{{ $pest }}</option>
                    @endforeach
                </select>
            </div>

            <!-- District Selector -->
            <div class="flex flex-col">
                <label class="block text-xs font-semibold text-gray-600 mb-1">District</label>
                <select wire:model="districtId"
                    class="w-full rounded-xl border-gray-300 text-sm p-2.5 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 shadow-sm transition">
                    <option value="0">All Districts</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Season Selector -->
            <div class="col-span-2 flex flex-col">
                <label class="block text-xs font-semibold text-gray-600 mb-2">Seasons</label>
                <div class="flex flex-wrap gap-2">
                    @foreach ($seasons as $season)
                        <label
                            class="inline-flex items-center gap-2 text-sm px-3 py-1.5 rounded-lg border border-gray-300 hover:bg-indigo-100 cursor-pointer transition font-medium bg-gray-50">
                            <input type="checkbox" wire:model="selectedSeasons" value="{{ $season->id }}"
                                class="rounded border-gray-300 focus:ring-2 focus:ring-indigo-400">
                            <span>
                                @php
                                    // Shorten year format
                                    $shortName = preg_replace_callback(
                                        '/(\d{4})(?:\/(\d{4}))?/',
                                        function ($matches) {
                                            $start = substr($matches[1], 2); // last 2 digits of first year
                                            $end = isset($matches[2]) ? '/' . substr($matches[2], 2) : '';
                                            return $start . $end;
                                        },
                                        $season->name,
                                    );
                                @endphp
                                {{ $shortName }}
                            </span>

                        </label>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- Reset Filters -->
        <div class="mt-3 flex justify-end flex-wrap gap-2">
            <button wire:click="$set('selectedPest', '')"
                class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 rounded-full text-xs font-medium transition shadow-sm">
                Reset Pest
            </button>
            <button wire:click="$set('selectedSeasons', [])"
                class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 rounded-full text-xs font-medium transition shadow-sm">
                Reset Seasons
            </button>
            <button wire:click="$set('districtId', 0)"
                class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 rounded-full text-xs font-medium transition shadow-sm">
                Reset District
            </button>
        </div>
    </div>


    <!-- Chart -->
    <div class="bg-white border rounded-2xl shadow-md p-5">
        <div class="relative h-[500px]">
            <canvas id="pestTempRainChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:load', function() {
            const ctx = document.getElementById('pestTempRainChart');
            let chart = null;
            const colors = ['#4F46E5', '#DC2626', '#059669', '#D97706', '#7C3AED', '#DB2777', '#0D9488', '#EA580C'];

            function prepareChartData(pestData) {
                const seasons = Object.values(pestData || {});
                const maxWeeks = Math.max(...seasons.map(s => s.data.length), 0);
                const labels = Array.from({
                    length: maxWeeks
                }, (_, i) => `Week ${i + 1}`);
                const datasets = [];

                seasons.forEach((s, idx) => {
                    // Pest Severity
                    datasets.push({
                        label: `${s.name} (Pest)`,
                        data: s.data,
                        borderColor: colors[idx % colors.length],
                        backgroundColor: colors[idx % colors.length] + '33',
                        borderWidth: 2,
                        tension: 0.3,
                        yAxisID: 'y'
                    });
                    // Temperature
                    if (s.temperature) {
                        datasets.push({
                            label: `${s.name} (Temp °C)`,
                            data: s.temperature,
                            borderColor: '#000000',
                            backgroundColor: '#00000022',
                            borderWidth: 2,
                            borderDash: [6, 4],
                            pointStyle: 'cross',
                            tension: 0.3,
                            yAxisID: 'y1'
                        });
                    }
                    // Rain Days
                    if (s.rainDays) {
                        datasets.push({
                            label: `${s.name} (Rain Days)`,
                            data: s.rainDays,
                            borderColor: '#2563EB',
                            backgroundColor: '#2563EB33',
                            borderWidth: 2,
                            borderDash: [4, 4],
                            pointStyle: 'triangle',
                            tension: 0.3,
                            yAxisID: 'y2'
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
                                    usePointStyle: true,
                                    padding: 15
                                }
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                displayColors: true
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 10,
                                title: {
                                    display: true,
                                    text: 'Pest Severity',
                                    font: {
                                        weight: 'bold'
                                    }
                                }
                            },
                            y1: {
                                position: 'right',
                                grid: {
                                    drawOnChartArea: false
                                },
                                title: {
                                    display: true,
                                    text: 'Temperature (°C)',
                                    font: {
                                        weight: 'bold'
                                    }
                                }
                            },
                            y2: {
                                position: 'right',
                                grid: {
                                    drawOnChartArea: false
                                },
                                title: {
                                    display: true,
                                    text: 'Rainy Days',
                                    font: {
                                        weight: 'bold'
                                    }
                                },
                                offset: true
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Weeks',
                                    font: {
                                        weight: 'bold'
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Initial Chart
            initChart(@json($pestData));

            // Livewire Updates
            document.addEventListener('chartUpdated', e => {
                initChart(e.detail.pestData);
            });
        });
    </script>
@endpush
