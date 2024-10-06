<x-app-layout>
    <div class="flex justify-between">
        <h1 class="text-2xl font-bold mb-4 text-white">Pests</h1>
       <a href="{{ route('pest.create') }}" class="btn btn-primary ">Add</a>
    </div>
    {{-- <x.-form method="POST" action="{{ route('admin.collector.update', $collector) }}"> --}}
    <x-success-massage/>
    <div class="p-6  border-b border-gray-200 overflow-x-auto">
        <table class="table-auto">

            <thead>
                <tr>
                    <th>Pest Id</th>
                    <th>Pest Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                @if (!empty($pests) && $pests->count())
                    @foreach ($pests as $pest)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                            <td class="py-4 px-6"> {{ $pest->id }}</td>
                            <td class="py-4 px-6"> {{ $pest->name }}</td>
                            <td class="py-4 px-6"> 
                                <a class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 text-sm" href="{{ route('pest.edit', $pest->id) }}">Edit</a> 
                                <form action="{{ route('pest.destroy', $pest->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-700 text-sm">
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
</x-app-layout>
