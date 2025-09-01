<div x-data="{
    pests: {{ json_encode($average['pests'] ?? []) }},
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
}" class="w-full  mx-auto p-2 space-y-3">

    <!-- Pest Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 ">
        <template x-for="([pest, count], index) in pestEntries" :key="pest">
            <div :class="`${getColorClasses(getPestLevel(count).color).bgLight} ${getColorClasses(getPestLevel(count).color).border}`"
                class="p-2 rounded-lg border flex flex-col justify-between transition transform hover:scale-105 hover:shadow-lg duration-300 group">

                <div class="flex justify-between items-start mb-1">
                    <div class="pr-1">
                        <h3 class="font-medium text-gray-100 capitalize text-xs sm:text-sm truncate"
                            x-text="pest.replace(/_/g,' ')"></h3>
                        <span
                            class="inline-flex items-center text-[9px] sm:text-xs px-1.5 py-0.5 rounded-full bg-gray-800 mt-1"
                            :class="getColorClasses(getPestLevel(count).color).text">
                            <i :class="`fas fa-${getPestLevel(count).icon} mr-1 text-[8px] sm:text-xs`"></i>
                            <span x-text="getPestLevel(count).level"></span>
                        </span>
                    </div>
                    <div class="flex items-center ml-1">
                        <span class="text-sm sm:text-lg font-bold mr-1.5"
                            :class="getColorClasses(getPestLevel(count).color).text" x-text="count"></span>
                        <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-full flex items-center justify-center bg-gray-800">
                            <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full flex items-center justify-center"
                                :class="getColorClasses(getPestLevel(count).color).bg">
                                <i class="fas fa-bug text-white text-[8px] sm:text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="w-full bg-gray-800 rounded-full h-1.5 mt-1">
                    <div :class="getColorClasses(getPestLevel(count).color).bg"
                        class="h-1.5 rounded-full transition-all duration-700 ease-out"
                        :style="`width: ${Math.min(count*10,100)}%`"></div>
                </div>

            </div>
        </template>
    </div>
</div>
