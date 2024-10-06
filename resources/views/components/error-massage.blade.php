@if (session('error'))
<div id="error-message" class="bg-red-500 text-white p-4 rounded mb-4">
    {{ session('error') }}
</div>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            setTimeout(() => {
                errorMessage.style.display = 'none';
            }, 3000); // 5000 milliseconds = 5 seconds
        }
    });
</script>