<div>
    <div class="max-w-lg p-6 mx-auto bg-gray-800 shadow-lg rounded-xl">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-white">Account Settings</h2>
            <div class="flex items-center space-x-1 text-sm text-gray-400 select-none">
                <span class="font-bold text-emerald-400">*</span>
                <span>= required</span>
            </div>
        </div>

        <x-form wire:submit.prevent="update" method="put" class="p-2 space-y-5 bg-gray-500 rounded-lg">

            <x-form.input wire:model.defer="name" label="Name *" name="name" required
                class="text-gray-200 bg-gray-900 border-gray-700 focus:border-emerald-500 focus:ring-emerald-400"
                label-class="text-gray-300" />

            <x-form.input wire:model.defer="email" label="Email *" name="email" type="email" required
                class="text-gray-200 bg-gray-900 border-gray-700 focus:border-emerald-500 focus:ring-emerald-400"
                label-class="text-gray-300" />

            <x-form.input wire:model="image" label="Image" name="image" type="file"
                class="text-gray-200 bg-gray-900 border-gray-700 focus:border-emerald-500 focus:ring-emerald-400"
                label-class="text-gray-300" />

            <div class="mt-4">
                @if ($image)
                    <p class="mb-2 text-gray-300">Photo Preview:</p>
                    <img src="{{ $image->temporaryUrl() }}" alt="Photo Preview"
                        class="object-cover w-24 h-24 rounded-md shadow-md" />
                @elseif(storage_exists($user->image))
                    <img src="{{ storage_url($user->image) }}" alt="{{ $user->name }}"
                        class="object-cover w-24 h-24 rounded-md shadow-md" />
                @endif
            </div>

            <div>
                <x-button class="w-full py-2 font-semibold rounded-lg shadow-md bg-emerald-600 hover:bg-emerald-700">
                    Update Profile
                </x-button>
            </div>

            @include('errors.messages')

        </x-form>

    </div>
</div>
