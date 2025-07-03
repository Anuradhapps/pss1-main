@props([
    'required' => '',
    'type' => 'text',
    'name' => '',
    'label' => '',
    'value' => '',
    'placeholder' => '',
])

@if ($label === 'none')
@elseif ($label === '')
    @php
        $label = str_replace('_', ' ', $name);
        $label = preg_split('/(?=[A-Z])/', $label);
        $label = implode(' ', $label);
        $label = ucwords(strtolower($label));
    @endphp
@endif

<div class="mb-5">
    @if ($label != 'none')
        <label for="{{ $name }}"
            class="block mb-2 ml-1 text-sm font-medium leading-5 text-gray-900">{{ $label }}
            @if ($required != '')
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative rounded-md shadow-sm">
        <input placeholder="{{ $placeholder }}" type="{{ $type === 'password' ? 'password' : $type }}"
            id="{{ $name }}" name="{{ $name }}" value="{{ $slot }}" {{ $required }}
            {{ $attributes->merge([
                'class' =>
                    'block w-full bg-gray-900 text-gray-200 placeholder-gray-400 border border-gray-600 rounded-xl shadow-sm py-2 px-3 pr-10 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm',
            ]) }}>

        {{-- Show/hide password toggle --}}
        @if ($type === 'password')
            <button type="button" onclick="togglePassword('{{ $name }}')"
                class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-white focus:outline-none">
                <i id="icon-{{ $name }}" class="text-sm fas fa-eye"></i>
            </button>
        @endif

        @error($name)
            <p class="p-2 mt-2 text-sm text-white bg-red-700 rounded">{{ $message }}</p>
        @enderror
    </div>
</div>
