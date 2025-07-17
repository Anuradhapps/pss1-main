@props([
    'title' => '',
    'subtitle' => '',
    'icon' => null,
    'class' => '',
])

<div class="mb-3  p-1 pl-2 {{ $class }}">
    <div class="flex items-center gap-3">
        @if ($icon)
            <i class="{{ $icon }} text-2xl"></i>
        @endif
        <h1 class="text-2xl font-bold text-white">{{ $title }}</h1>
    </div>

    @if ($subtitle)
        <p class="text-sm text-gray-400">{{ $subtitle }}</p>
    @endif
</div>
