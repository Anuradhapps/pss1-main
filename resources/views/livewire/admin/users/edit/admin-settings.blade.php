<div>
    <x-2col>
        <x-slot name="left">
            <h3>Admin Settings</h3>
        </x-slot>
        <x-slot name="right">
            <div class="card">

                <x-form wire:submit.prevent="update" method="put">

                    <fieldset>

                        <div class="mt-1 -space-y-px text-gray-200 bg-gray-500 rounded-md shadow-sm">

                            <div class="relative flex p-4 border border-gray-200 rounded-tl-md rounded-tr-md">
                                <div class="flex items-center h-5">
                                    <input wire:model="isOfficeLoginOnly" id="isOfficeLoginOnly" type="checkbox"
                                        class="w-4 h-4 border-gray-300 cursor-pointer text-light-blue-600 focus:ring-light-blue-500"
                                        checked="">
                                </div>
                                <label for="isOfficeLoginOnly" class="flex flex-col ml-3 cursor-pointer">
                                    <span class="block text-sm font-medium text-gray-300">
                                        Office Login Only
                                    </span>
                                    <span class="block text-sm text-gray-200">
                                        When active user can only login at pre-approved IP addresses set in <a
                                            href="{{ route('admin.settings') }}">System Settings</a>.
                                    </span>
                                </label>
                            </div>

                            @if ($user->id !== auth()->id())
                                <div class="relative flex p-4 border border-gray-200 rounded-tl-md rounded-tr-md">
                                    <div class="flex items-center h-5">
                                        <input wire:model="isActive" id="isActive" type="checkbox"
                                            class="w-4 h-4 border-gray-300 cursor-pointer text-light-blue-600 focus:ring-light-blue-500"
                                            checked="">
                                    </div>
                                    <label for="isActive" class="flex flex-col ml-3 cursor-pointer">
                                        <span class="block text-sm font-medium text-gray-300">
                                            Account Active
                                        </span>
                                        <span class="block text-sm text-gray-200">
                                            Only active users can login.
                                        </span>
                                    </label>
                                </div>
                            @endif

                        </div>
                    </fieldset>

                    <x-button class="mt-5">Update Settings</x-button>

                    @include('errors.success')

                </x-form>
            </div>

        </x-slot>
    </x-2col>
</div>
