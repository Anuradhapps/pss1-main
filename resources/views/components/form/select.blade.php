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
        <label for='{{ $name }}' class='block mb-1.5 text-sm font-medium text-slate-700 dark:text-slate-300'>{{ $label }}
            @if ($required != '')
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    <select name='{{ $name }}' id='{{ $name }}' {{ $required }}
        {{ $attributes->merge(['class' => 'peer block w-full px-4 py-2.5 text-sm bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:border-primary dark:focus:border-primary focus:ring-2 focus:ring-primary/50 focus:outline-none transition duration-300 ease-in-out']) }}>
        @if ($placeholder != '')
            <option value=''>{{ $placeholder }}</option>
        @endif
        {{ $slot }}
    </select>

    {{-- Error --}}
    @error($name)
        <p class="mt-1 text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>
