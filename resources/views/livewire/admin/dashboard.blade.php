@section('title', 'Dashboard')

<div class="space-y-3">
    {{-- Header --}}
    <x-headings.basic_heading title="Dashboard" icon="fas fa-house" />

    {{-- Description Section --}}
    <div
        class="relative overflow-hidden rounded-xl border border-primary/20 bg-gradient-to-br from-primary/5 via-white to-white dark:from-primary/10 dark:via-slate-900 dark:to-slate-900 shadow-sm">
        <div class="absolute -right-6 -top-6 w-28 h-28 rounded-full bg-primary/10 blur-2xl"></div>
        <div class="relative p-3.5 sm:p-4">
            <h2 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <i class="fas fa-bullseye text-primary text-sm"></i>
                Pest Surveillance Programme Objectives
            </h2>

            <div class="grid md:grid-cols-2 gap-3 mt-3">
                <div class="flex items-start gap-2.5">
                    <div
                        class="w-7 h-7 shrink-0 rounded-full bg-primary text-white text-sm font-bold flex items-center justify-center mt-0.5">
                        1
                    </div>
                    <p class="text-slate-600 dark:text-slate-300 leading-snug text-sm">
                        Enables the National Plant Protection Service to efficiently gather field data via a
                        mobile-friendly web application focused on pest surveillance.
                    </p>
                </div>
                <div class="flex items-start gap-2.5">
                    <div
                        class="w-7 h-7 shrink-0 rounded-full bg-primary text-white text-sm font-bold flex items-center justify-center mt-0.5">
                        2
                    </div>
                    <p class="text-slate-600 dark:text-slate-300 leading-snug text-sm">
                        Records pest density and damage intensity weekly throughout the cropping season across
                        selected locations.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Count Cards Grid --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 xl:grid-cols-8 gap-2">
        <livewire:count-card :cardName="'Users'" :iconName="'fas fa-users'" :color="'from-purple-600 to-indigo-600'" />
        <livewire:count-card :cardName="'Collectors'" :iconName="'fas fa-user-check'" :color="'from-emerald-500 to-teal-500'" />
        <livewire:count-card :cardName="'Provinces'" :iconName="'fas fa-map'" :color="'from-sky-500 to-blue-600'" />
        <livewire:count-card :cardName="'Districts'" :iconName="'fas fa-flag'" :color="'from-rose-500 to-red-600'" />

        <livewire:count-card :cardName="'ASC'" :iconName="'fas fa-building'" :color="'from-amber-500 to-orange-500'" />
        <livewire:count-card :cardName="'AiRanges'" :iconName="'fas fa-map-pin'" :color="'from-pink-500 to-rose-500'" />
        <livewire:count-card :cardName="'Pests'" :iconName="'fas fa-bug'" :color="'from-violet-500 to-purple-600'" />
        <livewire:count-card :cardName="'ConductedPrograms'" :iconName="'fas fa-chalkboard-teacher'" :color="'from-cyan-500 to-blue-500'" />
    </div>

    {{-- District Pest Summary (Last 7 Days) --}}
    @php
        // Centralized pest metadata so table (desktop) and cards (mobile) stay in sync
        $pestMeta = [
            'thrips' => ['label' => 'Thrips', 'sub' => 'S. biformis', 'icon' => 'fa-magnifying-glass-plus'],
            'gallMidge' => ['label' => 'Gall Midge', 'sub' => 'O. oryzae', 'icon' => 'fa-seedling'],
            'leaffolder' => ['label' => 'Leaffolder', 'sub' => 'C. medinalis', 'icon' => 'fa-leaf'],
            'yellowStemBorer' => ['label' => 'Stem Borer', 'sub' => 'S. incertulas', 'icon' => 'fa-wheat-awn'],
            'bphWbph' => ['label' => 'BPH & WBPH', 'sub' => 'Planthoppers', 'icon' => 'fa-bug'],
            'paddyBug' => ['label' => 'Paddy Bug', 'sub' => 'L. oratorius', 'icon' => 'fa-spider'],
        ];

        // Shared risk-level resolver -> returns [badge, dot, label]
        $riskLevel = function ($code) {
            return match (true) {
                $code >= 9 => [
                    'badge' =>
                        'bg-red-50 text-red-700 ring-red-200 dark:bg-red-500/15 dark:text-red-400 dark:ring-red-500/30 font-bold',
                    'dot' => 'bg-red-500',
                    'label' => 'Critical',
                ],
                $code >= 5 => [
                    'badge' =>
                        'bg-orange-50 text-orange-700 ring-orange-200 dark:bg-orange-500/15 dark:text-orange-400 dark:ring-orange-500/30 font-bold',
                    'dot' => 'bg-orange-500',
                    'label' => 'High',
                ],
                $code >= 1 => [
                    'badge' =>
                        'bg-amber-50 text-amber-700 ring-amber-200 dark:bg-amber-500/15 dark:text-amber-400 dark:ring-amber-500/30 font-semibold',
                    'dot' => 'bg-amber-500',
                    'label' => 'Low',
                ],
                default => [
                    'badge' =>
                        'bg-slate-50 text-slate-500 ring-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:ring-slate-700 font-medium',
                    'dot' => 'bg-slate-300 dark:bg-slate-600',
                    'label' => 'None',
                ],
            };
        };
    @endphp

    <div
        class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm overflow-hidden">

        {{-- Header --}}
        <div
            class="flex items-center justify-between gap-3 px-3.5 sm:px-4 py-3 border-b border-slate-200 dark:border-slate-800 bg-gradient-to-r from-slate-50 to-white dark:from-slate-800/60 dark:to-slate-900">
            <div class="flex items-center gap-2.5 min-w-0">
                <div
                    class="w-9 h-9 shrink-0 rounded-lg bg-amber-500/10 flex items-center justify-center text-amber-600 dark:text-amber-400 ring-1 ring-amber-500/20">
                    <i class="fas fa-calendar-week text-sm"></i>
                </div>
                <div class="min-w-0">
                    <h2 class="text-base font-bold text-slate-900 dark:text-white leading-tight truncate">
                        Pest Risk Summary by District
                    </h2>
                    <p class="text-xs text-slate-400 dark:text-slate-500 leading-tight">Last 7 days · averaged
                        risk codes</p>
                </div>
            </div>

            {{-- Legend --}}
            @if (!empty($districtSummaries))
                <div class="hidden sm:flex items-center gap-3 shrink-0">
                    @foreach ([9 => 'Critical', 5 => 'High', 1 => 'Low', 0 => 'None'] as $code => $label)
                        @php $lvl = $riskLevel($code); @endphp
                        <span
                            class="inline-flex items-center gap-1 text-xs font-medium text-slate-500 dark:text-slate-400">
                            <span class="w-1.5 h-1.5 rounded-full {{ $lvl['dot'] }}"></span>
                            {{ $label }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Empty state --}}
        @if (empty($districtSummaries))
            <div class="p-8 text-center">
                <div
                    class="w-12 h-12 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400">
                    <i class="fas fa-folder-open text-lg"></i>
                </div>
                <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-1">No Recent Data</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 max-w-xs mx-auto">
                    No pest data records were uploaded in the past 7 days.
                </p>
            </div>
        @else
            {{-- ===================== DESKTOP / TABLET: COMPACT TABLE (md+) ===================== --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/60">
                            <th scope="col"
                                class="sticky left-0 z-10 bg-slate-50 dark:bg-slate-800/60 px-4 py-3 font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide text-xs align-middle">
                                District
                            </th>
                            @foreach ($pestMeta as $meta)
                                <th scope="col" class="px-2.5 py-3 text-center align-middle min-w-[100px]">
                                    <span
                                        class="block text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wide leading-tight">{{ $meta['label'] }}</span>
                                    <span
                                        class="block text-[11px] font-medium text-slate-400 dark:text-slate-500 italic leading-tight">{{ $meta['sub'] }}</span>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($districtSummaries as $district => $pests)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                <td
                                    class="sticky left-0 z-10 bg-white dark:bg-slate-900 px-4 py-2.5 font-semibold text-slate-800 dark:text-slate-100 whitespace-nowrap text-sm">
                                    <i
                                        class="fas fa-location-dot text-primary/60 mr-1.5 text-xs"></i>{{ $district }}
                                </td>

                                @foreach ($pestMeta as $pestKey => $meta)
                                    @php
                                        $code = $pests[$pestKey] ?? 0;
                                        $lvl = $riskLevel($code);
                                    @endphp
                                    <td class="px-2.5 py-2.5 text-center">
                                        <span
                                            title="{{ $meta['label'] }}: {{ $lvl['label'] }} risk (code {{ $code }})"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-md text-sm ring-1 ring-inset {{ $lvl['badge'] }}">
                                            {{ $code }}
                                        </span>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- ===================== MOBILE: COMPACT STACKED CARDS (below md) ===================== --}}
            <div class="md:hidden divide-y divide-slate-100 dark:divide-slate-800">
                @foreach ($districtSummaries as $district => $pests)
                    @php
                        $worstCode = -1;
                        foreach ($pestMeta as $key => $meta) {
                            $c = $pests[$key] ?? 0;
                            if ($c > $worstCode) {
                                $worstCode = $c;
                            }
                        }
                        $worstLvl = $riskLevel($worstCode);
                    @endphp
                    <details class="group">
                        <summary
                            class="list-none flex items-center justify-between gap-2 px-3.5 py-2.5 cursor-pointer select-none active:bg-slate-50 dark:active:bg-slate-800/40">
                            <div class="flex items-center gap-2 min-w-0">
                                <i class="fas fa-location-dot text-primary/60 text-sm shrink-0"></i>
                                <span
                                    class="font-semibold text-slate-800 dark:text-white text-sm truncate">{{ $district }}</span>
                            </div>
                            <div class="flex items-center gap-1.5 shrink-0">
                                <span
                                    class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full ring-1 ring-inset {{ $worstLvl['badge'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $worstLvl['dot'] }}"></span>
                                    {{ $worstCode > 0 ? $worstLvl['label'] : 'No risk' }}
                                </span>
                                <i
                                    class="fas fa-chevron-down text-xs text-slate-400 transition-transform duration-200 group-open:rotate-180"></i>
                            </div>
                        </summary>

                        <div class="px-3.5 pb-3 pt-0.5 bg-slate-50/60 dark:bg-slate-800/20">
                            <div class="grid grid-cols-2 gap-1.5">
                                @foreach ($pestMeta as $pestKey => $meta)
                                    @php
                                        $code = $pests[$pestKey] ?? 0;
                                        $lvl = $riskLevel($code);
                                    @endphp
                                    <div
                                        class="flex items-center justify-between gap-1.5 rounded-md bg-white dark:bg-slate-900 ring-1 ring-slate-200 dark:ring-slate-700 px-2.5 py-2">
                                        <div class="min-w-0">
                                            <p
                                                class="text-xs font-bold text-slate-700 dark:text-slate-100 truncate leading-tight">
                                                {{ $meta['label'] }}
                                            </p>
                                            <p
                                                class="text-[10.5px] font-medium text-slate-400 dark:text-slate-500 italic truncate leading-tight">
                                                {{ $meta['sub'] }}
                                            </p>
                                        </div>
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 shrink-0 rounded-md text-xs ring-1 ring-inset {{ $lvl['badge'] }}">
                                            {{ $code }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </details>
                @endforeach
            </div>
        @endif
    </div>
</div>
