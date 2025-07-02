<x-app-layout>
    <div class="mx-4 sm:mx-6 md:mx-10">
        <!-- Header -->
        <div class="flex flex-col items-start justify-between py-4 border-b border-gray-700 sm:flex-row sm:items-center">
            <h1 class="text-2xl font-extrabold text-white">🐛 Pest Data</h1>
            <div class="mt-3 sm:mt-0">
                @if (has_role('collector'))
                    <a href="{{ route('pestdata.view', $commonData->collector_id) }}"
                        class="inline-block px-4 py-2 text-sm font-semibold text-white transition bg-red-700 rounded hover:bg-red-800">
                        ⬅️ Back
                    </a>
                @else
                    <a href="{{ route('pestdata.index') }}"
                        class="inline-block px-4 py-2 text-sm font-semibold text-white transition bg-red-700 rounded hover:bg-red-800">
                        ⬅️ Back
                    </a>
                @endif
            </div>
        </div>

        <!-- Meta Information -->
        <div class="grid grid-cols-1 gap-4 mt-5 text-sm text-white sm:grid-cols-2 md:grid-cols-3">
            <div class="px-4 py-3 bg-gray-800 rounded-lg hover:scale-[1.05] transition-transform duration-300">
                <strong>📅 Created At:</strong>
                <div class="mt-1 text-gray-200">{{ $commonData->created_at }}</div>
            </div>
            <div class="px-4 py-3 bg-gray-800 rounded-lg hover:scale-[1.05] transition-transform duration-300">
                <strong>🗓️ Collected Date:</strong>
                <div class="mt-1 text-gray-200">{{ $commonData->c_date }}</div>
            </div>
            <div class="px-4 py-3 bg-gray-800 rounded-lg hover:scale-[1.05] transition-transform duration-300">
                <strong>🌡️ Temperature:</strong>
                <div class="mt-1 text-gray-200">{{ $commonData->temperature }} °C</div>
            </div>
            <div class="px-4 py-3 bg-gray-800 rounded-lg hover:scale-[1.05] transition-transform duration-300">
                <strong>🌧️ Rainy Days:</strong>
                <div class="mt-1 text-gray-200">{{ $commonData->numbrer_r_day }}</div>
            </div>
            <div class="px-4 py-3 bg-gray-800 rounded-lg hover:scale-[1.05] transition-transform duration-300">
                <strong>🌱 Growth Stage Code:</strong>
                <div class="mt-1 text-gray-200">{{ $commonData->growth_s_c }}</div>
            </div>
        </div>

        <!-- Pest Table -->
        <div class="mt-8 overflow-x-auto bg-gray-900 rounded-lg shadow">
            <table class="min-w-full text-sm text-white">
                <thead class="text-xs text-gray-300 bg-gray-800 sm:text-sm">
                    <tr>
                        <th class="px-4 py-3 text-left">🐞 Pest Name</th>
                        @for ($i = 1; $i <= 10; $i++)
                            <th class="hidden px-4 py-3 text-center sm:table-cell">SP-{{ $i }}</th>
                        @endfor
                        <th class="px-4 py-3 text-center">📊 Total</th>
                        <th class="px-4 py-3 text-center">⚠️ Code</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach ($pestsData as $pestData)
                        <tr class="transition hover:bg-gray-100">
                            <td class="px-4 py-3">{{ $pestData->pest_name }}</td>
                            @for ($i = 1; $i <= 10; $i++)
                                <td class="hidden px-4 py-3 text-center sm:table-cell">
                                    {{ $pestData->{'location_' . $i} }}
                                </td>
                            @endfor
                            <td class="px-4 py-3 font-semibold text-center">{{ $pestData->total }}</td>
                            <td class="px-4 py-3 text-center">
                                <span
                                    class="inline-block px-2 py-1 text-xs font-bold rounded-full
                                    {{ $pestData->code > 5 ? 'bg-red-600 text-white' : 'bg-green-600 text-white' }}">
                                    {{ $pestData->code }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Other Info -->
        @if ($commonData->otherinfo)
            <div class="mt-6 text-white">
                <h2 class="font-semibold">📝 Other Info:</h2>
                <div class="p-3 mt-1 text-gray-200 bg-gray-800 rounded">{{ $commonData->otherinfo }}</div>
            </div>
        @endif
    </div>

    <!-- Optional: Dark mode toggle script (if needed) -->
</x-app-layout>
