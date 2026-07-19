<div class="">

    <div class="w-full mx-auto">
        <div class="overflow-hidden bg-slate-500 rounded-lg shadow-sm">

            <!-- Modern Premium Loading Overlay -->
            <div wire:loading.flex class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300">
                <div class="flex flex-col items-center justify-center bg-white dark:bg-slate-800 px-10 py-8 rounded-3xl shadow-2xl border border-slate-200/50 dark:border-slate-700/50 transform transition-all">
                    
                    <!-- High-tech Modern Loader -->
                    <div class="relative w-16 h-16 mb-5 flex items-center justify-center">
                        <!-- Background track -->
                        <div class="absolute inset-0 rounded-full border-[3px] border-slate-100 dark:border-slate-700/50"></div>
                        <!-- Spinning gradient ring -->
                        <div class="absolute inset-0 rounded-full border-[3px] border-primary border-t-transparent border-l-transparent animate-spin" style="animation-duration: 0.8s;"></div>
                        <!-- Pulsing core -->
                        <div class="w-6 h-6 bg-primary/30 dark:bg-primary/40 rounded-full animate-pulse flex items-center justify-center">
                            <div class="w-2.5 h-2.5 bg-primary rounded-full"></div>
                        </div>
                    </div>
                    
                    <span class="text-slate-700 dark:text-slate-200 font-bold text-sm tracking-widest uppercase shadow-sm">Processing Data</span>
                    <span class="text-slate-400 dark:text-slate-500 text-xs mt-1.5 font-medium">Please wait a moment...</span>
                </div>
            </div>






            <x-ui.card padding="p-6" class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                    
                    <div>
                        <x-forms.input type="date" label="From Date" wire:model.lazy="fromdate" icon="fas fa-calendar-day" />
                    </div>
                    
                    <div>
                        <x-forms.input type="date" label="To Date" wire:model.lazy="todate" icon="fas fa-calendar-day" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Report Type</label>
                        <select wire:model.lazy="selectedrange" class="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary/20 transition-colors duration-200" wire:loading.attr="disabled" onchange="setchart()">
                            <option value="1">District wise</option>
                            <option value="2">ASC wise</option>
                            <option value="3">AI Range wise</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">District</label>
                        <select wire:model.lazy="selecteddistrict" class="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary/20 transition-colors duration-200" wire:change="clear1()" wire:loading.attr="disabled">
                            <option value="">Select District</option>
                            @foreach ($dis as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">ASC</label>
                        <select wire:model.lazy="selectedasc" class="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary/20 transition-colors duration-200" wire:change="clear2()" wire:loading.attr="disabled">
                            <option value="">Select ASC</option>
                            @foreach ($asc as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="a" class="hidden">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">AI Range</label>
                        <select id="test1" wire:model.lazy="selectedgs" class="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary/20 transition-colors duration-200" wire:loading.attr="disabled">
                            <option value="">Select AI Range</option>
                            @foreach ($airange as $item)
                                <option value="">{{ $item->ai_range }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </x-ui.card>



            <!--<x-button class="bg-sky-800 hover:bg-sky-700" wire:click="showdata({{ $this->selectedgs }})">Show</x-button>-->
            <label for="state" class="col-md-4 col-form-label text-md-right"></label>


            @if ($selrange == 3)
                <x-data.table>
                    <x-slot name="header">
                        <th scope="col" class="px-6 py-4">District</th>
                        <th scope="col" class="px-6 py-4">ASC</th>
                        <th scope="col" class="px-6 py-4">AI Range</th>
                        <th scope="col" class="px-6 py-4">Thrips</th>
                        <th scope="col" class="px-6 py-4">Gall Midge</th>
                        <th scope="col" class="px-6 py-4">Leaffolder</th>
                        <th scope="col" class="px-6 py-4">Yellower Stem Borer</th>
                        <th scope="col" class="px-6 py-4">BPH</th>
                        <th scope="col" class="px-6 py-4">Paddy bugs</th>
                    </x-slot>

                    @foreach ($alldata as $item)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">{{ $item->district }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $item->ascenter }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $item->ai }}</td>

                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                {{ $item->reccount != 0 ? number_format($item->thrips / $item->reccount, 2, '.', ',') : '0' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                {{ $item->tillers != 0 ? number_format(($item->gallmidge / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') : '0' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                {{ $item->tillers != 0 ? number_format(($item->leaffolder / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') : '0' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                {{ $item->tillers != 0 ? number_format(($item->yellowerstemborer / $item->reccount / ($item->tillers / $item->reccount)) * 100, 2, '.', ',') : '0' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                {{ $item->reccount != 0 ? number_format($item->bhp / $item->reccount / 50, 2) : '0' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                {{ $item->reccount != 0 ? number_format($item->paddybug / $item->reccount / 10, 2) : '0' }}
                            </td>
                        </tr>
                    @endforeach
                </x-data.table>
            @endif


            @if ($selrange == 2)
                <?php
                unset($dataPoints1);
                $dataPoints1 = [];
                ?>
                <x-data.table>
                    <x-slot name="header">
                        <th scope="col" class="px-6 py-4">District</th>
                        <th scope="col" class="px-6 py-4">ASC</th>
                        <th scope="col" class="px-6 py-4">Thrips</th>
                        <th scope="col" class="px-6 py-4">Gall Midge</th>
                        <th scope="col" class="px-6 py-4">Leaffolder</th>
                        <th scope="col" class="px-6 py-4">Yellower Stem Borer</th>
                        <th scope="col" class="px-6 py-4">BPH</th>
                        <th scope="col" class="px-6 py-4">Paddy bugs</th>
                    </x-slot>
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
                </x-data.table>
            @endif




            @if ($selrange == 1)
                <?php
                $dataPoints1 = [];
                ?>




                <x-data.table>
                    <x-slot name="header">
                        <th scope="col" class="px-6 py-4">District</th>
                        <th scope="col" class="px-6 py-4">Thrips</th>
                        <th scope="col" class="px-6 py-4">Gall Midge</th>
                        <th scope="col" class="px-6 py-4">Leaffolder</th>
                        <th scope="col" class="px-6 py-4">Yellower Stem Borer</th>
                        <th scope="col" class="px-6 py-4">BPH</th>
                        <th scope="col" class="px-6 py-4">Paddy bugs</th>
                    </x-slot>
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
                </x-data.table>
            @endif




        </div>
    </div>
</div>
