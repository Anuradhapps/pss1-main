@props([
    'options' => [],
    'required' => '',
    'name' => '',
    'label' => '',
    'value' => '',
])

@if ($label === 'none')
@elseif ($label === '')
    @php
        // Format label from name
        $label = str_replace('_', ' ', $name);
        $label = preg_split('/(?=[A-Z])/', $label);
        $label = implode(' ', $label);
        $label = ucwords(strtolower($label));
    @endphp
@endif

@php
    $options = array_merge(
        [
            'enableTime' => true,
            'noCalendar' => true,
            'dateFormat' => 'H:i',
            'time_24hr' => true,
        ],
        $options,
    );
@endphp

<div class="mb-5">
    @if ($label != 'none')
        <label for="{{ $name }}" class="block mb-1 text-sm font-medium text-gray-200">
            {{ $label }}
            @if ($required != '')
                <span class="text-red-600">*</span>
            @endif
        </label>
    @endif

    <input x-data x-init="flatpickr($refs.input, {{ json_encode((object) $options) }});" x-ref="input" type="text" id="{{ $name }}" name="{{ $name }}"
        value="{{ $slot }}" {{ $required }}
        {{ $attributes->merge([
            'class' =>
                'block w-full rounded-md border border-gray-400 bg-gray-700 py-2 px-3 text-gray-200 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm',
        ]) }}>

    @error($name)
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
