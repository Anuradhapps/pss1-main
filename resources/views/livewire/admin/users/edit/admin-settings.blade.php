<div>
    <x-2col>
        <x-slot name="left">
            <h3 class="mb-6 text-xl font-semibold text-slate-900 dark:text-white">Admin Settings</h3>
        </x-slot>
        <x-slot name="right">
            <div
                class="rounded-xl border border-slate-200 bg-white p-6 shadow-lg transition-colors dark:border-slate-700 dark:bg-slate-800">

                <x-form wire:submit.prevent="update" method="put" class="space-y-6">

                    <fieldset class="space-y-4">

                        <div
                            class="flex items-start space-x-3 rounded-md border border-slate-200 bg-slate-50 p-4 transition-colors dark:border-slate-600 dark:bg-slate-700/80">
                            <input wire:model="isOfficeLoginOnly" id="isOfficeLoginOnly" type="checkbox"
                                class="mt-1 h-5 w-5 cursor-pointer rounded border-slate-400 text-emerald-500 focus:ring-emerald-400" />
                            <label for="isOfficeLoginOnly" class="flex flex-col cursor-pointer select-none">
                                <span class="text-sm font-medium text-slate-800 dark:text-slate-100">Office Login
                                    Only</span>
                                <span class="max-w-md text-sm text-slate-600 dark:text-slate-400">
                                    When active, the user can only login from pre-approved IP addresses configured in
                                    <a href="{{ route('admin.settings') }}" class="text-emerald-500 hover:underline"
                                        target="_blank" rel="noopener noreferrer">
                                        System Settings
                                    </a>.
                                </span>
                            </label>
                        </div>

                        @if ($user->id !== auth()->id())
                            <div
                                class="flex items-start space-x-3 rounded-md border border-slate-200 bg-slate-50 p-4 transition-colors dark:border-slate-600 dark:bg-slate-700/80">
                                <input wire:model="isActive" id="isActive" type="checkbox"
                                    class="mt-1 h-5 w-5 cursor-pointer rounded border-slate-400 text-emerald-500 focus:ring-emerald-400" />
                                <label for="isActive" class="flex flex-col cursor-pointer select-none">
                                    <span class="text-sm font-medium text-slate-800 dark:text-slate-100">Account
                                        Active</span>
                                    <span class="max-w-md text-sm text-slate-600 dark:text-slate-400">
                                        Only active users are allowed to login.
                                    </span>
                                </label>
                            </div>
                        @endif

                    </fieldset>

                    <x-button class="mt-4 w-full bg-emerald-600 py-2 transition hover:bg-emerald-700">
                        Update Settings
                    </x-button>

                    @include('errors.success')

                </x-form>
            </div>
        </x-slot>
    </x-2col>
</div>
