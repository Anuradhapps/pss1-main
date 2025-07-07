@props([
    'level' => 0,
    'data' => null,
    'wireName' => null,
    'id' => 'id',
    'label' => 'title',
])

<div class="ml-{{ $level * 4 }} flex items-start space-x-2 py-1">
    <input type="checkbox" wire:model="{{ $wireName . '.' . $data->$id }}" value="{{ $data->$id }}"
        class="mt-1 text-blue-600 border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-400 focus:ring-opacity-50"
        id="checkbox-{{ $data->$id }}">
    <label for="checkbox-{{ $data->$id }}" class="text-sm text-gray-200 cursor-pointer">
        {{ $data->$label }}
    </label>
</div>

@if ($data->children && $data->children->count())
    @foreach ($data->children as $child)
        <x-form.checkbox-row :data="$child" :level="$level + 1" :id="$id" :label="$label"
            :wireName="$wireName" />
    @endforeach
@endif
