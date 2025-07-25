<x-guest-layout>
    @section('title', 'Register')
    <x-auth-card class="max-w-md p-6 mx-auto text-white bg-gray-900 rounded-lg shadow-xl">
        <h1 class="mb-6 text-2xl font-extrabold text-center text-white">Create Your Account</h1>

        {{-- ✅ Show All Validation Errors (Top Alert Box) --}}
        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-200 bg-red-800 border border-red-700 ">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-6" novalidate>
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block mb-1 text-sm font-semibold text-gray-300">Full Name</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                    class="w-full px-4 py-2 text-white bg-gray-800 border border-gray-700 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Your full name" />
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block mb-1 text-sm font-semibold text-gray-300">Email Address</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-2 text-white bg-gray-800 border border-gray-700  shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="you@example.com" />
            </div>

            <!-- Password Tips -->
            <div class="ps-3 space-y-2 text-sm bg-blue-900 border border-blue-700">
                <p class="font-semibold text-blue-200">🔐 Password Tips : Minimum 5 characters</p>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block mb-1 text-sm font-semibold text-gray-300">Password</label>
                <div class="relative">
                    <input id="password" name="password" type="password" required
                        class="w-full px-4 py-2 pr-10 text-white bg-gray-800 border border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter password" />
                    <button type="button"
                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-white focus:outline-none toggle-password"
                        data-target="password">
                        <i class="fas fa-eye" id="eye-password"></i>
                    </button>
                </div>
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="confirmPassword" class="block mb-1 text-sm font-semibold text-gray-300">Confirm
                    Password</label>
                <div class="relative">
                    <input id="confirmPassword" name="confirmPassword" type="password" required
                        class="w-full px-4 py-2 pr-10 text-white bg-gray-800 border border-gray-700 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Confirm password" />
                    <button type="button"
                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-white focus:outline-none toggle-password"
                        data-target="confirmPassword">
                        <i class="fas fa-eye" id="eye-confirmPassword"></i>
                    </button>
                </div>
            </div>

            <!-- Already Registered -->
            <div class="text-sm text-gray-400">
                Already have an account?
                <a href="{{ route('login') }}" class="text-blue-400 underline hover:text-blue-300">Login here</a>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full px-5 py-3 mt-4 text-sm font-semibold text-white transition duration-300 bg-green-600 hover:bg-green-700 hover:shadow-md">
                Create Account
            </button>
        </form>
    </x-auth-card>

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Show/Hide Password Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-password').forEach(button => {
                const inputId = button.getAttribute('data-target');
                const input = document.getElementById(inputId);
                const icon = button.querySelector('i');

                button.addEventListener('click', () => {
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                });
            });
        });
    </script>
</x-guest-layout>
