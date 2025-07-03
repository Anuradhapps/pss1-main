<x-guest-layout>
    @section('title', 'Login')

    <x-auth-card class="max-w-md p-6 mx-auto text-white bg-gray-900 rounded-lg shadow-xl">
        <!-- Top Links -->
        <div class="flex flex-col justify-between mb-6 space-y-3 sm:flex-row sm:items-center sm:space-y-0">
            <p class="text-sm italic text-gray-300">Don’t have an account?</p>

            @if (Route::has('register'))
                <a href="{{ route('register') }}"
                    class="inline-block px-4 py-2 text-sm font-semibold text-white transition duration-300 bg-green-600 rounded-md hover:bg-green-700 hover:shadow-md">
                    Register
                </a>
            @endif
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-6" novalidate>
            @csrf

            <p class="text-sm text-gray-300">Welcome back! Please log in to your account.</p>

            @include('errors.messages')

            <!-- Email -->
            <div>
                <label for="email" class="block mb-1 text-sm font-semibold text-gray-300">Email Address</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                    autocomplete="username"
                    class="w-full px-4 py-2 text-white bg-gray-800 border border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="you@example.com" />
            </div>

            <!-- Password with show/hide -->
            <div>
                <label for="password" class="block mb-1 text-sm font-semibold text-gray-300">Password</label>
                <div class="relative">
                    <input id="password" name="password" type="password" required autocomplete="current-password"
                        class="w-full px-4 py-2 pr-10 text-white bg-gray-800 border border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter your password" />
                    <button type="button" id="toggle-password"
                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-white focus:outline-none"
                        tabindex="-1" aria-label="Toggle password visibility">
                        <i class="fas fa-eye" id="toggle-password-icon"></i>
                    </button>
                </div>
            </div>

            <!-- Remember Me and Forgot Password -->
            <div class="flex items-center justify-between text-sm text-gray-300">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember"
                        class="text-blue-500 bg-gray-800 border-gray-600 rounded focus:ring-blue-500">
                    <span class="ml-2">Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="underline hover:text-blue-300">
                        Forgot Password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full px-5 py-3 mt-4 text-sm font-semibold text-white transition duration-300 bg-blue-600 rounded-md hover:bg-blue-700 hover:shadow-md">
                Login
            </button>
        </form>
    </x-auth-card>

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Show/Hide Password Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggle-password');
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('toggle-password-icon');

            toggleBtn.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                if (type === 'text') {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>
</x-guest-layout>
