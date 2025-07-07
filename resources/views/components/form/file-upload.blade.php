@props(['label' => 'Select File'])

<div class="flex flex-wrap items-center gap-4">
    {{ $slot }}

    <div x-data="{ focused: false }">
        <span class="inline-flex rounded-md shadow-sm">
            <input type="file" class="sr-only" x-ref="fileInput" @focus="focused = true" @blur="focused = false"
                {{ $attributes }}>

            <label for="{{ $attributes->get('id', 'file-upload-' . uniqid()) }}"
                :class="{ 'ring-2 ring-blue-500': focused }"
                class="inline-block px-4 py-2 text-sm font-medium text-white transition bg-gray-700 border border-gray-600 rounded-md cursor-pointer hover:bg-gray-600 focus:outline-none"
                @click="$refs.fileInput.click()">
                {{ $label }}
            </label>
        </span>
    </div>
</div>
