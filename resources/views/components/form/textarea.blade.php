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

<div class="w-full">
    @if ($label != 'none')
        <label for="{{ $name }}" class="block mb-1.5 text-sm font-medium text-slate-700 dark:text-slate-300">
            {{ $label }}
            @if ($required != '')
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <textarea name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge([
            'class' =>
                'peer block w-full px-4 py-2.5 text-sm bg-white dark:bg-slate-900 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:border-primary dark:focus:border-primary focus:ring-2 focus:ring-primary/50 focus:outline-none transition duration-300 ease-in-out',
        ]) }}>{{ $slot }}</textarea>

    @error($name)
        <p class="mt-1 text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>
