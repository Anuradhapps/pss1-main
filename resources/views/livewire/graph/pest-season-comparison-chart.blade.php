<div class="m-2 relative font-sans">
    
    <div class="bg-gray-900 rounded-2xl shadow-lg overflow-hidden mb-2">
    <div class="bg-gradient-to-r from-pink-600 to-emerald-600 py-2 px-4">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <h1 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                        Pest Season Comparison
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
   
        <div class="bg-white px-2 py-2 border-t border-gray-100">
             <x-pest-damage-risk-guide />
        </div>
    </div>

   <div class="bg-white p-3.5 sm:p-4 rounded-xl border border-gray-200 shadow-sm mb-4">
    <div class="flex flex-col xl:flex-row gap-5 items-start xl:items-end justify-between">
        
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 w-full xl:flex-1">
            
            <div class="relative">
                <label for="pestSelect" class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Target Pest</label>
                <select wire:model="selectedPest" wire:loading.attr="disabled" id="pestSelect"
                    class="block w-full py-2 px-3 text-sm border border-gray-300 rounded-lg bg-gray-50 text-gray-800 font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm hover:bg-white disabled:opacity-50">
                    @foreach ($pests as $key => $pest)
                        <option value="{{ $key }}">{{ $pest }}</option>
                    @endforeach
                </select>
            </div>

            <div class="relative">
                <label for="districtSelect" class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Region Filter</label>
                <select wire:model="districtId" wire:loading.attr="disabled" id="districtSelect"
                    class="block w-full py-2 px-3 text-sm border border-gray-300 rounded-lg bg-gray-50 text-gray-800 font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm hover:bg-white disabled:opacity-50">
                    <option value="0">National Average (All)</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="relative">
                <label for="seasonFilter" class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Season Alignment</label>
                <select wire:model="seasonFilter" wire:loading.attr="disabled" id="seasonFilter"
                    class="block w-full py-2 px-3 text-sm border border-gray-300 rounded-lg bg-gray-50 text-gray-800 font-medium focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-sm hover:bg-white disabled:opacity-50">
                    <option value="all">Compare All (Raw)</option>
                    <option value="yala">Yala Only (Starts March)</option>
                    <option value="maha">Maha Only (Starts October)</option>
                </select>
            </div>
        </div>

        <div class="flex flex-wrap sm:flex-nowrap items-center gap-4 w-full xl:w-auto pt-4 xl:pt-0 border-t xl:border-t-0 border-gray-100 xl:mb-0.5">
            
            <div class="flex items-center bg-gray-100 p-1 rounded-lg border border-gray-200 shrink-0">
                <button wire:click="$set('chartType', 'line')" class="flex items-center justify-center px-3 py-1.5 text-xs font-semibold rounded-md transition-all {{ $chartType === 'line' ? 'bg-white text-indigo-700 shadow-sm border border-gray-200/50' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-200/50' }}">
                    <i class="fas fa-chart-line mr-1.5"></i> Line
                </button>
                <button wire:click="$set('chartType', 'bar')" class="flex items-center justify-center px-3 py-1.5 text-xs font-semibold rounded-md transition-all {{ $chartType === 'bar' ? 'bg-white text-indigo-700 shadow-sm border border-gray-200/50' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-200/50' }}">
                    <i class="fas fa-chart-bar mr-1.5"></i> Bar
                </button>
            </div>

            <div class="hidden sm:block w-px h-8 bg-gray-200 shrink-0"></div>

            <label class="flex items-center cursor-pointer group shrink-0">
                <div class="relative flex items-center">
                    <input type="checkbox" wire:model="showTemperature" class="sr-only">
                    <div class="block w-9 h-5 bg-gray-200 rounded-full border border-gray-300 transition-colors duration-200 ease-in-out group-hover:bg-gray-300 {{ $showTemperature ? '!bg-orange-500 !border-orange-600' : '' }}"></div>
                    <div class="absolute left-0.5 top-0.5 bg-white w-4 h-4 rounded-full shadow-sm transition-transform duration-200 ease-in-out {{ $showTemperature ? 'transform translate-x-4' : '' }}"></div>
                </div>
                <span class="ml-2.5 text-xs font-semibold text-gray-600 group-hover:text-gray-900 transition-colors select-none">
                    Overlay Temp
                </span>
            </label>
            
        </div>

    </div>
</div>

    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm relative min-h-[500px] flex flex-col">
        
        <div wire:loading.flex wire:target="fetchChartData" class="absolute inset-0 z-10 bg-white/90 backdrop-blur-sm rounded-2xl flex-col items-center justify-center">
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 bg-indigo-600 rounded-full animate-bounce" style="animation-delay: -0.3s"></div>
                <div class="w-3 h-3 bg-indigo-600 rounded-full animate-bounce" style="animation-delay: -0.15s"></div>
                <div class="w-3 h-3 bg-indigo-600 rounded-full animate-bounce"></div>
            </div>
            <p class="text-gray-900 font-bold mt-4 tracking-tight">Processing Matrix Data...</p>
        </div>

        <div class="relative flex-grow w-full" wire:ignore>
            <canvas id="pestComparisonChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:load', function() {
            const ctx = document.getElementById('pestComparisonChart');
            let chart = null;

            // WCAG AAA High Contrast Palette
            const colors = [
                '#1D4ED8', // Deep Blue
                '#B91C1C', // Deep Red
                '#047857', // Deep Emerald
                '#C2410C', // Deep Orange
                '#6D28D9', // Deep Purple
                '#0E7490', // Deep Cyan
                '#BE185D', // Deep Pink
                '#4338CA', // Indigo
            ];

           function prepareChartData(pestData, currentFilter, chartType, showTemp) {
    const seasonEntries = Object.values(pestData || {});
    const maxWeeks = Math.max(...seasonEntries.map(s => s.data.length), 0);
    
    const labels = Array.from({ length: maxWeeks }, (_, i) => {
        let weekNum = i + 1;
        let label = `W${weekNum}`;
        // Adjusted slightly to align months better
        let monthOffset = Math.floor(i / 4.33); 
        
        // FIX 1: Expanded the arrays to handle extra-long seasons (up to 8+ months)
        if (currentFilter === 'yala') {
            const yalaMonths = ['Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov'];
            if(yalaMonths[monthOffset]) label += `\n(${yalaMonths[monthOffset]})`;
        } else if (currentFilter === 'maha') {
            const mahaMonths = ['Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            if(mahaMonths[monthOffset]) label += `\n(${mahaMonths[monthOffset]})`;
        }
        return label;
    });

    let datasets = seasonEntries.map((season, index) => {
        const color = colors[index % colors.length];
        return {
            label: season.name,
            data: season.data,
            type: chartType,
            borderColor: color,
            backgroundColor: chartType === 'bar' ? color : color + '1A', 
            borderWidth: 2,
            borderRadius: 4, 
            pointBackgroundColor: '#ffffff',
            pointBorderColor: color,
            pointBorderWidth: 2,
            pointRadius: chartType === 'line' ? 4 : 0,
            pointHoverRadius: 6,
            fill: true,
            tension: 0.4,
            yAxisID: 'y'
        };
    });

// Add Temperature Data if toggled
                if (showTemp && seasonEntries.length > 0) {
                    const avgTempData = Array.from({ length: maxWeeks }, (_, i) => {
                        let sum = 0; let count = 0;
                        seasonEntries.forEach(season => {
                            // Only count valid temperatures (greater than 0)
                            if(season.temperature[i] > 0) { 
                                sum += season.temperature[i]; 
                                count++; 
                            }
                        });
                        return count > 0 ? (sum / count) : null;
                    });

                    datasets.push({
                        label: 'Avg Temperature (°C)',
                        data: avgTempData,
                        type: 'line',
                        borderColor: '#F97316', 
                        backgroundColor: 'transparent',
                        borderWidth: 3,
                        borderDash: [5, 5],
                        pointRadius: 0,
                        pointHoverRadius: 5,
                        tension: 0.4,
                        yAxisID: 'yTemperature',
                        spanGaps: true // <--- THIS FIXES THE BROKEN LINE
                    });
                }

    return { labels, datasets };
}

function initChart(pestData, filterType, chartType, showTemp) {
    const { labels, datasets } = prepareChartData(pestData, filterType, chartType, showTemp);

    if (chart) {
        chart.data.labels = labels;
        chart.data.datasets = datasets;
        chart.options.scales.yTemperature.display = showTemp;
        chart.update('active'); 
        return;
    }

    chart = new Chart(ctx, {
        data: { labels, datasets },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: {
                    position: 'top',
                    labels: { font: { family: "'Inter', sans-serif", size: 14, weight: '600' }, color: '#111827', usePointStyle: true, padding: 25 }
                },
                tooltip: { /* ... your existing tooltip config ... */ }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { 
                        font: { weight: '600', size: 12 }, 
                        color: '#4B5563',
                        // FIX 2: Force Chart.js to render all labels, even if it gets crowded
                        autoSkip: false,
                        maxRotation: 0, // Keeps them flat (change to 45 if they overlap too much)
                    }
                },
                y: { /* ... your existing y axis config ... */ },
                yTemperature: { /* ... your existing yTemperature axis config ... */ }
            }
        }
    });
}

            function initChart(pestData, filterType, chartType, showTemp) {
                const { labels, datasets } = prepareChartData(pestData, filterType, chartType, showTemp);

                if (chart) {
                    chart.data.labels = labels;
                    chart.data.datasets = datasets;
                    
                    // Toggle Y-Axis visibility dynamically
                    chart.options.scales.yTemperature.display = showTemp;
                    
                    chart.update('active'); 
                    return;
                }

                chart = new Chart(ctx, {
                    data: { labels, datasets },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    font: { family: "'Inter', sans-serif", size: 14, weight: '600' },
                                    color: '#111827',
                                    usePointStyle: true,
                                    padding: 25
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(17, 24, 39, 0.95)',
                                titleFont: { family: "'Inter', sans-serif", size: 14 },
                                bodyFont: { family: "'Inter', sans-serif", size: 13 },
                                padding: 16,
                                cornerRadius: 12,
                                displayColors: true,
                                boxPadding: 6,
                                callbacks: {
                                    label: (ctx) => {
                                        if (ctx.dataset.yAxisID === 'yTemperature') {
                                            return ` Temperature: ${ctx.parsed.y.toFixed(1)} °C`;
                                        }
                                        return ` Damage Code: ${ctx.parsed.y.toFixed(1)}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { font: { weight: '600', size: 12 }, color: '#4B5563' }
                            },
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                beginAtZero: true,
                                max: 10,
                                grid: { color: '#E5E7EB', drawBorder: false },
                                ticks: { stepSize: 1, color: '#4B5563', font: { weight: '600' } },
                                title: { display: true, text: 'Damage Risk Code (0-9)', font: { weight: '700', size: 13 }, color: '#111827' }
                            },
                            yTemperature: {
                                type: 'linear',
                                display: showTemp,
                                position: 'right',
                                grid: { drawOnChartArea: false }, // Only draw grid lines for the main axis
                                ticks: { color: '#C2410C', font: { weight: '600' } },
                                title: { display: true, text: 'Temperature (°C)', font: { weight: '700', size: 13 }, color: '#C2410C' }
                            }
                        }
                    }
                });
            }

            // Initialization logic compatible with Livewire payload
            initChart(@json($pestData), @json($seasonFilter), @json($chartType), @json($showTemperature));

            window.addEventListener('chartUpdated', event => {
                const payload = event.detail[0] || event.detail; // Handle Livewire 2 & 3 quirks
                initChart(payload.pestData, payload.seasonFilter, payload.chartType, payload.showTemperature);
            });
        });
    </script>
@endpush

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
    .font-sans { font-family: 'Inter', sans-serif; }
</style>