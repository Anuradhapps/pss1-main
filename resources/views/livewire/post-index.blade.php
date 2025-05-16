<div class="">

    <div class="mx-auto max-w-max sm:px-6 lg:px-8">
        <div class="overflow-hidden  bg-slate-500">

            <div wire:loading.block class="flex justify-center w-full h-full p-2 text-center bg-black opacity-60"
                style="position:fixed; top:0; left:0"></div>
            <div id = "loading_indicator">
                <div class="text-center">
                    <div role="status">

                        <span class="sr-only"></span>
                    </div>
                </div>
            </div>






            <div class="p-2 form-group row ">
                <label for="state" class="col-md-4 col-form-label text-md-right"></label>




                <div class="col-md-6">

                    <div class="grid grid-cols-4 gap-4">
                        <div><label for="state" class="text-black col-md-4 col-form-label text-md-right">From
                                Date</label></div>
                        <div><input type="date" wire:loading.attr="disabled" wire:model.debounce.300ms="fromdate"
                                wire:model.lazy="fromdate" class="w-full " value=""></div>
                        <div><label for="state" class="text-black col-md-4 col-form-label text-md-right">To
                                Date</label></div>
                        <div><input type="date" wire:loading.attr="disabled" wire:model.debounce.300ms="todate"
                                wire:model.lazy="todate" class="w-full border-gray-900 " value=""></div>
                    </div>


                    <div>

                        <div class ="grid grid-cols-4 p-1 border-gray-900">
                            <label for="state" class="w-3 text-black col-md-4 col-form-label text-md-right">Select
                                Report Type</label>
                            <select wire:model.lazy="selectedrange" class="w-full text-green-900 border form-control "
                                wire:loading.attr="disabled" onchange="setchart()">
                                <option value="1" selected>District wise</option>
                                <option value="2" selected>ASC wise</option>
                                <option value="3" selected>AI Range wise</option>
                            </select>
                        </div>


                    </div>

                    <div class ="grid grid-cols-4 p-1 border-gray-900">
                        <label for="state" class="w-3 text-black col-md-4 col-form-label text-md-right">Select
                            District</label>
                        <select wire:model.lazy="selecteddistrict" class="w-full text-green-900 border form-control "
                            wire:change="clear1()" wire:loading.attr="disabled">
                            <option value="" selected>Select District</option>
                            @foreach ($dis as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class ="grid grid-cols-4 p-1 border-gray-900">
                        <label for="state" class="w-3 text-black col-md-4 col-form-label text-md-right">Select
                            ASC</label>
                        <select wire:model.lazy="selectedasc" class="w-full text-green-900 border-gray-900 form-control"
                            wire:change="clear2()" wire:loading.attr="disabled">
                            <option value="" selected>Select ASC</option>
                            @foreach ($asc as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>




                    <div id="a" class="hidden">
                        <select id="test1" wire:model.lazy="selectedgs"
                            class="w-full text-green-900 border-gray-900 form-control" wire:change="" onchange=""
                            wire:loading.attr="disabled">
                            <option value="" selected>Select AI Range</option>
                            @foreach ($airange as $item)
                                <option value="">{{ $item->ai_range }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>



            <!--<x-button class="bg-sky-800 hover:bg-sky-700" wire:click="showdata({{ $this->selectedgs }})">Show</x-button>-->
            <label for="state" class="col-md-4 col-form-label text-md-right"></label>


            @if ($selrange == 3)
                <table class="w-full divide-y divide-sky-700">

                    <thead class="text-gray-200  bg-sky-600">
                        <tr>
                            <th scope="col" class="w-4 px-6 py-4 text-black whitespace-nowrap">District</th>
                            <th scope="col" class="px-6 py-4 text-black whitespace-nowrap">ASC</th>
                            <th scope="col" class="px-6 py-4 text-black whitespace-nowrap">AI Range</th>

                            <th scope="col" class="px-6 py-3 text-black ">Thrips</th>
                            <th scope="col" class="px-6 py-3 text-black ">Gall Midge</th>
                            <th scope="col" class="px-6 py-3 text-black ">Leaffolder</th>
                            <th scope="col" class="px-6 py-3 text-black ">Yellower Stem Borer</th>
                            <th scope="col" class="px-6 py-3 text-black ">BPH</th>
                            <th scope="col" class="px-6 py-3 text-black ">Paddy bugs</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-sky-500">
                        @foreach ($alldata as $item)
                            <tr>
                                <td class="px-6 py-4 text-black whitespace-nowrap">{{ $item->district }} </td>
                                <td class="px-6 py-4 text-black whitespace-nowrap">{{ $item->ascenter }} </td>
                                <td class="px-6 py-4 text-black whitespace-nowrap">{{ $item->ai }} </td>

                                @if ($item->reccount != 0)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">
                                        {{ number_format($item->thrips / $item->reccount, 2, '.', ',') }}</td>
                                @endif
                                @if ($item->tillers != 0)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">
                                        {{ number_format(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}
                                    </td>
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif
                                @if ($item->tillers != 0)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">
                                        {{ number_format(($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}
                                    </td>
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif
                                @if ($item->tillers != 0)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">
                                        {{ number_format(($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}
                                    </td>
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif
                                <td class="px-6 py-4 text-black whitespace-nowrap">
                                    {{ $item->bhp / $item->reccount / 50 }}</td>
                                <td class="px-6 py-4 text-black whitespace-nowrap">
                                    {{ $item->paddybug / $item->reccount / 10 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif


            @if ($selrange == 2)
                <?php
                unset($dataPoints1);
                $dataPoints1 = [];
                ?>
                <table class="w-full divide-y divide-sky-700">

                    <thead class="text-gray-200  bg-sky-600">
                        <tr>
                            <th scope="col" class="w-4 px-6 py-4 text-black whitespace-nowrap">District</th>
                            <th scope="col" class="px-6 py-4 text-black whitespace-nowrap">ASC</th>

                            <th scope="col" class="px-6 py-3 text-black ">Thrips</th>
                            <th scope="col" class="px-6 py-3 text-black ">Gall Midge</th>
                            <th scope="col" class="px-6 py-3 text-black ">Leaffolder</th>
                            <th scope="col" class="px-6 py-3 text-black ">Yellower Stem Borer</th>
                            <th scope="col" class="px-6 py-3 text-black ">BPH</th>
                            <th scope="col" class="px-6 py-3 text-black ">Paddy bugs</th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-sky-500">
                        @foreach ($alldataasc as $item)
                            <?php
                            $newdata = [
                                'label' => $item->district,
                                'y' => 0,
                            ];
                            array_push($dataPoints1, $newdata);
                            ?>
                            <tr>
                                <td class="px-6 py-4 text-black whitespace-nowrap">{{ $item->district }} </td>
                                <td class="px-6 py-4 text-black whitespace-nowrap">{{ $item->ascenter }} </td>

                                @if ($item->reccount != 0)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">
                                        {{ number_format($item->thrips / $item->reccount, 2, '.', ',') }}-{{ $item->reccount }}
                                    </td>
                                @endif
                                @if ($item->tillers != 0 && $item->reccount != 0)
                                    @if (($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-0
                                        </td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 1)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-1
                                        </td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 5)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-3
                                        </td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-5
                                        </td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 25)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-7
                                        </td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-9
                                        </td>
                                    @endif
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif


                                @if ($item->tillers != 0 && $item->reccount != 0)
                                    @if (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-0
                                        </td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 5)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-1
                                        </td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-3
                                        </td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 20)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-5
                                        </td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 50)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-7
                                        </td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-9
                                        </td>
                                    @endif
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif

                                @if ($item->tillers != 0 && $item->reccount != 0)
                                    @if (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-0
                                        </td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 1)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-1
                                        </td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 3)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-3
                                        </td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-5
                                        </td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 50)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-7
                                        </td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-9
                                        </td>
                                    @endif
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif

                                @if ($item->reccount != 0)
                                    @if ($item->bhp / $item->reccount / 50 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format($item->bhp / $item->reccount / 50, 2, '.', ',') }}-0</td>
                                    @elseif ($item->bhp / $item->reccount / 50 <= 2)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format($item->bhp / $item->reccount / 50, 2, '.', ',') }}-1</td>
                                    @elseif ($item->bhp / $item->reccount / 50 <= 5)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format($item->bhp / $item->reccount / 50, 2, '.', ',') }}-3</td>
                                    @elseif ($item->bhp / $item->reccount / 50 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format($item->bhp / $item->reccount / 50, 2, '.', ',') }}-5</td>
                                    @elseif ($item->bhp / $item->reccount / 50 <= 20)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format($item->bhp / $item->reccount / 50, 2, '.', ',') }}-7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format($item->bhp / $item->reccount / 50, 2, '.', ',') }}-9</td>
                                    @endif
                                @endif

                                @if ($item->reccount != 0)
                                    @if ($item->paddybug / $item->reccount / 10 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format($item->paddybug / $item->reccount / 10, 2, '.', ',') }}-0
                                        </td>
                                    @elseif ($item->paddybug / $item->reccount / 10 <= 1)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format($item->paddybug / $item->reccount / 10, 2, '.', ',') }}-1
                                        </td>
                                    @elseif ($item->paddybug / $item->reccount / 10 <= 4)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format($item->paddybug / $item->reccount / 10, 2, '.', ',') }}-3
                                        </td>
                                    @elseif ($item->paddybug / $item->reccount / 10 <= 15)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format($item->paddybug / $item->reccount / 10, 2, '.', ',') }}-5
                                        </td>
                                    @elseif ($item->paddybug / $item->reccount / 10 <= 20)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format($item->paddybug / $item->reccount / 10, 2, '.', ',') }}-7
                                        </td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format($item->paddybug / $item->reccount / 10, 2, '.', ',') }}-9
                                        </td>
                                    @endif
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif




            @if ($selrange == 1)
                <?php
                $dataPoints1 = [];
                ?>




                <table class="w-full divide-y divide-sky-700">

                    <thead class="text-gray-200  bg-sky-600">
                        <tr>
                            <th scope="col" class="w-4 px-6 py-4 text-black whitespace-nowrap">District</th>

                            <th scope="col" class="px-6 py-3 text-black ">Thrips</th>
                            <th scope="col" class="px-6 py-3 text-black ">Gall Midge</th>
                            <th scope="col" class="px-6 py-3 text-black ">Leaffolder</th>
                            <th scope="col" class="px-6 py-3 text-black ">Yellower Stem Borer</th>
                            <th scope="col" class="px-6 py-3 text-black ">BPH</th>
                            <th scope="col" class="px-6 py-3 text-black ">Paddy bugs</th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-sky-500">
                        @foreach ($alldatadis as $item)
                            <?php
                            $newdata = [
                                'label' => $item->district,
                                'y' => (int) $item->thrips,
                            ];
                            array_push($dataPoints1, $newdata);
                            ?>
                            <tr>
                                <td class="px-6 py-4 text-black whitespace-nowrap">{{ $item->district }} </td>

                                @if ($item->reccount != 0)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">
                                        {{ number_format($item->thrips / $item->reccount, 2, '.', ',') }}-{{ $item->reccount }}
                                    </td>
                                @endif
                                @if ($item->tillers != 0)
                                    @if (($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-0
                                        </td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 1)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-1
                                        </td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 5)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-3
                                        </td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-5
                                        </td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 25)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-7
                                        </td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-9
                                        </td>
                                    @endif
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif


                                @if ($item->tillers != 0)
                                    @if (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-0
                                        </td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 5)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-1
                                        </td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-3
                                        </td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 20)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-5
                                        </td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 50)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-7
                                        </td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-9
                                        </td>
                                    @endif
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif

                                @if ($item->tillers != 0)
                                    @if (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-0
                                        </td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 1)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-1
                                        </td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 3)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-3
                                        </td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-5
                                        </td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 50)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-7
                                        </td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">
                                            {{ number_format(($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') }}-9
                                        </td>
                                    @endif
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif


                                @if ($item->bhp / $item->reccount / 50 == 0)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">
                                        {{ number_format($item->bhp / $item->reccount / 50, 2, '.', ',') }}-0</td>
                                @elseif ($item->bhp / $item->reccount / 50 <= 2)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">
                                        {{ number_format($item->bhp / $item->reccount / 50, 2, '.', ',') }}-1</td>
                                @elseif ($item->bhp / $item->reccount / 50 <= 5)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">
                                        {{ number_format($item->bhp / $item->reccount / 50, 2, '.', ',') }}-3</td>
                                @elseif ($item->bhp / $item->reccount / 50 <= 10)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">
                                        {{ number_format($item->bhp / $item->reccount / 50, 2, '.', ',') }}-5</td>
                                @elseif ($item->bhp / $item->reccount / 50 <= 20)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">
                                        {{ number_format($item->bhp / $item->reccount / 50, 2, '.', ',') }}-7</td>
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">
                                        {{ number_format($item->bhp / $item->reccount / 50, 2, '.', ',') }}-9</td>
                                @endif


                                @if ($item->paddybug / $item->reccount / 10 == 0)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">
                                        {{ number_format($item->paddybug / $item->reccount / 10, 2, '.', ',') }}-0</td>
                                @elseif ($item->paddybug / $item->reccount / 10 <= 1)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">
                                        {{ number_format($item->paddybug / $item->reccount / 10, 2, '.', ',') }}-1</td>
                                @elseif ($item->paddybug / $item->reccount / 10 <= 4)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">
                                        {{ number_format($item->paddybug / $item->reccount / 10, 2, '.', ',') }}-3</td>
                                @elseif ($item->paddybug / $item->reccount / 10 <= 15)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">
                                        {{ number_format($item->paddybug / $item->reccount / 10, 2, '.', ',') }}-5</td>
                                @elseif ($item->paddybug / $item->reccount / 10 <= 20)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">
                                        {{ number_format($item->paddybug / $item->reccount / 10, 2, '.', ',') }}-7</td>
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">
                                        {{ number_format($item->paddybug / $item->reccount / 10, 2, '.', ',') }}-9</td>
                                @endif

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif




        </div>
    </div>
</div>
