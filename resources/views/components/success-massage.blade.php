{{-- Success Message (Light/Dark Mode) --}}
@if (session('success'))
    <div id="success-message"
        class="flex items-start sm:items-center p-4 mb-4 gap-3 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/50 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 shadow-sm transition-all duration-500"
        role="alert">
        <i class="fas fa-check-circle text-emerald-500 dark:text-emerald-400 text-lg mt-0.5 sm:mt-0 flex-shrink-0"></i>
        <div class="font-medium text-sm sm:text-base leading-snug">{{ session('success') }}</div>
    </div>
@endif

{{-- Auto-hide Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.opacity = '0';
                successMessage.style.transform = 'translateY(-10px)';
                setTimeout(() => successMessage.remove(), 500);
            }, 5000);
        }
    });
</script>
