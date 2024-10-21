@section('title', 'Add My Info')
<x-app-layout>

    <div class="m-5">
        <h3 class="mb-2 text-2xl font-semibold">{{ $season }}</h3>

        <!-- Form for updating collector information -->
        <x-form action="{{ route('admin.collector.update', $collector->id) }}">
            @csrf
            @method('PUT')

            <!-- Phone Number -->
            <x-form.input name="phone_no" label="Phone Number:"
                class="mb-4">{{ old('phone_no', $collector->phone_no) }}</x-form.input>

            <!-- Display Existing Location Info -->
            <div class="flex flex-col sm:flex-row sm:justify-between gap-4 mb-4 text-sm">
                <span class="bg-gray-300 text-gray-900 border border-gray-300 p-2 rounded">Province:
                    {{ $collector->getProvince->name }}</span>
                <span class="bg-gray-300 text-gray-900 border border-gray-300 p-2 rounded">District:
                    {{ $collector->getDistrict->name }}</span>
                <span class="bg-gray-300 text-gray-900 border border-gray-300 p-2 rounded">ASC Center:
                    {{ $collector->getAsCenter->name }}</span>
                <span class="bg-gray-300 text-gray-900 border border-gray-300 p-2 rounded">AI Range:
                    {{ $collector->getAiRange->name }}</span>
            </div>

            <!-- Message to reselect location -->
            <span class="text-red-800 text-sm mb-4 block">If you want to change the location or any other data, please
                select location again and save.</span>

            <!-- Location Selection (Livewire Component) -->
            <livewire:location-select />

            <!-- Village Field -->
            <x-form.input name="village" label="Village:"
                class="mb-4">{{ old('village', $collector->village) }}</x-form.input>

            <!-- GPS Location -->
            <x-gpsFill :collector="$collector"/>
            <!-- Rice Variety and Date Established Fields -->
            <x-form.input name="rice_variety" label="Rice Variety:"
                class="mb-4">{{ old('rice_variety', $collector->rice_variety) }}</x-form.input>
            <x-form.date name="date_establish" label="Date Established:"
                class="mb-4">{{ old('date_establish', $collector->date_establish) }}</x-form.date>

            <!-- Save Button -->
            <x-form.submit
                class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">Save</x-form.submit>
        </x-form>
    </div>

    <!-- Ensure the spinning icon works properly -->

</x-app-layout>
