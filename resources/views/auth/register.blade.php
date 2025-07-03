<x-guest-layout>
    @section('title', 'Register')

    <x-auth-card class="text-white bg-gray-900 shadow-lg">
        <h1 class="mb-6 text-2xl font-extrabold text-center text-white">Create Your Account</h1>

        @include('errors.success')

        <x-form action="{{ route('register') }}" class="space-y-6">

            <!-- Name -->
            <x-form.input type="text" label="Full Name" name="name" required
                class="text-white bg-gray-800 border-gray-600">
                {{ old('name') }}
            </x-form.input>

            <!-- Email -->
            <x-form.input type="email" label="Email Address" name="email" required
                class="text-white bg-gray-800 border-gray-600">
                {{ old('email') }}
            </x-form.input>

            <!-- Password Helper Box -->
            <div class="p-4 space-y-2 text-sm bg-blue-900 border border-blue-700 rounded-lg">
                <p class="font-semibold text-blue-200">🔐 Password Tips:</p>
                <ul class="text-blue-300 list-disc list-inside">
                    <li>Minimum 8 characters</li>
                    <li>At least one lowercase & uppercase letter</li>
                    <li>Include at least one number</li>
                </ul>
                <p class="mt-2">Use <a href="https://1password.com/password-generator/" target="_blank"
                        class="text-blue-400 underline hover:text-blue-300">1Password Generator</a> for strong
                    passwords.</p>
            </div>

            <!-- Password Fields -->
            <x-form.input type="password" label="Password" name="password" required />
            <x-form.input type="password" label="Confirm Password" name="confirmPassword" required />

            <!-- Already Registered? -->
            <div class="text-sm text-gray-400">
                Already have an account?
                <a href="{{ route('login') }}" class="text-blue-400 underline hover:text-blue-300">Login here</a>
            </div>

            <!-- Submit -->
            <x-button class="w-full bg-green-600 hover:bg-green-700">Create Account</x-button>
        </x-form>
    </x-auth-card>

    <!-- Optional: Show/Hide Password Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[type="password"]').forEach((input, i) => {
                const wrapper = input.closest('.relative');
                const id = input.id || `password_${i}`;
                input.id = id;

                const toggleBtn = document.createElement('button');
                toggleBtn.setAttribute('type', 'button');
                toggleBtn.className =
                    'absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-white';
                toggleBtn.innerHTML = `<i class="fas fa-eye" id="eye-${id}"></i>`;

                toggleBtn.addEventListener('click', () => {
                    const icon = toggleBtn.querySelector('i');
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });

                if (wrapper && wrapper.classList.contains('relative')) {
                    wrapper.appendChild(toggleBtn);
                }
            });
        });
    </script>
</x-guest-layout>
