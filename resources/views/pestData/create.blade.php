<x-app-layout>
    <x-headings.top-heading title="Create Pest Data" icon="fas fa-bug " buttonText="Back"
        buttonAction="{{ route('pestdata.view', $collectorId) }}" buttonIcon="fas fa-arrow-left" buttonColor="red"
        class="bg-green-700" />


    <x-form method="POST" action="{{ route('pestdata.store', $collectorId) }}" class="m-2">
        @csrf
        <div class="grid grid-cols-2 gap-2">
            <div class="col-span-2 sm:col-span-1">
                <x-form.date name="date_collected"
                    label="Data Collecting Date : ">{{ old('date_collected') }}</x-form.date>
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
                        <option value="{{ $i }}" {{ old('growth_s_c') == $i ? 'selected' : '' }}>
                            {{ $i }} - {{ $growthStageCode[$i - 1] }}</option>
                    @endfor
                </x-form.select>
            </div>
            <div class="col-span-2 sm:col-span-1">
                <x-form.input type="number" placeholder="Enter Temperature in celsius" name="temperature"
                    label="Temperature:" min=-50 max=50>{{ old('temperature') }}</x-form.input>
            </div>

            <div class="col-span-2 sm:col-span-1">
                <x-form.select id="numbrer_r_day" label="Number of Rainy Days: (Within the week)" class="block w-full"
                    name="numbrer_r_day" placeholder="Select Number of Rainy Days">
                    @for ($i = 0; $i <= 7; $i++)
                        <option value="{{ $i }}" {{ old('numbrer_r_day') == $i ? 'selected' : '' }}>
                            {{ $i }}</option>
                    @endfor
                </x-form.select>
            </div>

        </div>

        <div class="p-2  transition transform border-2 border-gray-900 shadow-lg hover:shadow-xl">
            <h5 class="mb-2 italic text-red-400">If you have identified the pest, Please click on the pest and enter the
                value.
            </h5>
            <span class="text-sm italic text-red-400">* SP - Sample point</span>
        </div>

        <div class="mt-2">
            <div class="mb-2">
                <h2
                    class="p-2 text-base font-bold text-white transition bg-gray-900 border border-green-400 cursor-pointer toggleButton hover:bg-gray-700">
                    Number Of Tillers</h2>
                <div class="hidden p-4 border border-black rounded-md toggleDiv">
                    <input type="text" hidden name="Number_Of_Tillers" value="Number_Of_Tillers">
                    <div class="grid grid-cols-3 gap-4 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-5 xl:grid-cols-10">
                        @for ($i = 1; $i <= 10; $i++)
                            <div class="col-span-1">
                                <x-form.input type="number" name="Number_Of_Tillers_location_{{ $i }}"
                                    label="SP {{ $i }}" min=0
                                    required>{{ old('Number_Of_Tillers_location_' . $i) }}</x-form.input>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
            @foreach ($pests as $pest)
                @if ($pest->name == 'Thrips')
                    <div class="mb-2">
                        <h2
                            class="p-2 text-base font-bold text-white transition bg-gray-900 border border-green-400 cursor-pointer toggleButton hover:bg-gray-700">
                            {{ $pest->name }}</h2>
                        <div class="hidden p-4 border border-black toggleDiv bg-gray-450">
                            <input type="text" hidden name="{{ $pest->name }}" value="{{ $pest->name }}">
                            <div class="">
                                <div class="">
                                    <x-form.select id="{{ $pest->id }}all_location" label="Code:" class="block"
                                        name="{{ $pest->id }}all_location">
                                        <option value="0"
                                            {{ old($pest->id . 'all_location') == 0 ? 'selected' : '' }}>
                                            0 - No damage.</option>
                                        <option value="1"
                                            {{ old($pest->id . 'all_location') == 1 ? 'selected' : '' }}>
                                            1 - Rolling of terminal 1/3 of upper leaf only.</option>
                                        <option value="3"
                                            {{ old($pest->id . 'all_location') == 3 ? 'selected' : '' }}>
                                            3 - Rolling of terminal 1/3 to 1/2 of terminal 2 leaves.</option>
                                        <option value="5"
                                            {{ old($pest->id . 'all_location') == 5 ? 'selected' : '' }}>
                                            5 - Rolling and scorching of terminal 2 leaves.</option>
                                        <option value="7"
                                            {{ old($pest->id . 'all_location') == 7 ? 'selected' : '' }}>
                                            7 - Rolling of entire length of all leaves and prominent scorching and
                                            wilting of leaves</option>
                                        <option value="9"
                                            {{ old($pest->id . 'all_location') == 9 ? 'selected' : '' }}>
                                            9 - Pronounced wilting and drying of seedlings</option>

                                    </x-form.select>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mb-2">
                        <h2
                            class="p-2 text-base font-bold text-white transition bg-gray-900 border border-green-400 cursor-pointer  toggleButton hover:bg-gray-700">
                            {{ $pest->name }}</h2>
                        <div class="hidden p-4 border border-black rounded-md toggleDiv bg-gray-450">
                            <input type="text" hidden name="{{ $pest->name }}" value="{{ $pest->name }}">
                            <div class="mb-2">
                                @switch($pest->name)
                                    @case($pest->name == 'Gall Midge')
                                        <div class="text-sm italic text-red-600">No of silver shoots</div>
                                    @break

                                    @case($pest->name == 'Leaffolder')
                                        <div class="text-sm italic text-red-600">No of damaged tillers</div>
                                    @break

                                    @case($pest->name == 'Yellow Stem Borer')
                                        <div class="text-sm italic text-red-600">No of dead hearts + white heads</div>
                                    @break

                                    @case($pest->name == 'BPH+WBPH')
                                        <div class="text-sm italic text-red-600">No of adults and nymphs</div>
                                    @break

                                    @case($pest->name == 'Paddy Bug')
                                        <div class="text-sm italic text-red-600">No of adults and nymphs</div>
                                    @break

                                    @default
                                @endswitch
                            </div>
                            <div
                                class="grid grid-cols-3 gap-4 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-5 xl:grid-cols-10">

                                @for ($i = 1; $i <= 10; $i++)
                                    <div class="col-span-1">
                                        <x-form.input type="number"
                                            name="{{ $pest->id }}_location_{{ $i }}"
                                            label="SP {{ $i }}"
                                            min=0>{{ old($pest->id . '_location_' . $i) }}</x-form.input>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            <div class="col-span-2 sm:col-span-1">
                <x-form.textarea name="otherinfo" label="Other information within the Ai Range :"
                    placeholder="Example: Any insects damage (% damage or extent) , Any disease, Any weeds">{{ old('otherinfo') }}</x-form.input>
            </div>

        </div>

        <div class="mt-1">
            <x-form.submit class="">Submit</x-form.submit>
        </div>
    </x-form>

    <script>
        document.querySelectorAll('.toggleButton').forEach(button => {
            button.addEventListener('click', () => {
                const toggleDiv = button.nextElementSibling; // Get the next div sibling
                toggleDiv.classList.toggle('hidden');
            });
        });
    </script>
</x-app-layout>
