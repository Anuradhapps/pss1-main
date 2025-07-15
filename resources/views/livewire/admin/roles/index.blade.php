@section('title', 'Roles')

<div class="dark bg-gray-950 min-h-screen text-gray-100 p-6 space-y-6 max-w-7xl mx-auto">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        <h1 class="text-3xl font-bold text-white">🛡️ Roles</h1>
        <livewire:admin.roles.create />
    </div>

    <!-- Info banner -->
    <div class="bg-indigo-900 text-indigo-200 px-4 py-3 rounded-md shadow-sm max-w-4xl">
        By default, only <b>Admin</b> roles have permissions. Additional roles will need permissions assigned by editing
        below.
    </div>

    <!-- Search -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 max-w-4xl">
        <div class="md:col-span-2">
            <x-form.input type="search" id="roles" name="query" wire:model="query" label="none"
                placeholder="🔍 Search Roles" class="bg-gray-900 text-white border-gray-700">
                {{ old('query', request('query')) }}
            </x-form.input>
        </div>
    </div>

    <!-- Roles Table -->
    <div class="overflow-x-auto rounded-lg bg-gray-900 shadow max-w-4xl">
        <table class="min-w-full divide-y divide-gray-700 text-sm">
            <thead class="bg-gray-800 text-gray-300 uppercase tracking-wide">
                <tr>
                    <th class="px-6 py-3 text-left cursor-pointer select-none hover:text-indigo-400"
                        wire:click.prevent="sortBy('name')">Name</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse($this->roles() as $role)
                    <tr class="hover:bg-gray-700 transition">
                        <td class="px-6 py-4">{{ $role->label }}</td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-4 items-center">

                                <a href="{{ route('admin.settings.roles.edit', ['role' => $role->id]) }}"
                                    class="text-indigo-400 hover:underline font-medium">Edit</a>
                                @if ($role->label !== 'App' && $role->name !== 'admin')
                                    <x-modal>
                                        <x-slot name="trigger">
                                            <button
                                                class="text-red-500 hover:underline font-medium focus:outline-none focus:ring-2 focus:ring-red-500 rounded"
                                                @click="on = true" aria-haspopup="dialog" aria-expanded="false"
                                                aria-controls="modal-title">
                                                Delete
                                            </button>
                                        </x-slot>

                                        <x-slot name="title">Confirm Delete</x-slot>

                                        <x-slot name="content">
                                            <p class="text-center text-gray-800 dark:text-gray-200">
                                                Are you sure you want to delete role: <b>{{ $role->name }}</b>?
                                            </p>
                                        </x-slot>

                                        <x-slot name="footer" class="flex justify-center space-x-4">
                                            <button type="button"
                                                class="px-4 py-2 rounded bg-gray-700 hover:bg-gray-600 text-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-gray-500"
                                                @click="on = false">
                                                Cancel
                                            </button>
                                            <button type="button"
                                                class="px-4 py-2 rounded bg-red-800 hover:bg-red-500 text-white font-semibold focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-red-600"
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
                        <td colspan="2" class="px-6 py-6 text-center text-gray-500">No roles found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="max-w-4xl">
        {{ $this->roles()->links('vendor.pagination.tailwind') }}
    </div>

</div>
