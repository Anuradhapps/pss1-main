@props([
    'name' => '',
    'id' => '',
    'label' => '',
    'value' => '',
    // optionally pass the selected value for comparison
    'selected' => null,
])

@php
    if ($id === '') {
        $id = $name;
    }

    if ($label === '') {
        $label = ucwords(strtolower(implode(' ', preg_split('/(?=[A-Z])/', str_replace('_', ' ', $name)))));
    }
@endphp

<div>
    <input type="radio" name="{{ $name }}" id="{{ $id }}" value="{{ $value }}"
        @if ($selected !== null && $selected == $value) checked @endif {{ $attributes }}>
    <label for="{{ $id }}">{{ $label }}</label>
</div>
