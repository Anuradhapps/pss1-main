<div>
    <div class="mx-auto bg-gray-50 p-4 min-h-screen">
        <div class="bg-white/90 backdrop-blur-sm border border-gray-200 rounded-xl shadow-sm overflow-hidden mb-1">
            <!-- Gradient Header Bar -->
            <div class="bg-gradient-to-r from-pink-600 to-emerald-600 py-2 px-4">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <h1 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                        Pest & Both Season combined Analysis
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
                        Visualize weekly pest severity (0–9 scale) alongside average seasonal temperatures for
                        comparison.
                    </p>
                </div>
            </div>

            <!-- Risk Guide -->
            <div class="px-2">
                <x-pest-damage-risk-guide />
            </div>
        </div>


        @if (count($analytics['critical_alerts']) > 0)
            <div class="mb-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg p-4 shadow-sm animate-pulse">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-semibold text-red-800">Action Required: Critical Thresholds Breached
                        </h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($analytics['critical_alerts'] as $alert)
                                    <li>{{ $alert }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-2 p-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Cultivation
                        Year</label>
                    <select wire:model="selectedYear"
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block p-2.5">
                        <option value="all">All Available Years</option>
                        @foreach ($availableYears as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Season
                        View</label>
                    <div class="flex rounded-md shadow-sm" role="group">
                        <button type="button" wire:click="$set('selectedSeasonType', 'both')"
                            class="flex-1 px-4 py-2 text-sm font-medium rounded-l-lg border transition-colors {{ $selectedSeasonType == 'both' ? 'bg-teal-600 text-white border-teal-600' : 'bg-white text-gray-900 border-gray-300 hover:bg-gray-100' }}">
                            Annual
                        </button>
                        <button type="button" wire:click="$set('selectedSeasonType', 'yala')"
                            class="flex-1 px-4 py-2 text-sm font-medium border-t border-b transition-colors {{ $selectedSeasonType == 'yala' ? 'bg-teal-600 text-white border-teal-600' : 'bg-white text-gray-900 border-gray-300 hover:bg-gray-100' }}">
                            Yala Only
                        </button>
                        <button type="button" wire:click="$set('selectedSeasonType', 'maha')"
                            class="flex-1 px-4 py-2 text-sm font-medium rounded-r-lg border transition-colors {{ $selectedSeasonType == 'maha' ? 'bg-teal-600 text-white border-teal-600' : 'bg-white text-gray-900 border-gray-300 hover:bg-gray-100' }}">
                            Maha Only
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Region /
                        District</label>
                    <select wire:model="districtId"
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block p-2.5">
                        <option value="0">National Overview (All Districts)</option>
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}">{{ $district->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div class="bg-white rounded-xl p-1 border border-gray-200 shadow-sm flex items-center gap-4">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-lg"><i class="fas fa-calendar-alt text-xl"></i></div>
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">Monitoring Window</p>
                    <p class="text-sm font-bold text-gray-900 mt-1">
                        @if (count($dates) > 0)
                            {{ \Carbon\Carbon::parse($dates[0])->format('M d, Y') }} -
                            {{ \Carbon\Carbon::parse(end($dates))->format('M d, Y') }}
                        @else
                            No Data
                        @endif
                    </p>
                </div>
            </div>
            <div class="bg-white rounded-xl p-1done border border-gray-200 shadow-sm flex items-center gap-4">
                <div class="p-3 bg-purple-50 text-purple-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">Weeks Tracked</p>
                    <p class="text-xl font-bold text-gray-900 mt-0.5">{{ count($dates) }}</p>
                </div>
            </div>
            {{-- <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm flex items-center gap-4">
                <div class="p-3 bg-red-50 text-red-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">Primary Threat</p>
                    <p class="text-sm font-bold text-gray-900 mt-1">{{ $analytics['highest_risk_pest'] }}</p>
                    <p class="text-xs text-red-500 font-medium">Index:
                        {{ number_format($analytics['highest_risk_level'], 1) }}</p>
                </div>
            </div> --}}




        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-gray-800">Risk Trajectory Analysis</h2>
                {{-- <button onclick="exportChart()"
                    class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg font-medium transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Download PNG
                </button> --}}
            </div>

            <div class="relative h-[400px] w-full">
                <div wire:loading wire:target="generateData"
                    class="absolute inset-0 bg-white/80 backdrop-blur-sm z-20 flex flex-col items-center justify-center rounded-lg">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-teal-600 mb-3"></div>
                    <p class="text-teal-800 font-medium">Analyzing spatial data...</p>
                </div>

                <canvas id="pestChart" wire:ignore></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:load', function() {
                const ctx = document.getElementById('pestChart');
                let chart = null;

                // Optimized Color Palette suitable for data visualization
                const colors = [{
                        bg: 'rgba(220, 38, 38, 0.1)',
                        border: '#DC2626'
                    }, // Red (High threat pests)
                    {
                        bg: 'rgba(217, 119, 6, 0.1)',
                        border: '#D97706'
                    }, // Amber
                    {
                        bg: 'rgba(79, 70, 229, 0.1)',
                        border: '#4F46E5'
                    }, // Indigo
                    {
                        bg: 'rgba(5, 150, 105, 0.1)',
                        border: '#059669'
                    }, // Emerald
                    {
                        bg: 'rgba(124, 58, 237, 0.1)',
                        border: '#7C3AED'
                    }, // Purple
                    {
                        bg: 'rgba(87, 83, 78, 0.1)',
                        border: '#57534E'
                    }, // Stone
                ];

                function initChart(dates, pestData) {
                    if (chart) chart.destroy();

                    const datasets = Object.entries(pestData).map(([pest, data], i) => {
                        const isThreat = Math.max(...data) >= 5; // Highlight critical pests
                        return {
                            label: formatPestName(pest),
                            data: data,
                            backgroundColor: colors[i].bg,
                            borderColor: colors[i].border,
                            borderWidth: isThreat ? 3 : 1.5, // Thicker lines for dangerous pests
                            pointRadius: isThreat ? 4 : 2,
                            tension: 0.4,
                            hidden: Math.max(...data) === 0 // Hide pests with zero data automatically
                        };
                    });

                    chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: dates.map(d => new Date(d).toLocaleDateString('en-US', {
                                month: 'short',
                                day: 'numeric'
                            })),
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
                                    position: 'bottom',
                                    labels: {
                                        usePointStyle: true,
                                        padding: 20
                                    }
                                },
                            },
                            scales: {
                                y: {
                                    min: 0,
                                    max: 10,
                                    grid: {
                                        drawBorder: false,
                                        color: '#f3f4f6'
                                    },
                                    title: {
                                        display: true,
                                        text: 'Risk Intensity (0-9)',
                                        font: {
                                            weight: 'bold'
                                        }
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    },
                                }
                            }
                        }
                    });
                }

                function formatPestName(pest) {
                    return pest.replace(/([A-Z])/g, ' $1').replace(/^./, s => s.toUpperCase()).replace('Bph Wbph',
                        'BPH/WBPH').trim();
                }

                initChart(@json($dates), @json($pestData));

                window.addEventListener('chartUpdated', e => {
                    initChart(e.detail.dates, e.detail.pestData);
                });
            });
        </script>
    @endpush
</div>
