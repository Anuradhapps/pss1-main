<div>
    <div class="max-w-lg p-6 mx-auto bg-gray-800 shadow-md border border-gray-700">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-user-cog text-emerald-400 mr-2"></i> Account Settings
            </h2>
            <div class="flex items-center space-x-1 text-sm text-gray-400 select-none">
                <span class="font-bold text-emerald-400">*</span>
                <span>= required</span>
            </div>
        </div>

        <!-- Form -->
        <x-form wire:submit.prevent="update" method="put" class="space-y-5 bg-gray-900 p-4 border border-gray-700">

            <!-- Name -->
            <x-form.input wire:model.defer="name" label='Name *' name="name" required
                class="text-gray-100 bg-gray-800 border border-gray-700 focus:border-emerald-500 focus:ring-emerald-500"
                label-class="text-gray-300" />

            <!-- Email -->
            <x-form.input wire:model.defer="email" label='Email *' name="email" type="email" required
                class="text-gray-100 bg-gray-800 border border-gray-700 focus:border-emerald-500 focus:ring-emerald-500"
                label-class="text-gray-300" />

            <!-- Image Upload -->
            <x-form.input wire:model="image" label='Upload Image' name="image" type="file"
                class="text-gray-100 bg-gray-800 border border-gray-700 focus:border-emerald-500 focus:ring-emerald-500 file:mr-4 file:py-1 file:px-3 file:border-0 file:bg-emerald-600 file:text-white file:hover:bg-emerald-700"
                label-class="text-gray-300" />

            <!-- Image Preview -->
            <div>
                @if ($image)
                    <p class="mb-2 text-sm text-gray-400">Photo Preview:</p>
                    <img src="{{ $image->temporaryUrl() }}" alt="Photo Preview"
                        class="object-cover w-24 h-24 border border-gray-600 shadow" />
                @elseif(storage_exists($user->image))
                    <p class="mb-2 text-sm text-gray-400">Current Photo:</p>
                    <img src="{{ storage_url($user->image) }}" alt="{{ $user->name }}"
                        class="object-cover w-24 h-24 border border-gray-600 shadow" />
                @endif
            </div>

            <!-- Submit Button -->
            <div>
                <x-button
                    class="w-full py-2 text-white font-semibold bg-emerald-600 hover:bg-emerald-700 border border-emerald-500 shadow-none">
                    <i class="fas fa-save mr-2"></i> Update Profile
                </x-button>
            </div>

            <!-- Error Messages -->
            @include('errors.messages')

        </x-form>
    </div>
</div>
