@props([
    'padding' => 'p-6',
    'shadow' => 'shadow-sm',
])

<div
    {{ $attributes->merge(['class' => "bg-surface dark:bg-card border border-slate-200 dark:border-slate-800 rounded-2xl $shadow transition-all duration-300 relative overflow-hidden group"]) }}>
    <div class="{{ $padding }} relative z-10">
        {{ $slot }}
    </div>

    <!-- Optional hover glass effect overlay -->
    <div
        class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
    </div>
</div>
