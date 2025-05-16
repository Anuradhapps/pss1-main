@props(['label'])

<div>
    <label class="block text-sm font-medium leading-5 text-white">{{ $label }}</label>
    <div class="mt-2">
        {{ $slot }}
    </div>
</div>
