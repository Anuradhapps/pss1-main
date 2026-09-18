<x-guest-layout>
    @section('title', 'Register')

    <x-auth-card>
        <!-- Header -->
        <div class="mb-4 text-center">
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Create an account</h1>
            <p class="pt-0 text-sm text-slate-600 dark:text-slate-400">
                Please fill in your details to register for a new account.
            </p>
        </div>

        {{-- ✅ Show All Validation Errors (Top Alert Box) --}}
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Please fix the following errors
                        </h3>
                        <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-5" novalidate>
            @csrf
            @if (config('services.recaptcha.site_key'))
                <input type="hidden" name="recaptcha_token" id="recaptcha_token">
            @endif
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Full
                    Name</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-slate-400 group-focus-within:text-primary transition-colors"></i>
                    </div>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                        class="block w-full pl-10 pr-3 py-2.5 text-sm bg-slate-50 dark:bg-slate-800/50 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition duration-300"
                        placeholder="John Doe" />
                </div>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Email
                    address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-slate-400 group-focus-within:text-primary transition-colors"></i>
                    </div>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="block w-full pl-10 pr-3 py-2.5 text-sm bg-slate-50 dark:bg-slate-800/50 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition duration-300"
                        placeholder="you@example.com" />
                </div>
            </div>

            <!-- Password Tips -->
            <div
                class="p-3 rounded-lg bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 flex items-start">
                <i class="fas fa-info-circle mt-0.5 text-blue-600 dark:text-blue-400 mr-2"></i>
                <p class="text-xs font-medium text-blue-800 dark:text-blue-200">Password must be at least 5 characters
                    long.</p>
            </div>

            <!-- Password -->
            <div>
                <label for="password"
                    class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-slate-400 group-focus-within:text-primary transition-colors"></i>
                    </div>
                    <input id="password" name="password" type="password" required
                        class="block w-full pl-10 pr-10 py-2.5 text-sm bg-slate-50 dark:bg-slate-800/50 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition duration-300"
                        placeholder="Create a password" />
                    <button type="button"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors focus:outline-none toggle-password"
                        data-target="password">
                        <i class="fas fa-eye" id="eye-password"></i>
                    </button>
                </div>
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="confirmPassword"
                    class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Confirm Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i
                            class="fas fa-shield-alt text-slate-400 group-focus-within:text-primary transition-colors"></i>
                    </div>
                    <input id="confirmPassword" name="confirmPassword" type="password" required
                        class="block w-full pl-10 pr-10 py-2.5 text-sm bg-slate-50 dark:bg-slate-800/50 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition duration-300"
                        placeholder="Confirm your password" />
                    <button type="button"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors focus:outline-none toggle-password"
                        data-target="confirmPassword">
                        <i class="fas fa-eye" id="eye-confirmPassword"></i>
                    </button>
                </div>
            </div>

            <!-- Submit & Login -->
            <div class="space-y-4 pt-2">
                <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-base font-semibold text-white bg-primary hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary dark:focus:ring-offset-slate-900 transition-all duration-300">
                    Create Account
                </button>

                <div class="relative py-2">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200 dark:border-slate-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white dark:bg-slate-900 text-slate-500 dark:text-slate-400">Already have an
                            account?</span>
                    </div>
                </div>

                <a href="{{ route('login') }}"
                    class="w-full flex justify-center py-3 px-4 border-2 border-slate-300 dark:border-slate-600 rounded-xl shadow-sm text-base font-bold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 dark:focus:ring-offset-slate-900 transition-all duration-300">
                    Back to Sign In
                </a>
            </div>
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
    @if (config('services.recaptcha.site_key'))
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>

        <script>
            grecaptcha.ready(function() {
                grecaptcha.execute(
                    '{{ config('services.recaptcha.site_key') }}', {
                        action: 'register'
                    }
                ).then(function(token) {
                    document.getElementById('recaptcha_token').value = token;
                });
            });
        </script>
    @endif
</x-guest-layout>
