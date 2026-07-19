<div x-data="{
    pests: {{ json_encode($average['pests'] ?? []) }},
    otherInfo: {{ json_encode($average['OtherInfo'] ?? []) }},
    get pestEntries() { return Object.entries(this.pests); },
    getPestLevel(count) {
        if (count <= 1) return { level: 'No risk', color: 'green', icon: 'check-circle' };
        if (count <= 3) return { level: 'Alert', color: 'yellow', icon: 'exclamation-triangle' };
        if (count <= 5) return { level: 'Threshold', color: 'orange', icon: 'exclamation-circle' };
        return { level: 'Critical', color: 'red', icon: 'exclamation-circle' };
    },
    getColorClasses(color) {
        const colors = {
            green: { bg: 'bg-green-600', text: 'text-green-300', bgLight: 'bg-green-900/50', border: 'border-green-700/50' },
            yellow: { bg: 'bg-yellow-600', text: 'text-yellow-300', bgLight: 'bg-yellow-900/50', border: 'border-yellow-700/50' },
            orange: { bg: 'bg-orange-600', text: 'text-orange-300', bgLight: 'bg-orange-900/50', border: 'border-orange-700/50' },
            red: { bg: 'bg-red-600', text: 'text-red-300', bgLight: 'bg-red-900/50', border: 'border-red-700/50' }
        };
        return colors[color] || colors.green;
    }
}" class="mx-auto w-full space-y-6 p-4 text-slate-700 transition-colors dark:text-slate-200">

    <!-- Pest Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        <template x-for="([pest, count], index) in pestEntries" :key="pest">
            <div :class="`${getColorClasses(getPestLevel(count).color).bgLight} ${getColorClasses(getPestLevel(count).color).border}`"
                class="group flex flex-col justify-between rounded-xl border p-3 transition duration-300 hover:scale-105 hover:shadow-lg">

                <div class="flex justify-between items-start mb-2">
                    <div class="pr-1">
                        <h3 class="truncate text-xs font-medium capitalize text-slate-900 dark:text-white sm:text-sm"
                            x-text="pest.replace(/_/g,' ')"></h3>
                        <span
                            class="mt-1 inline-flex items-center rounded-full bg-white/80 px-2 py-0.5 text-[9px] sm:text-xs dark:bg-slate-900/80"
                            :class="getColorClasses(getPestLevel(count).color).text">
                            <i :class="`fas fa-${getPestLevel(count).icon} mr-1 text-[8px] sm:text-xs`"></i>
                            <span x-text="getPestLevel(count).level"></span>
                        </span>
                    </div>
                    <div class="flex items-center ml-1">
                        <span class="text-sm sm:text-lg font-bold mr-1.5"
                            :class="getColorClasses(getPestLevel(count).color).text" x-text="count"></span>
                        <div class="flex h-6 w-6 items-center justify-center rounded-full bg-white/80 dark:bg-slate-900/80 sm:h-7 sm:w-7">
                            <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full flex items-center justify-center"
                                :class="getColorClasses(getPestLevel(count).color).bg">
                                <i class="fas fa-bug text-white text-[8px] sm:text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="mt-2 h-1.5 w-full rounded-full bg-slate-200 dark:bg-slate-800">
                    <div :class="getColorClasses(getPestLevel(count).color).bg"
                        class="h-1.5 rounded-full transition-all duration-700 ease-out"
                        :style="`width: ${Math.min(count*10,100)}%`"></div>
                </div>

            </div>
        </template>
    </div>
    <!-- Other Info Section -->
    <div x-show="otherInfo.length > 0" class="mt-6 rounded-xl border border-slate-200 bg-white p-3 dark:border-slate-800 dark:bg-slate-900" x-cloak>
        <h2 class="mb-2 flex items-center space-x-2 text-sm font-semibold text-slate-900 dark:text-white sm:text-base">
            <i class="fas fa-info-circle text-amber-500"></i>
            <span>Other Info</span>
        </h2>
        <div class="flex flex-wrap gap-2">
            <template x-for="info in otherInfo" :key="info">
                <span
                    class="flex items-center rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-700 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700 sm:text-sm">
                    <i class="fas fa-map-marker-alt mr-1 text-rose-500"></i>
                    <span x-text="info"></span>
                </span>
            </template>
        </div>
    </div>



</div>
