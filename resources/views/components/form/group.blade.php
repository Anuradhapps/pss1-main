@props([
    'label' => '',
    'for' => null,
    'required' => false,
])

<div class="w-full mb-4">
    <label @if ($for) for="{{ $for }}" @endif
        class="block text-sm font-medium text-slate-700 dark:text-slate-300">
        {{ $label }}
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    <div class="mt-2">
        {{ $slot }}
    </div>
</div>
