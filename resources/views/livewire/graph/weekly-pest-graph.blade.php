<div class="bg-gray-900 p-4 rounded-xl shadow-md">
    <h2 class="text-white text-lg font-semibold mb-4">Weekly Pest Density Chart</h2>

    <div class="mb-4 flex space-x-4">
        <div class="flex-1">
            <label class="block text-gray-400 text-sm mb-1">Select Region:</label>
            <select wire:model.debounce.500ms="regionId"
                class="w-full bg-gray-800 text-white border border-gray-700 rounded-md p-2">
                <option value="">All Regions</option>
                @foreach ($regions as $region)
                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex-1">
            <label class="block text-gray-400 text-sm mb-1">Select Province:</label>
            <select wire:model.debounce.500ms="provinceId"
                class="w-full bg-gray-800 text-white border border-gray-700 rounded-md p-2"
                {{ !$regionId ? 'disabled' : '' }}>
                <option value="">All Provinces</option>
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex-1">
            <label class="block text-gray-400 text-sm mb-1">Select District:</label>
            <select wire:model.debounce.500ms="districtId"
                class="w-full bg-gray-800 text-white border border-gray-700 rounded-md p-2"
                {{ !$provinceId ? 'disabled' : '' }}>
                <option value="">All Districts</option>
                @foreach ($districts as $district)
                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if (empty($chartData))
        <div class="text-gray-400 text-center">
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
        <canvas id="pestChart" class="w-full h-96"></canvas>
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
                                    color: '#ffffff',
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
                                    color: '#ffffff',
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
                                    color: '#ffffff',
                                    stepSize: 1
                                },
                                grid: {
                                    color: '#374151'
                                },
                                title: {
                                    display: true,
                                    text: 'Pest Density Code',
                                    color: '#ffffff'
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</div>
