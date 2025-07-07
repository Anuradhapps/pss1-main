<x-app-layout>
    <!-- Header -->
    <div
        class="flex flex-col items-start justify-between p-5 mb-6 shadow-lg sm:flex-row rounded-xl bg-gradient-to-r from-green-800 to-green-600">
        <h1 class="w-full text-3xl font-extrabold tracking-wide text-center text-white sm:text-start">🐛 Pest Data
            Overview</h1>
        <div class="flex justify-between w-full mt-5 sm:gap-3 sm:justify-end sm:mt-0">

            <a href="{{ route('pestdata.create', $collectorId) }}"
                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition duration-300 rounded-full shadow-md bg-emerald-700 hover:bg-emerald-800">
                ➕ Add Pest Data
            </a>
            <a href="{{ route('collector.create') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition duration-300 bg-red-700 rounded-full hover:bg-red-800">
                <i class="mr-2 fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <x-success-massage />
    <x-error-massage />

    <!-- Collector Info Table  -->
    <div class="mt-4 overflow-hidden bg-gray-900 rounded-lg shadow">
        <table class="w-full text-sm text-left text-white">
            <thead>
                <tr class="text-gray-400 bg-gray-800">
                    <th class="px-4 py-3">Field</th>
                    <th class="px-4 py-3">Details</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                <tr>
                    <td class="px-4 py-1"> <span class="mr-1 text-lg">👤</span> Collector Name</td>
                    <td class="px-4 py-1">{{ $collector->user->name }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-1"><span class="mr-1 text-lg">📌</span> Location</td>
                    <td class="px-4 py-1">{{ $collector->getAiRange->name }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-1"><span class="mr-1 text-lg">🌾</span> Rice Variety</td>
                    <td class="px-4 py-1">{{ $collector->rice_variety }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pest Data Table -->
    <div class="mt-6 overflow-x-auto bg-gray-900 rounded-lg shadow">
        <table class="w-full text-sm text-white">
            <thead class="text-xs text-gray-400 bg-gray-800 sm:text-sm">
                <tr>
                    <th class="px-4 py-3">📅 Created At</th>
                    <th class="px-4 py-3">🗓️ Collected Date</th>
                    <th class="px-4 py-3">🔍 More Info</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @if (!empty($CommonData) && $CommonData->count())
                    @foreach ($CommonData as $row)
                        <tr class="transition duration-200 hover:bg-gray-400 ">
                            <td class="px-4 py-3 ">{{ $row->created_at }}</td>
                            <td class="px-4 py-3">{{ $row->c_date }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('pestdata.show', $row->id) }}"
                                    class="inline-block px-4 py-1 text-xs font-bold text-white transition duration-200 bg-blue-600 rounded-full hover:bg-blue-700">
                                    View
                                </a>
                                <form action="{{ route('pestdata.destroy', $row->id) }}" method="POST"
                                    class="inline-block ml-2" onsubmit="return confirmDelete()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-1 text-xs font-bold text-white transition duration-200 bg-red-600 rounded-full hover:bg-red-700">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="px-4 py-6 text-center text-gray-400">🚫 No pest data available.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Confirm Delete Script -->
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this data? This action cannot be undone.');
        }
    </script>
</x-app-layout>
