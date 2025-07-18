<!-- GPS Location Refresh Section (Dark Mode Only) -->
<div
    class="flex flex-col items-start gap-3 p-4 mb-6 text-white bg-gray-900 border-l-4 border-blue-500 shadow-sm sm:flex-row sm:items-center">
    <button type="button" id="fill-location"
        class="flex items-center px-5 py-2.5 font-semibold text-white transition duration-300 bg-blue-600  hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
        <i id="refresh-icon" class="mr-2 fas fa-sync-alt"></i>
        <span id="refresh-text">Refresh Location</span>
    </button>
    <p class="text-sm italic text-blue-300">Click 'Refresh Location' to auto-fill your current GPS coordinates. You may
        enter them manually if needed.</p>
</div>

<!-- Latitude and Longitude Input Fields -->
@if (isset($collector))
    <div class="flex gap-4 justify-between">
        <x-form.input name="gps_lati" id="gps_lati" label="GPS Latitude:"
            class="mb-4 text-white bg-gray-800 border-gray-600">
            {{ old('gps_lati', $collector->gps_lati) }}
        </x-form.input>
        <x-form.input name="gps_long" id="gps_long" label="GPS Longitude:"
            class="mb-4 text-white bg-gray-800 border-gray-600">
            {{ old('gps_long', $collector->gps_long) }}
        </x-form.input>
    </div>
@else
    <div class="flex gap-4 justify-between">
        <x-form.input name="gps_lati" id="gps_lati" label="GPS Latitude:"
            class="mb-4 text-white bg-gray-800 border-gray-600">
            {{ old('gps_lati') }}
        </x-form.input>
        <x-form.input name="gps_long" id="gps_long" label="GPS Longitude:"
            class="mb-4 text-white bg-gray-800 border-gray-600">
            {{ old('gps_long') }}
        </x-form.input>
    </div>
@endif

<!-- GPS Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const button = document.getElementById('fill-location');
        const icon = document.getElementById('refresh-icon');
        const text = document.getElementById('refresh-text');

        button.addEventListener('click', function() {
            icon.classList.add('fa-spin');
            text.textContent = 'Locating...';
            button.disabled = true;

            if (!navigator.geolocation) {
                alert('Geolocation is not supported by your browser.');
                resetButton();
                return;
            }

            // Timeout if it takes too long
            const timeout = setTimeout(() => {
                alert('GPS request timed out. Please enter location manually.');
                resetButton();
            }, 10000);

            navigator.geolocation.getCurrentPosition(
                function(position) {
                    clearTimeout(timeout);

                    const latitude = position.coords.latitude.toFixed(6);
                    const longitude = position.coords.longitude.toFixed(6);

                    document.getElementById('gps_lati').value = latitude;
                    document.getElementById('gps_long').value = longitude;

                    resetButton('Location Set');
                },
                function(error) {
                    clearTimeout(timeout);
                    console.error('Location Error:', error.message);
                    alert('Unable to retrieve your location. Please enter manually.');
                    resetButton();
                }
            );

            function resetButton(status = 'Refresh Location') {
                icon.classList.remove('fa-spin');
                text.textContent = status;
                button.disabled = false;

                // Reset back to original text after 3 seconds
                if (status !== 'Refresh Location') {
                    setTimeout(() => text.textContent = 'Refresh Location', 3000);
                }
            }
        });
    });
</script>
