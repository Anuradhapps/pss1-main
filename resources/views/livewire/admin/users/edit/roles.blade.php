<div>
    <x-2col>
        <x-slot name="left">
            <h3 class="mb-3 text-2xl font-semibold text-slate-900 dark:text-white">Roles</h3>
            <p class="max-w-md leading-relaxed text-slate-600 dark:text-slate-400">
                Turn roles on and off. Disabled roles will disable the user's permissions.
            </p>
        </x-slot>

        <x-slot name="right">
            <div
                class="w-full max-w-md rounded-xl border border-slate-200 bg-white p-6 shadow-lg transition-colors dark:border-slate-700 dark:bg-slate-800">

                <x-form wire:submit.prevent="update" method="put" class="space-y-5">

                    <div class="max-h-64 space-y-3 overflow-y-auto">
                        @foreach ($roles as $role)
                            <label
                                class="flex cursor-pointer items-center space-x-3 text-slate-700 transition-colors hover:text-emerald-500 dark:text-slate-300 dark:hover:text-emerald-400 select-none">
                                <input type="checkbox" wire:model="roleSelections" value="{{ $role->id }}"
                                    class="h-5 w-5 rounded border-slate-300 bg-white text-emerald-500 focus:ring-emerald-400 dark:border-slate-600 dark:bg-slate-700" />
                                <span class="text-sm font-medium">{{ $role->label }}</span>
                            </label>
                        @endforeach
                    </div>

                    <x-button
                        class="w-full rounded-lg bg-emerald-600 py-2 font-semibold shadow-md hover:bg-emerald-700">
                        Update Roles
                    </x-button>

                    @include('errors.messages')

                </x-form>
            </div>
        </x-slot>
    </x-2col>
</div>
