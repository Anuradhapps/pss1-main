<div class="dark">
    @if (can('add_role'))
        <x-modal>
            <x-slot name="trigger">
                <button
                    class="bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-2 focus:ring-offset-2
                           text-white font-semibold px-4 py-2 rounded-md shadow-md transition
                           disabled:opacity-50 disabled:cursor-not-allowed"
                    @click="on = true">
                    + Add Role
                </button>
            </x-slot>

            <x-slot name="title" class="text-xl font-semibold text-gray-100 border-b border-gray-700 pb-3">
                Add Role
            </x-slot>

            <x-slot name="content" class="pt-4 pb-6">
                <x-form.input wire:model="role" label="Role" name="role" required
                    class="bg-gray-800 text-gray-200 border-gray-700 focus:ring-indigo-500 focus:border-indigo-500">
                    {{ old('role') }}
                </x-form.input>
            </x-slot>

            <x-slot name="footer" class="flex justify-end space-x-3 pt-4 border-t border-gray-700">
                <button type="button"
                    class="px-4 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-gray-300 transition"
                    @click="on = false">
                    Cancel
                </button>
                <button type="button" wire:click="store"
                    class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white font-semibold transition">
                    Create Role
                </button>
            </x-slot>
        </x-modal>
    @endif
</div>
