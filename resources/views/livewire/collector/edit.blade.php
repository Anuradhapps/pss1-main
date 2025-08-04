@section('title', 'Add My Info')

<x-app-layout>
    <div class="max-w-4xl mx-auto">

        <!-- Header -->
        <div
            class="flex flex-col md:flex-row md:items-center justify-between p-4 bg-gradient-to-r from-gray-900 to-gray-600 shadow">

            <div class="flex items-center space-x-4">
                <div class="text-6xl">🌾</div>
                <div>
                    <h3 class="text-3xl font-extrabold tracking-wide text-white">Collector Edit</h3>
                    <h5 class="text-base italic text-white">{{ $collector->riceSeason->name }} Season</h5>
                </div>
            </div>

            <div class="mt-4 md:mt-0">
                <a href="{{ route('admin.collector.records') }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition duration-300 bg-red-700 hover:bg-red-800">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
            </div>
        </div>

        <!-- Form -->
        <x-form action="{{ route(has_role('admin') ? 'admin.collector.update' : 'collector.update', $collector->id) }}"
            method="POST" class="space-y-6 py-6 px-4">
            @csrf
            @method('PUT')

            <!-- Phone Number -->
            <x-form.input name="phone_no" label="📞 Phone Number:" class="mb-4 text-base">
                {{ old('phone_no', $collector->phone_no) }}
            </x-form.input>

            @if (Auth::user()->name == 'npssoldata')
                <!-- Season Selection -->
                <x-form.select name="season" label="🗓️ Season:" id="season" class="text-base">
                    <option value="">-- Select Season --</option>
                    @foreach ([
        '20212022' => '2021/2022 Maha',
        '20222022' => '2022 Yala',
        '20222023' => '2022/2023 Maha',
        '20232023' => '2023 Yala',
        '20232024' => '2023/2024 Maha',
        '20242024' => '2024 Yala',
        '20242025' => '2024/2025 Maha',
        '20252025' => '2025 Yala',
    ] as $value => $label)
                        <option value="{{ $value }}"
                            {{ $collector->rice_season_id == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </x-form.select>
            @endif

            <!-- Region Selection -->
            <x-form.select name="region" label="🌍 Region:" id="region" class="text-base">
                <option value="1" {{ $collector->region_id == 1 ? 'selected' : '' }}>Provincial</option>
                <option value="2" {{ $collector->region_id == 2 ? 'selected' : '' }}>Inter Provincial</option>
                <option value="3" {{ $collector->region_id == 3 ? 'selected' : '' }}>Mahaweli</option>
            </x-form.select>

            <!-- Location Select -->
            <livewire:location-select :selectedProvince="$collector->province" :selectedDistrict="$collector->district" :selectedAsCenter="$collector->asc" :selectedAiRange="$collector->ai_range" />

            <!-- Village Field -->
            <x-form.input name="village" label="🏘️ Village:" class="mb-4 text-base">
                {{ old('village', $collector->village) }}
            </x-form.input>

            <!-- GPS Component -->
            <x-gpsFill :collector="$collector" />

            <!-- Rice Variety -->
            <x-form.input name="rice_variety" label="🌾 Rice Variety:" class="mb-4 text-base">
                {{ old('rice_variety', $collector->rice_variety) }}
            </x-form.input>

            <!-- Date Established -->
            <x-form.date name="date_establish" label="📅 Date Established:" class="mb-4 text-base">
                {{ old('date_establish', $collector->date_establish) }}
            </x-form.date>

            <!-- Established Method -->
            <x-form.select name="established_method" label="🛠️ Established Method:" id="established_method"
                class="text-base">
                <option value="">-- Select Method --</option>
                <option value="Broadcast" {{ $collector->established_method == 'Broadcast' ? 'selected' : '' }}>
                    Broadcast</option>
                <option value="Transplant" {{ $collector->established_method == 'Transplant' ? 'selected' : '' }}>
                    Transplant</option>
                <option value="Parachute" {{ $collector->established_method == 'Parachute' ? 'selected' : '' }}>
                    Parachute</option>
                <option value="N/A" {{ $collector->established_method == 'N/A' ? 'selected' : '' }}>N/A</option>
            </x-form.select>

            <!-- Submit Button -->
            <x-form.submit
                class="w-full px-6 py-3 font-bold text-white transition duration-300 bg-green-600 hover:bg-green-700 text-base">
                ✅ Update My Info
            </x-form.submit>

        </x-form>
    </div>
</x-app-layout>
