<div>
    <x-form.select wire:model.live='selectedSeason' name="season" label="season" id="season" required>
        <option value="">-- Select Season --</option>
        @foreach ($seasons as $season)
            @php
                $CollectorCount = \App\Models\Collector::where('rice_season_id', $season->id)->count();
            @endphp
            <option value="{{ $season->id }}">
                &#x2705;{{ $season->name }}{{ $CollectorCount > 0 ? ' (Collectors : ' . $CollectorCount . ')' : '' }}
            </option>
        @endforeach
    </x-form.select>
    @if ($selectedSeason)
        <x-form.select wire:model.live='selectedProvince' name="province" label="Province:" id="province" required>
            <option value="">-- Select Province --</option>
            @foreach ($provinces as $province)
                @php
                    $CollectorCount = \App\Models\Collector::where('rice_season_id', $selectedSeason)
                        ->where('province', $province->id)
                        ->count();
                @endphp
                <option value="{{ $province->id }}">
                    @if ($liveProvinces)
                        @foreach ($liveProvinces as $liveProvince)
                            @if ($liveProvince == $province->id)
                                &#x2705;
                            @endif
                        @endforeach
                    @endif
                    {{ old('province', $province->name) }}{{ $CollectorCount > 0 ? ' (Collectors : ' . $CollectorCount . ')' : '' }}
                </option>
            @endforeach
        </x-form.select>
    @endif

    @if ($districts)
        <x-form.select wire:model.live='selectedDistrict' name="district" label="District:" id="district">
            <option value="">-- Select District --</option>
            @foreach ($districts as $district)
                @php
                    $CollectorCount = \App\Models\Collector::where('rice_season_id', $selectedSeason)
                        ->where('district', $district->id)
                        ->count();
                @endphp
                <option value="{{ $district->id }}">
                    @if ($liveDistricts)
                        @foreach ($liveDistricts as $liveDistrict)
                            @if ($liveDistrict == $district->id)
                                &#x2705;
                            @endif
                        @endforeach
                    @endif
                    {{ old('district', $district->name) }}{{ $CollectorCount > 0 ? ' (Collectors : ' . $CollectorCount . ')' : '' }}
                </option>
            @endforeach
        </x-form.select>
    @endif
    @if ($asCenters)
        <x-form.select wire:model.live='selectedAsCenter' name="as_center" label="ASC/Unit:" id="as_center">
            <option value="">-- Select ASC --</option>
            @foreach ($asCenters as $asCenter)
                @php
                    $CollectorCount = \App\Models\Collector::where('rice_season_id', $selectedSeason)
                        ->where('asc', $asCenter->id)
                        ->count();
                @endphp
                <option value="{{ $asCenter->id }}">
                    @if ($liveAsCenters)
                        @foreach ($liveAsCenters as $liveAsCenter)
                            @if ($liveAsCenter == $asCenter->id)
                                &#x2705;
                            @endif
                        @endforeach
                    @endif
                    {{ old('as_center', $asCenter->name) }}{{ $CollectorCount > 0 ? ' (Collectors : ' . $CollectorCount . ')' : '' }}
                </option>
            @endforeach
        </x-form.select>
    @endif
    @if ($aiRanges)
        <x-form.select wire:model.live='selectedAiRange' name="ai_range" label="AI Range:" id="ai_range">
            <option value="">-- Select AI Range --</option>
            @foreach ($aiRanges as $aiRange)
                @php
                    $CollectorCount = \App\Models\Collector::where('rice_season_id', $selectedSeason)
                        ->where('ai_range', $aiRange->id)
                        ->count();
                @endphp
                <option value="{{ $aiRange->id }}">
                    @if ($liveAiRanges)
                        @foreach ($liveAiRanges as $liveAiRange)
                            @if ($liveAiRange == $aiRange->id)
                                &#x2705;
                            @endif
                        @endforeach
                    @endif
                    {{ old('ai_range', $aiRange->name) }}{{ $CollectorCount > 0 ? ' (Collectors : ' . $CollectorCount . ')' : '' }}
                </option>
            @endforeach
        </x-form.select>
    @endif
</div>
