@props([
    'name' => '',
    'label' => '',
    'value' => '',
    'required' => '',
])

@if ($label === 'none')
@elseif ($label === '')
    @php
        // Remove underscores and split camel case to generate label
        $label = str_replace('_', ' ', $name);
        $label = preg_split('/(?=[A-Z])/', $label);
        $label = implode(' ', $label);
        $label = ucwords(strtolower($label));
    @endphp
@endif

<div class="my-5">
    @if ($label != 'none')
        <label for="{{ $name }}" class="block mb-2 ml-2 text-sm font-medium text-gray-100">
            {{ $label }}
            @if ($required != '')
                <span class="text-red-600">*</span>
            @endif
        </label>
    @endif

    <textarea name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge([
            'class' =>
                'block w-full  border border-gray-300 bg-gray-900 py-2 px-3 text-sm text-gray-100 placeholder-gray-400 shadow-sm focus:border-light-blue-500 focus:outline-none focus:ring-1 focus:ring-light-blue-500',
        ]) }}>{{ $slot }}</textarea>

    @error($name)
        <p class="mt-2 ml-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
