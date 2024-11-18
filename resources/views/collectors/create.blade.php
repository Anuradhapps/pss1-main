@section('title', 'Add My info')
<x-app-layout>

    <div class="m-5">
        <h3 class="mb-4 text-2xl font-bold text-center text-gray-200 bg-emerald-900 rounded-3xl">{{ $season }}</h3>
        <x-error-massage />
        <x-form action="{{ route('admin.collector.store') }}">
            @csrf
            <x-form.input name="phone_no" label="Phone Number:">{{ old('phone_no') }}</x-form.input>

            <livewire:location-select />

            <x-form.input name="village" label="Village:">{{ old('village') }}</x-form.input>


            <!-- GPS Location -->
            <x-gpsFill/>

            <x-form.input name="rice_variety" label="Rice Variety:">{{ old('rice_variety') }}</x-form.input>
            <x-form.date name="date_establish" label="Date Established:">{{ old('date_establish') }}</x-form.date>
            <x-form.submit>Save</x-form.submit>
        </x-form>
    </div>
    <script>
        document.getElementById('fill-location').addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    // Get the current position
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    // Set the values of the latitude and longitude input fields
                    document.getElementById('gps_lati').value = latitude;
                    document.getElementById('gps_long').value = longitude;
                }, function(error) {
                    console.error('Error getting location:', error);
                    alert('Unable to retrieve your location. Please enter it manually.');
                });
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        });
    </script>

</x-app-layout>
