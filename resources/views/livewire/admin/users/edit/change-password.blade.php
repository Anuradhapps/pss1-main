<div class="font-sans">
    <div class="mb-8">
        <h3 class="text-2xl font-bold text-white mb-2">
            <i class="fas fa-lock mr-2"></i>Change Password
        </h3>
        <p class="text-gray-400 max-w-lg">
            Secure your account with a strong, unique password. We recommend using a password manager.
        </p>
    </div>

    <div class="w-full max-w-md bg-gray-800 border border-gray-700 shadow-xl">
        @if ($message)
            <div class="p-4 bg-green-800/50 border-b border-green-700 text-green-100 flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ $message }}
            </div>
        @endif

        <form wire:submit.prevent="update" class="p-6">
            <div class="mb-6 p-4 bg-gray-700/50 border border-gray-600">
                <h4 class="font-medium text-white mb-3 flex items-center">
                    <i class="fas fa-shield-alt mr-2 text-emerald-400"></i>
                    Password Requirements
                </h4>
                <ul class="text-gray-300 space-y-2">
                    <li class="flex items-center">
                        <i class="fas fa-check-circle text-xs text-emerald-400 mr-2"></i>
                        Minimum 8 characters
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check-circle text-xs text-emerald-400 mr-2"></i>
                        At least one uppercase letter
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check-circle text-xs text-emerald-400 mr-2"></i>
                        At least one lowercase letter
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check-circle text-xs text-emerald-400 mr-2"></i>
                        At least one number
                    </li>
                </ul>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="text-sm font-medium text-gray-300 mb-1 flex items-center">
                        <i class="fas fa-key mr-2 text-gray-400"></i>
                        New Password
                    </label>
                    <div class="relative">
                        <input type="password" wire:model="newPassword"
                            class="w-full px-4 py-2.5 bg-gray-900 text-white border border-gray-700 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/50"
                            required autocomplete="new-password">
                        <i
                            class="fas fa-eye-slash absolute right-3 top-3 text-gray-500 cursor-pointer hover:text-gray-400"></i>
                    </div>
                    @error('newPassword')
                        <p class="mt-1 text-sm text-red-400 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class=" text-sm font-medium text-gray-300 mb-1 flex items-center">
                        <i class="fas fa-key mr-2 text-gray-400"></i>
                        Confirm Password
                    </label>
                    <div class="relative">
                        <input type="password" wire:model="confirmPassword"
                            class="w-full px-4 py-2.5 bg-gray-900 text-white border border-gray-700 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/50"
                            required autocomplete="new-password">
                        <i
                            class="fas fa-eye-slash absolute right-3 top-3 text-gray-500 cursor-pointer hover:text-gray-400"></i>
                    </div>
                    @error('confirmPassword')
                        <p class="mt-1 text-sm text-red-400 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full py-3 font-medium text-white bg-emerald-600 hover:bg-emerald-700 transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i>
                    Update Password
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            document.querySelectorAll('.fa-eye-slash').forEach(icon => {
                icon.addEventListener('click', function() {
                    const input = this.previousElementSibling;
                    if (input.type === 'password') {
                        input.type = 'text';
                        this.classList.replace('fa-eye-slash', 'fa-eye');
                    } else {
                        input.type = 'password';
                        this.classList.replace('fa-eye', 'fa-eye-slash');
                    }
                });
            });
        });
    </script>
@endpush
