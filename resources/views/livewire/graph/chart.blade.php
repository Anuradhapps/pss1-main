<div class="mx-auto p-4 md:p-3 bg-white ">
    <!-- Header & Filters -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-4 gap-4">
        <div>
            <h1 class="text-xl md:text-3xl font-bold text-gray-900">Pest Monitoring Dashboard</h1>
            <p class="text-sm md:text-base text-gray-600">Track and analyze pest activity patterns in rice fields</p>
        </div>

        <!-- District Selector - Modern Dropdown -->
        <div class="relative w-full sm:w-56">
            <label for="districtSelect" class="block text-sm font-medium text-gray-700 mb-1">District</label>
            <div class="relative">
                <select wire:model="districtId" id="districtSelect"
                    class="text-black block w-full pl-4 pr-10 py-2.5 text-base border border-gray-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 appearance-none">
                    <option value="0">All Districts</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <!-- Season Selector - Modern Pill Tabs -->
    <div class="w-full sm:w- mb-4">
        <div class="relative">
            <div
                class="flex justify-center flex-wrap gap-1 overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                <button type="button" wire:click="$set('selectedSeason', '0')"
                    class="px-4 py-2 text-sm font-medium rounded-full whitespace-nowrap transition-all duration-200
                            @if ($selectedSeason == '0') bg-indigo-600 text-white shadow-md @else bg-white text-gray-700 hover:bg-gray-100 border border-gray-300 @endif">
                    All Seasons
                </button>

                @foreach ($seasons as $season)
                    <button type="button" wire:click="$set('selectedSeason', '{{ $season->id }}')"
                        class="px-4 py-2 text-sm font-medium rounded-full whitespace-nowrap transition-all duration-200
                                @if ($selectedSeason == $season->id) bg-indigo-600 text-white shadow-md @else bg-white text-gray-700 hover:bg-gray-100 border border-gray-300 @endif">
                        {{ $season->name }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Metrics Dashboard - Modern Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <!-- Time Period Card -->
        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-4 shadow-sm border border-indigo-100">
            <div class="flex items-center space-x-4">
                <div class="p-2.5 rounded-lg bg-white shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-indigo-800 uppercase tracking-wider">Time Period</p>
                    <p class="text-sm font-semibold text-gray-900 mt-0.5">
                        @if (count($dates) > 0)
                            {{ \Carbon\Carbon::parse($dates[0])->format('M d, Y') }} -
                            {{ \Carbon\Carbon::parse(end($dates))->addDays(7)->format('M d, Y') }}
                        @else
                            No data available
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Data Points Card -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 shadow-sm border border-green-100">
            <div class="flex items-center space-x-4">
                <div class="p-2.5 rounded-lg bg-white shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-green-800 uppercase tracking-wider">Data Points</p>
                    <p class="text-sm font-semibold text-gray-900 mt-0.5">
                        {{ count($dates) }} {{ \Illuminate\Support\Str::plural('week', count($dates)) }} tracked
                    </p>
                </div>
            </div>
        </div>

        <!-- Pests Tracked Card -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 shadow-sm border border-purple-100">
            <div class="flex items-center space-x-4">
                <div class="p-2.5 rounded-lg bg-white shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-purple-800 uppercase tracking-wider">Pest Species</p>
                    <p class="text-sm font-semibold text-gray-900 mt-0.5">
                        {{ count($pestData) }} species monitored
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading State with Animation -->
    @if ($isLoading)
        <div class="flex flex-col items-center justify-center p-8 bg-gray-50 rounded-xl border border-gray-200">
            <div class="relative w-12 h-12 mb-4">
                <div class="absolute inset-0 rounded-full border-4 border-indigo-500 border-t-transparent animate-spin">
                </div>
                <div
                    class="absolute inset-1 rounded-full border-4 border-indigo-300 border-b-transparent animate-spin animation-delay-150">
                </div>
            </div>
            <p class="text-gray-600 font-medium">Loading pest monitoring data...</p>
            <p class="text-sm text-gray-500 mt-1">This may take a moment</p>
        </div>
    @endif

    <!-- Chart Section with Enhanced UI -->
    <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm overflow-hidden">
        <!-- Chart Canvas with Glass Morphism Effect -->
        <div class="relative h-80 w-full bg-gradient-to-br from-gray-50 to-white rounded-lg overflow-hidden">
            <div class="absolute inset-0 backdrop-blur-sm bg-white/30 z-10 flex items-center justify-center"
                id="chartOverlay" style="display: none;">
                <div class="text-center p-6 bg-white/90 rounded-xl shadow-lg border border-gray-200 max-w-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-600 mx-auto mb-3"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="font-semibold text-gray-900 mb-1">Interactive Chart</h3>
                    <p class="text-sm text-gray-600">Hover over data points for details. Click legend items to toggle
                        visibility.</p>
                </div>
            </div>
            <canvas id="pestChart" wire:ignore></canvas>
        </div>

        <!-- Enhanced Chart Controls -->
        <div class="mt-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div class="flex items-center space-x-2 text-xs text-gray-600">
                <button type="button" onclick="toggleChartHelp()"
                    class="p-1.5 rounded-full hover:bg-gray-100 transition" title="Chart Help">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>
                <span class="hidden sm:inline">Hover for details • Click legend to toggle • Ctrl+Scroll to zoom •
                    Shift+Drag to pan</span>
            </div>

            <div class="flex space-x-2">
                <button type="button" onclick="resetZoom()"
                    class="flex items-center space-x-1 px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                    </svg>
                    <span>Reset View</span>
                </button>

                <button type="button" onclick="exportChart()"
                    class="flex items-center space-x-1 px-3 py-1.5 bg-indigo-600 border border-indigo-700 rounded-lg text-sm font-medium text-white hover:bg-indigo-700 transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Export</span>
                </button>
            </div>
        </div>

        <!-- Pest Damage Risk Guide - Modern Accordion -->
        <div class="mt-6 bg-indigo-50/50 rounded-xl border border-indigo-200 overflow-hidden">
            <div class="flex items-center justify-between p-3 cursor-pointer" onclick="toggleRiskGuide()">
                <h3 class="text-sm font-semibold text-indigo-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 mr-2 text-indigo-600 transition-transform duration-200" id="riskGuideIcon"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    Pest Damage Risk Level Guide
                </h3>
                <span class="text-xs font-medium text-indigo-600 bg-indigo-100 px-2 py-1 rounded-full">Click to
                    expand</span>
            </div>

            <div class="px-4 pb-3 pt-0 border-t border-indigo-100" id="riskGuideContent" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mt-2">
                    <div class="bg-white p-3 rounded-lg border border-green-200 shadow-xs">
                        <div class="flex items-center space-x-2">
                            <span
                                class="flex items-center justify-center h-6 w-6 rounded-full bg-green-100 text-green-800 font-bold text-sm">0-1</span>
                            <span class="text-sm font-medium text-gray-900">No damage risk</span>
                        </div>
                        <p class="text-xs text-gray-600 mt-1">Normal pest population, no action needed</p>
                    </div>

                    <div class="bg-white p-3 rounded-lg border border-yellow-200 shadow-xs">
                        <div class="flex items-center space-x-2">
                            <span
                                class="flex items-center justify-center h-6 w-6 rounded-full bg-yellow-100 text-yellow-800 font-bold text-sm">3</span>
                            <span class="text-sm font-medium text-gray-900">Alert level</span>
                        </div>
                        <p class="text-xs text-gray-600 mt-1">Close observation recommended</p>
                    </div>

                    <div class="bg-white p-3 rounded-lg border border-orange-200 shadow-xs">
                        <div class="flex items-center space-x-2">
                            <span
                                class="flex items-center justify-center h-6 w-6 rounded-full bg-orange-100 text-orange-800 font-bold text-sm">5</span>
                            <span class="text-sm font-medium text-gray-900">Economic threshold</span>
                        </div>
                        <p class="text-xs text-gray-600 mt-1">Pest control suggested</p>
                    </div>

                    <div class="bg-white p-3 rounded-lg border border-red-200 shadow-xs">
                        <div class="flex items-center space-x-2">
                            <span
                                class="flex items-center justify-center h-6 w-6 rounded-full bg-red-100 text-red-800 font-bold text-sm">7-9</span>
                            <span class="text-sm font-medium text-gray-900">Critical level</span>
                        </div>
                        <p class="text-xs text-gray-600 mt-1">Immediate action required</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@2.0.1"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    <script>
        document.addEventListener('livewire:load', function() {
            const ctx = document.getElementById('pestChart');
            let chart = null;

            // Modern color palette with better contrast
            const colors = [{
                    bg: 'rgba(79, 70, 229, 0.1)',
                    border: '#4F46E5',
                    hover: '#3E36C7'
                }, // indigo
                {
                    bg: 'rgba(220, 38, 38, 0.1)',
                    border: '#DC2626',
                    hover: '#C52222'
                }, // red
                {
                    bg: 'rgba(5, 150, 105, 0.1)',
                    border: '#059669',
                    hover: '#047857'
                }, // emerald
                {
                    bg: 'rgba(217, 119, 6, 0.1)',
                    border: '#D97706',
                    hover: '#B65D04'
                }, // amber
                {
                    bg: 'rgba(124, 58, 237, 0.1)',
                    border: '#7C3AED',
                    hover: '#6B28D9'
                }, // purple
                {
                    bg: 'rgba(219, 39, 119, 0.1)',
                    border: '#DB2777',
                    hover: '#BE185D'
                }, // pink
                {
                    bg: 'rgba(13, 148, 136, 0.1)',
                    border: '#0D9488',
                    hover: '#0F766E'
                }, // teal
                {
                    bg: 'rgba(234, 88, 12, 0.1)',
                    border: '#EA580C',
                    hover: '#C2410C'
                }, // orange
            ];

            function initChart(dates, pestData) {
                if (chart) chart.destroy();

                const datasets = Object.entries(pestData).map(([pest, data], i) => {
                    const colorIndex = i % colors.length;
                    const pestName = formatPestName(pest);

                    return {
                        label: pestName,
                        data: data,
                        backgroundColor: colors[colorIndex].bg,
                        borderColor: colors[colorIndex].border,
                        borderWidth: 2.5,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: colors[colorIndex].border,
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointHoverBorderWidth: 3,
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: colors[colorIndex].hover,
                        tension: 0.3,
                        fill: true,
                        borderDash: i > 3 ? [4, 4] : [], // Add dashes to lines after 4th dataset
                    };
                });

                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dates.map(d => formatDateLabel(d)),
                        datasets,
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
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
                                    label: ctx => {
                                        const label = ctx.dataset.label || '';
                                        const value = ctx.parsed.y;
                                        let riskLevel = '';

                                        if (value >= 7) riskLevel = ' (Critical)';
                                        else if (value >= 5) riskLevel = ' (Threshold)';
                                        else if (value >= 3) riskLevel = ' (Alert)';

                                        return `${label}: ${value}${riskLevel}`;
                                    },
                                    title: ctx => `Week of ${ctx[0].label}`,
                                    footer: ctx => {
                                        const value = ctx[0].parsed.y;
                                        if (value >= 7) return 'Action: Immediate treatment required';
                                        if (value >= 5) return 'Action: Consider pest control measures';
                                        if (value >= 3) return 'Action: Monitor closely';
                                        return 'Action: No treatment needed';
                                    }
                                },
                                footerFontStyle: 'normal',
                                footerMarginTop: 10,
                            },
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    font: {
                                        size: 13,
                                        family: 'Inter'
                                    },
                                    generateLabels: chart => {
                                        return chart.data.datasets.map((ds, i) => ({
                                            text: ds.label,
                                            fillStyle: ds.borderColor,
                                            strokeStyle: ds.borderColor,
                                            hidden: !chart.isDatasetVisible(i),
                                            index: i,
                                            fontColor: '#111827',
                                            lineWidth: 2,
                                        }));
                                    },
                                },
                                onClick: (e, legendItem, legend) => {
                                    const meta = legend.chart.getDatasetMeta(legendItem.index);
                                    meta.hidden = meta.hidden === null ? !legend.chart.data.datasets[
                                        legendItem.index].hidden : null;
                                    legend.chart.update();
                                },
                                onHover: (e, legendItem, legend) => {
                                    e.native.target.style.cursor = 'pointer';
                                },
                                onLeave: (e, legendItem, legend) => {
                                    e.native.target.style.cursor = 'default';
                                },
                            },
                            zoom: {
                                pan: {
                                    enabled: true,
                                    mode: 'x',
                                    modifierKey: 'shift',
                                },
                                zoom: {
                                    wheel: {
                                        enabled: true,
                                        modifierKey: 'ctrl',
                                    },
                                    pinch: {
                                        enabled: true
                                    },
                                    mode: 'x',
                                    speed: 0.1,
                                },
                                limits: {
                                    x: {
                                        minRange: 5
                                    }
                                }
                            }
                        },
                        interaction: {
                            mode: 'nearest',
                            axis: 'x',
                            intersect: false,
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 9,
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
                                    padding: 10,
                                    stepSize: 1,
                                    callback: function(value) {
                                        if (value === 0) return '0 - None';
                                        if (value === 3) return '3 - Alert';
                                        if (value === 5) return '5 - Threshold';
                                        if (value === 7) return '7 - Critical';
                                        if (value === 9) return '9 - Severe';
                                        return '';
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Pest Risk Level',
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
                                }
                            },
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false,
                                },
                                ticks: {
                                    font: {
                                        size: 12,
                                        family: 'Inter'
                                    },
                                    maxRotation: 45,
                                    minRotation: 0,
                                    padding: 10,
                                    autoSkip: true,
                                    maxTicksLimit: 12
                                },
                                title: {
                                    display: true,
                                    text: 'Week Starting Date',
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
                                }
                            }
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
                        },
                        animation: {
                            duration: 1000,
                            easing: 'easeOutQuart'
                        },
                        onHover: (event, chartElements) => {
                            if (chartElements.length > 0) {
                                document.getElementById('chartOverlay').style.display = 'none';
                            }
                        },
                    }
                });

                // Show help overlay initially
                setTimeout(() => {
                    if (chart && !localStorage.getItem('chartHelpShown')) {
                        document.getElementById('chartOverlay').style.display = 'flex';
                        localStorage.setItem('chartHelpShown', 'true');
                    }
                }, 1500);
            }

            // Helper functions
            function formatPestName(pest) {
                return pest
                    .replace(/([A-Z])/g, ' $1')
                    .replace(/^./, s => s.toUpperCase())
                    .replace('Bph Wbph', 'BPH/WBPH')
                    .replace('Thrips', 'Thrips ')
                    .trim();
            }

            function formatDateLabel(dateStr) {
                const dt = new Date(dateStr);
                return dt.toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric',
                });
            }

            // UI Functions
            window.toggleRiskGuide = function() {
                const content = document.getElementById('riskGuideContent');
                const icon = document.getElementById('riskGuideIcon');
                if (content.style.display === 'none') {
                    content.style.display = 'block';
                    icon.style.transform = 'rotate(90deg)';
                } else {
                    content.style.display = 'none';
                    icon.style.transform = 'rotate(0deg)';
                }
            };

            window.toggleChartHelp = function() {
                const overlay = document.getElementById('chartOverlay');
                overlay.style.display = overlay.style.display === 'none' ? 'flex' : 'none';
            };

            window.resetZoom = function() {
                if (chart) chart.resetZoom();
            };

            window.exportChart = function() {
                if (!chart) return;

                // Create a temporary canvas with higher resolution
                const tempCanvas = document.createElement('canvas');
                tempCanvas.width = 2000;
                tempCanvas.height = 1200;
                const tempCtx = tempCanvas.getContext('2d');

                // White background
                tempCtx.fillStyle = '#ffffff';
                tempCtx.fillRect(0, 0, tempCanvas.width, tempCanvas.height);

                // Draw chart with higher resolution
                tempCtx.drawImage(chart.canvas, 0, 0, tempCanvas.width, tempCanvas.height);

                // Convert to image and download
                const link = document.createElement('a');
                link.download = 'pest-monitoring-chart-' + new Date().toISOString().slice(0, 10) + '.png';
                link.href = tempCanvas.toDataURL('image/png');
                link.click();
            };

            // Initialize chart with initial data
            initChart(@json($dates), @json($pestData));

            // Listen for Livewire updates
            window.addEventListener('chartUpdated', e => {
                initChart(e.detail.dates, e.detail.pestData);
            });
        });
    </script>
@endpush

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');

    body {
        font-family: 'Inter', sans-serif;
    }

    /* Custom scrollbar */
    .scrollbar-thin::-webkit-scrollbar {
        height: 4px;
        width: 4px;
    }

    .scrollbar-thin::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }

    /* Animation delay for loading spinner */
    .animation-delay-150 {
        animation-delay: 0.15s;
    }

    /* Smooth transitions */
    .transition-all {
        transition-property: all;
    }

    .duration-200 {
        transition-duration: 200ms;
    }

    /* Hide scrollbar but allow scrolling */
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
