@section('title', 'Collector')
<div class="p-2 bg-slate-500">
    <div class="flex justify-between">
        <livewire:count-card :cardName="'Collectors'" :iconName="'fas fa-users'" :color="'from-purple-900 to-purple-700'" />
    </div>

    <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-4">

        <div class="col-span-2 py-2">
            <x-form.input type="search" id="roles" name="query" wire:model="query" label="none"
                placeholder="Search Collector Information">
                {{ old('query', request('query')) }}
            </x-form.input>
        </div>

    </div>
    <div class="overflow-x-auto">
        <table>
            <thead>
                <tr>
                    <th>
                        <a href="#" wire:click.prevent="sortBy('name')">Name</a>
                    </th>
                    {{-- <th>
                        <a href="#" wire:click.prevent="sortBy('email')">Email</a>
                    </th> --}}
                    {{-- <th>
                        <a href="#" wire:click.prevent="sortBy('phone_no')">Phone No.</a>
                    </th> --}}
                    <th>
                        <a href="#" wire:click.prevent="sortBy('district')">District</a>
                    </th>
                    <th>
                        <a href="#" wire:click.prevent="sortBy('asc')"> ASC</a>
                    </th>
                    <th>
                        <a href="#" wire:click.prevent="sortBy('ai_range')"> AI Range</a>
                    </th>

                    <th>
                        <a href="#" wire:click.prevent="sortBy('village')"> Village</a>
                    </th>
                    <th>
                        <a href="#"> Rice Season</a>
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
                    <tr class="bg-emerald-900">
                        <td> {{ $collector->name }}</td>
                        {{-- <td> {{ $collector->email }}</td> --}}
                        {{-- <td> {{ $collector->phone_no }}</td> --}}
                        <td> {{ $collector->dname }}</td>
                        <td> {{ $collector->asname }}</td>
                        <td> {{ $collector->ainame }}</td>
                        <td> {{ $collector->village }}</td>
                        <td> {{ $collector->riceSeasonName }}</td>
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
