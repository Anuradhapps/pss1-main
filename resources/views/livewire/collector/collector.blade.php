@section('title', 'Collector')
<div class="bg-slate-500 p-2">
    <div class="flex justify-between">

        <h1>Collectors Information</h1>


    </div>

    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4">

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
                    <th>
                        <a href="#" wire:click.prevent="sortBy('phone_no')">Phone No.</a>
                    </th>
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
                    <tr>
                        <td> {{ $collector->name }}</td>
                        {{-- <td> {{ $collector->email }}</td> --}}
                        <td> {{ $collector->phone_no }}</td>
                        <td> {{ $collector->dname }}</td>
                        <td> {{ $collector->asname }}</td>
                        <td> {{ $collector->ainame }}</td>
                        <td> {{ $collector->village }}</td>
                        <td> {{ $collector->riceSeasonName }}</td>
                        {{-- <td> {{ $collector->rice_variety }}</td>
                        <td> {{ $collector->gps_lati }}</td>
                        <td> {{ $collector->gps_long }}</td>
                        <td> {{ $collector->date_establish }}</td> --}}
                        <td> <a href="{{ route('admin.collector.common.show', $collector->id) }}"> More>>
                            </a>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $this->collectors()->links() }}
    </div>
</div>
