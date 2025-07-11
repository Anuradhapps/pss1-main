@section('title', 'Add My Info')

<x-app-layout>
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div
            class="flex flex-col items-start justify-between p-6 mb-8 space-y-4 shadow-lg bg-gradient-to-r from-green-700 to-green-800 rounded-xl md:flex-row md:items-center md:space-y-0">

            <div class="flex justify-between">
                <div class="font-extrabold text-7xl">
                    🌾
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold tracking-wide text-white">
                        Collector Create
                    </h3>
                    <h5 class="text-lg italic text-white">{{ $season }} Season</h5>
                </div>

            </div>
            <div class="flex justify-end w-full sm:w-auto">
                <a href="{{ route('collector.create') }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition duration-300 bg-red-700 rounded-full hover:bg-red-800">
                    <i class="mr-2 fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <!-- Error Messages -->
        <x-error-massage />

        <!-- Form -->
        <x-form action="{{ route('collector.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Phone Number -->
            <x-form.input placeholder="Enter your phone number" name="phone_no" label="📞 Phone Number:" class="mb-4">
                {{ old('phone_no') }}
            </x-form.input>

            <!-- Region Selection -->
            <x-form.select name="region" label="🌍 Region:" id="region" placeholder="Select Region">
                <option value="1" {{ old('region') == 1 ? 'selected' : '' }}>Provincial</option>
                <option value="2" {{ old('region') == 2 ? 'selected' : '' }}>Inter Provincial</option>
                <option value="3" {{ old('region') == 3 ? 'selected' : '' }}>Mahaweli</option>
            </x-form.select>

            <!-- Location Selection Component -->
            <livewire:location-select />

            <!-- Village Field -->
            <x-form.input placeholder="Enter your village" name="village" label="🏘️ Village:" class="mb-4">
                {{ old('village') }}
            </x-form.input>

            <!-- GPS Location -->
            <x-gpsFill />

            <!-- Rice Variety & Date Established -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <x-form.input placeholder="Enter your rice variety" name="rice_variety" label="🌾 Rice Variety:"
                    class="mb-4">
                    {{ old('rice_variety') }}
                </x-form.input>

                <x-form.date name="date_establish" label="📅 Date Established:" class="mb-4">
                    {{ old('date_establish') }}
                </x-form.date>
            </div>

            <!-- Established Method Field -->
            <x-form.select name="established_method" label="🛠️ Established Method:" id="established_method"
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
            <x-form.submit
                class="w-full px-6 py-3 font-bold text-white transition duration-300 bg-green-600 rounded-xl hover:bg-green-700">
                ✅ Save Information
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
