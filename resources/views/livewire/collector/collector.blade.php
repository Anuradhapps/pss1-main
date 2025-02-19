@section('title', 'Collector')
<div class="p-2 bg-slate-500">
    <h1 class="px-1 py-3 mb-3 text-2xl font-bold text-gray-300 bg-gray-700">Collectors</h1>
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="grid flex-grow gap-4 sm:grid-cols-1 md:grid-cols-4">
            <div class="col-span-2 py-2">
                <x-form.input type="search" id="roles" name="query" wire:model="query" label="none"
                    placeholder="Search Collector Information">
                    {{ old('query', request('query')) }}
                </x-form.input>
            </div>
        </div>

        <livewire:count-card :cardName="'Collectors'" :iconName="'fas fa-users'" :color="'from-purple-900 to-purple-700'" />
    </div>



    <div class="overflow-x-auto">
        <table>
            <thead>
                <tr>
                    <th class="bg-red-700 dark:bg-red-900">
                        <a href="#" wire:click.prevent="sortBy('name')">Name</a>
                    </th>
                    {{-- <th>
                        <a href="#" wire:click.prevent="sortBy('email')">Email</a>
                    </th> --}}
                    {{-- <th>
                        <a href="#" wire:click.prevent="sortBy('phone_no')">Phone No.</a>
                    </th> --}}
                    <th class="bg-green-700 dark:bg-green-900">
                        <a href="#" wire:click.prevent="sortBy('regions.name')">Region</a>
                    </th>
                    <th class="bg-blue-700 dark:bg-blue-900">
                        <a href="#" wire:click.prevent="sortBy('districts.name')">District</a>
                    </th>
                    <th class="bg-pink-700 dark:bg-pink-900">
                        <a href="#" wire:click.prevent="sortBy('as_centers.name')"> ASC</a>
                    </th>
                    <th class="bg-yellow-700 dark:bg-yellow-900">
                        <a href="#" wire:click.prevent="sortBy('ai_ranges.name')"> AI Range</a>
                    </th>

                    <th class="bg-purple-700 dark:bg-purple-900">
                        Village
                    </th>
                    <th class="bg-teal-700 dark:bg-teal-900">
                        Rice Season
                    </th>
                    {{-- <th>
                        <a href="#" wire:click.prevent="sortBy('rice_variety')"> Rice Variety</a>
                    </th>
                    <th>
                        <a href="#" wire:click.prevent="sortBy('gps_lati')"> Latitude</a>
                    </th>
                    <th>
                        <a href="#" wire:click.prevent="sortBy('gps_long')"> Longitude</a>
                    </th>

                    <th>
                        <a href="#" wire:click.prevent="sortBy('date_establish')">Date Establish</a>
                    </th> --}}
                    <th>
                        More info.
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->collectors() as $collector)
                    <tr>

                        <td class="bg-red-200 dark:bg-red-700">
                            <div class="flex justify-between">
                                <div>{{ $collector->name }} </div>
                                @if ($collector->commonDataCollect->count() == 0)
                                    <div
                                        class="inline-flex items-center justify-center w-6 h-6 text-white bg-red-500 rounded-full ms-2">
                                        {{ $collector->commonDataCollect->count() }}
                                    </div>
                                @elseif ($collector->commonDataCollect->count() >= 7)
                                    <div
                                        class="inline-flex items-center justify-center w-6 h-6 text-white bg-green-500 rounded-full ms-2">
                                        {{ $collector->commonDataCollect->count() }}
                                    </div>
                                @else
                                    <div
                                        class="inline-flex items-center justify-center w-6 h-6 text-white bg-yellow-500 rounded-full ms-2">
                                        {{ $collector->commonDataCollect->count() }}
                                    </div>
                                @endif


                            </div>
                        </td>
                        {{-- <td> {{ $collector->email }}</td> --}}
                        {{-- <td> {{ $collector->phone_no }}</td> --}}
                        @if ($collector->regionName == 'Inter Provincial')
                            <td class="bg-green-300 dark:bg-green-700"> {{ $collector->regionName }}</td>
                        @else
                            <td class="bg-green-200 dark:bg-green-600"> {{ $collector->regionName }}</td>
                        @endif

                        <td class="bg-blue-200 dark:bg-blue-700"> {{ $collector->dname }}</td>
                        <td class="bg-pink-200 dark:bg-pink-700"> {{ $collector->asname }}</td>
                        <td class="bg-yellow-200 dark:bg-yellow-700"> {{ $collector->ainame }}</td>
                        <td class="bg-purple-200 dark:bg-purple-700"> {{ $collector->village }}</td>
                        <td class="bg-teal-200 dark:bg-teal-700"> {{ $collector->riceSeasonName }}</td>
                        {{-- <td> {{ $collector->rice_variety }}</td>
                        <td> {{ $collector->gps_lati }}</td>
                        <td> {{ $collector->gps_long }}</td>
                        <td> {{ $collector->date_establish }}</td> --}}
                        <td> <a href="{{ route('admin.collector.edit', $collector->id) }}"
                                class="px-2 py-1 text-sm font-bold text-white bg-orange-400 rounded me-1 hover:bg-orange-500">
                                Edit
                            </a>
                            <a href="{{ route('chart.ai.show', $collector->id, 'yes') }}"
                                class="px-2 py-1 text-sm font-bold text-white bg-blue-600 rounded me-1 hover:bg-blue-600">
                                View pest Data
                            </a>
                            <form action="{{ route('admin.collector.destroy', $collector->id) }}" method="POST"
                                style="display:inline;" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="confirmDelete(event)"
                                    class="px-2 py-1 text-sm font-bold text-white bg-red-600 rounded hover:bg-red-600">
                                    Delete
                                </button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $this->collectors()->links() }}
    </div>
</div>
<!-- Include this script in your Blade view -->
<script>
    function confirmDelete(event) {
        if (!confirm('Are you sure you want to delete this collector?')) {
            event.preventDefault();
        }
    }
</script>
