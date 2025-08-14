 <div class="p-4 bg-gray-900 border border-gray-700 rounded-xl shadow-md mt-6  mx-auto">
     <!-- Header -->
     <div class="flex items-center justify-between px-4 py-3 mb-4 bg-gray-800 rounded-lg border-l-4 border-green-500">
         <h2 class="flex items-center text-lg font-semibold text-white">
             <i class="mr-2 fas fa-calendar-alt text-green-400"></i>
             Weekly Pest Risk Index
         </h2>
         <span class="text-xs text-gray-400 italic">Updated: {{ now()->format('M d, Y') }}</span>
     </div>

     <!-- Description -->
     <p class="text-gray-300 text-sm px-4 mb-4">
         Stay informed about weekly pest risk levels to make timely decisions.
         View detailed charts and insights based on field data.
     </p>

     <!-- Action Button -->
     <div class="flex justify-end px-4">
         <a href="{{ route('weekly-pest-risk.index') }}"
             class="inline-flex items-center px-5 py-2 text-sm font-medium text-white bg-green-600 rounded-lg
                  hover:bg-green-700 focus:ring-2 focus:ring-green-400 focus:outline-none shadow
                  transition-all duration-200">
             <i class="fas fa-chart-line mr-2"></i> View Report
         </a>
     </div>
 </div>
