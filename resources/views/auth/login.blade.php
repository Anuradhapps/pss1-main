<x-guest-layout>
    @section('title', 'Login')

    <x-auth-card class="max-w-md mx-auto p-6 sm:p-8 bg-gray-900 text-white rounded-2xl shadow-2xl space-y-6">

        <!-- Header -->
        <div class="flex items-center justify-between gap-2">
            <p class="text-sm text-gray-400">Don't have an account?</p>
            @if (Route::has('register'))
                <a href="{{ route('register') }}"
                    class="px-4 py-2 text-sm font-medium rounded-lg bg-green-600 hover:bg-green-700 transition duration-300 shadow">
                    New Registration
                </a>
            @endif
        </div>

        <!-- Title -->
        <div class="text-center">

            <h3 class="text-lg font-bold text-gray-400">Log in to your account</h3>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="p-4 text-sm text-red-200 bg-red-800 border border-red-500 rounded-md animate-pulse">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5" novalidate>
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                        autocomplete="username"
                        class="w-full pl-10 pr-4 py-2 bg-gray-800 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="you@example.com" />
                </div>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input id="password" name="password" type="password" required autocomplete="current-password"
                        class="w-full pl-10 pr-10 py-2 bg-gray-800 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="••••••••" />
                    <button type="button" id="toggle-password"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white"
                        aria-label="Toggle password visibility">
                        <i class="fas fa-eye" id="toggle-password-icon"></i>
                    </button>
                </div>
            </div>

            <!-- Help -->
            <div class="text-right text-sm text-gray-400">
                <a href="{{ route('loginhelp') }}" class="underline hover:text-blue-400">
                    Need help logging in ❓
                </a>
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full py-3 font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition duration-300 shadow-md hover:shadow-lg">
                Login
            </button>
        </form>
    </x-auth-card>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Show/Hide Password Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('toggle-password');
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('toggle-password-icon');

            toggleBtn.addEventListener('click', () => {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        });
    </script>
</x-guest-layout>
