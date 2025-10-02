{{-- Success Message (Dark Mode) --}}
@if (session('success'))
    <div id="success-message"
        class="flex items-center p-4 mb-3 text-green-400 border border-green-700 rounded-lg bg-gray-900 shadow-lg transition-opacity duration-500"
        role="alert">
        <i class="fas fa-check-circle mr-2 text-green-500"></i>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
@endif

{{-- Auto-hide Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.opacity = '0'; // fade out
                setTimeout(() => successMessage.remove(), 500); // remove after fade
            }, 5000); // 5 seconds
        }
    });
</script>
