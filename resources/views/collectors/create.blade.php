@section('title', 'Add My info')
<x-app-layout>
    <div class="m-5">
        <!-- resources/views/collector.blade.php -->
        <x-form action="{{ route('admin.collector.store') }}">
            <x-form.input name="phone_no" label="Phone Number:">{{ old('phone_no') }}</x-form.input>
            <x-form.select name="district" label="District:">
                <option value="">-- Select District --</option>
                @foreach ($districts as $district)
                <option value="{{ $district->id }}">{{ $district->name }}</option>
                @endforeach
            </x-form.select>

            <div class="mb-5">
                <label for='asc' class='block mb-2 font-bold text-sm text-gray-600 dark:text-gray-200'>ASC/Unit</label>
                <select class="border border-gray-300 dark:bg-gray-500 dark:text-gray-200 p-1 w-full rounded" name="asc"
                    id="as_center">
                    <option value="">-- Select ASC --</option>
                    <option value="">No ASC</option>
                </select>
                <span>If there is no ASC/Unit, please create a new one</span>
                <input id="new-asc" type="text" class="border border-gray-300 dark:bg-gray-500 dark:text-gray-200 p-1 w-full rounded ml-2" placeholder="Enter new asc" name="asc_input" />
            </div>
            <x-form.input name="ai_range" label="AI Range:">{{ old('ai_range') }}</x-form.input>
            <x-form.input name="village" label="Village:">{{ old('village') }}</x-form.input>
            <x-form.input name="gps_lati" label="GPS Latitude:">{{ old('gps_lati') }}</x-form.input>
            <x-form.input name="gps_long" label="GPS Longitude:">{{ old('gps_long') }}</x-form.input>
            <x-form.input name="rice_variety" label="Rice Variety:">{{ old('rice_variety') }}</x-form.input>
            <x-form.date name="date_establish" label="Date Established:">{{ old('date_establish') }}</x-form.date>
            <x-form.submit>Save</x-form.submit>
        </x-form>
        <script>
            document.querySelector('#district').addEventListener('change', function() {

            var Id = this.value; // get the selected district ID
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route('admin.get.as.centers', ':districtId') }}'.replace(':districtId', Id));
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // success, update the as_centers dropdown with the new options
                    var asCenters = JSON.parse(xhr.responseText);
                    var asCentersDropdown = document.querySelector('#as_center');
                    asCentersDropdown.innerHTML = '';
                    asCenters.forEach(function(asCenter) {
                        var option = document.createElement('option');
                        option.value = asCenter.id;
                        option.text = asCenter.name;
                        asCentersDropdown.appendChild(option);
                    });
                } else {
                    // error handling
                    //alert("jchvfdh");
                }
            };
            xhr.send();

        });
        </script>
    </div>
</x-app-layout>