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

    $getColorClasses = function ($color) {
        $colors = [
            'green' => [
                'bg' => 'bg-green-500',
                'text' => 'text-green-300',
                'bgLight' => 'bg-green-900/30',
                'border' => 'border-green-700/40',
            ],
            'yellow' => [
                'bg' => 'bg-yellow-500',
                'text' => 'text-yellow-300',
                'bgLight' => 'bg-yellow-900/30',
                'border' => 'border-yellow-700/40',
            ],
            'orange' => [
                'bg' => 'bg-orange-500',
                'text' => 'text-orange-300',
                'bgLight' => 'bg-orange-900/30',
                'border' => 'border-orange-700/40',
            ],
            'red' => [
                'bg' => 'bg-red-500',
                'text' => 'text-red-300',
                'bgLight' => 'bg-red-900/30',
                'border' => 'border-red-700/40',
            ],
        ];

        return $colors[$color] ?? $colors['green'];
    };
@endphp

<div class="w-full max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 space-y-8">

    <!-- Pest Grid -->
    <!-- UI Pattern: Adaptive layout (1 col on tiny phones, 2 on regular phones, scaling up) -->
    <div class="grid grid-cols-1 min-[480px]:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5">
        @foreach ($pests as $pest => $count)
            @php
                $level = $getPestLevel($count);
                $classes = $getColorClasses($level['color']);
            @endphp

            <div
                class="{{ $classes['bgLight'] }} {{ $classes['border'] }} p-4 sm:p-5 rounded-xl border flex flex-col justify-between transition-all transform hover:-translate-y-1 hover:shadow-lg duration-300 group">

                <div class="flex justify-between items-start mb-4 gap-3">

                    <div class="flex-1 min-w-0">
                        <!-- Typography: Bumped up to readable minimums (text-sm/text-base) -->
                        <h3 class="font-semibold text-gray-100 capitalize text-sm sm:text-base leading-tight truncate">
                            {{ Str::headline($pest) }}
                        </h3>

                        <!-- Distinct pill shape for status -->
                        <span
                            class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-md bg-gray-900/60 mt-2 {{ $classes['text'] }}">
                            <i class="fas fa-{{ $level['icon'] }} mr-1.5 text-[10px]" aria-hidden="true"></i>
                            {{ $level['level'] }}
                        </span>
                    </div>

                    <!-- Visual Hierarchy: Grouped number and icon -->
                    <div class="flex flex-col items-end gap-1 flex-shrink-0">
                        <span class="text-xl sm:text-2xl font-black leading-none {{ $classes['text'] }}">
                            {{ $count }}
                        </span>
                        <div class="w-7 h-7 rounded-full flex items-center justify-center bg-gray-900/50 shadow-inner">
                            <div class="w-5 h-5 rounded-full flex items-center justify-center {{ $classes['bg'] }}">
                                <i class="fas fa-bug text-gray-900 text-[10px]" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Progress Bar: Slightly thicker for mobile visibility -->
                <div class="w-full bg-gray-900/80 rounded-full h-2 overflow-hidden shadow-inner">
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
                    class="w-12 h-12 rounded-xl bg-yellow-500/20 border border-yellow-500/30 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-triangle-exclamation text-yellow-400 text-xl" aria-hidden="true"></i>
                </div>
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-white tracking-wide">
                        Field Alerts
                    </h2>
                    <p class="text-sm text-gray-400 mt-0.5">
                        {{ count($otherInfo) }} record(s) require attention
                    </p>
                </div>
            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 sm:gap-6">
                @foreach ($otherInfo as $info)
                    <div
                        class="group rounded-2xl border border-gray-700/60 bg-gradient-to-br from-gray-900 to-gray-800 hover:border-yellow-500/40 hover:shadow-xl hover:shadow-yellow-500/5 transition-all duration-300 overflow-hidden flex flex-col">

                        <!-- Top Accent Bar -->
                        <div class="h-1 w-full bg-gradient-to-r from-yellow-500 via-orange-500 to-red-500"></div>

                        <div class="p-5 sm:p-6 flex flex-col flex-1">

                            <!-- Issue (Proximity: kept together at the top) -->
                            <div class="flex items-start gap-3 sm:gap-4 mb-5 sm:mb-6">
                                <div
                                    class="w-10 h-10 rounded-full bg-red-500/15 border border-red-500/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i class="fas fa-circle-exclamation text-red-400 text-sm" aria-hidden="true"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1.5">
                                        Reported Issue
                                    </div>
                                    <div class="text-red-300 text-sm sm:text-base font-medium leading-relaxed">
                                        {{ $info['otherInfo'] }}
                                    </div>
                                </div>
                            </div>

                            <!-- Details (Gestalt Law of Enclosure: contained in bubbles) -->
                            <div class="flex flex-col sm:flex-row flex-wrap gap-3 mt-auto">

                                <!-- AI Range -->
                                <div
                                    class="flex-1 flex items-center gap-3 p-3 rounded-xl bg-gray-800/40 border border-gray-700/40">
                                    <div
                                        class="w-9 h-9 rounded-lg bg-blue-500/15 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-map-marker-alt text-blue-400 text-sm" aria-hidden="true"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div
                                            class="text-[10px] sm:text-xs text-gray-500 uppercase font-semibold tracking-wide">
                                            AI Range
                                        </div>
                                        <div class="text-gray-100 text-sm font-medium truncate mt-0.5">
                                            {{ $info['aiRange'] }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Collector -->
                                <div
                                    class="flex-1 flex items-center gap-3 p-3 rounded-xl bg-gray-800/40 border border-gray-700/40">
                                    <div
                                        class="w-9 h-9 rounded-lg bg-green-500/15 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-user text-green-400 text-sm" aria-hidden="true"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div
                                            class="text-[10px] sm:text-xs text-gray-500 uppercase font-semibold tracking-wide">
                                            Collector
                                        </div>
                                        <div class="text-gray-100 text-sm font-medium truncate mt-0.5">
                                            {{ $info['name'] }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Number (Fitts's Law: Massive touch target for dialing) -->
                                <a href="tel:{{ $info['phone'] }}"
                                    class="w-full flex items-center gap-3 p-3 rounded-xl bg-purple-500/10 border border-purple-500/20 active:bg-purple-500/20 hover:bg-purple-500/20 transition-colors mt-1 sm:mt-0">
                                    <div
                                        class="w-9 h-9 rounded-lg bg-purple-500/20 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-phone text-purple-400 text-sm" aria-hidden="true"></i>
                                    </div>
                                    <div>
                                        <div
                                            class="text-[10px] sm:text-xs text-purple-400/80 uppercase font-semibold tracking-wide">
                                            Tap to Call
                                        </div>
                                        <div class="text-purple-200 text-sm sm:text-base font-bold mt-0.5">
                                            {{ $info['phone'] }}
                                        </div>
                                    </div>
                                    <div class="ml-auto pr-2">
                                        <i class="fas fa-chevron-right text-purple-500/50 text-xs"></i>
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
