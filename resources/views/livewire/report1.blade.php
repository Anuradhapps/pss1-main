<div class="">

    <div class="w-full mx-auto">
        <div class="overflow-hidden bg-slate-500 rounded-lg shadow-sm">

            <!-- Modern Premium Loading Overlay (Livewire) -->
            <div wire:loading.flex class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300">
                <div class="flex flex-col items-center justify-center bg-white dark:bg-slate-800 px-10 py-8 rounded-3xl shadow-2xl border border-slate-200/50 dark:border-slate-700/50 transform transition-all">
                    <!-- High-tech Modern Loader -->
                    <div class="relative w-16 h-16 mb-5 flex items-center justify-center">
                        <div class="absolute inset-0 rounded-full border-[3px] border-slate-100 dark:border-slate-700/50"></div>
                        <div class="absolute inset-0 rounded-full border-[3px] border-primary border-t-transparent border-l-transparent animate-spin" style="animation-duration: 0.8s;"></div>
                        <div class="w-6 h-6 bg-primary/30 dark:bg-primary/40 rounded-full animate-pulse flex items-center justify-center">
                            <div class="w-2.5 h-2.5 bg-primary rounded-full"></div>
                        </div>
                    </div>
                    <span class="text-slate-700 dark:text-slate-200 font-bold text-sm tracking-widest uppercase shadow-sm">Processing Data</span>
                    <span class="text-slate-400 dark:text-slate-500 text-xs mt-1.5 font-medium">Please wait a moment...</span>
                </div>
            </div>

            <!-- Modern Premium Loading Overlay (JS/PDF) -->
            <div id="loading_indicator" style="display: none;" class="fixed inset-0 z-[60] flex items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300">
                <div class="flex flex-col items-center justify-center bg-white dark:bg-slate-800 px-10 py-8 rounded-3xl shadow-2xl border border-slate-200/50 dark:border-slate-700/50 transform transition-all">
                    <!-- High-tech Modern Loader -->
                    <div class="relative w-16 h-16 mb-5 flex items-center justify-center">
                        <div class="absolute inset-0 rounded-full border-[3px] border-slate-100 dark:border-slate-700/50"></div>
                        <div class="absolute inset-0 rounded-full border-[3px] border-primary border-t-transparent border-l-transparent animate-spin" style="animation-duration: 0.8s;"></div>
                        <div class="w-6 h-6 bg-primary/30 dark:bg-primary/40 rounded-full animate-pulse flex items-center justify-center">
                            <div class="w-2.5 h-2.5 bg-primary rounded-full"></div>
                        </div>
                    </div>
                    <span class="text-slate-700 dark:text-slate-200 font-bold text-sm tracking-widest uppercase shadow-sm">Generating PDF</span>
                    <span class="text-slate-400 dark:text-slate-500 text-xs mt-1.5 font-medium">Preparing your document...</span>
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
                                wire:loading.attr="disabled">
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

                    <thead class="text-gray-200 bg-sky-600">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-black whitespace-nowrap">AI Range</th>
                            <th scope="col" class="px-6 py-4 text-black whitespace-nowrap">ASC</th>
                            <th scope="col" class="w-4 px-6 py-4 text-black whitespace-nowrap">District</th>

                            <th scope="col" class="px-6 py-3 text-black ">Thrips</th>
                            <th scope="col" class="px-6 py-3 text-black ">Gall Midge</th>
                            <th scope="col" class="px-6 py-3 text-black ">Leaffolder</th>
                            <th scope="col" class="px-6 py-3 text-black ">Yellow Stem Borer</th>
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

                                @if ($item->tillers != 0 && $item->reccount != 0)
                                    @if (($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 1)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 5)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 25)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                    @endif
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif


                                @if ($item->tillers != 0 && $item->reccount != 0)
                                    @if (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 5)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 20)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 50)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                    @endif
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif

                                @if ($item->tillers != 0 && $item->reccount != 0)
                                    @if (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 1)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 3)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 50)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                    @endif
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif

                                @if ($item->reccount != 0 && $item->reccount != 0)
                                    @if ($item->bhp / $item->reccount / 50 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif ($item->bhp / $item->reccount / 50 <= 2)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif ($item->bhp / $item->reccount / 50 <= 5)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif ($item->bhp / $item->reccount / 50 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif ($item->bhp / $item->reccount / 50 <= 20)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                    @endif
                                @endif

                                @if ($item->reccount != 0 && $item->reccount != 0)
                                    @if ($item->paddybug / $item->reccount / 10 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif ($item->paddybug / $item->reccount / 10 <= 1)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif ($item->paddybug / $item->reccount / 10 <= 4)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif ($item->paddybug / $item->reccount / 10 <= 15)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif ($item->paddybug / $item->reccount / 10 <= 20)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                    @endif
                                @endif

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif


            @if ($selrange == 2)
                <table class="w-full divide-y divide-sky-700">

                    <thead class="text-gray-200 bg-sky-600">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-black whitespace-nowrap">ASC</th>
                            <th scope="col" class="w-4 px-6 py-4 text-black whitespace-nowrap">District</th>


                            <th scope="col" class="px-6 py-3 text-black ">Thrips</th>
                            <th scope="col" class="px-6 py-3 text-black ">Gall Midge</th>
                            <th scope="col" class="px-6 py-3 text-black ">Leaffolder</th>
                            <th scope="col" class="px-6 py-3 text-black ">Yellow Stem Borer</th>
                            <th scope="col" class="px-6 py-3 text-black ">BPH</th>
                            <th scope="col" class="px-6 py-3 text-black ">Paddy bugs</th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-sky-500">
                        @foreach ($alldataasc as $item)
                            <tr>
                                <td class="px-6 py-4 text-black whitespace-nowrap">{{ $item->ascenter }} </td>
                                <td class="px-6 py-4 text-black whitespace-nowrap">{{ $item->district }} </td>


                                @if ($item->reccount != 0)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">
                                        {{ number_format($item->thrips / $item->reccount, 2, '.', ',') }}-{{ $item->thrips }}-{{ $item->reccount }}
                                    </td>
                                @endif

                                @if ($item->tillers != 0 && $item->reccount != 0)
                                    @if (($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 1)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 5)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 25)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                    @endif
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif


                                @if ($item->tillers != 0 && $item->reccount != 0)
                                    @if (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 5)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 20)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 50)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                    @endif
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif

                                @if ($item->tillers != 0 && $item->reccount != 0)
                                    @if (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 1)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 3)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 50)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap"></td>9</td>
                                    @endif
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif

                                @if ($item->reccount != 0)
                                    @if ($item->bhp / $item->reccount / 50 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif ($item->bhp / $item->reccount / 50 <= 2)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif ($item->bhp / $item->reccount / 50 <= 5)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif ($item->bhp / $item->reccount / 50 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif ($item->bhp / $item->reccount / 50 <= 20)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                    @endif
                                @endif

                                @if ($item->reccount != 0)
                                    @if ($item->paddybug / $item->reccount / 10 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif ($item->paddybug / $item->reccount / 10 <= 1)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif ($item->paddybug / $item->reccount / 10 <= 4)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif ($item->paddybug / $item->reccount / 10 <= 15)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif ($item->paddybug / $item->reccount / 10 <= 20)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                    @endif
                                @endif

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif



            @if ($selrange == 1)
                <table class="w-full divide-y divide-sky-700">

                    <thead class="text-gray-200 bg-sky-600">
                        <tr>
                            <th scope="col" class="w-4 px-6 py-4 text-black whitespace-nowrap">District</th>

                            <th scope="col" class="px-6 py-3 text-black ">Thrips</th>
                            <th scope="col" class="px-6 py-3 text-black ">Gall Midge</th>
                            <th scope="col" class="px-6 py-3 text-black ">Leaffolder</th>
                            <th scope="col" class="px-6 py-3 text-black ">Yellow Stem Borer</th>
                            <th scope="col" class="px-6 py-3 text-black ">BPH</th>
                            <th scope="col" class="px-6 py-3 text-black ">Paddy bugs</th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-sky-500">
                        @foreach ($alldatadis as $item)
                            <tr>
                                <td class="px-6 py-4 text-black whitespace-nowrap">{{ $item->district }} </td>

                                @if ($item->reccount != 0)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">
                                        {{ number_format($item->thrips / $item->reccount, 2, '.', ',') }}</td>
                                @endif

                                @if ($item->tillers != 0 && $item->reccount != 0)
                                    @if (($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 1)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 5)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 25)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                    @endif
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif


                                @if ($item->tillers != 0 && $item->reccount != 0)
                                    @if (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 5)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 20)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif (($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 50)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                    @endif
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif

                                @if ($item->tillers != 0 && $item->reccount != 0)
                                    @if (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 == 0)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 1)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 3)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 10)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                    @elseif (($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100 <= 50)
                                        <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                    @else
                                        <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                    @endif
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @endif


                                @if ($item->bhp / $item->reccount / 50 == 0)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @elseif ($item->bhp / $item->reccount / 50 <= 2)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                @elseif ($item->bhp / $item->reccount / 50 <= 5)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                @elseif ($item->bhp / $item->reccount / 50 <= 10)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                @elseif ($item->bhp / $item->reccount / 50 <= 20)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                @endif


                                @if ($item->paddybug / $item->reccount / 10 == 0)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">0</td>
                                @elseif ($item->paddybug / $item->reccount / 10 <= 1)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">1</td>
                                @elseif ($item->paddybug / $item->reccount / 10 <= 4)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">3</td>
                                @elseif ($item->paddybug / $item->reccount / 10 <= 15)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">5</td>
                                @elseif ($item->paddybug / $item->reccount / 10 <= 20)
                                    <td class="px-6 py-4 text-black whitespace-nowrap">7</td>
                                @else
                                    <td class="px-6 py-4 text-black whitespace-nowrap">9</td>
                                @endif

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif



        </div>
    </div>
</div>







<script>
    document.onreadystatechange = function() {
        if (document.readyState !== "complete") {
            document.querySelector("body").style.visibility = "hidden";
            document.getElementById("loading_indicator").style.visibility = "visible";
        } else {

            document.getElementById("loading_indicator").style.display = "none";
            document.querySelector("body").style.visibility = "visible";

        }
    };
</script>



<style>
    #loading_indicator {

        visibility: hidden;
    }


    @keyframes spinIndicator {
        100% {
            transform: rotate(360deg);
        }
    }
</style>
