<x-app-layout>
    <div class="flex items-center justify-between bg-gray-900">
        <h1 class="p-2 mx-3 text-2xl font-bold text-center text-indigo-100 rounded-3xl">Pest Data
        </h1>

        <div class="flex gap-1 mx-3">
            <a href="{{ route('pestdata.create', $collectorId) }}"
                class="px-4 py-2 text-sm font-bold text-white bg-green-800 rounded shadow-sm hover:bg-green-900 hover:shadow-2xl">
                Add
            </a>
            <a href="{{ route('collector.create') }}"
                class="px-4 py-2 text-sm font-bold text-white bg-red-800 rounded hover:bg-red-900">Back</a>
        </div>

    </div>
    <div class="mb-3 ml-2 text-sm italic text-orange-400">Please check your collector information carefully before
        adding pest data</div>

    <x-success-massage />
    <x-error-massage />
    {{-- <x-form method="POST" action="{{ route('admin.collector.update', $collector) }}"> --}}
    <p class="p-2 m-1 bg-gray-900">
        <span class="text-orange-700">{{ $collector->getDistrict->name }}</span>
        <i class="fas fa-arrow-right"></i>
        <span class="text-pink-500"> {{ $collector->getAsCenter->name }}</span>
        <i class="fas fa-arrow-right"></i>
        <span class="text-yellow-500">{{ $collector->getAiRange->name }}</span>
        <span class="text-white">( {{ $collector->region->name }} )</span>
    </p>
    <div class="relative p-1 overflow-x-auto border-b border-gray-200">

        <table class="table-auto">

            <thead>
                <tr class="bg-gray-900">
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
