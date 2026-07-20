<div x-data="{
    pests: {{ json_encode($average['pests'] ?? []) }},
    otherInfo: {{ json_encode($average['OtherInfo'] ?? []) }},
    get pestEntries() { return Object.entries(this.pests); },
    getPestLevel(count) {
        if (count <= 1) return { level: 'No risk', color: 'green', icon: 'check-circle', bg: 'bg-emerald-50', border: 'border-emerald-200', text: 'text-emerald-700', badge: 'bg-emerald-100', badgeText: 'text-emerald-700', dot: 'bg-emerald-500', progress: 'bg-emerald-500', darkBg: 'dark:bg-emerald-950/30', darkBorder: 'dark:border-emerald-800', darkText: 'dark:text-emerald-300', darkBadge: 'dark:bg-emerald-900/50' };
        if (count <= 3) return { level: 'Alert', color: 'yellow', icon: 'exclamation-triangle', bg: 'bg-amber-50', border: 'border-amber-200', text: 'text-amber-700', badge: 'bg-amber-100', badgeText: 'text-amber-700', dot: 'bg-amber-500', progress: 'bg-amber-500', darkBg: 'dark:bg-amber-950/30', darkBorder: 'dark:border-amber-800', darkText: 'dark:text-amber-300', darkBadge: 'dark:bg-amber-900/50' };
        if (count <= 5) return { level: 'Threshold', color: 'orange', icon: 'exclamation-circle', bg: 'bg-orange-50', border: 'border-orange-200', text: 'text-orange-700', badge: 'bg-orange-100', badgeText: 'text-orange-700', dot: 'bg-orange-500', progress: 'bg-orange-500', darkBg: 'dark:bg-orange-950/30', darkBorder: 'dark:border-orange-800', darkText: 'dark:text-orange-300', darkBadge: 'dark:bg-orange-900/50' };
        return { level: 'Critical', color: 'red', icon: 'exclamation-circle', bg: 'bg-rose-50', border: 'border-rose-200', text: 'text-rose-700', badge: 'bg-rose-100', badgeText: 'text-rose-700', dot: 'bg-rose-500', progress: 'bg-rose-500', darkBg: 'dark:bg-rose-950/30', darkBorder: 'dark:border-rose-800', darkText: 'dark:text-rose-300', darkBadge: 'dark:bg-rose-900/50' };
    }
}" class="mx-auto w-full space-y-6 p-4 text-slate-700 transition-colors dark:text-slate-200">

    <!-- Pest Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 sm:gap-4">
        <template x-for="([pest, count], index) in pestEntries" :key="pest">
            <div class="group relative flex flex-col justify-between rounded-2xl border p-3 sm:p-4 transition-all duration-300 hover:scale-[1.03] hover:shadow-lg cursor-default"
                :class="[
                    getPestLevel(count).bg,
                    getPestLevel(count).border,
                    getPestLevel(count).darkBg,
                    getPestLevel(count).darkBorder
                ]">

                <!-- Top Row: Status Dot + Count -->
                <div class="flex items-center justify-between mb-2 sm:mb-3">
                    <div class="flex items-center gap-1.5">
                        <div class="w-2 h-2 rounded-full animate-pulse" :class="getPestLevel(count).dot"></div>
                        <span class="text-[10px] sm:text-xs font-semibold uppercase tracking-wider"
                            :class="getPestLevel(count).text + ' ' + getPestLevel(count).darkText"
                            x-text="getPestLevel(count).level"></span>
                    </div>
                    <span class="text-lg sm:text-2xl font-bold tabular-nums"
                        :class="getPestLevel(count).text + ' ' + getPestLevel(count).darkText"
                        x-text="count"></span>
                </div>

                <!-- Pest Name -->
                <div class="mb-2 sm:mb-3">
                    <h3 class="text-xs sm:text-sm font-bold capitalize text-slate-900 dark:text-white leading-tight"
                        x-text="pest.replace(/_/g,' ')"></h3>
                </div>

                <!-- Progress Bar -->
                <div class="mt-auto">
                    <div class="h-1.5 sm:h-2 w-full rounded-full bg-white/60 dark:bg-slate-800/60 overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-700 ease-out"
                            :class="getPestLevel(count).progress"
                            :style="`width: ${Math.min(count * 10, 100)}%`"></div>
                    </div>
                </div>



            </div>
        </template>
    </div>

    <!-- Empty State -->
    <div x-show="pestEntries.length === 0" class="text-center py-12" x-cloak>
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
            <i class="fas fa-leaf text-slate-400 dark:text-slate-600 text-2xl"></i>
        </div>
        <p class="text-sm text-slate-500 dark:text-slate-400">No pest data available for this period.</p>
    </div>

    <!-- Other Info Section -->
    <div x-show="otherInfo.length > 0"
        class="mt-6 rounded-2xl border border-slate-200 bg-white p-4 sm:p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm"
        x-cloak>

        <div class="flex items-center gap-2 mb-3 sm:mb-4">
            <div class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-500/20 flex items-center justify-center text-amber-600 dark:text-amber-400">
                <i class="fas fa-info-circle text-sm"></i>
            </div>
            <h2 class="text-sm sm:text-base font-bold text-slate-900 dark:text-white">Other Information</h2>
            <span class="ml-auto text-xs text-slate-500 dark:text-slate-400" x-text="otherInfo.length + ' items'"></span>
        </div>

        <div class="flex flex-wrap gap-2">
            <template x-for="info in otherInfo" :key="info">
                <span class="inline-flex items-center gap-1.5 rounded-xl px-3 py-1.5 text-xs sm:text-sm font-medium transition-all duration-200 hover:scale-105 hover:shadow-md cursor-default bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                    <i class="fas fa-map-marker-alt text-rose-500 text-xs"></i>
                    <span x-text="info"></span>
                </span>
            </template>
        </div>
    </div>

</div>