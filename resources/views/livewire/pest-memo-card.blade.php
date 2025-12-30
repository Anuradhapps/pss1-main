@php

@endphp

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
}" class="w-full mx-auto p-4 space-y-6">

    <!-- Pest Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        <template x-for="([pest, count], index) in pestEntries" :key="pest">
            <div :class="`${getColorClasses(getPestLevel(count).color).bgLight} ${getColorClasses(getPestLevel(count).color).border}`"
                class="p-3 rounded-lg border flex flex-col justify-between transition transform hover:scale-105 hover:shadow-lg duration-300 group">

                <div class="flex justify-between items-start mb-2">
                    <div class="pr-1">
                        <h3 class="font-medium text-gray-100 capitalize text-xs sm:text-sm truncate"
                            x-text="pest.replace(/_/g,' ')"></h3>
                        <span
                            class="inline-flex items-center text-[9px] sm:text-xs px-2 py-0.5 rounded-full bg-gray-800 mt-1"
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
                <div class="w-full bg-gray-800 rounded-full h-1.5 mt-2">
                    <div :class="getColorClasses(getPestLevel(count).color).bg"
                        class="h-1.5 rounded-full transition-all duration-700 ease-out"
                        :style="`width: ${Math.min(count*10,100)}%`"></div>
                </div>

            </div>
        </template>
    </div>
    <!-- Other Info Section -->
    <div x-show="otherInfo.length > 0" class="mt-6 p-3 bg-gray-900 rounded-lg border border-gray-700" x-cloak>
        <h2 class="text-gray-100 font-semibold text-sm sm:text-base mb-2 flex items-center space-x-2">
            <i class="fas fa-info-circle text-yellow-400"></i>
            <span>Other Info</span>
        </h2>
        <div class="flex flex-wrap gap-2">
            <template x-for="info in otherInfo" :key="info">
                <span
                    class="flex items-center text-xs sm:text-sm px-2 py-1 bg-gray-800 text-gray-200 rounded-full hover:bg-gray-700 transition">
                    <i class="fas fa-map-marker-alt text-red-400 mr-1"></i>
                    <span x-text="info"></span>
                </span>
            </template>
        </div>
    </div>



</div>
