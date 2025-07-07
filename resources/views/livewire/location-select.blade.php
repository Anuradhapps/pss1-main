<div class="p-3 space-y-6 text-white bg-gray-900 rounded-lg shadow-lg">
    {{-- Title --}}
    <label class="text-lg font-semibold text-white">📌 Location Selection</label>

    {{-- Region --}}
    {{-- Province --}}
    <div class="p-1 bg-gray-800 border border-green-400 rounded-lg shadow-sm">
        <label for="province" class="block mb-1 text-sm font-semibold text-white">Province</label>
        <select wire:model.live="selectedProvince" id="province" name="province"
            class="w-full px-4 py-2 text-sm text-white bg-gray-900 border border-white rounded-lg shadow-sm focus:ring-blue-400 focus:border-blue-400">
            <option value="">-- Select Province --</option>
            @foreach ($provinces as $province)
                <option value="{{ $province->id }}">
                    {{ in_array($province->id, $liveProvinces ?? []) ? '✔️ ' : '' }}{{ $province->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- District --}}
    @if ($districts)
        <div x-data x-transition.duration.400ms class="p-1 bg-gray-800 border border-green-400 rounded-lg shadow-sm ">
            <label for="district" class="block mb-1 text-sm font-semibold text-white">District</label>
            <select wire:model.live="selectedDistrict" id="district" name="district"
                class="w-full px-4 py-2 text-sm text-white bg-gray-900 border border-gray-700 rounded-lg shadow-sm focus:ring-green-400 focus:border-green-400">
                <option value="">-- Select District --</option>
                @foreach ($districts as $district)
                    <option value="{{ $district->id }}">
                        {{ in_array($district->id, $liveDistricts ?? []) ? '✔️ ' : '' }}{{ $district->name }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif

    {{-- ASC/Unit --}}
    @if ($asCenters)
        <div x-data x-transition.duration.400ms class="p-1 bg-gray-800 border border-green-400 rounded-lg shadow-sm">
            <label for="as_center" class="block mb-1 text-sm font-semibold text-white">ASC/Unit</label>
            <select wire:model.live="selectedAsCenter" id="as_center" name="as_center"
                class="w-full px-4 py-2 text-sm text-white bg-gray-900 border border-gray-700 rounded-lg shadow-sm focus:ring-purple-400 focus:border-purple-400">
                <option value="">-- Select ASC --</option>
                @foreach ($asCenters as $asCenter)
                    <option value="{{ $asCenter->id }}">
                        {{ in_array($asCenter->id, $liveAsCenters ?? []) ? '✔️ ' : '' }}{{ $asCenter->name }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif

    {{-- AI Range --}}
    @if ($aiRanges)
        <div x-data x-transition.duration.400ms class="p-1 bg-gray-800 border border-green-400 rounded-lg shadow-sm">
            <label for="ai_range" class="block mb-1 text-sm font-semibold text-white">AI Range</label>
            <select wire:model.live="selectedAiRange" id="ai_range" name="ai_range"
                class="w-full px-4 py-2 text-sm text-white bg-gray-900 border border-gray-700 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400">
                <option value="">-- Select AI Range --</option>
                @foreach ($aiRanges as $aiRange)
                    <option value="{{ $aiRange->id }}">
                        {{ in_array($aiRange->id, $liveAiRanges ?? []) ? '✔️ ' : '' }}{{ $aiRange->name }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif
</div>


{{-- old one -------------------------------------------------- --}}
{{-- <div>
    <x-form.select wire:model.live='selectedProvince' name="province" label="Province:" id="province">
        <option value="">-- Select Province --</option>
        @foreach ($provinces as $province)
            <option value="{{ $province->id }}">
                @if ($liveProvinces)
                    @foreach ($liveProvinces as $liveProvince)
                        @if ($liveProvince == $province->id)
                            &#x2705;
                        @endif
                    @endforeach
                @endif
                {{ old('province', $province->name) }}
            </option>
        @endforeach
    </x-form.select>
    @if ($districts)
        <x-form.select wire:model.live='selectedDistrict' name="district" label="District:" id="district">
            <option value="">-- Select District --</option>
            @foreach ($districts as $district)
                <option value="{{ $district->id }}">
                    @if ($liveDistricts)
                        @foreach ($liveDistricts as $liveDistrict)
                            @if ($liveDistrict == $district->id)
                                &#x2705;
                            @endif
                        @endforeach
                    @endif
                    {{ old('district', $district->name) }}
                </option>
            @endforeach
        </x-form.select>
    @endif
    @if ($asCenters)
        <x-form.select wire:model.live='selectedAsCenter' name="as_center" label="ASC/Unit:" id="as_center">
            <option value="">-- Select ASC --</option>
            @foreach ($asCenters as $asCenter)
                <option value="{{ $asCenter->id }}">
                    @if ($liveAsCenters)
                        @foreach ($liveAsCenters as $liveAsCenter)
                            @if ($liveAsCenter == $asCenter->id)
                                &#x2705;
                            @endif
                        @endforeach
                    @endif
                    {{ old('as_center', $asCenter->name) }}
                </option>
            @endforeach
        </x-form.select>
    @endif
    @if ($aiRanges)
        <x-form.select wire:model.live='selectedAiRange' name="ai_range" label="AI Range:" id="ai_range">
            <option value="">-- Select AI Range --</option>
            @foreach ($aiRanges as $aiRange)
                <option value="{{ $aiRange->id }}">
                    @if ($liveAiRanges)
                        @foreach ($liveAiRanges as $liveAiRange)
                            @if ($liveAiRange == $aiRange->id)
                                &#x2705;
                            @endif
                        @endforeach
                    @endif
                    {{ old('ai_range', $aiRange->name) }}
                </option>
            @endforeach
        </x-form.select>
    @endif
</div> --}}
