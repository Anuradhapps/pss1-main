@section('title', 'Add My Info')

<x-app-layout>
    <div class="">
        <!-- Header -->
        <x-headings.topHeading title="Collector Create" subtitle="{{ $season }} Season" icon="fas fa-wheat-awn"
            buttonText="Back" buttonAction="{{ route('collector.create') }}" buttonIcon="fas fa-arrow-left"
            buttonColor="red" class="bg-cyan-700" />

        <!-- Error Messages -->
        <x-error-massage />

        <!-- Form -->
        <x-form action="{{ route('collector.store') }}" method="POST" class="space-y-6 p-2">
            @csrf

            <!-- Phone Number -->
            <x-form.input placeholder="Enter your phone number" type="tel" name="phone_no" label="Phone Number:"
                class="mb-4">
                {{ old('phone_no') }}
            </x-form.input>

            <!-- Region Selection -->
            <x-form.select name="region" label="Region:" id="region" placeholder="Select Region">
                <option value="1" {{ old('region') == 1 ? 'selected' : '' }}>Provincial</option>
                <option value="2" {{ old('region') == 2 ? 'selected' : '' }}>Inter Provincial</option>
                <option value="3" {{ old('region') == 3 ? 'selected' : '' }}>Mahaweli</option>
            </x-form.select>

            <!-- Location Selection Component -->
            <div class=" border border-green-300 ">
                <livewire:location-select />
            </div>


            <!-- Village Field -->
            <x-form.input placeholder="Enter your village" name="village" label="Village:" class="mb-4">
                {{ old('village') }}
            </x-form.input>

            <!-- GPS Location -->
            <x-gpsFill />

            <!-- Rice Variety & Date Established -->
            <div class="flex gap-4 justify-between">
                <x-form.input placeholder="Enter your rice variety" name="rice_variety" label="Rice Variety:"
                    class="mb-4">
                    {{ old('rice_variety') }}
                </x-form.input>

                <x-form.date name="date_establish" label="Date Established:" class="mb-4">
                    {{ old('date_establish') }}
                </x-form.date>
            </div>

            <!-- Established Method Field -->
            <x-form.select name="established_method" label="Established Method:" id="established_method"
                placeholder="Select Established Method">

                <option value="Broadcast" {{ old('established_method') == 'Broadcast' ? 'selected' : '' }}>Broadcast
                </option>
                <option value="Transplant" {{ old('established_method') == 'Transplant' ? 'selected' : '' }}>Transplant
                </option>
                <option value="Parachute" {{ old('established_method') == 'Parachute' ? 'selected' : '' }}>Parachute
                </option>
                <option value="N/A" {{ old('established_method') == 'N/A' ? 'selected' : '' }}>N/A
                </option>
            </x-form.select>

            <!-- Save Button -->

            <x-buttons.button-1 type="submit" color="blue" href="" icon="fas fa-save" class="w-full">
                Save
                </x-button>

        </x-form>
    </div>

    <!-- GPS Auto-Fill Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fillLocationBtn = document.getElementById('fill-location');

            if (fillLocationBtn) {
                fillLocationBtn.addEventListener('click', function() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            function(position) {
                                document.getElementById('gps_lati').value = position.coords.latitude;
                                document.getElementById('gps_long').value = position.coords.longitude;
                            },
                            function(error) {
                                console.error('Error getting location:', error);
                                alert('Unable to retrieve your location. Please enter it manually.');
                            }
                        );
                    } else {
                        alert('Geolocation is not supported by this browser.');
                    }
                });
            }
        });
    </script>
</x-app-layout>
