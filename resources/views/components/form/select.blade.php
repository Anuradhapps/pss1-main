@props([
    'required' => '',
    'name' => '',
    'id' => '',
    'placeholder' => '',
    'label' => '',
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

<div class="w-full p-2 mb-5 bg-gray-700 shadow-sm rounded-xl">
    @if ($label != 'none')
        <label for='{{ $name }}' class='block mb-2 ml-1 text-sm font-medium text-gray-100'>{{ $label }}
            @if ($required != '')
                <span class="text-red-600">*</span>
            @endif
        </label>
    @endif
    <select name='{{ $name }}' id='{{ $name }}' {{ $required }}
        {{ $attributes->merge(['class' => 'border border-gray-300 bg-gray-900 text-gray-200 pl-2  py-2 text-sm w-full rounded-xl']) }}>
        @if ($placeholder != '')
            <option value=''>{{ $placeholder }}</option>
        @endif
        {{ $slot }}
    </select>

    @error($name)
        <p class="p-2 mt-2 text-lg text-white bg-red-700 rounded-xl">{{ $message }}</p>
    @enderror
</div>
