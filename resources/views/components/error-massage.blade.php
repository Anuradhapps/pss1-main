{{-- Error Message (Dark Mode) --}}
@if (session('error'))
    <div id="error-message"
        class="flex items-center p-4 mb-3 text-red-400 border border-red-700 rounded-lg bg-gray-900 shadow-lg transition-opacity duration-500"
        role="alert">
        <i class="fas fa-exclamation-circle mr-2 text-red-500"></i>
        <span class="font-medium">{{ session('error') }}</span>
    </div>
@endif

{{-- Auto-hide Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            setTimeout(() => {
                errorMessage.style.opacity = '0'; // fade out
                setTimeout(() => errorMessage.remove(), 500); // remove after fade
            }, 5000); // 5 seconds
        }
    });
</script>
