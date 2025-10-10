<div class="p-2 min-h-screen space-y-3">

    <!-- Title Card -->
    <div class="bg-white/95 backdrop-blur-md border border-gray-200 rounded-2xl shadow-lg overflow-hidden">
        <!-- Gradient Header -->
        <div
            class="bg-gradient-to-r from-indigo-600 via-sky-500 to-emerald-500 px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight drop-shadow">
                Rice Variety & Pest
            </h1>
            <a href="{{ url('/') }}"
                class="inline-flex items-center px-4 py-2 rounded-full bg-red-500 hover:bg-red-600 transition-colors duration-200 text-sm font-semibold text-white shadow-md">
                <i class="fas fa-home mr-2"></i> Home
            </a>
        </div>
        <div class="px-6 py-3 bg-gray-50 border-t">
            <p class="text-gray-700 text-sm italic tracking-wide">
                Analysis of top 15 rice varieties & their averaged pest distribution in Sri Lanka
            </p>
        </div>
        <div class="px-6 py-4">
            <x-pest-damage-risk-guide />
        </div>
    </div>

    @php
        $pestNameMap = [
            'gallMidge' => 'Gall Midge',
            'thrips' => 'Thrips',
            'leaffolder' => 'Leaffolder',
            'bphwbph' => 'BPH/WBPH',
            'paddyBug' => 'Paddy Bug',
        ];
        $maxValue = max($values);
        $maxIndex = array_search($maxValue, $values);
        $maxLabel = $labels[$maxIndex];
    @endphp

    <!-- Rice Variety Pie Chart -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 transition hover:shadow-xl">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Rice Variety Distribution (Top 15)</h2>
        <div class="flex flex-col md:flex-row gap-6 items-start md:items-center">

            <!-- Chart -->
            <div class="w-full md:w-1/2 h-64 md:h-80">
                <canvas id="pieChart"></canvas>
            </div>

            <!-- Stats Panel -->
            <div
                class="w-full md:w-1/2 p-5 space-y-5 bg-gradient-to-r from-green-100 to-blue-100 rounded-2xl shadow-inner text-gray-700">

                <!-- Most common variety -->
                <div class="flex items-center space-x-3">
                    <i class="fas fa-seedling text-green-700 text-2xl"></i>
                    <div>
                        <p class="text-lg font-semibold text-green-800">Most common variety</p>
                        <p class="text-blue-700 font-bold text-lg">{{ $maxLabel }}
                            <span
                                class="ml-2 px-2 py-1 text-sm bg-green-200 text-green-800 rounded-full">{{ $maxValue }}
                                collectors</span>
                        </p>
                    </div>
                </div>

                <!-- Data coverage -->
                <div class="flex items-center space-x-3">
                    <i class="fas fa-map-marked-alt text-yellow-600 text-2xl"></i>
                    <div>
                        <p class="text-lg font-semibold text-yellow-700">Data coverage</p>
                        <p class="text-gray-600 text-sm">Major agricultural regions of Sri Lanka</p>
                    </div>
                </div>

                <!-- Total collectors -->
                <div class="flex items-center space-x-3">
                    <i class="fas fa-users text-purple-700 text-2xl"></i>
                    <div>
                        <p class="text-lg font-semibold text-purple-700">Total collectors</p>
                        <p class="text-gray-800 font-bold text-lg">{{ array_sum($collectorsCount) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pest Charts Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($pestDataByVariety as $variety => $pestData)
            @php
                $maxPestKey = array_keys($pestData, max($pestData))[0];
                $maxPestCount = max($pestData);
                $maxPestLabel = $pestNameMap[$maxPestKey] ?? $maxPestKey;
            @endphp
            <div
                class="bg-white rounded-xl shadow p-4 border border-gray-100 hover:shadow-lg transition-all duration-200">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-sm font-semibold text-gray-800 tracking-wide bg-yellow-300 px-2 rounded-xl">
                        {{ $variety }}</h3>
                    <span
                        class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full">{{ $collectorsCount[$variety] }}
                        collector(s)</span>
                </div>
                <div class="h-44 md:h-48">
                    <canvas id="pestChart-{{ \Illuminate\Support\Str::slug($variety) }}" class="pestChart"></canvas>
                </div>
                <p class="text-xs text-gray-500 mt-2">Highest pest: <span
                        class="font-semibold">{{ $maxPestLabel }}</span> ({{ $maxPestCount }})</p>
            </div>
        @endforeach
    </div>

    <!-- Footer -->
    <p class="text-center text-gray-400 text-xs mt-6">Data updated: {{ now()->format('M j, Y') }} | Source: Field
        Research Collection</p>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const pestDataByVariety = @json($pestDataByVariety);
                const pestNameMap = @json($pestNameMap);

                // Pie Chart
                const pieCtx = document.getElementById('pieChart').getContext('2d');
                new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: @json($labels),
                        datasets: [{
                            data: @json($values),
                            backgroundColor: [
                                '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4',
                                '#d946ef', '#f97316', '#14b8a6', '#64748b', '#a855f7', '#84cc16',
                                '#ec4899', '#06b6d4', '#f43f5e'
                            ],
                            borderColor: '#fff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    color: '#374151',
                                    padding: 12,
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        }
                    }
                });

                // Pest Charts
                document.querySelectorAll('.pestChart').forEach(canvas => {
                    const slug = canvas.id.replace('pestChart-', '');
                    const variety = Object.keys(pestDataByVariety).find(v => v.replace(/\s+/g, '-')
                        .toLowerCase() === slug);
                    const rawData = pestDataByVariety[variety];

                    const labels = Object.keys(rawData).map(key => pestNameMap[key] || key);
                    const data = Object.values(rawData);

                    new Chart(canvas.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Pest Count',
                                data: data,
                                backgroundColor: 'rgba(59,130,246,0.8)',
                                borderRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const key = context.label;
                                            return key + ': ' + context.raw;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    min: 0, // 👈 Fixed minimum value
                                    max: 9,
                                    ticks: {
                                        stepSize: 1,
                                        font: {
                                            size: 10
                                        }
                                    }
                                },
                                x: {
                                    ticks: {
                                        font: {
                                            size: 10
                                        },
                                        color: '#374151'
                                    }
                                }
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
</div>
