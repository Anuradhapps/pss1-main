<x-app-layout>
    <div class="flex justify-between">
        <h1 class="text-2xl font-bold ml-2 text-gray-300">Pest Data</h1>
        <a href="{{ route('pestdata.create') }}" class="bg-green-800 text-white font-bold py-2 px-4 rounded hover:bg-green-900 text-sm mr-1">Add</a>
    </div>
    {{-- <x-form method="POST" action="{{ route('admin.collector.update', $collector) }}"> --}}

    <div class="p-1 border-b border-gray-200 relative overflow-x-auto">

        <table class="table-auto">

            <thead>
                <tr>
                    <th>Date</th>
                    <th>Growth stage</th>
                    <th>More info.</th>
                </tr>
            </thead>
            <tbody>

                @if (!empty($CommonData) && $CommonData->count())
                    @foreach ($CommonData as $row)
                   
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6">{{ $row->created_at }}</td>

                            <td class="py-4 px-6"> {{ $row->growth_s_c }}</td>
                            <td class="py-4 px-6">
                                <a class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 text-sm"
                                    href="{{ route('pestdata.show', $row->id) }}">view</a>
                                <form action="{{ route('pestdata.destroy', $row->id) }}" method="POST"
                                    style="display:inline;" onsubmit="return confirmDelete()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-700 text-sm">
                                        Delete
                                    </button>
                                </form>
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



    </div>
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this data? This action cannot be undone.');
        }
    </script>
</x-app-layout>
