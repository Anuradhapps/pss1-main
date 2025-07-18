@props([
    'required' => false,
    'type' => '',
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

<div class="w-full">
    @if ($label !== 'none')
        <label for="{{ $name }}" class="block mb-1 text-sm font-semibold text-white">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" {{-- {{ $type === 'tel' ? 'pattern="[\d\s\+\-]{10,15}"" maxlength="10"' : '' }} --}}
            value="{{ old($name, $slot ?: $value) }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}
            {{ $attributes->merge([
                'class' =>
                    'peer block w-full px-4 py-2 text-sm bg-gray-800 text-white border border-gray-600  shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-200 ease-in-out',
            ]) }} />

        {{-- Password Toggle --}}
        @if ($type === 'password')
            <button type="button" aria-label="Toggle password visibility"
                onclick="togglePassword('{{ $name }}')"
                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-white focus:outline-none">
                <i id="icon-{{ $name }}" class="fas fa-eye text-sm"></i>
            </button>
        @endif

        {{-- Error --}}
        @error($name)
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
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
