<x-app-layout>
    <div class="flex justify-between">
        <livewire:count-card :cardName="'Collectors'" :iconName="'fas fa-money-bill'" :color="'from-green-900 to-green-700'" />
    </div>
    {{-- <x.-form method="POST" action="{{ route('admin.collector.update', $collector) }}"> --}}
    <x-success-massage />
    <div class="p-6 overflow-x-auto border-b border-gray-200">
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
                        Village
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

                            <td class="px-6 py-4"> {{ $collector->id }}</td>
                            <td class="px-6 py-4"> {{ $collector->user->name }}</td>
                            <td class="px-6 py-4"> {{ $collector->riceSeason->name }}</td>
                            <td class="px-6 py-4"> {{ $collector->getProvince->name }}</td>
                            <td class="px-6 py-4"> {{ $collector->getDistrict->name }}</td>
                            <td class="px-6 py-4"> {{ $collector->getAsCenter->name }}</td>
                            <td class="px-6 py-4"> {{ $collector->getAiRange->name }}</td>
                            <td class="px-6 py-4"> {{ $collector->village }}</td>
                            <td class="px-6 py-4"> {{ $collector->gps_lati.','.$collector->gps_long }}</td>
                            <td class="px-6 py-4">
                                <a class="px-4 py-2 text-sm font-bold text-white bg-blue-500 rounded hover:bg-blue-700"
                                    href="{{ route('aCollector.edit', $collector->id) }}">Edit</a>
                                {{-- <form action="{{ route('pest.destroy', $collector->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-red-500 rounded hover:bg-red-700">
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
