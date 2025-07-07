@props([
    'name' => '',
    'id' => '',
    'label' => '',
    'value' => '',
    'selected' => null,
])

@php
    $id = $id ?: $name;

    if ($label === '') {
        $label = ucwords(strtolower(implode(' ', preg_split('/(?=[A-Z])/', str_replace('_', ' ', $name)))));
    }
@endphp

<div class="flex items-center mb-2 space-x-2">
    <input type="checkbox" name="{{ $name }}" id="{{ $id }}" value="{{ $value }}"
        @checked($selected == $value)
        {{ $attributes->merge([
            'class' => 'text-blue-600 border-gray-300 rounded focus:ring-blue-500',
        ]) }}>
    <label for="{{ $id }}" class="text-sm text-gray-200 cursor-pointer">
        {{ $label }}
    </label>
</div>
