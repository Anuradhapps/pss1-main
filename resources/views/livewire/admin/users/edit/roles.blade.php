<div>
    <x-2col>
        <x-slot name="left">
            <h3 class="mb-3 text-2xl font-semibold text-white">Roles</h3>
            <p class="max-w-md leading-relaxed text-gray-400">
                Turn roles on and off. Disabled roles will disable the user's permissions.
            </p>
        </x-slot>

        <x-slot name="right">
            <div class="w-full max-w-md p-6 bg-gray-800 shadow-lg rounded-xl">

                <x-form wire:submit.prevent="update" method="put" class="space-y-5">

                    <div class="space-y-3 overflow-y-auto max-h-64">
                        @foreach ($roles as $role)
                            <label
                                class="flex items-center space-x-3 text-gray-300 cursor-pointer select-none hover:text-emerald-400">
                                <input type="checkbox" wire:model="roleSelections" value="{{ $role->id }}"
                                    class="w-5 h-5 bg-gray-700 border-gray-600 rounded text-emerald-500 focus:ring-emerald-400" />
                                <span class="text-sm font-medium">{{ $role->label }}</span>
                            </label>
                        @endforeach
                    </div>

                    <x-button
                        class="w-full py-2 font-semibold rounded-lg shadow-md bg-emerald-600 hover:bg-emerald-700">
                        Update Roles
                    </x-button>

                    @include('errors.messages')

                </x-form>
            </div>
        </x-slot>
    </x-2col>
</div>
