<x-app-layout>
    <div class="flex justify-between">
        <livewire:count-card :cardName="'Collectors'" :iconName="'fas fa-money-bill'" :color="'from-green-900 to-green-700'" />
    </div>
    {{-- <x.-form method="POST" action="{{ route('admin.collector.update', $collector) }}"> --}}
    <x-success-massage />
    <div class="p-6  border-b border-gray-200 overflow-x-auto">
        <table class="table-auto">

            <thead>

                <tr>
                    <th>
                        <a
                            href="{{ route('aCollector.index', ['sort_by' => 'id', 'sort_direction' => $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                            Id
                            @if ($sortColumn === 'id')
                                @if ($sortDirection === 'asc')
                                    ▲
                                @else
                                    ▼
                                @endif
                            @endif
                        </a>
                    </th>
                    <th>
                        Name
                    </th>
                    <th>
                        <a
                            href="{{ route('aCollector.index', ['sort_by' => 'rice_season_id', 'sort_direction' => $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                            Season
                            @if ($sortColumn === 'rice_season_id')
                                @if ($sortDirection === 'asc')
                                    ▲
                                @else
                                    ▼
                                @endif
                            @endif
                        </a>
                    </th>
                    <th>
                        <a
                            href="{{ route('aCollector.index', ['sort_by' => 'province', 'sort_direction' => $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                            province
                            @if ($sortColumn === 'province')
                                @if ($sortDirection === 'asc')
                                    ▲
                                @else
                                    ▼
                                @endif
                            @endif
                        </a>
                    </th>
                    <th>
                        <a
                            href="{{ route('aCollector.index', ['sort_by' => 'district', 'sort_direction' => $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                            district
                            @if ($sortColumn === 'district')
                                @if ($sortDirection === 'asc')
                                    ▲
                                @else
                                    ▼
                                @endif
                            @endif
                        </a>
                    </th>
                    <th>
                        <a
                            href="{{ route('aCollector.index', ['sort_by' => 'asc', 'sort_direction' => $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                            ASC
                            @if ($sortColumn === 'asc')
                                @if ($sortDirection === 'asc')
                                    ▲
                                @else
                                    ▼
                                @endif
                            @endif
                        </a>
                    </th>
                    <th>
                        <a
                            href="{{ route('aCollector.index', ['sort_by' => 'ai_range', 'sort_direction' => $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                            Ai Range
                            @if ($sortColumn === 'ai_range')
                                @if ($sortDirection === 'asc')
                                    ▲
                                @else
                                    ▼
                                @endif
                            @endif
                        </a>
                    </th>
                    <th>
                        GPS
                    </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                @if (!empty($collectors) && $collectors->count())
                    @foreach ($collectors as $collector)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                            <td class="py-4 px-6"> {{ $collector->id }}</td>
                            <td class="py-4 px-6"> {{ $collector->user->name }}</td>
                            <td class="py-4 px-6"> {{ $collector->riceSeason->name }}</td>
                            <td class="py-4 px-6"> {{ $collector->getProvince->name }}</td>
                            <td class="py-4 px-6"> {{ $collector->getDistrict->name }}</td>
                            <td class="py-4 px-6"> {{ $collector->getAsCenter->name }}</td>
                            <td class="py-4 px-6"> {{ $collector->getAiRange->name }}</td>
                            <td class="py-4 px-6"> {{ $collector->gps_lati.','.$collector->gps_long }}</td>
                            <td class="py-4 px-6">
                                <a class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 text-sm"
                                    href="{{ route('aCollector.edit', $collector->id) }}">Edit</a>
                                {{-- <form action="{{ route('pest.destroy', $collector->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-700 text-sm">
                                        Delete
                                    </button>
                                </form> --}}
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">There are no data.</td>
                    </tr>
                @endif
            </tbody>
        </table>
        {{ $collectors->links() }}



    </div>
</x-app-layout>
