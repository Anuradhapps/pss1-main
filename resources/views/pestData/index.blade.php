<x-app-layout>
    <!-- Header -->
    <div class="p-4 bg-green-700 shadow">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <i class="fas fa-bug text-2xl text-white"></i>
                <h1 class="text-2xl font-bold text-white">Pest Data Overview</h1>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('pestdata.create', $collectorId) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-700 hover:bg-blue-900 text-sm font-medium text-white rounded shadow">
                    <i class="fas fa-plus mr-2"></i> Add Pest Data
                </a>
                <a href="{{ route('pestdata.create', $collectorId) }}"
                    class="inline-flex items-center px-4 py-2 bg-red-700 hover:bg-red-900 text-sm font-medium text-white rounded shadow">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
            </div>
        </div>
    </div>

    <div class="p-2">
        <x-success-massage />
        <x-error-massage />

        <!-- Collector Info -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-white mb-6 ">
            @foreach ([['fas fa-user', 'Collector Name', $collector->user->name], ['fas fa-map-marker-alt', 'Location', $collector->getAiRange->name], ['fas fa-seedling', 'Rice Variety', $collector->rice_variety]] as [$icon, $label, $value])
                <div class="flex items-center gap-2 bg-orange-600 p-2 rounded">
                    <div class="flex items-center justify-center w-10 h-10 bg-green-700 rounded-full">
                        <i class="{{ $icon }} text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-300 p-0">{{ $label }}</p>
                        <p class="text-base font-semibold text-white p-0">{{ $value }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex flex-col">
            <!-- Pest Data Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($CommonData as $row)
                    <div
                        class="bg-gray-800 border border-gray-800 text-white p-4 rounded-lg shadow hover:shadow-xl transition">
                        <div class="flex items-center gap-2 mb-2 text-gray-400 text-sm">
                            <i class="fas fa-calendar-alt text-yellow-400"></i>
                            <span>Created: {{ $row->created_at }}</span>
                        </div>
                        <div class="flex items-center gap-2 mb-4 text-gray-400 text-sm">
                            <i class="fas fa-calendar-day text-green-400"></i>
                            <span>Collected: {{ $row->c_date }}</span>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('pestdata.show', $row->id) }}"
                                class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-blue-600 hover:bg-blue-700 rounded">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <form action="{{ route('pestdata.destroy', $row->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this?')" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-red-600 hover:bg-red-700 rounded">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-gray-800 text-gray-400 text-center p-6 rounded">
                        <i class="fas fa-exclamation-circle text-yellow-400"></i> No pest data available.
                    </div>
                @endforelse
            </div>

            <!-- Chart -->
            <div class="mt-6">
                <x-charts.collector-pest-chart title="Pest Data This Week" :labels="['Pest A', 'Pest B', 'Pest C', 'PEST D']" :data="[10, 5, 8, 9]"
                    icon="fas fa-chart-bar" id="weeklyPestChart" />
            </div>
        </div>

    </div>
</x-app-layout>
