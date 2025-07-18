<div class="p-1 space-y-6 text-white bg-gray-900 ">
    {{-- Title --}}
    <label class="text-lg font-semibold text-white">📌 Location Selection</label>

    {{-- Province --}}
    <div class="p-1 bg-gray-800  shadow-sm">
        <label for="province" class="block mb-1 text-sm font-semibold text-white">Province</label>
        <select wire:model.live="selectedProvince" id="province" name="province"
            class="w-full px-4 py-2 text-sm text-white bg-gray-900 border border-white shadow-sm focus:ring-blue-400 focus:border-blue-400 focus:outline-none">
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
        <div x-data x-transition.duration.400ms class="p-1 bg-gray-800 shadow-sm">
            <label for="district" class="block mb-1 text-sm font-semibold text-white">District</label>
            <select wire:model.live="selectedDistrict" id="district" name="district"
                class="w-full px-4 py-2 text-sm text-white bg-gray-900 border border-gray-700 shadow-sm focus:ring-green-400 focus:border-green-400 focus:outline-none">
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
        <div x-data x-transition.duration.400ms class="p-1 bg-gray-800 shadow-sm">
            <label for="as_center" class="block mb-1 text-sm font-semibold text-white">ASC/Unit</label>
            <select wire:model.live="selectedAsCenter" id="as_center" name="as_center"
                class="w-full px-4 py-2 text-sm text-white bg-gray-900 border border-gray-700 shadow-sm focus:ring-purple-400 focus:border-purple-400 focus:outline-none">
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
        <div x-data x-transition.duration.400ms class="p-1 bg-gray-800 shadow-sm">
            <label for="ai_range" class="block mb-1 text-sm font-semibold text-white">AI Range</label>
            <select wire:model.live="selectedAiRange" id="ai_range" name="ai_range"
                class="w-full px-4 py-2 text-sm text-white bg-gray-900 border border-gray-700 shadow-sm focus:ring-yellow-400 focus:border-yellow-400 focus:outline-none">
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
