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
            'mode' => 'range',
        ],
        $options,
    );
@endphp

<div class="w-full mb-5">
    @if ($label !== 'none')
        <label for="{{ $name }}" class="block mb-1 text-sm font-semibold text-gray-100">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <input x-data x-init="flatpickr($refs.input, {{ json_encode((object) $options) }})" x-ref="input" type="text" id="{{ $name }}"
            name="{{ $name }}" value="{{ $slot }}" {{ $required ? 'required' : '' }}
            {{ $attributes->merge([
                'class' => 'w-full px-4 py-2 text-sm bg-gray-700 border border-gray-600 rounded-lg
                                text-white placeholder-gray-300 focus:outline-none focus:ring-2
                                focus:ring-purple-500 focus:border-purple-500',
            ]) }} />

        @error($name)
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>
</div>
