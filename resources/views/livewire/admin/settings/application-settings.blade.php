<!-- Form -->
<x-form wire:submit.prevent="update" method="put" class="space-y-6">

    <!-- Grid Inputs -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

        <!-- Site Name -->
        <x-form.input wire:model="siteName" name="siteName" label="Site Name"
            class="bg-gray-800 border-gray-700 text-white" />

        <!-- Enforce 2FA Toggle -->
        {{-- <fieldset class="col-span-1">
                    <div class="bg-gray-800 border border-gray-700 rounded-md p-4 space-y-2">
                        <div class="flex items-start gap-3">
                            <input wire:model="isForced2Fa" id="isForced2Fa" type="checkbox"
                                class="mt-1 h-5 w-5 text-indigo-500 bg-gray-900 border-gray-600 focus:ring-indigo-400 rounded">
                            <label for="isForced2Fa" class="cursor-pointer select-none">
                                <span class="block text-sm font-semibold text-white">Enforce 2FA</span>
                                <span class="text-sm text-gray-400">
                                    Require all users to use two-factor authentication.<br>
                                    Only allow login from pre-approved IP addresses.
                                </span>
                            </label>
                        </div>
                    </div>
                </fieldset> --}}

    </div>

    <!-- Submit Button -->
    <div>
        <x-button class="bg-indigo-600 hover:bg-indigo-500 text-white">
            Update Application Settings
        </x-button>
    </div>

</x-form>

<!-- Error Messages -->
@include('errors.messages')
