<div>

    <div class="card">

        <h3 class="mb-4">Application Settings</h3>

        <x-form wire:submit.prevent="update" method="put">

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                <x-form.input wire:model="siteName" name="siteName" label="Site Name" />

                <fieldset>

                    <div class="mt-1 -space-y-px text-gray-200 bg-gray-500 rounded-md shadow-sm">

                        <div class="relative flex p-4 border border-gray-200 rounded-tl-md rounded-tr-md">
                            <div class="flex items-center h-5">
                                <input wire:model="isForced2Fa" id="isForced2Fa" type="checkbox"
                                    class="w-4 h-4 border-gray-300 cursor-pointer text-light-blue-600 focus:ring-light-blue-500">
                            </div>
                            <label for="isOfficeLoginOnly" class="flex flex-col ml-3 cursor-pointer">
                                <span class="block text-sm font-medium text-gray-300">
                                    Enforce 2Fa
                                </span>
                                <span class="block text-sm text-gray-200">
                                    Force 2 factor authentication for all users on login.
                                    Users can only login at pre-approved IP addresses.
                                </span>
                            </label>
                        </div>

                    </div>
                </fieldset>

            </div>

            <x-button>Update Application Settings</x-button>

        </x-form>

        @include('errors.messages')

    </div>
</div>
