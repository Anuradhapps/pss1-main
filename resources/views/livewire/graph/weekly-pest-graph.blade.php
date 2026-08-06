<div
    class="rounded-xl border border-slate-200 bg-white p-4 shadow-md transition-colors dark:border-slate-700 dark:bg-slate-900">
    <h2 class="mb-4 text-lg font-semibold text-slate-900 dark:text-white">Weekly Pest Density Chart</h2>

    <div class="mb-4 flex space-x-4">
        <div class="flex-1">
            <label class="mb-1 block text-sm text-slate-500 dark:text-slate-400">Select Region:</label>
            <select wire:model.debounce.500ms="regionId"
                class="w-full rounded-md border border-slate-300 bg-white p-2 text-slate-900 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                <option value="">All Regions</option>
                @foreach ($regions as $region)
                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex-1">
            <label class="mb-1 block text-sm text-slate-500 dark:text-slate-400">Select Province:</label>
            <select wire:model.debounce.500ms="provinceId"
                class="w-full rounded-md border border-slate-300 bg-white p-2 text-slate-900 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100"
                {{ !$regionId ? 'disabled' : '' }}>
                <option value="">All Provinces</option>
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex-1">
            <label class="mb-1 block text-sm text-slate-500 dark:text-slate-400">Select District:</label>
            <select wire:model.debounce.500ms="districtId"
                class="w-full rounded-md border border-slate-300 bg-white p-2 text-slate-900 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100"
                {{ !$provinceId ? 'disabled' : '' }}>
                <option value="">All Districts</option>
                @foreach ($districts as $district)
                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if (empty($chartData))
        <div class="text-center text-slate-500 dark:text-slate-400">
            No data available for the selected period ({{ $startDate }} to {{ $endDate }}) or area.
            @if ($regionId)
                Region: {{ App\Models\Region::find($regionId)?->name ?? 'Unknown' }}
            @endif
            @if ($provinceId)
                , Province: {{ App\Models\Province::find($provinceId)?->name ?? 'Unknown' }}
            @endif
            @if ($districtId)
                , District: {{ App\Models\District::find($districtId)?->name ?? 'Unknown' }}
            @endif
        </div>
    @else
        <canvas id="pestChart" class="h-96 w-full"></canvas>
    @endif

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('livewire:load', () => {
                console.log('Livewire loaded, dispatching refreshChart');
                window.dispatchEvent(new Event('refreshChart'));
            });

            window.addEventListener('refreshChart', function() {
                console.log('refreshChart event triggered', @json($chartData));
                if (window.pestChart) {
                    window.pestChart.destroy();
                }

                const chartCanvas = document.getElementById('pestChart');
                if (!chartCanvas) {
                    console.error('Chart canvas not found');
                    return;
                }

                const data = @json($chartData);
                const isDark = document.documentElement.classList.contains('dark');
                const textColor = isDark ? '#94a3b8' : '#475569';
                const gridColor = isDark ? '#374151' : '#e2e8f0';
                const labels = data.map(item => item.week);

                const pests = ['thrips', 'gallMidge', 'leaffolder', 'yellowStemBorer', 'bphWbph', 'paddyBug'];
                const pestColors = {
                    thrips: '#22c55e',
                    gallMidge: '#facc15',
                    leaffolder: '#3b82f6',
                    yellowStemBorer: '#f97316',
                    bphWbph: '#8b5cf6',
                    paddyBug: '#ef4444',
                };

                const datasets = pests.map(pest => ({
                    label: pest.charAt(0).toUpperCase() + pest.slice(1).replace(/([A-Z])/g, ' $1').trim(),
                    data: data.map(item => item.data[pest] || 0),
                    borderColor: pestColors[pest],
                    backgroundColor: pestColors[pest] + '80',
                    fill: false,
                    tension: 0.3,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }));

                window.pestChart = new Chart(chartCanvas, {
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
                                    color: textColor,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `${context.dataset.label}: ${context.parsed.y}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    color: textColor,
                                    maxRotation: 45,
                                    minRotation: 45
                                },
                                grid: {
                                    color: '#374151'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: textColor,
                                    stepSize: 1
                                },
                                grid: {
                                    color: '#374151'
                                },
                                title: {
                                    display: true,
                                    text: 'Pest Density Code',
                                    color: textColor
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</div>
