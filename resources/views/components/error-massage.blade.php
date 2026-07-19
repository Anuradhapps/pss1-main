{{-- Error Message (Light/Dark Mode) --}}
@if (session('error'))
    <div id="error-message"
        class="flex items-start sm:items-center p-4 mb-4 gap-3 text-red-800 dark:text-red-300 border border-red-200 dark:border-red-800/50 rounded-xl bg-red-50 dark:bg-red-900/20 shadow-sm transition-all duration-500"
        role="alert">
        <i class="fas fa-exclamation-circle text-red-500 dark:text-red-400 text-lg mt-0.5 sm:mt-0 flex-shrink-0"></i>
        <div class="font-medium text-sm sm:text-base leading-snug">{{ session('error') }}</div>
    </div>
@endif

{{-- Auto-hide Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            setTimeout(() => {
                errorMessage.style.opacity = '0';
                errorMessage.style.transform = 'translateY(-10px)';
                setTimeout(() => errorMessage.remove(), 500);
            }, 6000); // 6 seconds to give them time to read longer errors
        }
    });
</script>
