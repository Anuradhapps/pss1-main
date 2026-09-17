<div>
    <!-- Modern Full Screen Loader -->
    <div id="modernPageLoader"
        class="fixed inset-0 z-[100] flex flex-col items-center justify-center transition-all duration-500 opacity-0 pointer-events-none bg-white/90 dark:bg-slate-900/90 backdrop-blur-md">

        <!-- Animated Icon Container -->
        <div class="relative flex items-center justify-center mb-6">
            <!-- Pulsing outer rings -->
            <div class="absolute inset-0 rounded-full bg-emerald-500/20 dark:bg-emerald-400/20 animate-ping" style="animation-duration: 2s;"></div>
            <div class="absolute inset-[-15px] rounded-full bg-emerald-500/10 dark:bg-emerald-400/10 animate-pulse" style="animation-duration: 1.5s;"></div>
            
            <!-- Center Icon -->
            <div class="relative w-20 h-20 bg-emerald-100 dark:bg-emerald-500/20 rounded-full flex items-center justify-center shadow-lg shadow-emerald-500/20">
                <i class="fas fa-seedling text-4xl text-emerald-600 dark:text-emerald-400 animate-pulse"></i>
            </div>
            
            <!-- Spinning border -->
            <svg class="absolute inset-[-8px] w-[96px] h-[96px] animate-spin text-emerald-500 dark:text-emerald-400 opacity-70" style="animation-duration: 3s;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>

        <!-- Text -->
        <h2 class="text-slate-800 dark:text-white text-2xl font-bold mb-2 tracking-wide animate-pulse">Loading NPSS...</h2>
        <p class="text-slate-500 dark:text-slate-400 text-sm tracking-wide text-center">Preparing your workspace</p>
    </div>

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
                loader.classList.add('opacity-100');
            }
        });

        // Hide loader on page load
        window.addEventListener('load', () => {
            setTimeout(() => {
                loader.classList.remove('opacity-100');
                loader.classList.add('opacity-0', 'pointer-events-none');
            }, 300); // Fast, smooth fade out
        });
    </script>
</div>
