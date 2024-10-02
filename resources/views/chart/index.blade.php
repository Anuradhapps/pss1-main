<x-app-layout>
    <div class="flex justify-between">
        <h1 class="text-2xl font-bold mb-4 text-red-900">Pests</h1>
        <a href="{{ route('pest.create') }}" class="btn btn-primary ">Add</a>
    </div>

    <div class="m-5">
        <x-form action="{{ route('admin.collector.store') }}">
            @csrf
            <x-form.select name="province" label="Province:" id="province">
                <option value="">-- Select Province --</option>
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                @endforeach
            </x-form.select>

            <x-form.select name="district" label="District:" id="district">
                <option value="">-- Select District --</option>
            </x-form.select>

            <x-form.select name="as_center" label="ASC/Unit:" id="as_center">
                <option value="">-- Select ASC --</option>
            </x-form.select>
            <x-form.select name="ai_range" label="AI Range:" id="ai_range">
                <option value="">-- Select AI Range --</option>
            </x-form.select>
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
                console.log('aiRangeDropdown found')
                as_centerDropdown.addEventListener('change', function() {
                    const ascId = this.value;
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', '{{ route('admin.get.ai.ranges', ':ascId') }}'.replace(':ascId',
                        ascId));
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            const airRanges = JSON.parse(xhr.responseText);
                            console.log(airRanges);
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
