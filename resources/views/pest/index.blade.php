<x-app-layout>

    <div class="flex items-center justify-between p-2 bg-gray-700">
        <livewire:count-card :cardName="'Pests'" :iconName="'fas fa-bug'" :color="'from-indigo-900 to-indigo-700'" />

        <a href="{{ route('pest.create') }}"
            class="px-4 py-2 text-sm font-bold bg-blue-800 rounded shadow-sm hover:bg-blue-900 hover:shadow-2xl whitespace-nowrap">
            Add
        </a>
    </div>

    {{-- <x.-form method="POST" action="{{ route('admin.collector.update', $collector) }}"> --}}
    <x-success-massage />
    <div class="p-6 overflow-x-auto border-b border-gray-200">
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

                            <td class="px-6 py-4"> {{ $pest->id }}</td>
                            <td class="px-6 py-4"> {{ $pest->name }}</td>
                            <td class="px-6 py-4">
                                <a class="px-4 py-2 text-sm font-bold text-white bg-blue-500 rounded hover:bg-blue-700"
                                    href="{{ route('pest.edit', $pest->id) }}">Edit</a>
                                <form action="{{ route('pest.destroy', $pest->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="confirmDelete(event)"
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
    <!-- Include this script in your Blade view -->
    <script>
        function confirmDelete(event) {
            if (!confirm('Are you sure you want to delete this pest?')) {
                event.preventDefault();
            }
        }
    </script>

</x-app-layout>
