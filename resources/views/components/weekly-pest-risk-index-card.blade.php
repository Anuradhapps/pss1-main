<div class="grid md:grid-cols-2 gap-6 my-4">

    <!-- Weekly Pest Risk Index -->
    <div class="p-5 bg-gray-900 border border-gray-700 rounded-2xl shadow-md hover:shadow-lg transition">
        <!-- Header -->
        <div class="flex flex-col items-center justify-between mb-4">
            <h2 class="flex items-center text-lg font-semibold text-white">
                <i class="mr-2 fas fa-calendar-week text-green-400"></i>
                Weekly Pest Risk Index
            </h2>
            <span class="text-xs text-gray-400 italic">Last updated: {{ now()->format('M d, Y') }}</span>
        </div>

        <!-- Description -->
        <p class="text-gray-300 text-sm mb-4 leading-relaxed">
            Stay informed about weekly pest risk levels to take timely preventive actions.
            Explore detailed charts and insights derived from field data.
        </p>

        <!-- Action -->
        <div class="flex justify-end">
            <a href="{{ route('weekly-pest-risk.index') }}"
                class="inline-flex items-center px-5 py-2 text-sm font-medium text-white bg-green-600 rounded-lg
                      hover:bg-green-700 focus:ring-2 focus:ring-green-400 focus:outline-none shadow transition-all duration-200">
                <i class="fas fa-chart-line mr-2"></i> View Report
            </a>
        </div>
    </div>

    <!-- Pest & Season Comparison -->
    <div class="p-5 bg-gray-900 border border-gray-700 rounded-2xl shadow-md hover:shadow-lg transition">
        <!-- Header -->
        <div class="flex flex-col items-center justify-between mb-4">
            <h2 class="flex items-center text-lg font-semibold text-white">
                <i class="mr-2 fas fa-random text-pink-400"></i>
                Pest & Season Comparison
            </h2>
            <span class="text-xs text-gray-400 italic">Last updated: {{ now()->format('M d, Y') }}</span>
        </div>

        <!-- Description -->
        <p class="text-gray-300 text-sm mb-4 leading-relaxed">
            Compare seasonal trends by visualizing weekly averages of pest damage intensity
            using a coded risk index (0–9 scale).
        </p>

        <!-- Action -->
        <div class="flex justify-end">
            <a href="{{ route('pest-season-comparison') }}"
                class="inline-flex items-center px-5 py-2 text-sm font-medium text-white bg-pink-600 rounded-lg
                      hover:bg-pink-700 focus:ring-2 focus:ring-pink-400 focus:outline-none shadow transition-all duration-200">
                <i class="fas fa-chart-area mr-2"></i> View Report
            </a>
        </div>
    </div>

    <!-- Pest & Temperature Comparison -->
    <div class="p-5 bg-gray-900 border border-gray-700 rounded-2xl shadow-md hover:shadow-lg transition">
        <!-- Header -->
        <div class="flex flex-col items-center justify-between mb-4">
            <h2 class="flex items-center text-lg font-semibold text-white">
                <i class="mr-2 fas fa-thermometer-half text-yellow-400"></i>
                Pest & Temperature Comparison
            </h2>
            <span class="text-xs text-gray-400 italic">Last updated: {{ now()->format('M d, Y') }}</span>
        </div>

        <!-- Description -->
        <p class="text-gray-300 text-sm mb-4 leading-relaxed">
            Analyze how weekly pest damage intensity (0–9 risk index scale)
            correlates with temperature variations.
        </p>

        <!-- Action -->
        <div class="flex justify-end">
            <a href="{{ route('pest-temp-comparison') }}"
                class="inline-flex items-center px-5 py-2 text-sm font-medium text-white bg-yellow-600 rounded-lg
                      hover:bg-yellow-700 focus:ring-2 focus:ring-yellow-400 focus:outline-none shadow transition-all duration-200">
                <i class="fas fa-chart-bar mr-2"></i> View Report
            </a>
        </div>
    </div>

    <!-- Pest, Rain & Temperature Comparison -->
    <div class="p-5 bg-gray-900 border border-gray-700 rounded-2xl shadow-md hover:shadow-lg transition">
        <!-- Header -->
        <div class="flex flex-col items-center justify-between mb-4">
            <h2 class="flex items-center text-lg font-semibold text-white">
                <i class="mr-2 fas fa-cloud-rain text-blue-400"></i>
                Pest, Rain & Temperature Comparison
            </h2>
            <span class="text-xs text-gray-400 italic">Last updated: {{ now()->format('M d, Y') }}</span>
        </div>

        <!-- Description -->
        <p class="text-gray-300 text-sm mb-4 leading-relaxed">
            Analyze how weekly pest damage intensity (0–9 risk index scale)
            correlates with rainfall and temperature variations.
        </p>

        <!-- Action -->
        <div class="flex justify-end">
            <a href="{{ route('pest-rain-comparison') }}"
                class="inline-flex items-center px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg
                      hover:bg-blue-700 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow transition-all duration-200">
                <i class="fas fa-chart-bar mr-2"></i> View Report
            </a>
        </div>
    </div>

</div>
