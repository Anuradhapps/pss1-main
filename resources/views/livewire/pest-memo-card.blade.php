@php
    use Illuminate\Support\Str;

    // Sort by count descending so the most severe pest is always first —
    // a field officer scanning this shouldn't have to read all six cards
// to find the one that matters most right now.
$pests = collect($average['pests'] ?? [])->sortDesc();
$otherInfo = $average['OtherInfo'] ?? [];

// Use closures to avoid "Cannot redeclare function" PHP errors
$getPestLevel = function ($count) {
    // Bar width mapping (exact, not a flat per-tier value):
    //   0 -> 0, 1 -> 10, 3 -> 30, 5 -> 50, 7 -> 75, 9 -> 100
    // That's slope 10/unit from 0–5, then slope 12.5/unit from 5–9.
        $barWidth = $count <= 5 ? $count * 10 : 50 + ($count - 5) * 12.5;
        $barWidth = max(0, min(100, $barWidth));

        // count = 0 gets its own neutral tier, distinct from "No risk" (1) —
        // zero means nothing was observed at all, not "observed and safe."
        if ($count <= 0) {
            return ['level' => 'None', 'color' => 'gray', 'icon' => 'minus-circle', 'barWidth' => $barWidth];
        }
        if ($count <= 1) {
            return ['level' => 'No risk', 'color' => 'green', 'icon' => 'check-circle', 'barWidth' => $barWidth];
        }
        if ($count <= 3) {
            return ['level' => 'Alert', 'color' => 'yellow', 'icon' => 'exclamation-triangle', 'barWidth' => $barWidth];
        }
        if ($count <= 5) {
            return [
                'level' => 'Threshold',
                'color' => 'orange',
                'icon' => 'exclamation-circle',
                'barWidth' => $barWidth,
            ];
        }
        return ['level' => 'Critical', 'color' => 'red', 'icon' => 'exclamation-circle', 'barWidth' => $barWidth];
    };

    // Every class pair below is chosen to meet ~4.5:1 contrast against its
    // own background in BOTH light and dark mode (WCAG AA for body text).
    $getColorClasses = function ($color) {
        $colors = [
            'gray' => [
                'bg' => 'bg-slate-400 dark:bg-slate-600',
                'text' => 'text-slate-600 dark:text-slate-400',
                'bgLight' => 'bg-slate-50 dark:bg-slate-900/40',
                'border' => 'border-slate-200 dark:border-slate-700',
                'pill' => 'bg-slate-200 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
            ],
            'green' => [
                'bg' => 'bg-emerald-700',
                'text' => 'text-emerald-900 dark:text-emerald-300',
                'bgLight' => 'bg-emerald-100 dark:bg-emerald-950/40',
                'border' => 'border-emerald-400 dark:border-emerald-800',
                'pill' => 'bg-emerald-200 text-emerald-900 dark:bg-emerald-900/70 dark:text-emerald-200',
            ],
            'yellow' => [
                'bg' => 'bg-amber-600',
                'text' => 'text-amber-900 dark:text-amber-300',
                'bgLight' => 'bg-amber-100 dark:bg-amber-950/40',
                'border' => 'border-amber-400 dark:border-amber-800',
                'pill' => 'bg-amber-200 text-amber-900 dark:bg-amber-900/70 dark:text-amber-200',
            ],
            'orange' => [
                'bg' => 'bg-orange-700',
                'text' => 'text-orange-900 dark:text-orange-300',
                'bgLight' => 'bg-orange-100 dark:bg-orange-950/40',
                'border' => 'border-orange-400 dark:border-orange-800',
                'pill' => 'bg-orange-200 text-orange-900 dark:bg-orange-900/70 dark:text-orange-200',
            ],
            'red' => [
                'bg' => 'bg-red-700',
                'text' => 'text-red-900 dark:text-red-300',
                'bgLight' => 'bg-red-100 dark:bg-red-950/40',
                'border' => 'border-red-400 dark:border-red-800',
                'pill' => 'bg-red-200 text-red-900 dark:bg-red-900/70 dark:text-red-200',
            ],
        ];

        return $colors[$color] ?? $colors['green'];
    };
@endphp

{{-- No outer card/border/shadow here — this component renders inside the
     district card in the dashboard, which already provides that chrome.
     Adding our own would double up the border/shadow around it. --}}
<div class="w-full space-y-3" wire:loading.class="opacity-60 pointer-events-none" wire:target="districtId, days">

    @if ($pests->isEmpty())
        {{-- Empty state: without this, "no data yet" looked identical to a rendering bug --}}
        <div
            class="flex flex-col items-center justify-center gap-2 rounded-lg border border-dashed border-slate-300 bg-slate-50/60 py-8 text-center dark:border-slate-700 dark:bg-slate-900/40">
            <i class="fas fa-bug-slash text-lg text-slate-400 dark:text-slate-600" aria-hidden="true"></i>
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">No pest data for this period</p>
        </div>
    @else
        <!-- Pest Grid -->
        <!-- 2 cols on phones, 3 at sm, 6 at xl — all clean divisors of 6, so
             there's never an orphaned item alone in the last row. -->
        <div class="grid grid-cols-2 gap-2 sm:grid-cols-3 sm:gap-2.5 xl:grid-cols-6" role="list">
            @foreach ($pests as $pest => $count)
                @php
                    $level = $getPestLevel($count);
                    $classes = $getColorClasses($level['color']);
                    $pestName = Str::headline($pest);
                @endphp

                <div role="listitem" aria-label="{{ $pestName }}: {{ $level['level'] }}, count {{ $count }}"
                    class="{{ $classes['bgLight'] }} {{ $classes['border'] }} group flex flex-col justify-between rounded-lg border p-2.5 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">

                    <div class="mb-2 flex items-start justify-between gap-2">

                        <div class="min-w-0 flex-1">
                            {{-- line-clamp instead of truncate: on a pest ID tool, a
                                 clipped name ("Yellow Stem B…") risks misreading a
                                 species — better to wrap onto a second line.
                                 text-sm (14px) instead of the old text-xs (12px):
                                 this is the label an officer identifies the pest by,
                                 it shouldn't be the smallest thing on the card. --}}
                            <h3
                                class="line-clamp-2 text-sm font-semibold capitalize leading-snug text-slate-900 dark:text-slate-100">
                                {{ $pestName }}
                            </h3>

                            {{-- Severity pill: text-xs (12px) is the accessibility
                                 floor for anything carrying real information — the
                                 old text-[11px] sat just under that. --}}
                            <span
                                class="{{ $classes['pill'] }} mt-1.5 inline-flex items-center rounded-md px-1.5 py-0.5 text-xs font-semibold">
                                <i class="fas fa-{{ $level['icon'] }} mr-1 text-[10px]" aria-hidden="true"></i>
                                {{ $level['level'] }}
                            </span>
                        </div>

                        <!-- The count is the thing an officer scans for first, so
                             it's the single largest element on the card. -->
                        <div class="flex flex-shrink-0 flex-col items-end gap-1">
                            <span
                                class="tabular-nums text-xl font-black leading-none {{ $classes['text'] }} sm:text-2xl">
                                {{ $count }}
                            </span>
                            <div class="flex h-5 w-5 items-center justify-center rounded-full {{ $classes['bg'] }}">
                                <i class="fas fa-bug text-[9px] text-white" aria-hidden="true"></i>
                            </div>
                        </div>

                    </div>

                    <!-- Progress bar follows the exact count→width mapping:
                         0→0, 1→10, 3→30, 5→50, 7→75, 9→100 -->
                    <div class="h-1.5 w-full overflow-hidden rounded-full bg-slate-900/10 dark:bg-slate-900/80">
                        <div class="{{ $classes['bg'] }} h-full rounded-full transition-all duration-700 ease-out"
                            style="width: {{ $level['barWidth'] }}%">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Other Info -->
    @if (!empty($otherInfo))
        <div>

            <!-- Header -->
            <div class="mb-2 flex items-center gap-2">
                <div
                    class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-lg border border-amber-300 bg-amber-100 dark:border-amber-500/30 dark:bg-amber-500/20">
                    <i class="fas fa-triangle-exclamation text-xs text-amber-700 dark:text-amber-400"
                        aria-hidden="true"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        {{ count($otherInfo) }} record(s) require attention
                    </p>
                </div>
            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 gap-2 lg:grid-cols-2 xl:grid-cols-2">
                @foreach ($otherInfo as $info)
                    <div
                        class="group flex flex-col  rounded-lg border border-slate-200 bg-white shadow-sm transition-all duration-200 hover:border-amber-300 hover:shadow-md dark:border-slate-700/60 dark:bg-slate-900/60">

                        <!-- Top Accent Bar -->
                        <div class="h-0.5 w-full bg-gradient-to-r from-amber-500 via-orange-500 to-red-500"></div>

                        <div class="flex flex-1 flex-col p-3">

                            <!-- Issue -->
                            <div class="mb-2.5 flex items-start gap-2">
                                <div
                                    class="mt-0.5 flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full border border-red-200 bg-red-100 dark:border-red-500/20 dark:bg-red-500/15">
                                    <i class="fas fa-circle-exclamation text-xs text-red-600 dark:text-red-400"
                                        aria-hidden="true"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    {{-- Eyebrow bumped from text-[10px] to text-xs (12px):
                                         the accessibility floor for informational text --}}
                                    <div
                                        class="mb-0.5 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                        Reported Issue
                                    </div>
                                    <div class="text-sm font-medium leading-relaxed text-red-700 dark:text-red-300">
                                        {{ $info['otherInfo'] }}
                                    </div>
                                </div>
                            </div>

                            <!-- Details -->
                            <div class="mt-auto grid grid-cols-1 gap-2 sm:grid-cols-3">

                                <!-- AI Range -->
                                <div
                                    class="flex items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 p-2 dark:border-slate-700/40 dark:bg-slate-800/40">
                                    <div
                                        class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-md bg-blue-100 dark:bg-blue-500/15">
                                        <i class="fas fa-map-marker-alt text-xs text-blue-600 dark:text-blue-400"
                                            aria-hidden="true"></i>
                                    </div>
                                    <div class="min-w-0">
                                        {{-- Eyebrow labels bumped from text-[9px] to
                                             text-[11px] — still visually secondary to
                                             the value below it, but no longer below
                                             any reasonable reading threshold. --}}
                                        <div
                                            class="text-[11px] font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                                            AI Range - {{ $info['region'] }}
                                        </div>
                                        <div class="truncate text-sm font-medium text-slate-900 dark:text-slate-100">
                                            {{ $info['aiRange'] }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Collector -->
                                <div
                                    class="flex items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 p-2 dark:border-slate-700/40 dark:bg-slate-800/40">
                                    <div
                                        class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-md bg-emerald-100 dark:bg-emerald-500/15">
                                        <i class="fas fa-user text-xs text-emerald-600 dark:text-emerald-400"
                                            aria-hidden="true"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div
                                            class="text-[11px] font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                                            Collector
                                        </div>
                                        <div class="truncate text-sm font-medium text-slate-900 dark:text-slate-100">
                                            {{ $info['name'] }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Number (Fitts's Law: large touch target for dialing) -->
                                <a href="tel:{{ $info['phone'] }}"
                                    class="flex items-center gap-2 rounded-lg border border-purple-200 bg-purple-50 p-2 transition-colors hover:bg-purple-100 active:bg-purple-100 dark:border-purple-500/20 dark:bg-purple-500/10 dark:hover:bg-purple-500/20">
                                    <div
                                        class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-md bg-purple-100 dark:bg-purple-500/20">
                                        <i class="fas fa-phone text-xs text-purple-600 dark:text-purple-400"
                                            aria-hidden="true"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div
                                            class="text-[11px] font-semibold uppercase tracking-wide text-purple-700/80 dark:text-purple-400/80">
                                            Tap to Call
                                        </div>
                                        <div class="truncate text-sm font-bold text-purple-900 dark:text-purple-200">
                                            {{ $info['phone'] }}
                                        </div>
                                    </div>
                                    <i class="fas fa-chevron-right flex-shrink-0 text-xs text-purple-400 dark:text-purple-500/50"
                                        aria-hidden="true"></i>
                                </a>

                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
