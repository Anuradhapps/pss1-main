<x-app-layout>
    <div class="flex justify-between p-3 mb-4 bg-orange-700">
        <h1 class="text-2xl font-bold text-indigo-100">Create Pest Data</h1>
        <a href="{{ route('pestdata.index') }}"
            class="px-4 py-2 text-sm font-bold text-white bg-red-800 rounded hover:bg-red-900">Back</a>
    </div>

    <x-form method="POST" action="{{ route('pestdata.store') }}">
        @csrf
        <div class="grid grid-cols-2 gap-2 mb-3">
            <div class="col-span-2 sm:col-span-1">
                <x-form.date name="date_collected"
                    label="Date of Collected Data:">{{ old('date_collected') }}</x-form.date>
            </div>
            <div class="col-span-2 sm:col-span-1">
                <x-form.select id="growth_s_c" label="Growth Stage Code" class="block w-full mt-1" name="growth_s_c">
                    <option value="">-- Select code --</option>
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
                <x-form.input type="number" name="temperature" label="Temperature:" min=-50
                    max=50>{{ old('temperature') }}</x-form.input>
            </div>

            <div class="col-span-2 sm:col-span-1">
                <x-form.select id="numbrer_r_day" label="Number of Rainy Days: (In last week)" class="block w-full mt-1"
                    name="numbrer_r_day">
                    <option value="">-- Select Number of Rainy Days --</option>
                    @for ($i = 0; $i <= 7; $i++)
                        <option value="{{ $i }}" {{ old('numbrer_r_day') == $i ? 'selected' : '' }}>
                            {{ $i }}</option>
                    @endfor
                </x-form.select>
            </div>

        </div>



        <h5 class="mb-2 italic text-orange-400">Select and enter a value for the identified pest only</h5>
        <span class="text-sm italic text-orange-400">* SP - Sample point</span>
        <div class="mt-2">
            <div class="mb-2">
                <h2
                    class="p-2 text-base font-bold text-white transition bg-gray-600 border border-gray-100 rounded-lg cursor-pointer toggleButton hover:bg-gray-500">
                    Number Of Tillers</h2>
                <div class="hidden p-4 border border-black rounded-md toggleDiv bg-gray-450">
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
                            class="p-2 text-base font-bold text-white transition bg-gray-600 border border-gray-100 rounded-lg cursor-pointer toggleButton hover:bg-gray-500">
                            {{ $pest->name }}</h2>
                        <div class="hidden p-4 border border-black rounded-md toggleDiv bg-gray-450">
                            <input type="text" hidden name="{{ $pest->name }}" value="{{ $pest->name }}">
                            <div
                                class="grid grid-cols-3 gap-4 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-5 xl:grid-cols-10">
                                <div class="col-span-1">
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
                    {{-- <div class="mb-2">
                        <h2
                            class="p-2 text-base font-bold text-white transition bg-gray-600 border border-gray-100 rounded-lg cursor-pointer toggleButton hover:bg-gray-500">
                            {{ $pest->name }}</h2>
                        <div class="hidden p-4 border border-black rounded-md toggleDiv bg-gray-450">
                            <input type="text" hidden name="{{ $pest->name }}" value="{{ $pest->name }}">
                            <div
                                class="grid grid-cols-3 gap-4 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-5 xl:grid-cols-10">
                                <div class="col-span-1">
                                    <x-form.input type="number" name="{{ $pest->id }}all_location" label="Code:"
                                        min=0>{{ old($pest->id . 'all_location') }}</x-form.input>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                @else
                    <div class="mb-2">
                        <h2
                            class="p-2 text-base font-bold text-white transition bg-gray-600 border border-gray-100 rounded-lg cursor-pointer toggleButton hover:bg-gray-500">
                            {{ $pest->name }}</h2>
                        <div class="hidden p-4 border border-black rounded-md toggleDiv bg-gray-450">
                            <input type="text" hidden name="{{ $pest->name }}" value="{{ $pest->name }}">
                            <div class="mb-2">
                                @switch($pest->name)
                                    @case($pest->name == 'Gall Midge')
                                        <div class="text-sm italic text-orange-500">No of silver shoots</div>
                                    @break

                                    @case($pest->name == 'Leaffolder')
                                        <div class="text-sm italic text-orange-500">No of damaged tillers</div>
                                    @break

                                    @case($pest->name == 'Yellow Stem Borer')
                                        <div class="text-sm italic text-orange-500">No of dead hearts + white heads</div>
                                    @break

                                    @case($pest->name == 'BPH+WBPH')
                                        <div class="text-sm italic text-orange-500">No of adults and nymphs</div>
                                    @break

                                    @case($pest->name == 'Paddy Bug')
                                        <div class="text-sm italic text-orange-500">No of adults and nymphs</div>
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
                <x-form.textarea name="otherinfo" label="Other info:">{{ old('otherinfo') }}</x-form.input>
            </div>

        </div>

        <div class="mt-6">
            <x-form.submit class="text-white transition bg-red-900 hover:bg-red-700">Submit</x-form.submit>
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
