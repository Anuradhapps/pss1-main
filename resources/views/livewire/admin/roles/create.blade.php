<div>
    @if (can('add_role'))
        <x-modal>
            <x-slot name="trigger">
                <button
                    class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 disabled:cursor-not-allowed disabled:opacity-50"
                    @click="on = true">
                    <i class="fas fa-plus text-xs"></i>
                    Add Role
                </button>
            </x-slot>

            <x-slot name="title">Add Role</x-slot>

            <x-slot name="content">
                <x-form.input wire:model="role" label="Role" name="role" required>
                    {{ old('role') }}
                </x-form.input>
            </x-slot>

            <x-slot name="footer" class="flex justify-end gap-3">
                <button type="button"
                    class="rounded-xl bg-slate-200 px-4 py-2 font-semibold text-slate-700 transition hover:bg-slate-300 dark:bg-slate-700 dark:text-slate-200 dark:hover:bg-slate-600"
                    @click="on = false">
                    Cancel
                </button>
                <button type="button" wire:click="store"
                    class="rounded-xl bg-indigo-600 px-4 py-2 font-semibold text-white transition hover:bg-indigo-500">
                    Create Role
                </button>
            </x-slot>
        </x-modal>
    @endif
</div>
