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

<div class="w-full mb-5">
    @if ($label != 'none')
        <label for='{{ $name }}' class='block mb-2 ml-1 text-sm font-medium text-gray-100'>{{ $label }}
            @if ($required != '')
                <span class="text-red-600">*</span>
            @endif
        </label>
    @endif
    <select name='{{ $name }}' id='{{ $name }}' {{ $required }}
        {{ $attributes->merge(['class' => 'peer block w-full px-4 py-2 text-sm bg-gray-800 text-white placeholder-transparent border border-gray-600  shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-200 ease-in-out']) }}>
        @if ($placeholder != '')
            <option value=''>{{ $placeholder }}</option>
        @endif
        {{ $slot }}
    </select>

    @error($name)
        <p class="p-2 mt-2 text-lg text-white bg-red-700 rounded-xl">{{ $message }}</p>
    @enderror
</div>
