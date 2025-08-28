<div class="m-3 space-y-5">

    <!-- Title Card -->
    <div class="bg-white/95 backdrop-blur-md border border-gray-200 rounded-2xl shadow-lg overflow-hidden">
        <!-- Gradient Header -->
        <div
            class="bg-gradient-to-r from-indigo-600 via-sky-500 to-emerald-500 px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <h1 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                Pest, Temperature & Rainy Days
            </h1>
            <a href="{{ url('/') }}"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm rounded-full bg-red-500 hover:bg-red-600 text-white font-medium shadow-md transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m-4-4h8" />
                </svg>
                Home
            </a>
        </div>
        <div class="px-6 py-3 bg-gray-50 border-t">
            <p class="text-gray-700 text-sm italic">
                Compare pest severity (0–9), weekly average temperature, and rainy days across multiple seasons.
            </p>
        </div>
        <div class="px-6 py-2">
            <x-pest-damage-risk-guide />
        </div>
    </div>

    <!-- Filter Panel -->
    <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-4 space-y-2">
        <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-1">Filters</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

            <!-- Pest -->
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Pest</label>
                <select wire:model="selectedPest"
                    class="w-full rounded-xl border-gray-300 text-sm p-2.5 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition">
                    <option value="">-- Choose Pest --</option>
                    @foreach ($pests as $key => $pest)
                        <option value="{{ $key }}">{{ $pest }}</option>
                    @endforeach
                </select>
            </div>

            <!-- District -->
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">District</label>
                <select wire:model="districtId"
                    class="w-full rounded-xl border-gray-300 text-sm p-2.5 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition">
                    <option value="0">All Districts</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Seasons -->
            <div class="col-span-2">
                <label class="block text-xs font-semibold text-gray-600 mb-2">Seasons</label>
                <div class="flex flex-wrap gap-2">
                    @foreach ($seasons as $season)
                        <label
                            class="inline-flex items-center gap-2 text-xs px-3 py-1.5 rounded-full border border-gray-300 hover:border-indigo-400 hover:bg-indigo-50 cursor-pointer transition font-medium bg-gray-50 text-gray-700">
                            <input type="checkbox" wire:model="selectedSeasons" value="{{ $season->id }}"
                                class="rounded border-gray-300 text-indigo-600 focus:ring-2 focus:ring-indigo-500">
                            <span>
                                @php
                                    $shortName = preg_replace_callback(
                                        '/(\d{4})(?:\/(\d{4}))?/',
                                        fn($m) => substr($m[1], 2) . (isset($m[2]) ? '/' . substr($m[2], 2) : ''),
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

        <!-- Reset Buttons -->
        <div class="flex justify-end gap-2 flex-wrap">
            <button wire:click="$set('selectedPest', '')"
                class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 rounded-full text-xs font-medium text-gray-600 shadow-sm transition">
                Reset Pest
            </button>
            <button wire:click="$set('selectedSeasons', [])"
                class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 rounded-full text-xs font-medium text-gray-600 shadow-sm transition">
                Reset Seasons
            </button>
            <button wire:click="$set('districtId', 0)"
                class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 rounded-full text-xs font-medium text-gray-600 shadow-sm transition">
                Reset District
            </button>
        </div>
    </div>

    <!-- Chart -->
    <div class="bg-white border rounded-2xl shadow-lg p-5">
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
