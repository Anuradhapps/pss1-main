@props([
    'required' => false,
    'type' => 'text',
    'name' => '',
    'label' => '',
    'value' => '',
    'placeholder' => '',
])

@php
    if ($label === '') {
        $label = ucwords(strtolower(implode(' ', preg_split('/(?=[A-Z])/', str_replace('_', ' ', $name)))));
    }
@endphp

<div class="w-full p-2 bg-gray-700 shadow-sm rounded-xl">
    @if ($label !== 'none')
        <label for="{{ $name }}" class="block mb-1 text-sm font-semibold text-gray-100">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ $slot }}"
            placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}
            {{ $attributes->merge([
                'class' =>
                    'block w-full px-4 py-2 text-sm bg-gray-900 text-white placeholder-gray-400 border border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500',
            ]) }}>

        @if ($type === 'password')
            <button type="button" aria-label="Toggle password visibility"
                onclick="togglePassword('{{ $name }}')"
                class="absolute inset-y-0 flex items-center text-gray-400 right-3 hover:text-white focus:outline-none">
                <i id="icon-{{ $name }}" class="text-sm fas fa-eye"></i>
            </button>
        @endif

        @error($name)
            <p class="mt-2 text-sm text-red-400 rounded-xl">{{ $message }}</p>
        @enderror
    </div>
</div>

@once
    @push('scripts')
        <script>
            function togglePassword(fieldId) {
                const input = document.getElementById(fieldId);
                const icon = document.getElementById('icon-' + fieldId);
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        </script>
    @endpush
@endonce
