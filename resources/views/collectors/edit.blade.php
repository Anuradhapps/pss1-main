@section('title', 'Add My Info')
<x-app-layout>

    <div class="m-5">
        <div class="flex items-center justify-between px-2 mb-3 bg-orange-700">
            <h3 class="text-2xl font-bold text-center text-indigo-100">{{ $collector->riceSeason->name }}
            </h3>


            @if (is_admin())
                <a href="{{ route('admin.collector.records') }}"
                    class="px-4 py-2 text-sm font-bold text-white bg-red-800 rounded hover:bg-red-900">Back</a>
            @else
                <a href="{{ route('collector.create') }}"
                    class="px-4 py-2 text-sm font-bold text-white bg-red-800 rounded hover:bg-red-900">Back</a>
            @endif
        </div>

        <!-- Form for updating collector information -->
        <x-form action="{{ route(has_role('admin') ? 'admin.collector.update' : 'collector.update', $collector->id) }}"
            method="POST">

            @csrf
            @method('PUT')

            <!-- Phone Number -->
            <x-form.input name="phone_no" label="Phone Number:"
                class="mb-4">{{ old('phone_no', $collector->phone_no) }}</x-form.input>

            <!-- Display Existing Location Info -->
            {{-- <div class="flex flex-col gap-4 mb-4 text-sm sm:flex-row sm:justify-between">
                <span class="p-2 text-gray-900 bg-gray-300 border border-gray-300 rounded">Province:
                    {{ $collector->getProvince->name }}</span>
                <span class="p-2 text-gray-900 bg-gray-300 border border-gray-300 rounded">District:
                    {{ $collector->getDistrict->name }}</span>
                <span class="p-2 text-gray-900 bg-gray-300 border border-gray-300 rounded">ASC Center:
                    {{ $collector->getAsCenter->name }}</span>
                <span class="p-2 text-gray-900 bg-gray-300 border border-gray-300 rounded">AI Range:
                    {{ $collector->getAiRange->name }}</span>
            </div> --}}
            <x-form.select name="region" label="Region:" id="region">
                <option value="1" {{ $collector->region_id == 1 ? 'selected' : '' }}>Provicial</option>
                <option value="2" {{ $collector->region_id == 2 ? 'selected' : '' }}>Inter Provicial</option>
                <option value="3" {{ $collector->region_id == 3 ? 'selected' : '' }}>Mahaweli</option>
            </x-form.select>
            <!-- Message to reselect location -->
            <span class="block mb-4 text-sm italic text-orange-400">If you want to change the location or any other
                data,
                please
                select location again and save.</span>

            <!-- Location Selection (Livewire Component) -->
            <livewire:location-select :selectedProvince="$collector->province" :selectedDistrict="$collector->district" :selectedAsCenter="$collector->asc" :selectedAiRange="$collector->ai_range" />


            <!-- Village Field -->
            <x-form.input name="village" label="Village:"
                class="mb-4">{{ old('village', $collector->village) }}</x-form.input>

            <!-- GPS Location -->
            <x-gpsFill :collector="$collector" />
            <!-- Rice Variety and Date Established Fields -->
            <x-form.input name="rice_variety" label="Rice Variety:"
                class="mb-4">{{ old('rice_variety', $collector->rice_variety) }}</x-form.input>
            <x-form.date name="date_establish" label="Date Established:"
                class="mb-4">{{ old('date_establish', $collector->date_establish) }}</x-form.date>

            <!-- Save Button -->
            <x-form.submit
                class="px-4 py-2 font-semibold text-white bg-green-500 rounded hover:bg-green-600">Update</x-form.submit>
        </x-form>
    </div>

    <!-- Ensure the spinning icon works properly -->

</x-app-layout>
