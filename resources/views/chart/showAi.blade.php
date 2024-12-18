<x-app-layout>
    <div class="flex items-center justify-between px-3">
        <span class="px-2 py-1 text-lg font-bold text-blue-100 rounded ">Ai Chart</span>

        <div>
            <a href="{{ route('chart.index') }}"
                class="px-4 py-2 mr-1 text-sm font-bold text-white bg-red-800 rounded hover:bg-red-900">Back</a>
        </div>

    </div>

    <x-success-massage />
    <x-error-massage />

    <div class="container px-2 mx-auto">


        <div class="p-4 m-1 bg-white rounded shadow">
            {!! $chart->container() !!}
        </div>

    </div>
    <div>
        <div class="p-4 mx-3 bg-gray-900 rounded-lg shadow-md">
            <div class="flex justify-between mb-2">
                <div class="text-lg font-semibold text-white">Name</div>
                <div class="text-lg font-semibold text-gray-400">
                    {{ $collector->user->name }}
                </div>
            </div>
            <div class="flex justify-between mb-2">
                <div class="text-lg font-semibold text-white">E-Mail</div>
                <div class="text-lg font-semibold text-gray-400">
                    {{ $collector->user->email }}
                </div>
            </div>
            <div class="flex justify-between mb-2">
                <div class="text-lg font-semibold text-white">Phone Number</div>
                <div class="text-lg font-semibold text-gray-400">
                    {{ $collector->phone_no }}
                </div>
            </div>
            <div class="flex justify-between mb-2">
                <div class="text-lg font-semibold text-white">Season</div>
                <div class="text-lg font-semibold text-gray-400">
                    {{ $collector->riceSeason->name }}
                </div>
            </div>
        </div>


        @foreach ($collector->commonDataCollect as $commonData)
            <div class="container px-2 mx-auto">

                <div class="p-4 m-1 mb-3 bg-gray-800 rounded shadow">
                    <div class="justify-between mt-4 text-white sm:flex">
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
                    <table class="my-4 table-auto">
                        <thead>
                            <tr>

                                <th scope="col" class="px-2 py-2">
                                    Pest Name
                                </th>
                                @for ($i = 1; $i <= 10; $i++)
                                    <th scope="col" class="hidden px-2 py-2 sm:table-cell">
                                        SP-{{ $i }}
                                    </th>
                                @endfor
                                <th scope="col" class="px-2 py-2">
                                    Total
                                </th>
                                <th scope="col" class="px-2 py-2">
                                    code
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($commonData->pestDataCollect as $pestData)
                                <tr>
                                    @if ($pestData->pest_name == 'Thrips')
                                        <td>{{ $pestData->pest_name }}</td>
                                        @for ($i = 1; $i <= 10; $i++)
                                            <td class="hidden sm:table-cell">-</td>
                                        @endfor
                                        <td>-</td>
                                        <td class=" {{ $pestData->code > 5 ? 'bg-red-700' : '' }}">
                                            {{ $pestData->code }}
                                        </td>
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
                                        <td class=" {{ $pestData->code > 5 ? 'bg-red-700' : '' }}">
                                            {{ $pestData->code }}
                                        </td>
                                    @endif

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="flex items-center justify-between">
                        <div class="mb-4 text-white">
                            <span>Other info: </span>
                            <span class="p-1 border border-gray-200">{{ $commonData->otherinfo }}</span>
                        </div>
                        <form action="{{ route('admin.pestdata.destroy', $commonData->id) }}" method="POST"
                            style="display:inline;" onsubmit="return confirmDelete()">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-2 py-1 text-sm text-white bg-red-500 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2">
                                Delete
                            </button>
                        </form>
                        {{-- <div>
                            <a href="{{ route('admin.pestdata.destroy', $commonData->id) }}"
                                class="px-2 py-1 text-sm text-white bg-red-500 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2">
                                Delete
                            </a>
                        </div> --}}
                    </div>


                </div>

            </div>
        @endforeach




    </div>

    <script src="{{ $chart->cdn() }}"></script>

    {{ $chart->script() }}


</x-app-layout>
