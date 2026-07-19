@props([
    'title' => 'Pest Data Overview',
    'icon' => 'fas fa-bug',
    'labels' => [],
    'data' => [],
    'bgColor' => 'rgba(59, 130, 246, 0.7)',
    'borderColor' => 'rgba(59, 130, 246, 1)',
    'id' => 'pestChart',
])

<div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm rounded-2xl p-6 w-full transition-colors duration-300">
    <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-3 mb-6">
        <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-primary/10 dark:bg-primary/20 text-primary">
            <i class="{{ $icon }} text-lg"></i>
        </div>
        {{ $title }}
    </h2>

    <div class="h-[300px] relative w-full">
        <canvas id="{{ $id }}" class="w-full h-full"></canvas>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('{{ $id }}');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');

            const labels = {!! json_encode($labels) !!};
            const data = {!! json_encode($data) !!};
            const maxY = data.length > 0 ? Math.max(...data) + 1 : 10;

            const isDark = () => document.documentElement.classList.contains('dark');
            const getTextColor = () => isDark() ? '#94a3b8' : '#64748b'; // slate-400 / slate-500
            const getGridColor = () => isDark() ? 'rgba(248, 250, 252, 0.05)' : 'rgba(15, 23, 42, 0.05)';

            // Create Premium Gradient
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(79, 70, 229, 0.9)'); // primary (indigo-600)
            gradient.addColorStop(1, 'rgba(79, 70, 229, 0.1)'); // transparent primary

            // Destroy previous chart instance if it exists
            if (canvas.chartInstance) {
                canvas.chartInstance.destroy();
            }

            canvas.chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Pest Occurrences',
                        data: data,
                        backgroundColor: gradient,
                        borderColor: 'rgba(79, 70, 229, 1)',
                        borderWidth: 0,
                        borderRadius: { topLeft: 8, topRight: 8, bottomLeft: 0, bottomRight: 0 },
                        borderSkipped: false,
                        barPercentage: 0.5,
                        hoverBackgroundColor: 'rgba(79, 70, 229, 1)',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: maxY,
                            border: { display: false },
                            ticks: {
                                color: getTextColor(),
                                padding: 10,
                                stepSize: 1,
                                font: {
                                    family: "'Inter', sans-serif",
                                    size: 12
                                }
                            },
                            grid: {
                                color: getGridColor(),
                                drawBorder: false,
                                borderDash: [5, 5] // Dashed grid lines for premium look
                            }
                        },
                        x: {
                            border: { display: false },
                            ticks: {
                                color: getTextColor(),
                                padding: 10,
                                font: {
                                    family: "'Inter', sans-serif",
                                    size: 12,
                                    weight: '500'
                                }
                            },
                            grid: {
                                display: false,
                                drawBorder: false,
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // Hide legend since there's only one dataset
                        },
                        tooltip: {
                            backgroundColor: isDark() ? 'rgba(15, 23, 42, 0.95)' : 'rgba(255, 255, 255, 0.95)',
                            titleColor: isDark() ? '#f8fafc' : '#0f172a',
                            bodyColor: isDark() ? '#cbd5e1' : '#475569',
                            borderColor: isDark() ? '#334155' : '#e2e8f0',
                            borderWidth: 1,
                            padding: 12,
                            boxPadding: 6,
                            usePointStyle: true,
                            titleFont: {
                                size: 14,
                                family: "'Inter', sans-serif"
                            },
                            bodyFont: {
                                size: 13,
                                family: "'Inter', sans-serif"
                            },
                            callbacks: {
                                label: function(context) {
                                    return ` Count: ${context.parsed.y}`;
                                }
                            }
                        }
                    }
                }
            });

            // Update chart colors dynamically when theme changes
            const observer = new MutationObserver(() => {
                if (canvas.chartInstance) {
                    const newTextColor = getTextColor();
                    const newGridColor = getGridColor();
                    
                    canvas.chartInstance.options.scales.x.ticks.color = newTextColor;
                    canvas.chartInstance.options.scales.y.ticks.color = newTextColor;
                    canvas.chartInstance.options.scales.y.grid.color = newGridColor;
                    
                    canvas.chartInstance.options.plugins.tooltip.backgroundColor = isDark() ? 'rgba(15, 23, 42, 0.95)' : 'rgba(255, 255, 255, 0.95)';
                    canvas.chartInstance.options.plugins.tooltip.titleColor = isDark() ? '#f8fafc' : '#0f172a';
                    canvas.chartInstance.options.plugins.tooltip.bodyColor = isDark() ? '#cbd5e1' : '#475569';
                    canvas.chartInstance.options.plugins.tooltip.borderColor = isDark() ? '#334155' : '#e2e8f0';
                    
                    canvas.chartInstance.update();
                }
            });
            
            observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
        });
    </script>
</div>
