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
        //remove underscores from name
        $label = str_replace('_', ' ', $name);
        //detect subsequent letters starting with a capital
        $label = preg_split('/(?=[A-Z])/', $label);
        //display capital words with a space
        $label = implode(' ', $label);
        //uppercase first letter and lower the rest of a word
        $label = ucwords(strtolower($label));
    @endphp
@endif

@php
    $options = array_merge(
        [
            'dateFormat' => 'd-m-Y',
            // 'altInput' => false,
            'enableTime' => false,
            'time_24hr' => true,
        ],
        $options,
    );
@endphp

<div class="mb-5">
    @if ($label != 'none')
        <label for="{{ $name }}"
            class="block mb-2 ml-1 text-sm font-medium leading-5 text-gray-900">{{ $label }}
            @if ($required != '')
                <span class="text-red-600">*</span>
            @endif
        </label>
    @endif
    <div class="rounded-md shadow-sm">
        <input placeholder="dd-mm-yyyy" x-data x-init="flatpickr($refs.input, {{ json_encode((object) $options) }});" x-ref="input" type="text" id="{{ $name }}"
            name="{{ $name }}" value="{{ $slot }}" {{ $required }}
            {{ $attributes->merge(['class' => ' block w-full bg-gray-900 text-gray-200 placeholder-gray-200 border border-gray-300 rounded-xl shadow-sm py-2 px-3 focus:outline-none focus:ring-light-blue-500 focus:border-light-blue-500 sm:text-sm']) }}>
        @error($name)
            <p class="p-2 mt-2 text-lg text-white bg-red-700">{{ $message }}</p>
        @enderror
    </div>
</div>
