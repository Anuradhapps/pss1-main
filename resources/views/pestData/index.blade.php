<x-app-layout>
    <!-- Header -->
    <div class="p-4 bg-green-900 shadow flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <i class="fas fa-bug text-2xl text-green-400"></i>
            <h1 class="text-2xl font-bold text-white">Pest Data Overview</h1>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('pestdata.create', $collectorId) }}"
                class="inline-flex items-center px-4 py-2 bg-blue-700 hover:bg-blue-900 text-sm font-medium text-white rounded shadow transition">
                <i class="fas fa-plus mr-2"></i> Add Pest Data
            </a>

            <a href="{{ route('collector.index') }}"
                class="inline-flex items-center px-4 py-2 bg-red-700 hover:bg-red-900 text-sm font-medium text-white rounded shadow transition">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>
    </div>

    <div class="p-3 sm:p-6">
        <x-success-massage />
        <x-error-massage />

        <!-- Collector Info Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            @foreach ([['fas fa-user', 'bg-red-700', 'Collector Name', $collector->user->name], ['fas fa-map-marker-alt', 'bg-blue-700', 'Location', $collector->getAiRange->name], ['fas fa-seedling', 'bg-green-700', 'Rice Variety', $collector->rice_variety], ['fas fa-database', 'bg-yellow-700', 'Number of Data Uploads This Season', $CommonData->count()]] as [$icon, $iconColor, $label, $value])
                <div
                    class="flex items-center gap-4 p-4 bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                    <div
                        class="flex items-center justify-center w-12 h-12 {{ $iconColor }} rounded-full flex-shrink-0">
                        <i class="{{ $icon }} text-white text-xl"></i>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:justify-between w-full">
                        <div class="font-semibold text-gray-300">{{ $label }}</div>
                        <div class="text-green-400 font-medium break-words mt-1 sm:mt-0">{{ $value }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Main Content -->
        <div class="flex flex-col lg:flex-row gap-4">
            <!-- Pest Data Uploads -->
            <div class="w-full lg:w-2/3 grid gap-3">
                <h2 class="text-lg font-semibold text-white mb-2">Data Uploads</h2>

                @forelse ($CommonData as $row)
                    <div
                        class="bg-gray-800 hover:bg-gray-950 border border-gray-700 text-white p-4 rounded-lg shadow flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 transition-all duration-300">
                        <!-- Date Info -->
                        <div class="flex flex-col gap-1 text-gray-400 text-sm">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-calendar-alt text-yellow-400"></i>
                                <span>Created: {{ $row->created_at }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-calendar-day text-green-400"></i>
                                <span>Collected: {{ $row->c_date }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-2 mt-2 sm:mt-0">
                            <a href="{{ route('pestdata.show', $row->id) }}"
                                class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-blue-700 hover:bg-blue-900 rounded transition">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <form action="{{ route('pestdata.destroy', $row->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-red-700 hover:bg-red-900 rounded transition">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-gray-800 text-gray-400 text-center p-6 rounded-lg">
                        <i class="fas fa-exclamation-circle text-yellow-400"></i> No pest data available.
                    </div>
                @endforelse
            </div>

            <!-- Chart Section -->
            <div class="w-full lg:w-1/3">
                <x-charts.collector-pest-chart
                    title="{{ $collector->getAiRange->name }} - {{ $collector->riceSeason->name }} Season"
                    :labels="$pestLabels" :data="$pestCode" icon="fas fa-chart-bar" id="weeklyPestChart" />
            </div>
        </div>
    </div>
</x-app-layout>
