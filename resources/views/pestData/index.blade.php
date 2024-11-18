<x-app-layout>
    <div class="justify-between mb-2 sm:flex">
        <h1 class="p-2 mb-3 ml-2 text-2xl font-bold text-center text-indigo-100 bg-emerald-900 rounded-3xl">Pest Data</h1>
        <div class="mb-3 ml-2 text-sm font-bold text-red-900">Please check your collector information carefully before adding pest data</div>
        <a href="{{ route('pestdata.create') }}"
            class="px-4 py-2 mb-3 mr-1 text-sm font-bold text-white bg-green-800 rounded shadow-sm ms-1 hover:bg-green-900 hover:shadow-2xl">Add</a>
    </div>
    <x-success-massage />
    <x-error-massage />
    {{-- <x-form method="POST" action="{{ route('admin.collector.update', $collector) }}"> --}}

        <div class="relative p-1 overflow-x-auto border-b border-gray-200">

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
                        <td class="px-6 py-4">{{ $row->created_at }}</td>

                        <td class="px-6 py-4"> {{ $row->growth_s_c }}</td>
                        <td class="px-6 py-4">
                            <a class="px-4 py-2 text-sm font-bold text-white bg-blue-500 rounded hover:bg-blue-700"
                                href="{{ route('pestdata.show', $row->id) }}">view</a>
                            {{-- <a class="px-4 py-2 text-sm font-bold text-white bg-gray-500 rounded hover:bg-gray-700"
                                href="{{ route('pestdata.edit', $row->id) }}">Edit</a> --}}
                            <form action="{{ route('pestdata.destroy', $row->id) }}" method="POST"
                                style="display:inline;" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-bold text-white bg-red-500 rounded hover:bg-red-700">
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
