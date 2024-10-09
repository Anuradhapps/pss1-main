<x-app-layout>
    <div class="flex justify-between mb-4">
        <h1 class="text-2xl font-bold text-red-900 ">Create Pest Data</h1>
        <a href="{{ route('pestdata.index') }}"
            class="bg-red-800 text-white font-bold py-2 px-4 rounded hover:bg-red-900 text-sm mr-1">Back</a>
    </div>

    <x-form method="POST" action="{{ route('pestdata.store') }}">
        @csrf
        <div class="grid grid-cols-2 gap-2 mb-3">
            <div class="col-span-2 sm:col-span-1">
                <x-form.date name="date_collected" label="Date of Collected Data:">{{ old('date_collected') }}</x-form.date>
            </div>
            <div class="col-span-2 sm:col-span-1">
                <x-form.input type="number" name="temperature" label="Temperature:" min=-50 max=50>{{ old('temperature') }}</x-form.input>
            </div>
            <div class="col-span-2 sm:col-span-1">
                <x-form.select id="growth_s_c" label="Growth Stage Code" class="block mt-1 w-full" name="growth_s_c">
                    <option value="">-- Select code --</option>
                    @for ($i = 1; $i <= 9; $i++)
                        <option value="{{ $i }}" {{ old('growth_s_c') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </x-form.select>
            </div>
            <div class="col-span-2 sm:col-span-1">
                <x-form.select id="numbrer_r_day" label="Number of Rainy Days:" class="block mt-1 w-full"
                    name="numbrer_r_day">
                    <option value="" >-- Select Number of Rainy Days --</option>
                    @for ($i = 1; $i <= 7; $i++)
                        <option value="{{ $i }}" {{ old('numbrer_r_day') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </x-form.select>
            </div>

        </div>

      

        <h5 class="text-italic text-red-900 mb-2">Select and enter a value for the identified pest only</h5>
        <div >
                <div class="mb-2">
                    <h2 class="toggleButton text-base  font-bold p-2 rounded-lg border text-white border-gray-100 bg-gray-600 hover:bg-gray-500 cursor-pointer transition">Number Of Tillers</h2>
                    <div class="toggleDiv hidden bg-gray-450 p-4 border border-black rounded-md">
                        <input type="text" hidden name="Number_Of_Tillers" value="Number_Of_Tillers">
                        <div class="grid  grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-5 xl:grid-cols-10 gap-4">
                            @for ($i = 1; $i <= 10; $i++)
                                    <div class="col-span-1">
                                        <x-form.input type="number" name="Number_Of_Tillers_location_{{ $i }}" label="Sample Point {{ $i }}" min=0 required>{{ old('Number_Of_Tillers_location_' . $i) }}</x-form.input>
                                    </div>
                            @endfor
                        </div>
                    </div>
                </div>
                @foreach ($pests as $pest)
                    @if ($pest->name == 'Thrips')
                        <div class="mb-2">
                            <h2 class="toggleButton text-base  font-bold p-2 rounded-lg border text-white border-gray-100 bg-gray-600 hover:bg-gray-500 cursor-pointer transition">{{ $pest->name }}</h2>
                            <div class="toggleDiv hidden bg-gray-450 p-4 border border-black rounded-md">
                                <input type="text" hidden name="{{ $pest->name }}" value="{{ $pest->name }}">
                                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-5 xl:grid-cols-10 gap-4">
                                    <div class="col-span-1">
                                        <x-form.input type="number" name="{{ $pest->id }}all_location" label="Code:" min=0>{{ old($pest->id . 'all_location') }}</x-form.input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                    <div class="mb-2">
                        <h2 class="toggleButton text-base  font-bold p-2 rounded-lg border text-white border-gray-100 bg-gray-600 hover:bg-gray-500 cursor-pointer transition">{{ $pest->name }}</h2>
                        <div class="toggleDiv hidden bg-gray-450 p-4 border border-black rounded-md">
                            <input type="text" hidden name="{{ $pest->name }}" value="{{ $pest->name }}">
                            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-5 xl:grid-cols-10 gap-4">
                                @for ($i = 1; $i <= 10; $i++)
                                    <div class="col-span-1">
                                        <x-form.input type="number" name="{{ $pest->id }}_location_{{ $i }}" label="Sample Point {{ $i }}" min=0>{{ old($pest->id . '_location_' . $i) }}</x-form.input>
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
            <x-form.submit class="bg-red-900 text-white hover:bg-red-700 transition">Submit</x-form.submit>
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
