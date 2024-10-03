<x-app-layout>
    <div class="mx-5">
        <div class="flex justify-between border-b border-gray-200 py-1">
            <h1 class="text-2xl font-bold text-gray-300">Pest Data</h1>
            <div>
                {{-- <a href="{{ route('pestdata.edit',$commonData->id) }}"
                    class="bg-green-800 text-white font-bold py-2 px-4 rounded hover:bg-green-900 text-sm mr-1">Edit</a>
                --}}
                <a href="{{ route('pestdata.index') }}"
                    class="bg-red-800 text-white font-bold py-2 px-4 rounded hover:bg-red-900 text-sm mr-1">Back</a>
            </div>
        </div>
        <div class="sm:flex justify-between text-white mt-4">
            <div class="mb-4"><span>Created At : </span> <span
                    class="p-1 border border-gray-200">{{ $commonData->created_at }}</span></div>
            <div class="mb-4"><span>Date of Data Collected : </span> <span
                    class="p-1 border border-gray-200">{{ $commonData->c_date }}</span></div>
            <div class="mb-5"><span>Temperature : </span> <span
                    class="p-1 border border-gray-200">{{ $commonData->temperature }} °C</span></div>
            <div class="mb-5"><span>No of rainny days : </span> <span
                    class="p-1 border border-gray-200">{{ $commonData->numbrer_r_day }}</span></div>
            <div class="mb-5"><span>Growth stage code : </span><span
                    class="p-1 border border-gray-200">{{ $commonData->growth_s_c }}</span></div>
        </div>
        <div class="border-b border-gray-200"></div>
        <table class="table-auto my-4">
            <thead>
                <tr>

                    <th scope="col" class="py-2 px-2">
                        Pest Name
                    </th>
                    @for ($i = 1; $i <= 10; $i++)
                        <th scope="col" class="py-2 px-2 hidden sm:table-cell">
                            L-{{ $i }}
                        </th>
                    @endfor
                    <th scope="col" class="py-2 px-2">
                        Total
                    </th>
                    <th scope="col" class="py-2 px-2">
                        code
                    </th>
                </tr>
            </thead>

            <tbody>
                @foreach ($pestsData as $pestData)
                    <tr>
                        @if ($pestData->pest_name == 'Thrips')
                            <td>{{ $pestData->pest_name }}</td>
                            @for ($i = 1; $i <= 10; $i++)
                                <td class="hidden sm:table-cell">-</td>
                            @endfor
                            <td>-</td>
                            <td class=" {{ $pestData->code > 5 ? 'bg-red-700' : '' }}">{{ $pestData->code }}</td>
                        @else
                            <td>{{ $pestData->pest_name }}</td>
                           
                            <td class="hidden sm:table-cell">{{ $pestData->location_1 }}</td>
                            <td class="hidden sm:table-cell">{{ $pestData->location_2 }}</td>
                            <td class="hidden sm:table-cell">{{ $pestData->location_3 }}</td>
                            <td class="hidden sm:table-cell">{{ $pestData->location_4 }}</td>
                            <td class="hidden sm:table-cell">{{ $pestData->location_5 }}</td>
                            <td class="hidden sm:table-cell">{{ $pestData->location_6 }}</td>
                            <td class="hidden sm:table-cell">{{ $pestData->location_7 }}</td>
                            <td class="hidden sm:table-cell">{{ $pestData->location_8 }}</td>
                            <td class="hidden sm:table-cell">{{ $pestData->location_9 }}</td>
                            <td class="hidden sm:table-cell">{{ $pestData->location_10 }}</td>
                            <td>{{ $pestData->total }}</td>
                            <td class=" {{ $pestData->code > 5 ? 'bg-red-700' : '' }}">{{ $pestData->code }}</td>
                        @endif

                    </tr>
                @endforeach

            </tbody>
        </table>
        <div class="mb-4 text-white"><span>Other info : </span> <span
                class="p-1 border border-gray-200">{{ $commonData->otherinfo }}</span></div>
    </div>
</x-app-layout>
