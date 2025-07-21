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
    <h2 class="text-xl font-semibold flex items-center gap-3 mb-4 text-white">
        <i class="{{ $icon }} text-blue-400 text-2xl"></i> {{ $title }}
    </h2>

    <div class="h-[300px] relative">
        <canvas id="{{ $id }}" class="w-full h-full"></canvas>
    </div>

    <script>
        (function() {
            const canvas = document.getElementById('{{ $id }}');
            const ctx = canvas.getContext('2d');

            // Prevent growing chart bug
            if (canvas.chartInstance) {
                canvas.chartInstance.destroy();
            }

            canvas.chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [{
                        label: 'Pest Count',
                        data: {!! json_encode($data) !!},
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
                            ticks: {
                                color: '#d1d5db' // Tailwind gray-300
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
                                color: '#e5e7eb' // Tailwind gray-200
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1f2937', // Tailwind gray-800
                            titleColor: '#fff',
                            bodyColor: '#d1d5db'
                        }
                    }
                }
            });
        })();
    </script>
</div>
