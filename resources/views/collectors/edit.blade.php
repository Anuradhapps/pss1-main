@section('title', 'Add My Info')

<x-app-layout>
    <div class="max-w-4xl p-6 mx-auto">
        <!-- Header -->
        <div
            class="flex flex-col items-start justify-between p-4 mb-6 space-y-4 bg-green-700 rounded-md shadow-md md:flex-row md:items-center md:space-y-0">
            <h3 class="text-2xl font-bold text-white">{{ $collector->riceSeason->name }}</h3>
            <a href="{{ is_admin() ? route('admin.collector.records') : route('collector.create') }}"
                class="px-4 py-2 text-sm font-bold text-white transition bg-green-800 rounded hover:bg-green-900">
                Back
            </a>
        </div>
        <!-- Form -->
        <x-form action="{{ route(has_role('admin') ? 'admin.collector.update' : 'collector.update', $collector->id) }}"
            method="POST">
            @csrf
            @method('PUT')

            <!-- Phone Number -->
            <x-form.input name="phone_no" label="Phone Number:" class="mb-4">
                {{ old('phone_no', $collector->phone_no) }}
            </x-form.input>

            <!-- Region Selection -->
            <x-form.select name="region" label="Region:" id="region">
                <option value="1" {{ $collector->region_id == 1 ? 'selected' : '' }}>Provincial</option>
                <option value="2" {{ $collector->region_id == 2 ? 'selected' : '' }}>Inter Provincial</option>
                <option value="3" {{ $collector->region_id == 3 ? 'selected' : '' }}>Mahaweli</option>
            </x-form.select>

            <!-- Location Selection Info -->


            <!-- Livewire Location Selection Component -->
            <livewire:location-select :selectedProvince="$collector->province" :selectedDistrict="$collector->district" :selectedAsCenter="$collector->asc" :selectedAiRange="$collector->ai_range" />

            <!-- Village Field -->
            <x-form.input name="village" label="Village:" class="mb-4">
                {{ old('village', $collector->village) }}
            </x-form.input>

            <!-- GPS Location -->
            <x-gpsFill :collector="$collector" />

            <!-- Rice Variety & Date Established -->

            <x-form.input name="rice_variety" label="Rice Variety:" class="mb-4">
                {{ old('rice_variety', $collector->rice_variety) }}
            </x-form.input>

            <x-form.date name="date_establish" label="Date Established:" class="mb-4">
                {{ old('date_establish', $collector->date_establish) }}
            </x-form.date>


            <!-- Save Button -->
            <x-form.submit
                class="w-full px-4 py-2 font-semibold text-white transition bg-green-600 rounded hover:bg-green-700">
                Update
            </x-form.submit>
        </x-form>
    </div>
</x-app-layout>
