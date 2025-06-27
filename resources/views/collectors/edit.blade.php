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

            @if (Auth::user()->name == 'npssoldata')
                <!-- season Selection -->
                <x-form.select name="season" label="Season:" id="season">
                    <option value="20212022" {{ $collector->rice_season_id == 20212022 ? 'selected' : '' }}>2021/2022
                        maha
                    </option>
                    <option value="20222022" {{ $collector->rice_season_id == 20222022 ? 'selected' : '' }}>2022 Yala
                    </option>
                    <option value="20222023" {{ $collector->rice_season_id == 20222023 ? 'selected' : '' }}>2022/2023
                        maha
                    </option>
                    <option value="20232023" {{ $collector->rice_season_id == 20232023 ? 'selected' : '' }}>2023 Yala
                    </option>
                    <option value="20232024" {{ $collector->rice_season_id == 20232024 ? 'selected' : '' }}>2023/2024
                        maha
                    </option>
                    <option value="20242024" {{ $collector->rice_season_id == 20242024 ? 'selected' : '' }}>2024 yala
                    </option>
                    <option value="20242025" {{ $collector->rice_season_id == 20242025 ? 'selected' : '' }}>2024/2025
                        maha
                    </option>
                    <option value="20252025" {{ $collector->rice_season_id == 20252025 ? 'selected' : '' }}>2025 yala
                    </option>
                </x-form.select>
            @endif

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
            <!-- Established Method Field -->
            <x-form.select name="established_method" label="Established Method:" id="established_method">
                <option>-- Select established method--</option>
                <option value="Broadcast" {{ $collector->established_method == 'Broadcast' ? 'selected' : '' }}>
                    Broadcast
                </option>
                <option value="Transplant" {{ $collector->established_method == 'Transplant' ? 'selected' : '' }}>
                    Transplant
                </option>
                <option value="Parachute" {{ $collector->established_method == 'Parachute' ? 'selected' : '' }}>
                    Parachute
                </option>
            </x-form.select>

            <!-- Save Button -->
            <x-form.submit
                class="w-full px-4 py-2 font-semibold text-white transition bg-green-600 rounded hover:bg-green-700">
                Update
            </x-form.submit>
        </x-form>
    </div>
</x-app-layout>
