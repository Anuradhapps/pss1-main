<x-app-layout>
    <div class="mx-5">
        <div class="flex justify-between py-1 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-100">Pest Data</h1>
            <div>
                @if (has_role('collector'))
                    <a href="{{ route('pestdata.view', $commonData->collector_id) }}"
                        class="px-4 py-2 text-sm font-bold text-white transition-all duration-200 bg-red-800 rounded hover:bg-red-900">Back</a>
                @else
                    <a href="{{ route('pestdata.index') }}"
                        class="px-4 py-2 mr-1 text-sm font-bold text-white transition-all duration-200 bg-red-800 rounded hover:bg-red-900">Back</a>
                @endif
            </div>
        </div>
        <div class="mt-4 text-gray-100 sm:flex sm:justify-between sm:space-x-4">
            <div class="mb-4"><span>Created At : </span> <span
                    class="p-1 border border-gray-200">{{ $commonData->created_at }}</span></div>
            <div class="mb-4"><span>Date of Data Collected : </span> <span
                    class="p-1 border border-gray-200">{{ $commonData->c_date }}</span></div>
            <div class="mb-5"><span>Temperature : </span> <span
                    class="p-1 border border-gray-200">{{ $commonData->temperature }} °C</span>
            </div>
            <div class="mb-5"><span>No of Rainy Days : </span> <span
                    class="p-1 border border-gray-200">{{ $commonData->numbrer_r_day }}</span>
            </div>
            <div class="mb-5"><span>Growth Stage Code : </span><span
                    class="p-1 border border-gray-200">{{ $commonData->growth_s_c }}</span></div>
        </div>
        <div class="border-b border-gray-200"></div>
        <table class="w-full my-4 table-auto">
            <thead class="bg-gray-700">
                <tr>
                    <th scope="col" class="px-4 py-2 text-left">Pest Name</th>
                    @for ($i = 1; $i <= 10; $i++)
                        <th scope="col" class="hidden px-4 py-2 text-center sm:table-cell">SP-{{ $i }}
                        </th>
                    @endfor
                    <th scope="col" class="px-4 py-2 text-center">Total</th>
                    <th scope="col" class="px-4 py-2 text-center">Code</th>
                </tr>
            </thead>
            <tbody class="bg-gray-800">
                @foreach ($pestsData as $pestData)
                    <tr class="hover:bg-gray-600">
                        <td class="px-4 py-2 text-left">{{ $pestData->pest_name }}</td>
                        @for ($i = 1; $i <= 10; $i++)
                            <td class="hidden px-4 py-2 text-center sm:table-cell">{{ $pestData->{'location_' . $i} }}
                            </td>
                        @endfor
                        <td class="px-4 py-2 text-center">{{ $pestData->total }}</td>
                        <td class="px-4 py-2 text-center {{ $pestData->code > 5 ? 'bg-red-700' : '' }}">
                            {{ $pestData->code }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mb-4 text-gray-100"><span>Other Info: </span> <span
                class="p-1 border border-gray-200">{{ $commonData->otherinfo }}</span></div>
    </div>

    <!-- Add Tailwind dark mode toggle (optional) -->
    <script>
        // Toggle dark mode on the body
        const toggleDarkMode = () => {
            const body = document.querySelector('body');
            body.classList.toggle('dark');
            localStorage.setItem('theme', body.classList.contains('dark') ? 'dark' : 'light');
        };

        // Set the initial theme based on the user's preference or the stored preference
        window.addEventListener('DOMContentLoaded', () => {
            const theme = localStorage.getItem('theme') || 'light';
            if (theme === 'dark') {
                document.body.classList.add('dark');
            }
        });
    </script>
</x-app-layout>
