
    
    {{-- Check if an success message is set in the session and display it --}}
    @if (session('success'))
    <div id="success-message" class="bg-green-500 text-white p-4 rounded my-3">
        {{ session('success') }}
    </div>
    @endif

     {{-- JavaScript to hide the success message after 5 seconds --}}
     <script>
        document.addEventListener('DOMContentLoaded', function () {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 3000); // 5000 milliseconds = 5 seconds
            }
        });
    </script>
