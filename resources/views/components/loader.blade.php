 <div>
     <!-- Modern Full Screen Loader -->
     <div id="modernPageLoader"
         class="fixed inset-0 z-50 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 bg-opacity-95 flex flex-col items-center justify-center transition-opacity duration-500 opacity-0 pointer-events-none">

         <!-- Complex spinner wrapper -->
         <div class="relative w-24 h-24 mb-8">
             <!-- Outer rotating ring -->
             <div
                 class="absolute inset-0 border-4 border-t-transparent border-b-transparent border-l-red-500 border-r-red-500 rounded-full animate-spin-slow">
             </div>

             <!-- Inner rotating ring -->
             <div
                 class="absolute inset-4 border-4 border-t-transparent border-b-transparent border-l-yellow-400 border-r-yellow-400 rounded-full animate-spin-fast">
             </div>

             <!-- Center circle -->
             <div class="absolute inset-10 bg-red-600 rounded-full"></div>
         </div>

         <!-- Text -->
         <h2 class="text-white text-3xl font-extrabold mb-2 tracking-wide animate-pulse">Loading, please wait...</h2>
         <p class="text-gray-300 text-lg tracking-wide max-w-xs text-center">We're preparing your experience. Thanks
             for your patience!</p>
     </div>

     <style>
         /* Custom animations for spinner speeds */
         @keyframes spin-slow {
             from {
                 transform: rotate(0deg);
             }

             to {
                 transform: rotate(360deg);
             }
         }

         @keyframes spin-fast {
             from {
                 transform: rotate(360deg);
             }

             to {
                 transform: rotate(0deg);
             }
         }

         .animate-spin-slow {
             animation: spin-slow 4s linear infinite;
         }

         .animate-spin-fast {
             animation: spin-fast 2s linear infinite;
         }
     </style>

     <script>
         const loader = document.getElementById('modernPageLoader');
         const exportRoutes = [
             '/admin/report'
         ];

         function isExportRoute(url) {
             return exportRoutes.some(route => url.includes(route));
         }
         // Show loader on page unload (navigation)
         window.addEventListener('beforeunload', () => {
             if (!isExportRoute(window.location.pathname)) {
                 loader.classList.remove('opacity-0', 'pointer-events-none');
             }

         });

         // Hide loader on page load
         window.addEventListener('load', () => {

             setTimeout(() => {
                 loader.classList.add('opacity-0', 'pointer-events-none');
             }, 400);
         });
     </script>

 </div>
