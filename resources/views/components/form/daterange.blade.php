@props([
    'options' => [],
    'required' => false,
    'name' => '',
    'label' => '',
    'value' => '',
])

@php
    if ($label === '') {
        $label = ucwords(strtolower(implode(' ', preg_split('/(?=[A-Z])/', str_replace('_', ' ', $name)))));
    }

    $options = array_merge(
        [
            'dateFormat' => 'd-m-Y',
            'enableTime' => false,
            'time_24hr' => true,
            'mode' => 'range',
        ],
        $options,
    );
@endphp

<div class="w-full">
    @if ($label !== 'none')
        <label for="{{ $name }}" class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <i class="far fa-calendar-alt absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm z-10"></i>
        <input x-data x-init="flatpickr($refs.input, {{ json_encode((object) $options) }})" x-ref="input" type="text" id="{{ $name }}"
            name="{{ $name }}" value="{{ old($name, $value ?: $slot) }}" placeholder="Select date range"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge([
                'class' =>
                    'w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-900 dark:text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors',
            ]) }} />

        @error($name)
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>
</div>
