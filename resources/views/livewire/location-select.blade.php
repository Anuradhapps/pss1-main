<div>
    <x-form.select wire:model.live='selectedProvince' name="province" label="Province:" id="province">
        <option value="">-- Select Province --</option>
        @foreach ($provinces as $province)
        <option value="{{ $province->id }}">{{ old('province', $province->name) }}</option>
        @endforeach
    </x-form.select>
    @if ($districts)
    <x-form.select wire:model.live='selectedDistrict' name="district" label="District:" id="district">
        <option value="">-- Select District --</option>
        @foreach ($districts as $district)
        <option value="{{ $district->id }}">{{ old('district', $district->name) }}</option>
        @endforeach
    </x-form.select>
    @endif
    @if ($asCenters)
    <x-form.select wire:model.live='selectedAsCenter' name="as_center" label="ASC/Unit:" id="as_center">
        <option value="">-- Select ASC --</option>
        @foreach ($asCenters as $asCenter)
        <option value="{{ $asCenter->id }}">{{ old('as_center', $asCenter->name) }}</option>
        @endforeach
    </x-form.select>
    @endif
    @if ($aiRanges)
    <x-form.select wire:model.live='selectedAiRange' name="ai_range" label="AI Range:" id="ai_range">
        <option value="">-- Select AI Range --</option>
        @foreach ($aiRanges as $aiRange )
        <option value="{{ $aiRange->id }}">{{ old('ai_range', $aiRange->name) }}</option>
        @endforeach
    </x-form.select>
    @endif
</div>