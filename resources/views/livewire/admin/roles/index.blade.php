@section('title', 'Roles')

<div class="space-y-6">
    <div class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-colors dark:border-slate-800 dark:bg-slate-900 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300">
                <i class="fas fa-shield-alt text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Roles</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Manage access groups and permissions.</p>
            </div>
        </div>
        <livewire:admin.roles.create />
    </div>

    <div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900 shadow-sm dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-100">
        By default, only <b>Admin</b> roles have permissions. Additional roles will need permissions assigned by editing below.
    </div>

    <div class="max-w-4xl">
        <x-form.input type="search" id="roles" name="query" wire:model="query" label="none" placeholder="Search roles" />
    </div>

    @php($roles = $this->roles())
    @if ($roles->isEmpty())
        <x-data.empty-state icon="fas fa-user-shield" title="No Roles Found" description="Try a different search term or create a new role." />
    @else
        <x-data.table>
            <x-slot name="header">
                <th scope="col" class="px-6 py-4 font-bold"><button type="button" wire:click.prevent="sortBy('name')" class="hover:text-indigo-600 dark:hover:text-indigo-400">Name</button></th>
                <th scope="col" class="px-6 py-4 font-bold text-right">Actions</th>
            </x-slot>

            @foreach($roles as $role)
                <tr class="transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/50">
                    <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">{{ $role->label }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('admin.settings.roles.edit', ['role' => $role->id]) }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Edit</a>
                            @if ($role->label !== 'App' && $role->name !== 'admin')
                                <x-modal>
                                    <x-slot name="trigger">
                                        <button class="font-medium text-rose-600 hover:text-rose-500 dark:text-rose-400" @click="on = true" aria-haspopup="dialog" aria-expanded="false">Delete</button>
                                    </x-slot>

                                    <x-slot name="title">Confirm Delete</x-slot>

                                    <x-slot name="content">
                                        <p class="text-center text-slate-700 dark:text-slate-200">Are you sure you want to delete role: <b>{{ $role->name }}</b>?</p>
                                    </x-slot>

                                    <x-slot name="footer" class="flex justify-center gap-4">
                                        <button type="button" class="rounded-xl bg-slate-200 px-4 py-2 font-semibold text-slate-700 transition hover:bg-slate-300 dark:bg-slate-700 dark:text-slate-200 dark:hover:bg-slate-600" @click="on = false">Cancel</button>
                                        <button type="button" class="rounded-xl bg-rose-600 px-4 py-2 font-semibold text-white transition hover:bg-rose-500" wire:click="deleteRole('{{ $role->id }}')" @click="on = false">Delete Role</button>
                                    </x-slot>
                                </x-modal>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach

            <x-slot name="footer">
                <div class="w-full">{{ $roles->links() }}</div>
            </x-slot>
        </x-data.table>
    @endif
</div>
