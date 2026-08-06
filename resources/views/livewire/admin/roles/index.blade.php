@section('title', 'Roles')

<div
    class="min-h-screen bg-slate-50 px-4 py-6 text-slate-800 transition-colors duration-300 dark:bg-slate-950 dark:text-slate-100 space-y-6">

    <div class="text-center">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white"><i class="fas fa-shield-alt text-indigo-400"></i>
            Roles</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Manage roles, permissions, and access levels across
            the system.</p>
    </div>

    <div class="space-y-4">
        <div
            class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between dark:border-slate-800 dark:bg-slate-900">
            <p class="text-sm text-slate-600 dark:text-slate-300">
                By default, only <span class="font-semibold text-slate-900 dark:text-white">Admin</span> roles have
                permissions.
                Additional roles require permission assignments via editing below.
            </p>
            <div>
                <livewire:admin.roles.create />
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-form.input type="search" id="roles" name="query" wire:model="query" label="none"
                        placeholder="🔍 Search roles"
                        class="border-slate-300 bg-white text-slate-900 placeholder:text-slate-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-500">
                        {{ old('query', request('query')) }}
                    </x-form.input>
                </div>
            </div>
        </div>
    </div>

    <div
        class="mt-4 overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-700">
            <thead
                class="bg-slate-50 text-sm uppercase tracking-wide text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                <tr>
                    <th class="px-4 py-3 text-left">
                        <button type="button" wire:click.prevent="sortBy('name')"
                            class="w-full text-left text-slate-700 transition hover:text-cyan-500 dark:text-slate-300">Name</button>
                    </th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 text-sm dark:divide-slate-700">
                @forelse($this->roles() as $role)
                    <tr class="bg-white transition hover:bg-slate-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                        <td class="px-4 py-3 text-slate-800 dark:text-slate-100">{{ $role->label }}</td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap items-center gap-3">
                                <a href="{{ route('admin.settings.roles.edit', ['role' => $role->id]) }}"
                                    class="font-medium text-cyan-500 transition hover:text-cyan-400">
                                    Edit
                                </a>

                                @if ($role->label !== 'App' && $role->name !== 'admin')
                                    <x-modal>
                                        <x-slot name="trigger">
                                            <button
                                                class="rounded font-medium text-red-500 transition hover:text-red-400 focus:outline-none focus:ring-2 focus:ring-red-500"
                                                @click="on = true" aria-haspopup="dialog" aria-expanded="false"
                                                aria-controls="modal-title">
                                                Delete
                                            </button>
                                        </x-slot>

                                        <x-slot name="title"
                                            class="text-xl font-semibold text-slate-900 dark:text-slate-100">
                                            Confirm Delete
                                        </x-slot>

                                        <x-slot name="content">
                                            <p class="text-center text-slate-700 dark:text-slate-300">
                                                Are you sure you want to delete role:
                                                <span
                                                    class="font-semibold text-slate-900 dark:text-white">{{ $role->name }}</span>?
                                            </p>
                                        </x-slot>

                                        <x-slot name="footer" class="flex flex-wrap justify-center gap-3">
                                            <button type="button"
                                                class="rounded bg-slate-100 px-4 py-2 text-slate-700 transition hover:bg-slate-200 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-slate-500 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700"
                                                @click="on = false">
                                                Cancel
                                            </button>
                                            <button type="button"
                                                class="rounded bg-red-600 px-4 py-2 font-semibold text-white transition hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-red-600"
                                                wire:click="deleteRole('{{ $role->id }}')" @click="on = false">
                                                Delete Role
                                            </button>
                                        </x-slot>
                                    </x-modal>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-4 py-6 text-center text-slate-500 dark:text-slate-400">No roles
                            found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $this->roles()->links('vendor.pagination.tailwind') }}
    </div>
</div>
