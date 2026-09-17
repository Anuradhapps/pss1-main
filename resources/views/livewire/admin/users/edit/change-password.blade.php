<div class="h-full">
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden h-full flex flex-col">
        <!-- Header -->
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col gap-2 bg-slate-50 dark:bg-slate-900/50">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <i class="fas fa-lock text-primary"></i> Change Password
            </h3>
            <p class="text-xs text-slate-500 dark:text-slate-400">
                Secure your account with a strong, unique password. We recommend using a password manager.
            </p>
        </div>

        <div class="flex-1 flex flex-col">
            @if ($message)
                <div class="m-6 mb-0 p-4 bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 rounded-xl flex items-center shadow-sm">
                    <i class="fas fa-check-circle mr-3 text-lg"></i>
                    <span class="text-sm font-medium">{{ $message }}</span>
                </div>
            @endif

            <form wire:submit.prevent="update" class="p-6 space-y-6 flex-1 flex flex-col">
                
                <div class="space-y-6 flex-1">
                    <!-- Password Requirements Box -->
                    <div class="p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/60 rounded-xl">
                        <h4 class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-3 flex items-center uppercase tracking-wider">
                            <i class="fas fa-shield-alt mr-2 text-primary"></i> Password Requirements
                        </h4>
                        <ul class="text-sm text-slate-600 dark:text-slate-400 space-y-2 grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-primary text-[10px]"></i> Minimum 8 characters
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-primary text-[10px]"></i> At least one uppercase
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-primary text-[10px]"></i> At least one lowercase
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-primary text-[10px]"></i> At least one number
                            </li>
                        </ul>
                    </div>

                    <!-- New Password Input -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 flex items-center gap-2">
                            New Password
                        </label>
                        <div class="relative">
                            <i class="fas fa-key absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="password" wire:model="newPassword"
                                class="w-full pl-10 pr-10 py-2.5 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-900 dark:text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                required autocomplete="new-password" placeholder="Enter new password">
                            <i class="fas fa-eye-slash absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 cursor-pointer transition-colors text-sm"></i>
                        </div>
                        @error('newPassword')
                            <p class="mt-1.5 text-xs text-rose-500 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Confirm Password Input -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 flex items-center gap-2">
                            Confirm Password
                        </label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="password" wire:model="confirmPassword"
                                class="w-full pl-10 pr-10 py-2.5 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-900 dark:text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                required autocomplete="new-password" placeholder="Confirm new password">
                            <i class="fas fa-eye-slash absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 cursor-pointer transition-colors text-sm"></i>
                        </div>
                        @error('confirmPassword')
                            <p class="mt-1.5 text-xs text-rose-500 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-6 border-t border-slate-200 dark:border-slate-800 mt-auto">
                    <button type="submit"
                        class="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-primary hover:bg-emerald-600 rounded-xl shadow-sm hover:shadow-primary/30 transition-all">
                        <i class="fas fa-key"></i> Update Password
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
</div>
