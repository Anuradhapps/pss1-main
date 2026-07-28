@section('title', 'Roles')

<div class="dark bg-gray-950 min-h-screen text-gray-100 px-4 py-6 space-y-6">

    <div class="text-center">
        <h1 class="text-3xl font-bold text-white"><i class="fas fa-shield-alt text-indigo-400"></i> Roles</h1>
        <p class="text-sm text-gray-400 mt-1">Manage roles, permissions, and access levels across the system.</p>
    </div>

    <div class="space-y-4">
        <div
            class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between bg-gray-900 p-4 rounded-2xl border border-gray-800 shadow">
            <p class="text-sm text-gray-300">
                By default, only <span class="font-semibold text-white">Admin</span> roles have permissions.
                Additional roles require permission assignments via editing below.
            </p>
            <div>
                <livewire:admin.roles.create />
            </div>
        </div>

        <div class="bg-gray-900 p-4 rounded-2xl border border-gray-800 shadow">
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-form.input type="search" id="roles" name="query" wire:model="query" label="none"
                        placeholder="🔍 Search roles"
                        class="bg-gray-900 text-white border-gray-700 placeholder:text-gray-500">
                        {{ old('query', request('query')) }}
                    </x-form.input>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto bg-gray-900 shadow mt-4 rounded-2xl border border-gray-800">
        <table class="min-w-full divide-y divide-gray-700 text-sm">
            <thead class="bg-gray-800 text-gray-300 text-sm uppercase tracking-wide">
                <tr class="bg-gray-900">
                    <th class="px-4 py-3 text-left">
                        <button type="button" wire:click.prevent="sortBy('name')"
                            class="text-left w-full text-gray-300 hover:text-cyan-300 transition">Name</button>
                    </th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-800">
                @forelse($this->roles() as $role)
                    <tr class="hover:bg-gray-800 bg-gray-700 transition">
                        <td class="px-4 py-3 text-gray-100">{{ $role->label }}</td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap items-center gap-3">
                                <a href="{{ route('admin.settings.roles.edit', ['role' => $role->id]) }}"
                                    class="text-cyan-400 hover:text-cyan-200 font-medium transition">
                                    Edit
                                </a>

                                @if ($role->label !== 'App' && $role->name !== 'admin')
                                    <x-modal>
                                        <x-slot name="trigger">
                                            <button
                                                class="text-red-400 hover:text-red-200 font-medium focus:outline-none focus:ring-2 focus:ring-red-500 rounded transition"
                                                @click="on = true" aria-haspopup="dialog" aria-expanded="false"
                                                aria-controls="modal-title">
                                                Delete
                                            </button>
                                        </x-slot>

                                        <x-slot name="title" class="text-xl font-semibold text-gray-100">
                                            Confirm Delete
                                        </x-slot>

                                        <x-slot name="content">
                                            <p class="text-center text-gray-300">
                                                Are you sure you want to delete role:
                                                <span class="font-semibold text-white">{{ $role->name }}</span>?
                                            </p>
                                        </x-slot>

                                        <x-slot name="footer" class="flex flex-wrap justify-center gap-3">
                                            <button type="button"
                                                class="px-4 py-2 rounded bg-gray-800 hover:bg-gray-700 text-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-gray-500 transition"
                                                @click="on = false">
                                                Cancel
                                            </button>
                                            <button type="button"
                                                class="px-4 py-2 rounded bg-red-600 hover:bg-red-500 text-white font-semibold focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-red-600 transition"
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
                        <td colspan="2" class="px-4 py-6 text-center text-gray-500">No roles found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $this->roles()->links('vendor.pagination.tailwind') }}
    </div>
</div>
