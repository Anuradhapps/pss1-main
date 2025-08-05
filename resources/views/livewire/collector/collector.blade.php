@section('title', 'Collector')

<div class="space-y-4">
    <!-- Header -->
    <div
        class="flex flex-col items-start justify-between p-4 space-y-4 rounded-md shadow-md bg-gradient-to-r from-green-700 to-green-500 md:flex-row md:items-center md:space-y-0">
        <h1 class="text-2xl font-bold tracking-wider text-white">📋 Collector Information</h1>
    </div>

    <!-- Search -->
    <x-form.input type="search" id="roles" name="query" wire:model="query" label="none"
        placeholder="🔍 Search Collector Information by Name , District , ASC or AI-RANGE">
        {{ old('query', request('query')) }}
    </x-form.input>

    <!-- Table -->
    <div class="overflow-x-auto bg-white rounded-lg shadow-md ">
        <table class="min-w-full text-sm text-left divide-y divide-gray-300 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 ">
                <tr>
                    <th class="px-4 py-2 text-white bg-red-900">
                        <a href="#" wire:click.prevent="sortBy('name')">
                            <div class="flex items-center justify-between">
                                <span class="font-semibold">Name & Data Count</span>
                                <span class="text-xs text-gray-300"> &#9650;&#9660;</span>
                            </div>

                        </a>
                    </th>
                    {{-- <th class="px-4 py-2 text-white bg-green-900">
                        <a href="#" wire:click.prevent="sortBy('regions.name')">Region</a>
                    </th> --}}
                    <th class="px-4 py-2 text-white bg-blue-900">
                        <a href="#" wire:click.prevent="sortBy('districts.name')">
                            <div class="flex items-center justify-between">
                                <span class="font-semibold">District</span>
                                <span class="text-xs text-gray-300"> &#9650;&#9660;</span>
                            </div>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-white bg-pink-900">
                        <a href="#" wire:click.prevent="sortBy('as_centers.name')">
                            <div class="flex items-center justify-between">
                                <span class="font-semibold">ASC</span>
                                <span class="text-xs text-gray-300"> &#9650;&#9660;</span>
                            </div>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-white bg-yellow-900">
                        <a href="#" wire:click.prevent="sortBy('ai_ranges.name')">
                            <div class="flex items-center justify-between">
                                <span class="font-semibold">AI Range</span>
                                <span class="text-xs text-gray-300"> &#9650;&#9660;</span>
                            </div>
                        </a>
                    </th>
                    {{-- <th class="px-4 py-2 text-white bg-teal-900">Rice Season</th> --}}
                    <th class="px-4 py-2 text-white bg-gray-900">More Info</th>
                </tr>
            </thead>

            <tbody class="divide-x divide-y divide-gray-200 ">
                @foreach ($this->collectors() as $collector)
                    <tr class="transition bg-white hover:bg-gray-100 ">
                        <!-- Name & Count -->
                        <td class="px-4 py-2 text-white bg-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div>{{ $collector->name }}</div>
                                    <div class="text-xs italic"> {{ $collector->regionName }} -
                                        {{ $collector->riceSeasonName }}</div>
                                </div>

                                <div
                                    class="ml-2 w-6 h-6 text-xs flex items-center justify-center rounded-full
                                    {{ $collector->commonDataCollect->count() == 0
                                        ? 'bg-red-500'
                                        : ($collector->commonDataCollect->count() >= 7
                                            ? 'bg-green-500'
                                            : 'bg-yellow-500') }}">
                                    {{ $collector->commonDataCollect->count() }}
                                </div>
                            </div>
                        </td>

                        <!-- Region -->
                        {{-- <td
                            class="px-4 py-2 text-white {{ $collector->regionName == 'Inter Provincial' ? 'bg-green-700' : 'bg-green-600' }}">
                            {{ $collector->regionName }}
                        </td> --}}

                        <!-- District -->
                        <td class="px-4 py-2 text-white bg-gray-700">
                            {{ $collector->dname }}
                        </td>

                        <!-- ASC -->
                        <td class="px-4 py-2 text-white bg-gray-700">
                            {{ $collector->asname }}
                        </td>

                        <!-- AI Range -->
                        <td class="px-4 py-2 text-white bg-gray-700">
                            {{ $collector->ainame }}
                        </td>

                        <!-- Rice Season -->
                        {{-- <td class="px-4 py-2 text-white bg-teal-700">
                            {{ $collector->riceSeasonName }}
                        </td> --}}

                        <!-- Action Buttons -->
                        <td class="px-4 py-2 space-x-1 text-white bg-gray-800 whitespace-nowrap">

                            {{-- Common Data Edit --}}
                            <a href="{{ route('admin.collector.edit', $collector->id) }}"
                                class="text-white inline-block px-2 py-1 text-[10px] font-semibold rounded bg-orange-500 hover:bg-orange-600 transition">
                                Collector Edit
                            </a>

                            {{-- User Edit --}}
                            <a href="{{ route('admin.users.edit', ['user' => $collector->user->id]) }}"
                                class="text-white inline-block px-2 py-1 text-[10px] font-semibold rounded bg-green-600 hover:bg-green-800 transition">
                                User Edit
                            </a>

                            {{-- Pest Data --}}
                            @php
                                $hasCommonData = $collector->commonDataCollect->count() > 0;
                            @endphp

                            <a href="{{ $hasCommonData ? route('chart.ai.show', [$collector->id, 'yes']) : 'javascript:void(0);' }}"
                                class="inline-block px-2 py-1 text-[10px] font-semibold rounded transition 
                                 {{ $hasCommonData
                                     ? 'bg-blue-600 hover:bg-blue-800 text-white'
                                     : 'bg-gray-500 text-white cursor-not-allowed pointer-events-none' }}"
                                title="{{ $hasCommonData ? 'View Pest Data' : 'Common Data Required' }}"
                                aria-disabled="{{ $hasCommonData ? 'false' : 'true' }}">
                                {{ $hasCommonData ? 'Pest Data' : 'No Pest Data' }}
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('admin.collector.destroy', $collector->id) }}" method="POST"
                                class="inline-block" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-1.5 py-0.5 text-[10px] font-semibold rounded bg-red-600 hover:bg-red-800 transition">
                                    Delete
                                </button>
                            </form>

                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="p-4">
            {{ $this->collectors()->links() }}
        </div>
    </div>
</div>

<!-- Confirm delete script -->
<script>
    function confirmDelete(event) {
        if (!confirm('Are you sure you want to delete this collector?')) {
            event.preventDefault();
        }
    }
</script>
