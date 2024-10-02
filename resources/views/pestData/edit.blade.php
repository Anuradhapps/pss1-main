<x-app-layout>
    <div class="flex justify-between mb-4">
        <h1 class="text-2xl font-bold text-red-900 ">Edit Pest Data</h1>
        <a href="{{ route('pestdata.index') }}"
            class="bg-red-800 text-white font-bold py-2 px-4 rounded hover:bg-red-900 text-sm mr-1">Back</a>
    </div>

    <x-form method="POST" action="{{ route('pestdata.update', $commonData->id) }}">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="col-span-2 sm:col-span-1">
                <x-form.date name="date_collected" label="Date of Collected Data:">{{ $commonData->c_date }}
                </x-form.date>
            </div>
            <div class="col-span-2 sm:col-span-1">
                <x-form.input type="number" name="temperature" label="Temperature:" min=-50 max=50>{{ $commonData->temperature }}
                </x-form.input>
            </div>
            <div class="col-span-2 sm:col-span-1">
                <x-form.select id="growth_s_c" label="Growth Stage Code" class="block mt-1 w-full" name="growth_s_c">
                    <option value="">-- Select code --</option>
                    @for ($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}" {{ $i == $commonData->growth_s_c ? 'selected' : '' }}>
                            {{ $i }}</option>
                    @endfor
                </x-form.select>
            </div>
            <div class="col-span-2 sm:col-span-1">
                <x-form.select id="growth_s_c" label="Number of Rainy Days:" class="block mt-1 w-full"
                    name="numbrer_r_day">
                    <option value="">-- Select Number of Rainy Days --</option>
                    @for ($i = 1; $i <= 7; $i++)
                        <option value="{{ $i }}" {{ $i == $commonData->numbrer_r_day ? 'selected' : '' }}>
                            {{ $i }}</option>
                    @endfor
                </x-form.select>
            </div>

        </div>

        <h5 class="text-italic text-red-900 mb-5">Select and enter a value for the identified pest only</h5>

        <div>

            @foreach ($pestsData as $pest)
                @if ($pest->pest_name == 'Thrips')
                    <div class="mb-2">
                        <h2
                            class="toggleButton text-base  font-bold p-2 rounded-lg border text-white border-gray-100 bg-gray-600 hover:bg-gray-500 cursor-pointer transition">
                            {{ $pest->pest_name }}
                        </h2>

                        <div class="toggleDiv hidden bg-gray-450 p-4 border border-black rounded-md">
                            <input type="text" hidden name="{{ $pest->pest_name }}" value="{{ $pest->pest_name }}">
                            <div
                                class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-5 xl:grid-cols-10 gap-4">

                                <div class="col-span-1">
                                    <x-form.input type="number" name="{{ $pest->pest_name }}all_location"
                                        label="All Location:" min=0>
                                        {{ $pest->total }}
                                    </x-form.input>
                                </div>

                            </div>
                        </div>
                    </div>
                @else
                    <div class="mb-2">
                        <h2
                            class="toggleButton text-base  font-bold p-2 rounded-lg border text-white border-gray-100 bg-gray-600 hover:bg-gray-500 cursor-pointer transition">
                            {{ $pest->pest_name }}
                        </h2>

                        <div class="toggleDiv hidden bg-gray-450 p-4 border border-black rounded-md">
                            <input type="text" hidden name="{{ $pest->pest_name }}" value="{{ $pest->pest_name }}">
                            <div
                                class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-5 xl:grid-cols-10 gap-4">

                                <div class="col-span-1">
                                    <x-form.input type="number" name="{{ $pest->pest_name }}_location_1"
                                        label="Location 1:" min=0> {{ $pest->location_one }}
                                    </x-form.input>
                                </div>
                                <div class="col-span-1">
                                    <x-form.input type="number" name="{{ $pest->pest_name }}_location_2"
                                        label="Location 2:" min=0>{{ $pest->location_two }}
                                    </x-form.input>
                                </div>
                                <div class="col-span-1">
                                    <x-form.input type="number" name="{{ $pest->pest_name }}_location_3"
                                        label="Location 3:" min=0>{{ $pest->location_three }}
                                    </x-form.input>
                                </div>
                                <div class="col-span-1">
                                    <x-form.input type="number" name="{{ $pest->pest_name }}_location_4"
                                        label="Location 4:" min=0>{{ $pest->location_four }}
                                    </x-form.input>
                                </div>
                                <div class="col-span-1">
                                    <x-form.input type="number" name="{{ $pest->pest_name }}_location_5"
                                        label="Location 5:" min=0>{{ $pest->location_five }}
                                    </x-form.input>
                                </div>
                                <div class="col-span-1">
                                    <x-form.input type="number" name="{{ $pest->pest_name }}_location_6"
                                        label="Location 6:" min=0>{{ $pest->location_six }}
                                    </x-form.input>
                                </div>
                                <div class="col-span-1">
                                    <x-form.input type="number" name="{{ $pest->pest_name }}_location_7"
                                        label="Location 7:" min=0>{{ $pest->location_seven }}
                                    </x-form.input>
                                </div>
                                <div class="col-span-1">
                                    <x-form.input type="number" name="{{ $pest->pest_name }}_location_8"
                                        label="Location 8:" min=0>{{ $pest->location_eight }}
                                    </x-form.input>
                                </div>
                                <div class="col-span-1">
                                    <x-form.input type="number" name="{{ $pest->pest_name }}_location_9"
                                        label="Location 9:" min=0>{{ $pest->location_nine }}
                                    </x-form.input>
                                </div>
                                <div class="col-span-1">
                                    <x-form.input type="number" name="{{ $pest->pest_name }}_location_10"
                                        label="Location 10:" min=0>{{ $pest->location_ten }}
                                    </x-form.input>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
            <div class="col-span-2 sm:col-span-1">
                <x-form.textarea name="otherinfo" label="Other info:">{{ $commonData->otherinfo }}</x-form.input>
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
