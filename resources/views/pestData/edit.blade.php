<x-app-layout>
    <x-headings.top-heading title="Edit Pest Data" icon="fas fa-edit" buttonText="Back"
        buttonAction="{{ route('pestdata.index') }}" buttonIcon="fas fa-arrow-left" buttonColor="red"
        class="bg-red-700" />

    <x-form method="POST" action="{{ route('pestdata.update', $commonData->id) }}" class="m-2">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-2 gap-2">
            <div class="col-span-2 sm:col-span-1">
                <x-form.date name="date_collected"
                    label="Data Collecting Date : ">{{ old('date_collected', $commonData->c_date) }}</x-form.date>
            </div>
            <div class="col-span-2 sm:col-span-1">
                <x-form.select id="growth_s_c" label="Growth Stage Code" class="block w-full" name="growth_s_c"
                    placeholder="Select Growth Stage code">
                    @php
                        $growthStageCode = [
                            'Germination',
                            'Seedling',
                            'Tillering',
                            'Stem Elongation',
                            'Booting',
                            'Heading',
                            'Milk Stage',
                            'Dough Stage',
                            'Mature Grain',
                        ];
                    @endphp
                    @for ($i = 1; $i <= 9; $i++)
                        <option value="{{ $i }}" {{ old('growth_s_c', $commonData->growth_s_c) == $i ? 'selected' : '' }}>
                            {{ $i }} - {{ $growthStageCode[$i - 1] }}</option>
                    @endfor
                </x-form.select>
            </div>
            <div class="col-span-2 sm:col-span-1">
                <x-form.input type="number" placeholder="Enter Temperature in celsius" name="temperature"
                    label="Temperature:" min=-50 max=50>{{ old('temperature', $commonData->temperature) }}</x-form.input>
            </div>

            <div class="col-span-2 sm:col-span-1">
                <x-form.select id="numbrer_r_day" label="Number of Rainy Days: (Within the week)" class="block w-full"
                    name="numbrer_r_day" placeholder="Select Number of Rainy Days">
                    @for ($i = 0; $i <= 7; $i++)
                        <option value="{{ $i }}" {{ old('numbrer_r_day', $commonData->numbrer_r_day) == $i ? 'selected' : '' }}>
                            {{ $i }}</option>
                    @endfor
                </x-form.select>
            </div>

        </div>

        <div class="mt-6 mb-2 p-4 bg-sky-50 dark:bg-sky-500/10 border-l-4 border-sky-500 rounded-r-xl shadow-sm flex items-start gap-4 hover:shadow-md transition-shadow duration-300">
            <div class="mt-0.5 text-sky-500 dark:text-sky-400">
                <i class="fas fa-info-circle text-2xl"></i>
            </div>
            <div>
                <h5 class="text-base font-bold text-sky-900 dark:text-sky-300 mb-1">Pest Data Entry</h5>
                <p class="text-sm text-sky-800 dark:text-sky-400">If you have identified a pest, click on its name below to expand the section and enter the collected values.</p>
                <div class="mt-3 inline-flex items-center gap-2 text-xs font-bold text-sky-700 dark:text-sky-300 bg-sky-100 dark:bg-sky-500/20 px-3 py-1.5 rounded-lg border border-sky-200 dark:border-sky-500/30">
                    <i class="fas fa-map-marker-alt"></i>
                    <span><span class="text-sky-900 dark:text-sky-100">SP</span> = Sample Point</span>
                </div>
            </div>
        </div>

        <div class="mt-4">
            @php
                $tillersData = $pestsData->where('pest_name', 'Number_Of_Tillers')->first();
            @endphp
            <div class="mb-4 group">
                <h2 class="flex items-center justify-between p-4 text-lg font-bold text-slate-800 dark:text-slate-100 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl cursor-pointer toggleButton hover:border-primary dark:hover:border-primary hover:shadow-md transition-all">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <span>Number Of Tillers</span>
                    </div>
                    <i class="fas fa-chevron-down text-slate-400 transition-transform duration-300 toggleIcon"></i>
                </h2>
                <div class="hidden p-5 mt-2 border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 rounded-xl toggleDiv shadow-inner">
                    <input type="text" hidden name="Number_Of_Tillers" value="Number_Of_Tillers">
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-4 md:grid-cols-5 xl:grid-cols-10">
                        @for ($i = 1; $i <= 10; $i++)
                            <div class="col-span-1">
                                <x-form.input type="number" name="Number_Of_Tillers_location_{{ $i }}"
                                    label="SP {{ $i }}" min=0
                                    required>{{ old('Number_Of_Tillers_location_' . $i, $tillersData ? $tillersData->{'location_'.$i} : '') }}</x-form.input>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
            
            @foreach ($pests as $pest)
                @php
                    $pestData = $pestsData->where('pest_name', $pest->name)->first();
                @endphp
                @if ($pest->name == 'Thrips')
                    <div class="mb-4 group">
                        <h2 class="flex items-center justify-between p-4 text-lg font-bold text-slate-800 dark:text-slate-100 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl cursor-pointer toggleButton hover:border-primary dark:hover:border-primary hover:shadow-md transition-all">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                                    <i class="fas fa-bug"></i>
                                </div>
                                <span>{{ $pest->name }}</span>
                            </div>
                            <i class="fas fa-chevron-down text-slate-400 transition-transform duration-300 toggleIcon"></i>
                        </h2>
                        <div class="hidden p-5 mt-2 border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 rounded-xl toggleDiv shadow-inner">
                            <input type="text" hidden name="{{ $pest->name }}" value="{{ $pest->name }}">
                            <div class="w-full sm:max-w-md">
                                <x-form.select id="{{ $pest->id }}all_location" label="Code:" class="block w-full"
                                    name="{{ $pest->id }}all_location">
                                    <option value="0" {{ old($pest->id . 'all_location', $pestData ? $pestData->code : '') == 0 ? 'selected' : '' }}>
                                        0 - No damage.</option>
                                    <option value="1" {{ old($pest->id . 'all_location', $pestData ? $pestData->code : '') == 1 ? 'selected' : '' }}>
                                        1 - Rolling of terminal 1/3 of upper leaf only.</option>
                                    <option value="3" {{ old($pest->id . 'all_location', $pestData ? $pestData->code : '') == 3 ? 'selected' : '' }}>
                                        3 - Rolling of terminal 1/3 to 1/2 of terminal 2 leaves.</option>
                                    <option value="5" {{ old($pest->id . 'all_location', $pestData ? $pestData->code : '') == 5 ? 'selected' : '' }}>
                                        5 - Rolling and scorching of terminal 2 leaves.</option>
                                    <option value="7" {{ old($pest->id . 'all_location', $pestData ? $pestData->code : '') == 7 ? 'selected' : '' }}>
                                        7 - Rolling of entire length of all leaves and prominent scorching and wilting of leaves</option>
                                    <option value="9" {{ old($pest->id . 'all_location', $pestData ? $pestData->code : '') == 9 ? 'selected' : '' }}>
                                        9 - Pronounced wilting and drying of seedlings</option>
                                </x-form.select>
                            </div>
                        </div>
                    </div>
                @else
                    @php
                        $pestIcon = 'fa-bug';
                        $pestColor = 'bg-slate-100 dark:bg-slate-500/20 text-slate-600 dark:text-slate-400';
                        
                        switch($pest->name) {
                            case 'Gall Midge':
                                $pestIcon = 'fa-disease';
                                $pestColor = 'bg-purple-100 dark:bg-purple-500/20 text-purple-600 dark:text-purple-400';
                                break;
                            case 'Leaffolder':
                                $pestIcon = 'fa-leaf';
                                $pestColor = 'bg-teal-100 dark:bg-teal-500/20 text-teal-600 dark:text-teal-400';
                                break;
                            case 'Yellow Stem Borer':
                                $pestIcon = 'fa-spider';
                                $pestColor = 'bg-yellow-100 dark:bg-yellow-500/20 text-yellow-600 dark:text-yellow-400';
                                break;
                            case 'BPH+WBPH':
                                $pestIcon = 'fa-bacterium';
                                $pestColor = 'bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400';
                                break;
                            case 'Paddy Bug':
                                $pestIcon = 'fa-bug';
                                $pestColor = 'bg-rose-100 dark:bg-rose-500/20 text-rose-600 dark:text-rose-400';
                                break;
                            case 'Black Bug':
                                $pestIcon = 'fa-shield-virus';
                                $pestColor = 'bg-stone-200 dark:bg-stone-600/20 text-stone-700 dark:text-stone-300';
                                break;
                        }
                    @endphp
                    <div class="mb-4 group">
                        <h2 class="flex items-center justify-between p-4 text-lg font-bold text-slate-800 dark:text-slate-100 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl cursor-pointer toggleButton hover:border-primary dark:hover:border-primary hover:shadow-md transition-all">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg {{ $pestColor }} flex items-center justify-center">
                                    <i class="fas {{ $pestIcon }}"></i>
                                </div>
                                <span>{{ $pest->name }}</span>
                            </div>
                            <i class="fas fa-chevron-down text-slate-400 transition-transform duration-300 toggleIcon"></i>
                        </h2>
                        <div class="hidden p-5 mt-2 border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 rounded-xl toggleDiv shadow-inner">
                            <input type="text" hidden name="{{ $pest->name }}" value="{{ $pest->name }}">
                            <div class="mb-4">
                                @switch($pest->name)
                                    @case('Gall Midge')
                                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-red-100 dark:bg-red-500/10 text-sm font-semibold text-red-700 dark:text-red-400">
                                            <i class="fas fa-info-circle"></i> No of silver shoots
                                        </div>
                                    @break
                                    @case('Leaffolder')
                                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-red-100 dark:bg-red-500/10 text-sm font-semibold text-red-700 dark:text-red-400">
                                            <i class="fas fa-info-circle"></i> No of damaged tillers
                                        </div>
                                    @break
                                    @case('Yellow Stem Borer')
                                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-red-100 dark:bg-red-500/10 text-sm font-semibold text-red-700 dark:text-red-400">
                                            <i class="fas fa-info-circle"></i> No of dead hearts + white heads
                                        </div>
                                    @break
                                    @case('BPH+WBPH')
                                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-red-100 dark:bg-red-500/10 text-sm font-semibold text-red-700 dark:text-red-400">
                                            <i class="fas fa-info-circle"></i> No of adults and nymphs
                                        </div>
                                    @break
                                    @case('Paddy Bug')
                                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-red-100 dark:bg-red-500/10 text-sm font-semibold text-red-700 dark:text-red-400">
                                            <i class="fas fa-info-circle"></i> No of adults and nymphs
                                        </div>
                                    @break
                                @endswitch
                            </div>
                            <div class="grid grid-cols-2 gap-4 sm:grid-cols-4 md:grid-cols-5 xl:grid-cols-10">
                                @for ($i = 1; $i <= 10; $i++)
                                    <div class="col-span-1">
                                        <x-form.input type="number"
                                            name="{{ $pest->id }}_location_{{ $i }}"
                                            label="SP {{ $i }}"
                                            min=0>{{ old($pest->id . '_location_' . $i, $pestData ? $pestData->{'location_'.$i} : '') }}</x-form.input>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            <div class="col-span-2 mt-6">
                <div class="mb-4 group">
                    <h2 class="flex items-center justify-between p-4 text-lg font-bold text-slate-800 dark:text-slate-100 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-t-xl transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <span>Other Information within the AI Range</span>
                        </div>
                    </h2>
                    <div class="p-5 border border-t-0 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 rounded-b-xl shadow-inner">
                        <x-form.textarea name="otherinfo" label="none" rows="4"
                            placeholder="Example: Any insects damage (% damage or extent), Any disease, Any weeds">{{ old('otherinfo', $commonData->otherinfo) }}</x-form.textarea>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-indigo-700 text-white font-bold rounded-lg shadow-md transition-colors focus:ring-4 focus:ring-primary/50">
                <i class="fas fa-save mr-2"></i> Update Record
            </button>
        </div>
    </x-form>

    <script>
        document.querySelectorAll('.toggleButton').forEach(button => {
            button.addEventListener('click', () => {
                const toggleDiv = button.nextElementSibling;
                const icon = button.querySelector('.toggleIcon');
                
                // Toggle hidden class
                toggleDiv.classList.toggle('hidden');
                
                // Rotate icon if it exists
                if(icon) {
                    if(toggleDiv.classList.contains('hidden')) {
                        icon.style.transform = 'rotate(0deg)';
                        button.classList.remove('border-primary');
                    } else {
                        icon.style.transform = 'rotate(180deg)';
                        button.classList.add('border-primary');
                    }
                }
            });
        });
    </script>
</x-app-layout>
