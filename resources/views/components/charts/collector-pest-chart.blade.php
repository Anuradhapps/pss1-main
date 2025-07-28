@props([
    'title' => 'Pest Data Overview',
    'icon' => 'fas fa-bug',
    'labels' => [],
    'data' => [],
    'bgColor' => 'rgba(59, 130, 246, 0.7)',
    'borderColor' => 'rgba(59, 130, 246, 1)',
    'id' => 'pestChart',
])

<div class="bg-gray-900 border border-gray-700 shadow-lg p-6 w-full max-w-4xl mx-auto text-white">
    <h2 class="text-xl font-semibold flex items-center gap-3 mb-4">
        <i class="{{ $icon }} text-blue-400 text-2xl"></i> {{ $title }}
    </h2>

    <div class="h-[300px] relative">
        <canvas id="{{ $id }}" class="w-full h-full"></canvas>
    </div>

    <script>
        (function() {
            const canvas = document.getElementById('{{ $id }}');
            const ctx = canvas.getContext('2d');

            const labels = {!! json_encode($labels) !!};
            const data = {!! json_encode($data) !!};
            const maxY = Math.max(...data) + 1;

            // Destroy previous chart instance if it exists
            if (canvas.chartInstance) {
                canvas.chartInstance.destroy();
            }

            canvas.chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Pest Code',
                        data: data,
                        backgroundColor: '{{ $bgColor }}',
                        borderColor: '{{ $borderColor }}',
                        borderWidth: 1,
                        borderRadius: 6,
                        barPercentage: 0.6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: maxY,
                            ticks: {
                                color: '#d1d5db',
                                stepSize: 1
                            },
                            grid: {
                                color: 'rgba(255,255,255,0.1)'
                            }
                        },
                        x: {
                            ticks: {
                                color: '#d1d5db'
                            },
                            grid: {
                                color: 'rgba(255,255,255,0.05)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: '#e5e7eb'
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            titleColor: '#fff',
                            bodyColor: '#d1d5db'
                        }
                    }
                }
            });
        })();
    </script>
</div>
