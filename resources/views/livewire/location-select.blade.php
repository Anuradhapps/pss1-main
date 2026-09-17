<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-slate-900 dark:text-white transition-colors duration-300">
    {{-- Province --}}
    <div>
        <label for="province" class="block mb-1 text-sm font-semibold text-slate-700 dark:text-slate-300">Province</label>
        <select wire:model.live="selectedProvince" id="province" name="province"
            class="w-full px-4 py-2 text-sm text-slate-900 dark:text-white bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary/50 focus:border-primary focus:outline-none transition-colors duration-200">
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
        <div x-data x-transition.duration.400ms>
            <label for="district" class="block mb-1 text-sm font-semibold text-slate-700 dark:text-slate-300">District</label>
            <select wire:model.live="selectedDistrict" id="district" name="district"
                class="w-full px-4 py-2 text-sm text-slate-900 dark:text-white bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary/50 focus:border-primary focus:outline-none transition-colors duration-200">
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
        <div x-data x-transition.duration.400ms>
            <label for="as_center" class="block mb-1 text-sm font-semibold text-slate-700 dark:text-slate-300">ASC/Unit</label>
            <select wire:model.live="selectedAsCenter" id="as_center" name="as_center"
                class="w-full px-4 py-2 text-sm text-slate-900 dark:text-white bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary/50 focus:border-primary focus:outline-none transition-colors duration-200">
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
        <div x-data x-transition.duration.400ms>
            <label for="ai_range" class="block mb-1 text-sm font-semibold text-slate-700 dark:text-slate-300">AI Range</label>
            <select wire:model.live="selectedAiRange" id="ai_range" name="ai_range"
                class="w-full px-4 py-2 text-sm text-slate-900 dark:text-white bg-white dark:bg-slate-800/50 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary/50 focus:border-primary focus:outline-none transition-colors duration-200">
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
