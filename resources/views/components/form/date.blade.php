@props([
    'options' => [],
    'required' => false,
    'name' => '',
    'label' => '',
    'value' => '',
])

@php
    if ($label === '') {
        $label = ucwords(strtolower(implode(' ', preg_split('/(?=[A-Z])/', str_replace('_', ' ', $name)))));
    }

    $options = array_merge(
        [
            'dateFormat' => 'd-m-Y',
            'enableTime' => false,
            'time_24hr' => true,
        ],
        $options,
    );
@endphp

<div class="w-full">
    @if ($label !== 'none')
        <label for="{{ $name }}" class="block mb-1 text-sm font-semibold text-gray-100">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <input x-data x-init="flatpickr($refs.input, {{ json_encode((object) $options) }})" x-ref="input" id="{{ $name }}" name="{{ $name }}"
            type="text" value="{{ $slot }}" placeholder="dd-mm-yyyy" {{ $required ? 'required' : '' }}
            {{ $attributes->merge([
                'class' =>
                    'peer block w-full px-4 py-2 text-sm bg-gray-800 text-white border border-gray-600  shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-200 ease-in-out',
            ]) }} />

        @error($name)
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>
</div>
