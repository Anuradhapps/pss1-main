@section('title', 'Add My Info')

<x-app-layout>
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div
            class="flex flex-col items-start justify-between p-4 mb-6 space-y-4 bg-green-700 rounded-md shadow-md md:flex-row md:items-center md:space-y-0">
            <h3 class="text-2xl font-bold text-white">{{ $season }}</h3>
            <a href="{{ route('collector.create') }}"
                class="px-4 py-2 text-sm font-bold text-white transition bg-green-800 rounded hover:bg-green-900">
                Back
            </a>
        </div>

        <!-- Error Messages -->
        <x-error-massage />

        <!-- Form -->
        <x-form action="{{ route('collector.store') }}" method="POST">
            @csrf

            <!-- Phone Number -->
            <x-form.input placeholder="Enter your phone number" name="phone_no" label="Phone Number:" class="mb-4">
                {{ old('phone_no') }}
            </x-form.input>

            <!-- Region Selection -->
            <x-form.select name="region" label="Region:" id="region">
                <option>-- Select Region--</option>
                <option value="1" {{ old('region') == 1 ? 'selected' : '' }}>Provincial</option>
                <option value="2" {{ old('region') == 2 ? 'selected' : '' }}>Inter Provincial</option>
                <option value="3" {{ old('region') == 3 ? 'selected' : '' }}>Mahaweli</option>
            </x-form.select>

            <!-- Location Selection Component -->
            <livewire:location-select />

            <!-- Village Field -->
            <x-form.input placeholder="Enter your village" name="village" label="Village:" class="mb-4">
                {{ old('village') }}
            </x-form.input>

            <!-- GPS Location -->
            <x-gpsFill />

            <!-- Rice Variety & Date Established -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-form.input placeholder="Enter your rice variety" name="rice_variety" label="Rice Variety:"
                    class="mb-4">
                    {{ old('rice_variety') }}
                </x-form.input>

                <x-form.date name="date_establish" label="Date Established:" class="mb-4">
                    {{ old('date_establish') }}
                </x-form.date>
            </div>

            <!-- Save Button -->
            <x-form.submit
                class="w-full px-4 py-2 font-semibold text-center text-white transition bg-green-600 rounded hover:bg-green-700">
                Save
            </x-form.submit>
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
