@section('title', 'Admin Dashboard')

<div class="space-y-2">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-10 right-20 w-32 h-32 bg-secondary/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="flex items-center gap-4 relative z-10">
            <div class="w-12 h-12 rounded-xl bg-primary/10 dark:bg-primary/20 flex items-center justify-center text-primary dark:text-primary-light">
                <i class="fas fa-chart-line text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">System Dashboard</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">National Pest Surveillance Programme Overview</p>
            </div>
        </div>
    </div>

    {{-- Description Section --}}
    <x-ui.card padding="p-6" class="border-t-4 border-primary shadow-lg">
        <h2 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-lg bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                <i class="fas fa-seedling"></i>
            </div>
            Programme Objectives
        </h2>

        <div class="grid md:grid-cols-2 gap-6 mt-6">
            <div class="flex items-start gap-4">
                <div class="w-8 h-8 shrink-0 rounded-full bg-primary/10 flex items-center justify-center text-primary mt-0.5">
                    1
                </div>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed text-sm">
                    The system provides an understanding of the Plant Protection Service's requirements for creating a
                    new smartphone web app to collect data on pest surveillance purposes.
                </p>
            </div>
            <div class="flex items-start gap-4">
                <div class="w-8 h-8 shrink-0 rounded-full bg-primary/10 flex items-center justify-center text-primary mt-0.5">
                    2
                </div>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed text-sm">
                    The main purpose of the pest surveillance data collection web application is to record the density of
                    target pests and damage intensity in the selected location throughout the cropping season on a
                    regular basis (Weekly).
                </p>
            </div>
        </div>
    </x-ui.card>

    {{-- Count Cards Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 p-4">
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
    <x-ui.card padding="p-0" class="shadow-md overflow-hidden mt-8 border-t-4 border-amber-500">
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-amber-100 dark:bg-amber-900/50 flex items-center justify-center text-amber-600 dark:text-amber-400">
                    <i class="fas fa-calendar-week"></i>
                </div>
                Last 7 Days: Pest Risk Summary by District
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 ml-13">Aggregated average pest risk codes based on recent data uploads.</p>
        </div>

        <div class="overflow-x-auto">
            @if(empty($districtSummaries))
            <div class="p-10 text-center">
                <div class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                    <i class="fas fa-folder-open text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-slate-900 dark:text-white mb-2">No Recent Data</h3>
                <p class="text-slate-500 dark:text-slate-400 max-w-sm mx-auto">There are no pest data records uploaded in the past 7 days.</p>
            </div>
            @else
            <table class="w-full text-sm text-left border-collapse">
                <thead class="border-y border-emerald-100 dark:border-slate-700/80">
                    <tr class="!bg-gradient-to-r !from-emerald-50 !to-teal-50 dark:!from-slate-800/90 dark:!to-slate-800/90">
                        <th scope="col" class="px-6 py-5 font-bold !text-slate-900 dark:!text-slate-100 uppercase tracking-wider text-xs align-bottom">
                            District
                        </th>
                        <th scope="col" class="px-6 py-4 text-center align-bottom border-l border-slate-300/50 dark:border-slate-700/50">
                            <span class="block text-xs font-black text-slate-900 dark:text-slate-100 uppercase tracking-widest mb-1">Thrips</span>
                            <span class="block text-[11px] font-semibold text-emerald-800 dark:text-emerald-400 italic">S. biformis</span>
                        </th>
                        <th scope="col" class="px-6 py-4 text-center align-bottom border-l border-slate-300/50 dark:border-slate-700/50">
                            <span class="block text-xs font-black text-slate-900 dark:text-slate-100 uppercase tracking-widest mb-1">Gall Midge</span>
                            <span class="block text-[11px] font-semibold text-emerald-800 dark:text-emerald-400 italic">O. oryzae</span>
                        </th>
                        <th scope="col" class="px-6 py-4 text-center align-bottom border-l border-slate-300/50 dark:border-slate-700/50">
                            <span class="block text-xs font-black text-slate-900 dark:text-slate-100 uppercase tracking-widest mb-1">Leaffolder</span>
                            <span class="block text-[11px] font-semibold text-emerald-800 dark:text-emerald-400 italic">C. medinalis</span>
                        </th>
                        <th scope="col" class="px-6 py-4 text-center align-bottom border-l border-slate-300/50 dark:border-slate-700/50">
                            <span class="block text-xs font-black text-slate-900 dark:text-slate-100 uppercase tracking-widest mb-1">Stem Borer</span>
                            <span class="block text-[11px] font-semibold text-emerald-800 dark:text-emerald-400 italic">S. incertulas</span>
                        </th>
                        <th scope="col" class="px-6 py-4 text-center align-bottom border-l border-slate-300/50 dark:border-slate-700/50">
                            <span class="block text-xs font-black text-slate-900 dark:text-slate-100 uppercase tracking-widest mb-1">BPH & WBPH</span>
                            <span class="block text-[11px] font-semibold text-emerald-800 dark:text-emerald-400 italic">Planthoppers</span>
                        </th>
                        <th scope="col" class="px-6 py-4 text-center align-bottom border-l border-slate-300/50 dark:border-slate-700/50">
                            <span class="block text-xs font-black text-slate-900 dark:text-slate-100 uppercase tracking-widest mb-1">Paddy Bug</span>
                            <span class="block text-[11px] font-semibold text-emerald-800 dark:text-emerald-400 italic">L. oratorius</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($districtSummaries as $district => $pests)
                    <tr class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4 font-semibold text-slate-900 dark:text-white whitespace-nowrap">
                            <i class="fas fa-map-marker-alt text-primary/70 mr-2"></i> {{ $district }}
                        </td>

                        @foreach(['thrips', 'gallMidge', 'leaffolder', 'yellowStemBorer', 'bphWbph', 'paddyBug'] as $pestKey)
                        @php
                        $code = $pests[$pestKey] ?? 0;
                        $colorClasses = match(true) {
                        $code >= 9 => 'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-400 ring-red-500/30 font-black',
                        $code >= 5 => 'bg-orange-100 text-orange-800 dark:bg-orange-500/20 dark:text-orange-400 ring-orange-500/30 font-bold',
                        $code >= 1 => 'bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-400 ring-amber-500/30 font-bold',
                        default => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-400 ring-slate-300 dark:ring-slate-700 font-semibold'
                        };
                        @endphp
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-sm ring-1 ring-inset {{ $colorClasses }}">
                                {{ $code }}
                            </span>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </x-ui.card>
</div>