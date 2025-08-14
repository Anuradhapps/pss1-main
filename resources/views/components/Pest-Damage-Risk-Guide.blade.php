 <div class="my-2 bg-indigo-50/50 rounded-xl border border-indigo-200 overflow-hidden">
     <div class="flex items-center justify-between px-4 py-1 cursor-pointer" onclick="toggleRiskGuide()">
         <h3 class="text-sm font-semibold text-indigo-800 flex items-center">
             <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5 mr-2 text-indigo-600 transition-transform duration-200" id="riskGuideIcon" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
             </svg>
             Pest Damage Risk Level Guide
         </h3>
         <span class="text-xs font-medium text-indigo-600 bg-indigo-100 px-2 py-1 rounded-full">Click to
             expand</span>
     </div>

     <div class="px-4 pb-3 pt-0 border-t border-indigo-100" id="riskGuideContent" style="display: none;">
         <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mt-2">
             <div class="bg-white p-3 rounded-lg border border-green-200 shadow-xs">
                 <div class="flex items-center space-x-2">
                     <span
                         class="flex items-center justify-center h-6 w-6 rounded-full bg-green-100 text-green-800 font-bold text-sm">0-1</span>
                     <span class="text-sm font-medium text-gray-900">No damage risk</span>
                 </div>
                 <p class="text-xs text-gray-600 mt-1">Normal pest population, no action needed</p>
             </div>

             <div class="bg-white p-3 rounded-lg border border-yellow-200 shadow-xs">
                 <div class="flex items-center space-x-2">
                     <span
                         class="flex items-center justify-center h-6 w-6 rounded-full bg-yellow-100 text-yellow-800 font-bold text-sm">3</span>
                     <span class="text-sm font-medium text-gray-900">Alert level</span>
                 </div>
                 <p class="text-xs text-gray-600 mt-1">Close observation recommended</p>
             </div>

             <div class="bg-white p-3 rounded-lg border border-orange-200 shadow-xs">
                 <div class="flex items-center space-x-2">
                     <span
                         class="flex items-center justify-center h-6 w-6 rounded-full bg-orange-100 text-orange-800 font-bold text-sm">5</span>
                     <span class="text-sm font-medium text-gray-900">Threshold</span>
                 </div>
                 <p class="text-xs text-gray-600 mt-1">Pest control suggested</p>
             </div>

             <div class="bg-white p-3 rounded-lg border border-red-200 shadow-xs">
                 <div class="flex items-center space-x-2">
                     <span
                         class="flex items-center justify-center h-6 w-6 rounded-full bg-red-100 text-red-800 font-bold text-sm">7-9</span>
                     <span class="text-sm font-medium text-gray-900">Critical level</span>
                 </div>
                 <p class="text-xs text-gray-600 mt-1">Immediate action required</p>
             </div>
         </div>
     </div>
 </div>
 <script>
     // UI Functions
     window.toggleRiskGuide = function() {
         const content = document.getElementById('riskGuideContent');
         const icon = document.getElementById('riskGuideIcon');
         if (content.style.display === 'none') {
             content.style.display = 'block';
             icon.style.transform = 'rotate(90deg)';
         } else {
             content.style.display = 'none';
             icon.style.transform = 'rotate(0deg)';
         }
     };
 </script>
