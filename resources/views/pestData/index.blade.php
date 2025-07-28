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

                <a href="{{ route('collector.index') }}"
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
        <div
            class="flex flex-col sm:flex-row justify-start sm:gap-4 gap-2 text-white mb-4 border-b border-green-500 sm:pb-2 pb-4">
            @foreach ([['fas fa-user', 'bg-red-700', 'Collector Name', $collector->user->name], ['fas fa-map-marker-alt', 'bg-blue-700', 'Location', $collector->getAiRange->name], ['fas fa-seedling', 'bg-green-700', 'Rice Variety', $collector->rice_variety], ['fas fa-database', 'bg-yellow-700', 'Number of Data Uploads This Season', $CommonData->count()]] as [$icon, $iconColor, $label, $value])
                @php

                    preg_match('/^(bg-[a-z]+-)(\d{3})$/', $iconColor, $matches);
                    $lighterColor = isset($matches[2]) ? $matches[1] . ((int) $matches[2] + 200) : $iconColor;
                @endphp

                <div class="flex items-center gap-2 p-2 sm:p-4 pe-8 {{ $lighterColor }}">
                    <div class="flex items-center justify-center w-10 h-10 {{ $iconColor }} rounded-full">
                        <i class="{{ $icon }} text-white text-lg"></i>
                    </div>
                    <div class="text-sm flex sm:flex-col flex-row">
                        <div class=" pe-1 font-bold">{{ $label }}: {{-- <i class="fas fa-play"></i> --}}
                        </div>

                        <div class="text-blue-400 p-0">{{ $value }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex flex-col lg:flex-row gap-4 items-start">
            <!-- Pest Data Cards -->

            <div class="w-full lg:w-2/3 grid grid-cols-1 gap-3 border-b sm:border-none border-green-500 pb-4">
                <h1 class="text-lg text-white">Data Uploads</h1>
                @forelse ($CommonData as $row)
                    <div
                        class="bg-gray-800 hover:bg-gray-950 border border-gray-800 text-white p-3 shadow hover:shadow-xl transition flex justify-between items-start gap-4">
                        <!-- Date Info -->
                        <div>
                            <div class="flex items-center gap-2 mb-2 text-gray-400 text-sm">
                                <i class="fas fa-calendar-alt text-yellow-400"></i>
                                <span>Created: {{ $row->created_at }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-gray-400 text-sm">
                                <i class="fas fa-calendar-day text-green-400"></i>
                                <span>Collected: {{ $row->c_date }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('pestdata.show', $row->id) }}"
                                class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-blue-700 hover:bg-blue-900">
                                <i class="fas fa-eye pe-1"></i> View
                            </a>
                            <form action="{{ route('pestdata.destroy', $row->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this?')" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-red-700 hover:bg-red-900">
                                    <i class="fas fa-trash-alt pe-1"></i> Delete
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

            <!-- Chart Section -->
            <div class="w-full lg:w-1/3">
                <x-charts.collector-pest-chart title="My Data in {{ $collector->riceSeason->name }} Season"
                    :labels="$pestLabels" :data="$pestCode" icon="fas fa-chart-bar" id="weeklyPestChart" />
            </div>
        </div>


    </div>
</x-app-layout>
