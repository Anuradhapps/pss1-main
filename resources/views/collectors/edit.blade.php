@section('title', 'Add My info')
<x-app-layout>

    <div class="m-5">
        <h3 class="mb-2">{{ $season }}</h3>
        <x-form action="{{ route('admin.collector.update', $collector->id) }}">
            @csrf
            @method('PUT')
            <x-form.input name="phone_no" label="Phone Number:">{{ old('phone_no', $collector->phone_no) }}</x-form.input>
            {{-- <x-form.select name="province" label="Province:" id="province">
                <option value="">-- Select Province --</option>
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}" {{ $collector->province == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                @endforeach
            </x-form.select>

            <x-form.select name="district" label="District:" id="district">
                <option value="">-- Select District --</option>
                @foreach ($districts as $district)
                    <option value="{{ $district->id }}" {{ $collector->district == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                @endforeach
                
            </x-form.select>

            <x-form.select name="as_center" label="ASC/Unit:" id="as_center">
                <option value="">-- Select ASC --</option>
                @foreach ($as_centers as $as_center)
                    <option value="{{ $as_center->id }}" {{ $collector->asc == $as_center->id ? 'selected' : '' }}>{{ $as_center->name }}</option>
                @endforeach
            </x-form.select>
            <x-form.select name="ai_range" label="AI Range:" id="ai_range">
                <option value="">-- Select AI Range --</option>
                @foreach ($ai_ranges as $ai_range)
                    <option value="{{ $ai_range->id }}" {{ $collector->ai_range == $ai_range->id ? 'selected' : '' }}>{{ $ai_range->name }}</option>
                @endforeach
            </x-form.select> --}}
            <div class="flex flex-col sm:flex-row sm:justify-between gap-4 mb-2">
                <span class="text-white border border-gray-300 p-2">Province: {{ $collector->getProvince->name }}</span>
                <span class="text-white border border-gray-300 p-2">District: {{ $collector->getDistrict->name }}</span>
                <span class="text-white border border-gray-300 p-2">ASC Center: {{ $collector->getAsCenter->name }}</span>
                <span class="text-white border border-gray-300 p-2">AI Range: {{ $collector->getAiRange->name }}</span>
            </div>
            
            <span class="text-red-800">If you want to change location or any other data, please select location again and save</span>
            <livewire:location-select :collector="$collector" />

            <x-form.input name="village" label="Village:">{{ old('village', $collector->village) }}</x-form.input>
            <x-form.input name="gps_lati" label="GPS Latitude:">{{ old('gps_lati', $collector->gps_lati) }}</x-form.input>
            <x-form.input name="gps_long"
                label="GPS Longitude:">{{ old('gps_long', $collector->gps_long) }}</x-form.input>
            <x-form.input name="rice_variety"
                label="Rice Variety:">{{ old('rice_variety', $collector->rice_variety) }}</x-form.input>
            <x-form.date name="date_establish"
                label="Date Established:">{{ old('date_establish', $collector->date_establish) }}</x-form.date>
            <x-form.submit>Save</x-form.submit>
        </x-form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const provinceDropdown = document.getElementById('province');
            const districtDropdown = document.getElementById('district');
            const as_centerDropdown = document.getElementById('as_center');
            const aiRangeDropdown = document.getElementById('ai_range');




            if (provinceDropdown) {
                provinceDropdown.addEventListener('change', function() {
                    const provinceId = this.value;
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', '{{ route('admin.get.districts', ':provinceId') }}'.replace(
                        ':provinceId', provinceId));
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            const districts = JSON.parse(xhr.responseText);
                            districtDropdown.innerHTML =
                                '<option value="">-- Select District --</option>'; // Reset district options
                            districts.forEach(function(district) {
                                const option = document.createElement('option');
                                option.value = district.id;
                                option.text = district.name;
                                districtDropdown.appendChild(option);
                            });
                        }
                    };
                    xhr.send();
                });
            }

            if (districtDropdown) {
                districtDropdown.addEventListener('change', function() {
                    const districtId = this.value;
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', '{{ route('admin.get.as.centers', ':districtId') }}'.replace(
                        ':districtId', districtId));
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            const asCenters = JSON.parse(xhr.responseText);

                            if (as_centerDropdown) {

                                as_centerDropdown.innerHTML =
                                    '<option value="">-- Select ASC --</option>'; // Reset ASC options
                                asCenters.forEach(function(asCenter) {
                                    const option = document.createElement('option');
                                    option.value = asCenter.id;
                                    option.text = asCenter.name;
                                    as_centerDropdown.appendChild(option);
                                });
                            } else {
                                console.error('ASC dropdown not found after AS centers loaded');
                            }
                        } else {
                            console.error('Error fetching AS centers:', xhr.status, xhr.statusText);
                        }
                    };
                    xhr.send();
                });
            }

            if (as_centerDropdown) {

                as_centerDropdown.addEventListener('change', function() {
                    const ascId = this.value;
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', '{{ route('admin.get.ai.ranges', ':ascId') }}'.replace(':ascId',
                        ascId));
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            const airRanges = JSON.parse(xhr.responseText);

                            aiRangeDropdown.innerHTML =
                                '<option value="">-- Select AI Range --</option>'; // Reset AI range options
                            airRanges.forEach(function(airRange) {
                                const option = document.createElement('option');
                                option.value = airRange.id;
                                option.text = airRange.name;
                                aiRangeDropdown.appendChild(option);
                            });
                        }
                    };
                    xhr.send();
                });
            } else {
                console.error('ASC dropdown not found on page load');
            }
        });
    </script>

</x-app-layout>
