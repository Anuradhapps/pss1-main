<div>
    <x-2col>
        <x-slot name="left">
            <h3 class="mb-6 text-xl font-semibold text-white">Admin Settings</h3>
        </x-slot>
        <x-slot name="right">
            <div class="p-6 bg-gray-800 shadow-lg rounded-xl">

                <x-form wire:submit.prevent="update" method="put" class="space-y-6">

                    <fieldset class="space-y-4">

                        <!-- Office Login Only -->
                        <div class="flex items-start p-4 space-x-3 bg-gray-700 border border-gray-600 rounded-md">
                            <input wire:model="isOfficeLoginOnly" id="isOfficeLoginOnly" type="checkbox"
                                class="w-5 h-5 mt-1 border-gray-400 rounded cursor-pointer text-emerald-500 focus:ring-emerald-400" />
                            <label for="isOfficeLoginOnly" class="flex flex-col cursor-pointer select-none">
                                <span class="text-sm font-medium text-gray-200">Office Login Only</span>
                                <span class="max-w-md text-sm text-gray-400">
                                    When active, the user can only login from pre-approved IP addresses configured in
                                    <a href="{{ route('admin.settings') }}" class="text-emerald-400 hover:underline"
                                        target="_blank" rel="noopener noreferrer">
                                        System Settings
                                    </a>.
                                </span>
                            </label>
                        </div>

                        @if ($user->id !== auth()->id())
                            <!-- Account Active -->
                            <div class="flex items-start p-4 space-x-3 bg-gray-700 border border-gray-600 rounded-md">
                                <input wire:model="isActive" id="isActive" type="checkbox"
                                    class="w-5 h-5 mt-1 border-gray-400 rounded cursor-pointer text-emerald-500 focus:ring-emerald-400" />
                                <label for="isActive" class="flex flex-col cursor-pointer select-none">
                                    <span class="text-sm font-medium text-gray-200">Account Active</span>
                                    <span class="max-w-md text-sm text-gray-400">
                                        Only active users are allowed to login.
                                    </span>
                                </label>
                            </div>
                        @endif

                    </fieldset>

                    <x-button class="w-full py-2 mt-4 transition bg-emerald-600 hover:bg-emerald-700">
                        Update Settings
                    </x-button>

                    @include('errors.success')

                </x-form>
            </div>
        </x-slot>
    </x-2col>
</div>
