<div class="grid md:grid-cols-2 gap-6">

    <!-- Weekly Pest Risk Index -->
    <div class="p-5 bg-gray-900 border border-gray-700 rounded-2xl shadow-md hover:shadow-lg transition">
        <!-- Header -->
        <div class="flex flex-col items-center justify-between mb-4">
            <h2 class="flex items-center text-lg font-semibold text-white">
                <i class="mr-2 fas fa-calendar-week text-green-400"></i>
                Weekly Pest Risk Index
            </h2>
            <span class="text-xs text-gray-400 italic">Updated: {{ now()->format('M d, Y') }}</span>
        </div>

        <!-- Description -->
        <p class="text-gray-300 text-sm mb-4 leading-relaxed">
            Stay informed about weekly pest risk levels to make timely decisions.
            View detailed charts and insights based on field data.
        </p>

        <!-- Action -->
        <div class="flex justify-end">
            <a href="{{ route('weekly-pest-risk.index') }}"
                class="inline-flex items-center px-5 py-2 text-sm font-medium text-white bg-green-600 rounded-lg
                      hover:bg-green-700 focus:ring-2 focus:ring-green-400 focus:outline-none shadow
                      transition-all duration-200">
                <i class="fas fa-chart-line mr-2"></i> View Report
            </a>
        </div>
    </div>

    <!-- Pest Season Comparison -->
    <div class="p-5 bg-gray-900 border border-gray-700 rounded-2xl shadow-md hover:shadow-lg transition">
        <!-- Header -->
        <div class="flex flex-col items-center justify-between mb-4">
            <h2 class="flex items-center text-lg font-semibold text-white">
                <i class="mr-2 fas fa-random text-pink-400"></i>
                Pest & Season Comparison
            </h2>
            <span class="text-xs text-gray-400 italic">Updated: {{ now()->format('M d, Y') }}</span>
        </div>

        <!-- Description -->
        <p class="text-gray-300 text-sm mb-4 leading-relaxed">
            Visualize the weekly averages of each pest’s damage intensity using a coded risk index (0–9 scale)
            to enable clear comparison between seasons.
        </p>

        <!-- Action -->
        <div class="flex justify-end">
            <a href="{{ route('pest-season-comparison') }}"
                class="inline-flex items-center px-5 py-2 text-sm font-medium text-white bg-pink-600 rounded-lg
                      hover:bg-pink-700 focus:ring-2 focus:ring-pink-400 focus:outline-none shadow
                      transition-all duration-200">
                <i class="fas fa-chart-area mr-2"></i> View Report
            </a>
        </div>
    </div>

</div>
