<x-app-layout>
    <div class="flex flex-wrap items-center justify-between p-2 bg-gray-900">
        <h1 class="mx-3 text-lg font-bold text-center text-indigo-100 sm:text-2xl">Pest Data</h1>

        <div class="flex flex-wrap gap-1 mx-3">
            <a href="{{ route('pestdata.create', $collectorId) }}"
                class="px-2 py-1 text-xs font-bold text-white bg-green-800 rounded shadow-sm sm:px-4 sm:py-2 sm:text-sm hover:bg-green-900 hover:shadow-2xl">
                Add
            </a>
            <a href="{{ route('collector.create') }}"
                class="px-2 py-1 text-xs font-bold text-white bg-red-800 rounded sm:px-4 sm:py-2 sm:text-sm hover:bg-red-900">
                Back
            </a>
        </div>
    </div>

    <x-success-massage />
    <x-error-massage />

    <div class="mt-1 text-white bg-gray-900 ">
        <table class="w-full text-sm text-left">
            <thead>
                <tr class="text-gray-400 bg-gray-800">
                    <th class="px-2 py-1 sm:px-4 sm:py-2">Field</th>
                    <th class="px-2 py-1 sm:px-4 sm:py-2">Details</th>
                </tr>
            </thead>
            <tbod>
                <tr>
                    <td class="px-2 py-1 sm:px-4 sm:py-2">Collector Name</td>
                    <td class="px-2 py-1 sm:px-4 sm:py-2">{{ $collector->user->name }}</td>
                </tr>
                <tr>
                    <td class="px-2 py-1 sm:px-4 sm:py-2">Location</td>
                    <td class="px-2 py-1 sm:px-4 sm:py-2">
                        {{ $collector->getAiRange->name }}
                    </td>
                </tr>
                <tr>
                    <td class="px-2 py-1 sm:px-4 sm:py-2">Rice Variety</td>
                    <td class="px-2 py-1 sm:px-4 sm:py-2">{{ $collector->rice_variety }}</td>
                </tr>
            </tbod>
        </table>
    </div>

    <div class="relative mt-1 overflow-x-auto border-b border-gray-200">
        <table class="w-full table-auto">
            <thead>
                <tr class="text-xs text-white bg-gray-900 sm:text-base">
                    <th class="px-2 py-1 sm:px-4 sm:py-2">Date</th>
                    <th class="px-2 py-1 sm:px-4 sm:py-2">Growth stage</th>
                    <th class="px-2 py-1 sm:px-4 sm:py-2">More info.</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($CommonData) && $CommonData->count())
                    @foreach ($CommonData as $row)
                        <tr class="text-xs bg-gray-800 border-b border-gray-700 sm:text-sm">
                            <td class="px-2 py-1 text-white sm:px-6 sm:py-4">{{ $row->created_at }}</td>
                            <td class="px-2 py-1 text-white sm:px-6 sm:py-4"> {{ $row->growth_s_c }}</td>
                            <td class="px-2 py-1 text-white sm:px-6 sm:py-4">
                                <a class="px-2 py-1 text-xs font-bold text-white bg-blue-500 rounded sm:px-4 sm:py-2 sm:text-sm hover:bg-blue-700"
                                    href="{{ route('pestdata.show', $row->id) }}">View</a>
                                <form action="{{ route('pestdata.destroy', $row->id) }}" method="POST"
                                    class="inline-block" onsubmit="return confirmDelete()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-2 py-1 text-xs font-bold text-white bg-red-500 rounded sm:px-4 sm:py-2 sm:text-sm hover:bg-red-700">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="px-2 py-2 text-center sm:px-6 sm:py-4">There are no data.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this data? This action cannot be undone.');
        }
    </script>
</x-app-layout>
