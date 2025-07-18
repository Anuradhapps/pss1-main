@section('title', 'Add My Info')

<x-app-layout>
    <div class="">
        <!-- Header -->
        <x-headings.topHeading title="Collector Edit" subtitle="{{ $collector->riceSeason->name }} Season"
            icon="fas fa-wheat-awn" buttonText="Back" buttonAction="{{ route('collector.create') }}"
            buttonIcon="fas fa-arrow-left" buttonColor="red" class="bg-cyan-700" />

        <!-- Form -->
        <x-form action="{{ route(has_role('admin') ? 'admin.collector.update' : 'collector.update', $collector->id) }}"
            method="POST" class="space-y-6 p-2">
            @csrf
            @method('PUT')

            <!-- Phone Number -->
            <x-form.input name="phone_no" label="Phone Number:" class="mb-4">
                {{ old('phone_no', $collector->phone_no) }}
            </x-form.input>

            @if (Auth::user()->name == 'npssoldata')
                <!-- Season Selection -->
                <x-form.select name="season" label="Season:" id="season">
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
            <x-form.select name="region" label="Region:" id="region">
                <option value="1" {{ $collector->region_id == 1 ? 'selected' : '' }}>Provincial</option>
                <option value="2" {{ $collector->region_id == 2 ? 'selected' : '' }}>Inter Provincial</option>
                <option value="3" {{ $collector->region_id == 3 ? 'selected' : '' }}>Mahaweli</option>
            </x-form.select>

            <!-- Location Selection Component -->
            <livewire:location-select :selectedProvince="$collector->province" :selectedDistrict="$collector->district" :selectedAsCenter="$collector->asc" :selectedAiRange="$collector->ai_range" />

            <!-- Village Field -->
            <x-form.input name="village" label="Village:" class="mb-4">
                {{ old('village', $collector->village) }}
            </x-form.input>

            <!-- GPS Component -->
            <x-gpsFill :collector="$collector" />
            <div class="flex justify-between gap-4">
                <!-- Rice Variety & Establishment -->
                <x-form.input name="rice_variety" label="Rice Variety:" class="mb-4">
                    {{ old('rice_variety', $collector->rice_variety) }}
                </x-form.input>

                <x-form.date name="date_establish" label="Date Established:" class="mb-4">
                    {{ old('date_establish', $collector->date_establish) }}
                </x-form.date>
            </div>


            <!-- Established Method -->
            <x-form.select name="established_method" label="Established Method:" id="established_method">
                <option value="">-- Select Method --</option>
                <option value="Broadcast" {{ $collector->established_method == 'Broadcast' ? 'selected' : '' }}>
                    Broadcast</option>
                <option value="Transplant" {{ $collector->established_method == 'Transplant' ? 'selected' : '' }}>
                    Transplant</option>
                <option value="Parachute" {{ $collector->established_method == 'Parachute' ? 'selected' : '' }}>
                    Parachute</option>

                <option value="N/A" {{ $collector->established_method == 'N/A' ? 'selected' : '' }}>
                    N/A</option>

            </x-form.select>

            <!-- Submit Button -->
            <x-buttons.button-1 type="submit" color="green" href="" icon="fas fa-save" class="w-full">
                Update
                </x-button>
        </x-form>
    </div>
</x-app-layout>
