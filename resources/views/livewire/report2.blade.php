<div class="">

    <div class="w-full mx-auto">
        <div class="overflow-hidden bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg shadow-sm">

            <!-- Modern Premium Loading Overlay (Livewire) -->
            <div wire:loading.flex class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300">
                <div class="flex flex-col items-center justify-center bg-white dark:bg-slate-800 px-8 py-6 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-700 transform transition-all">
                    <svg class="animate-spin h-10 w-10 text-primary mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-slate-800 dark:text-slate-200 font-semibold text-sm tracking-wide">Processing Data...</span>
                </div>
            </div>

            <!-- Modern Premium Loading Overlay (JS/PDF) -->
            <div id="loading_indicator" style="display: none;" class="fixed inset-0 z-[60] flex items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300">
                <div class="flex flex-col items-center justify-center bg-white dark:bg-slate-800 px-8 py-6 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-700 transform transition-all">
                    <svg class="animate-spin h-10 w-10 text-primary mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-slate-800 dark:text-slate-200 font-semibold text-sm tracking-wide">Generating PDF...</span>
                </div>
            </div>






            <div class="p-2 form-group row ">
                <label for="state" class="col-md-4 col-form-label text-md-right"></label>




                <div class="col-md-6">

                    <div class="grid grid-cols-4 gap-4">
                        <div><label for="state" class="text-slate-700 dark:text-slate-300 col-md-4 col-form-label text-md-right">From
                                Date</label></div>
                        <div><input type="date" wire:loading.attr="disabled" wire:model.debounce.300ms="fromdate"
                                wire:model.lazy="fromdate" class="w-full px-4 py-2.5 text-slate-900 dark:text-white bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all outline-none shadow-sm" value=""></div>
                        <div><label for="state" class="text-slate-700 dark:text-slate-300 col-md-4 col-form-label text-md-right">To
                                Date</label></div>
                        <div><input type="date" wire:loading.attr="disabled" wire:model.debounce.300ms="todate"
                                wire:model.lazy="todate" class="w-full px-4 py-2.5 text-slate-900 dark:text-white bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all outline-none shadow-sm" value=""></div>
                    </div>


                    <div>




                    </div>

                    <div class ="grid grid-cols-4 p-1 border-slate-200 dark:border-slate-700">
                        <label for="state" class="w-3 text-slate-700 dark:text-slate-300 col-md-4 col-form-label text-md-right">Select
                            District</label>
                        <select wire:model.lazy="selecteddistrict" class="w-full px-4 py-2.5 text-slate-900 dark:text-white bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all outline-none shadow-sm"
                            wire:change="clear1()" wire:loading.attr="disabled">
                            <option value="" selected>Select District</option>
                            @foreach ($dis as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class ="grid grid-cols-4 p-1 border-slate-200 dark:border-slate-700">
                        <label for="state" class="w-3 text-slate-700 dark:text-slate-300 col-md-4 col-form-label text-md-right">Select
                            ASC</label>
                        <select wire:model.lazy="selectedasc" class="w-full px-4 py-2.5 text-slate-900 dark:text-white bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all outline-none shadow-sm"
                            wire:change="clear2()" wire:loading.attr="disabled">
                            <option value="" selected>Select ASC</option>
                            @foreach ($asc as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>




                    <div id="a" class="hidden">
                        <select id="test1" wire:model.lazy="selectedgs"
                            class="w-full px-4 py-2.5 text-slate-900 dark:text-white bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all outline-none shadow-sm" wire:change="" onchange=""
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


            @if ($selrange == 1)
                <table class="w-full min-w-full divide-y divide-slate-200 dark:divide-slate-800">

                    <thead class="bg-slate-50 dark:bg-slate-800/50 text-slate-700 dark:text-slate-200 uppercase text-xs font-semibold tracking-wider">
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">

                            <th scope="col" class="w-4 px-4 py-3 text-slate-700 dark:text-slate-300 whitespace-nowrap">District</th>
                            <th scope="col" class="px-4 py-3 text-slate-700 dark:text-slate-300 whitespace-nowrap">ASC</th>
                            <th scope="col" class="px-4 py-3 text-slate-700 dark:text-slate-300 whitespace-nowrap">AI Range</th>

                            <th scope="col" class="px-4 py-3 text-left text-slate-700 dark:text-slate-300 ">Temperature</th>
                            <th scope="col" class="px-4 py-3 text-left text-slate-700 dark:text-slate-300 ">Rainy Days</th>
                            <th scope="col" class="px-4 py-3 text-left text-slate-700 dark:text-slate-300 ">Growth Stage Code</th>
                            <th scope="col" class="px-4 py-3 text-left text-slate-700 dark:text-slate-300 ">Other Details</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-900 divide-y divide-slate-200 dark:divide-slate-800">
                        @foreach ($alldata as $item)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-4 py-3 text-slate-700 dark:text-slate-300 whitespace-nowrap">{{ $item->dname }}</td>
                                <td class="px-4 py-3 text-slate-700 dark:text-slate-300 whitespace-nowrap">{{ $item->ascname }}</td>
                                <td class="px-4 py-3 text-slate-700 dark:text-slate-300 whitespace-nowrap">{{ $item->airange }}</td>

                                <td class="px-4 py-3 text-slate-700 dark:text-slate-300 whitespace-nowrap">{{ $item->temperature }} °C</td>
                                <td class="px-4 py-3 text-slate-700 dark:text-slate-300 whitespace-nowrap">{{ $item->numbrer_r_day }}</td>
                                <td class="px-4 py-3 text-slate-700 dark:text-slate-300 whitespace-nowrap">{{ $item->growth_s_c }}</td>
                                <td class="px-4 py-3 text-slate-700 dark:text-slate-300 whitespace-nowrap">{{ $item->otherdet }}</td>





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
