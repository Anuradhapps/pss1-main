@php
    use Illuminate\Support\Str;

    $pests = $average['pests'] ?? [];
    $otherInfo = $average['OtherInfo'] ?? [];

    // Use closures to avoid "Cannot redeclare function" PHP errors
    $getPestLevel = function ($count) {
        if ($count <= 1) {
            return ['level' => 'No risk', 'color' => 'green', 'icon' => 'check-circle'];
        }
        if ($count <= 3) {
            return ['level' => 'Alert', 'color' => 'yellow', 'icon' => 'exclamation-triangle'];
        }
        if ($count <= 5) {
            return ['level' => 'Threshold', 'color' => 'orange', 'icon' => 'exclamation-circle'];
        }
        return ['level' => 'Critical', 'color' => 'red', 'icon' => 'exclamation-circle'];
    };

    // Every class pair below is chosen to meet ~4.5:1 contrast against its
    // own background in BOTH light and dark mode (WCAG AA for body text).
    $getColorClasses = function ($color) {
        $colors = [
            'green' => [
                'bg' => 'bg-green-500', // solid accent (icon dot / progress bar)
                'text' => 'text-green-700 dark:text-green-300', // status label text
                'bgLight' => 'bg-green-50 dark:bg-green-900/30', // card background
                'border' => 'border-green-200 dark:border-green-700/40', // card border
                'pill' => 'bg-green-100 text-green-800 dark:bg-green-900/60 dark:text-green-300',
            ],
            'yellow' => [
                'bg' => 'bg-yellow-500',
                'text' => 'text-yellow-800 dark:text-yellow-300',
                'bgLight' => 'bg-yellow-50 dark:bg-yellow-900/30',
                'border' => 'border-yellow-200 dark:border-yellow-700/40',
                'pill' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/60 dark:text-yellow-300',
            ],
            'orange' => [
                'bg' => 'bg-orange-500',
                'text' => 'text-orange-800 dark:text-orange-300',
                'bgLight' => 'bg-orange-50 dark:bg-orange-900/30',
                'border' => 'border-orange-200 dark:border-orange-700/40',
                'pill' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/60 dark:text-orange-300',
            ],
            'red' => [
                'bg' => 'bg-red-500',
                'text' => 'text-red-700 dark:text-red-300',
                'bgLight' => 'bg-red-50 dark:bg-red-900/30',
                'border' => 'border-red-200 dark:border-red-700/40',
                'pill' => 'bg-red-100 text-red-800 dark:bg-red-900/60 dark:text-red-300',
            ],
        ];

        return $colors[$color] ?? $colors['green'];
    };
@endphp

<div
    class="mx-auto w-full max-w-7xl space-y-8 rounded-3xl border border-slate-200 bg-slate-50/80 p-4 shadow-sm transition-colors dark:border-slate-800 dark:bg-slate-950/70 sm:p-6 lg:p-8">

    <!-- Pest Grid -->
    <!-- UI Pattern: Adaptive layout (1 col on tiny phones, 2 on regular phones, scaling up) -->
    <div class="grid grid-cols-1 min-[480px]:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5">
        @foreach ($pests as $pest => $count)
            @php
                $level = $getPestLevel($count);
                $classes = $getColorClasses($level['color']);
            @endphp

            <div
                class="{{ $classes['bgLight'] }} {{ $classes['border'] }} group flex flex-col justify-between rounded-xl border p-4 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg sm:p-5">

                <div class="flex justify-between items-start mb-4 gap-3">

                    <div class="flex-1 min-w-0">
                        <!-- Typography: Bumped up to readable minimums (text-sm/text-base) -->
                        <h3
                            class="truncate text-sm font-semibold capitalize leading-tight text-slate-900 dark:text-slate-100 sm:text-base">
                            {{ Str::headline($pest) }}
                        </h3>

                        <!-- Distinct pill shape for status: dedicated bg/text pair for guaranteed contrast -->
                        <span
                            class="{{ $classes['pill'] }} mt-2 inline-flex items-center rounded-md px-2.5 py-1 text-xs font-semibold">
                            <i class="fas fa-{{ $level['icon'] }} mr-1.5 text-[10px]" aria-hidden="true"></i>
                            {{ $level['level'] }}
                        </span>
                    </div>

                    <!-- Visual Hierarchy: Grouped number and icon -->
                    <div class="flex flex-col items-end gap-1 flex-shrink-0">
                        <span class="text-xl sm:text-2xl font-black leading-none {{ $classes['text'] }}">
                            {{ $count }}
                        </span>
                        <div
                            class="flex h-7 w-7 items-center justify-center rounded-full bg-white shadow-inner ring-1 ring-slate-900/5 dark:bg-slate-900/50 dark:ring-white/5">
                            <div class="w-5 h-5 rounded-full flex items-center justify-center {{ $classes['bg'] }}">
                                <i class="fas fa-bug text-white text-[10px]" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Progress Bar: Slightly thicker for mobile visibility -->
                <div class="h-2 w-full overflow-hidden rounded-full bg-slate-900/10 shadow-inner dark:bg-slate-900/80">
                    <div class="{{ $classes['bg'] }} h-full rounded-full transition-all duration-1000 ease-out"
                        style="width: {{ min($count * 10, 100) }}%">
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Other Info -->
    @if (!empty($otherInfo))
        <div class="mt-10 sm:mt-12">

            <!-- Header Section -->
            <div class="flex items-center gap-4 mb-6">
                <div
                    class="w-12 h-12 rounded-xl bg-yellow-100 border border-yellow-300 flex items-center justify-center flex-shrink-0 dark:bg-yellow-500/20 dark:border-yellow-500/30">
                    <i class="fas fa-triangle-exclamation text-yellow-700 dark:text-yellow-400 text-xl"
                        aria-hidden="true"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold tracking-wide text-slate-900 dark:text-white sm:text-xl">
                        Field Alerts
                    </h2>
                    <p class="mt-0.5 text-sm text-slate-600 dark:text-slate-400">
                        {{ count($otherInfo) }} record(s) require attention
                    </p>
                </div>
            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 sm:gap-6">
                @foreach ($otherInfo as $info)
                    <div
                        class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:border-yellow-400 hover:shadow-xl hover:shadow-yellow-500/10 dark:border-slate-700/60 dark:bg-gradient-to-br dark:from-slate-900 dark:to-slate-800 dark:hover:shadow-yellow-500/5">

                        <!-- Top Accent Bar -->
                        <div class="h-1 w-full bg-gradient-to-r from-yellow-500 via-orange-500 to-red-500"></div>

                        <div class="p-5 sm:p-6 flex flex-col flex-1">

                            <!-- Issue (Proximity: kept together at the top) -->
                            <div class="flex items-start gap-3 sm:gap-4 mb-5 sm:mb-6">
                                <div
                                    class="w-10 h-10 rounded-full bg-red-100 border border-red-200 flex items-center justify-center flex-shrink-0 mt-0.5 dark:bg-red-500/15 dark:border-red-500/20">
                                    <i class="fas fa-circle-exclamation text-red-600 dark:text-red-400 text-sm"
                                        aria-hidden="true"></i>
                                </div>
                                <div class="flex-1">
                                    <div
                                        class="mb-1.5 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                        Reported Issue
                                    </div>
                                    <div
                                        class="text-sm font-medium leading-relaxed text-red-700 dark:text-red-300 sm:text-base">
                                        {{ $info['otherInfo'] }}
                                    </div>
                                </div>
                            </div>

                            <!-- Details (Gestalt Law of Enclosure: contained in bubbles) -->
                            <div class="flex flex-col sm:flex-row flex-wrap gap-3 mt-auto">

                                <!-- AI Range -->
                                <div
                                    class="flex flex-1 items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-700/40 dark:bg-slate-800/40">
                                    <div
                                        class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-500/15">
                                        <i class="fas fa-map-marker-alt text-sm text-blue-600 dark:text-blue-400"
                                            aria-hidden="true"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div
                                            class="text-[10px] font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400 sm:text-xs">
                                            AI Range
                                        </div>
                                        <div
                                            class="mt-0.5 truncate text-sm font-medium text-slate-900 dark:text-slate-100">
                                            {{ $info['aiRange'] }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Collector -->
                                <div
                                    class="flex flex-1 items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-700/40 dark:bg-slate-800/40">
                                    <div
                                        class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-lg bg-green-100 dark:bg-green-500/15">
                                        <i class="fas fa-user text-sm text-green-600 dark:text-green-400"
                                            aria-hidden="true"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div
                                            class="text-[10px] font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400 sm:text-xs">
                                            Collector
                                        </div>
                                        <div
                                            class="mt-0.5 truncate text-sm font-medium text-slate-900 dark:text-slate-100">
                                            {{ $info['name'] }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Number (Fitts's Law: Massive touch target for dialing) -->
                                <a href="tel:{{ $info['phone'] }}"
                                    class="mt-1 flex w-full items-center gap-3 rounded-xl border border-purple-200 bg-purple-50 p-3 transition-colors hover:bg-purple-100 active:bg-purple-100 dark:border-purple-500/20 dark:bg-purple-500/10 dark:hover:bg-purple-500/20 dark:active:bg-purple-500/20 sm:mt-0">
                                    <div
                                        class="w-9 h-9 rounded-lg bg-purple-100 dark:bg-purple-500/20 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-phone text-purple-600 dark:text-purple-400 text-sm"
                                            aria-hidden="true"></i>
                                    </div>
                                    <div>
                                        <div
                                            class="text-[10px] sm:text-xs text-purple-700/80 dark:text-purple-400/80 uppercase font-semibold tracking-wide">
                                            Tap to Call
                                        </div>
                                        <div
                                            class="text-purple-900 dark:text-purple-200 text-sm sm:text-base font-bold mt-0.5">
                                            {{ $info['phone'] }}
                                        </div>
                                    </div>
                                    <div class="ml-auto pr-2">
                                        <i class="fas fa-chevron-right text-purple-400 dark:text-purple-500/50 text-xs"
                                            aria-hidden="true"></i>
                                    </div>
                                </a>

                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
