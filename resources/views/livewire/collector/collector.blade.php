@section('title', 'Collectors')
<!-- Header -->
<div class="bg-gray-800 border-b border-gray-700 p-3 mb-3">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <i class="fa-solid fa-chalkboard-user text-green-400 text-xl"></i>
            <h1 class="text-xl font-bold">Collectors</h1>
        </div>
        <div class="text-sm text-gray-400">
            {{ $this->collectors()->total() }} total collectors
        </div>
    </div>
</div>
<div class="bg-gray-900 min-h-screen text-gray-100 p-2">


    <!-- Search Bar -->
    <div class="mb-3">
        <div class="relative">
            <input type="search" wire:model="query" placeholder="Search by Name, District, ASC, or AI Range"
                class="w-full bg-gray-800 border border-gray-700 text-gray-100 px-3 py-2 text-sm focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-600 placeholder-gray-500">
            <div class="absolute right-3 top-2.5 text-gray-500">
                <i class="fas fa-search"></i>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="overflow-x-auto border border-gray-700 bg-gray-800 ">
        <table class="min-w-full divide-y divide-gray-700 text-sm bg-black">
            <thead>
                <tr class="text-xs text-gray-300 uppercase">
                    <th class="px-3 py-2 bg-gray-900 text-left">
                        <a href="#" wire:click.prevent="sortBy('name')"
                            class="flex items-center hover:text-green-400">
                            <span>Name & Data</span>
                            <span class="ml-1 text-xs">▲▼</span>
                        </a>
                    </th>
                    <th class="px-3 py-2 bg-gray-900 text-left">
                        <a href="#" wire:click.prevent="sortBy('districts.name')"
                            class="flex items-center hover:text-blue-400">
                            <span>District</span>
                            <span class="ml-1 text-xs">▲▼</span>
                        </a>
                    </th>
                    <th class="px-3 py-2 bg-gray-900 text-left">
                        <a href="#" wire:click.prevent="sortBy('as_centers.name')"
                            class="flex items-center hover:text-pink-400">
                            <span>ASC</span>
                            <span class="ml-1 text-xs">▲▼</span>
                        </a>
                    </th>
                    <th class="px-3 py-2 bg-gray-900 text-left">
                        <a href="#" wire:click.prevent="sortBy('ai_ranges.name')"
                            class="flex items-center hover:text-yellow-400">
                            <span>AI Range</span>
                            <span class="ml-1 text-xs">▲▼</span>
                        </a>
                    </th>
                    <th class="px-3 py-2 bg-gray-900 text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-900">
                @foreach ($this->collectors() as $collector)
                    <tr class="hover:bg-gray-700 transition-colors">
                        <!-- Name & Count -->
                        <td class="px-3 py-2 bg-gray-800">
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="font-medium">{{ $collector->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $collector->regionName }} -
                                        {{ $collector->riceSeasonName }}</div>
                                </div>
                                <span
                                    class="ml-2 w-5 h-5 flex items-center justify-center text-xs font-bold
                                {{ $collector->commonDataCollect->count() == 0
                                    ? 'bg-red-600'
                                    : ($collector->commonDataCollect->count() >= 7
                                        ? 'bg-green-600'
                                        : 'bg-yellow-600') }}">
                                    {{ $collector->commonDataCollect->count() }}
                                </span>
                            </div>
                        </td>

                        <!-- District -->
                        <td class="px-3 py-2 text-blue-300 bg-gray-800">{{ $collector->dname }}</td>

                        <!-- ASC -->
                        <td class="px-3 py-2 text-pink-300 bg-gray-800">{{ $collector->asname }}</td>

                        <!-- AI Range -->
                        <td class="px-3 py-2 text-yellow-300 bg-gray-800">{{ $collector->ainame }}</td>

                        <!-- Actions -->
                        <td class="px-3 bg-gray-800 py-2 text-right space-x-1 whitespace-nowrap">
                            <!-- Collector Edit -->
                            <div class="relative inline-block group">
                                <a href="{{ route('admin.collector.edit', $collector->id) }}"
                                    class="inline-block px-2 py-1 text-xs text-white bg-orange-600 hover:bg-orange-700 transition-colors"
                                    data-tooltip="Edit Collector">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <span
                                    class="absolute z-10 hidden group-hover:block px-2 py-1 text-xs text-white bg-gray-800 rounded shadow-lg bottom-full left-1/2 transform -translate-x-1/2 mb-1 whitespace-nowrap">
                                    Edit Collector
                                </span>
                            </div>

                            <!-- User Edit -->
                            <div class="relative inline-block group">
                                <a href="{{ route('admin.users.edit', ['user' => $collector->user->id]) }}"
                                    class="inline-block px-2 py-1 text-xs text-white bg-green-600 hover:bg-green-700 transition-colors"
                                    data-tooltip="Edit User">
                                    <i class="fas fa-user-edit"></i>
                                </a>
                                <span
                                    class="absolute z-10 hidden group-hover:block px-2 py-1 text-xs text-white bg-gray-800 rounded shadow-lg bottom-full left-1/2 transform -translate-x-1/2 mb-1 whitespace-nowrap">
                                    Edit User
                                </span>
                            </div>

                            <!-- Pest Data -->
                            @php $hasCommonData = $collector->commonDataCollect->count() > 0; @endphp
                            <div class="relative inline-block group">
                                <a href="{{ $hasCommonData ? route('chart.ai.show', [$collector->id, 'yes']) : '#' }}"
                                    class="inline-block px-2 py-1 text-xs text-white
                                {{ $hasCommonData ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-600 cursor-not-allowed' }} transition-colors"
                                    {{ !$hasCommonData ? 'disabled' : '' }}
                                    data-tooltip="{{ $hasCommonData ? 'View Pest Data' : 'No Data Available' }}">
                                    <i class="fas fa-chart-line"></i>
                                </a>
                                <span
                                    class="absolute z-10 hidden group-hover:block px-2 py-1 text-xs text-white bg-gray-800 rounded shadow-lg bottom-full left-1/2 transform -translate-x-1/2 mb-1 whitespace-nowrap">
                                    {{ $hasCommonData ? 'View Pest Data' : 'No Data Available' }}
                                </span>
                            </div>

                            <!-- Delete -->
                            <div class="relative inline-block group">
                                <form action="{{ route('admin.collector.destroy', $collector->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to delete this collector?')"
                                        class="inline-block px-2 py-1 text-xs text-white bg-red-600 hover:bg-red-700 transition-colors"
                                        data-tooltip="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <span
                                    class="absolute z-10 hidden group-hover:block px-2 py-1 text-xs text-white bg-gray-800 rounded shadow-lg bottom-full left-1/2 transform -translate-x-1/2 mb-1 whitespace-nowrap">
                                    Delete Collector
                                </span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-3 border-t border-gray-700 pt-3">
        {{ $this->collectors()->links() }}
    </div>
</div>
