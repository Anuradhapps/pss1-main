@push('scripts')
    <script src="/js/ckeditor/ckeditor.js"></script>
@endpush

@props([
    'name' => '',
    'label' => '',
    'required' => false,
])

@php
    if ($label === '') {
        $label = ucwords(strtolower(implode(' ', preg_split('/(?=[A-Z])/', str_replace('_', ' ', $name)))));
    }
@endphp

<div wire:ignore class="w-full mt-5">
    @if ($label !== 'none')
        <label for="{{ $name }}" class="block mb-1 text-sm font-semibold text-gray-100">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <textarea x-data x-init="const editor = CKEDITOR.replace($refs.ckeditor);
    editor.on('change', () => {
        @this.set('{{ $name }}', editor.getData());
    });" x-ref="ckeditor" wire:ignore id="{{ $name }}"
        class="w-full px-4 py-2 text-sm text-white bg-gray-800 border border-gray-600 rounded-md shadow-sm focus:ring focus:ring-blue-500 focus:outline-none"
        {{ $required ? 'required' : '' }} {{ $attributes }}>{{ $slot }}</textarea>

    @error($name)
        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
    @enderror
</div>
