<!-- GPS Location Refresh Button -->
<div class="flex items-center mb-4">
    <button type="button" id="fill-location"
        class="btn btn-sm btn-primary bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded flex items-center">
        <i id="refresh-icon" class="fas fa-sync-alt me-2"></i> <!-- Font Awesome Refresh Icon -->
        Refresh
    </button>
    <span class="text-red-800 text-sm ml-3">Click 'Refresh' if you want to get the current GPS location. If it is not
        correct, please enter it manually.</span>
</div>

<!-- Latitude and Longitude Input Fields -->
@if (isset($collector))
    <x-form.input name="gps_lati" label="GPS Latitude:"
        class="mb-4">{{ old('gps_lati', $collector->gps_lati) }}</x-form.input>
    <x-form.input name="gps_long" label="GPS Longitude:"
        class="mb-4">{{ old('gps_long', $collector->gps_long) }}</x-form.input>
@else
    <x-form.input name="gps_lati" label="GPS Latitude:">{{ old('gps_lati') }}</x-form.input>
    <x-form.input name="gps_long" label="GPS Longitude:">{{ old('gps_long') }}</x-form.input>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('fill-location').addEventListener('click', function() {
            // Get the icon element
            const refreshIcon = document.getElementById('refresh-icon');

            // Add the spinning class to the icon
            refreshIcon.classList.add('fa-spin');

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    // Get the current position
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    // Set the values of the latitude and longitude input fields
                    document.getElementById('gps_lati').value = latitude;
                    document.getElementById('gps_long').value = longitude;

                    // Stop the spinning icon after the location is retrieved
                    refreshIcon.classList.remove('fa-spin');
                }, function(error) {
                    console.error('Error getting location:', error);
                    alert('Unable to retrieve your location. Please enter it manually.');

                    // Stop the spinning icon in case of error
                    refreshIcon.classList.remove('fa-spin');
                });
            } else {
                alert('Geolocation is not supported by this browser.');
                refreshIcon.classList.remove('fa-spin');
            }
        });
    });
</script>
