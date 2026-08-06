<div class="bg-gray-950 min-h-screen text-gray-100 p-6 space-y-6">
    <div class="text-center">
        <h1 class="text-3xl font-bold text-white"><i class="fas fa-shield-alt text-green-400"></i> Permissions</h1>
        <p class="text-sm text-gray-400 mt-1">Create, update, and attach permissions to roles.</p>
    </div>

    <div class="grid gap-4 md:grid-cols-[1.5fr_auto]">
        <div class="space-y-4">
            <div class="bg-gray-900 border border-gray-800 shadow rounded-3xl p-5">
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="sm:col-span-2">
                        <x-form.input wire:model="search" label="Search" name="search" placeholder="Search permissions"
                            class="bg-gray-900 text-white border-gray-700" />
                    </div>
                    <div>
                        <x-form.select wire:model="roleFilter" id="roleFilter" name="roleFilter" label="Role Filter"
                            class="bg-gray-900 text-white border-gray-700">
                            <option value="">All Roles</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->label }}</option>
                            @endforeach
                        </x-form.select>
                    </div>
                </div>
            </div>

            <div class="bg-gray-900 border border-gray-800 shadow rounded-3xl p-5">
                <div class="flex items-center justify-between gap-4 mb-4">
                    <div>
                        <h2 class="text-lg font-semibold text-white">Permission Details</h2>
                        <p class="text-sm text-gray-400">Create or edit a permission and attach it to roles.</p>
                    </div>
                    <button wire:click="resetForm" type="button"
                        class="px-4 py-2 text-sm font-semibold text-white bg-gray-800 border border-gray-700 rounded hover:bg-gray-700 transition">
                        Reset
                    </button>
                </div>

                <x-form wire:submit.prevent="savePermission" class="space-y-4">
                    <div class="grid gap-4 md:grid-cols-2">
                        <x-form.input wire:model="label" name="label" label="Label" required
                            class="bg-gray-900 text-white border-gray-700" />
                        <x-form.input wire:model="name" name="name" label="Name" required
                            class="bg-gray-900 text-white border-gray-700" />
                    </div>

                    <x-form.input wire:model="module" name="module" label="Module"
                        class="bg-gray-900 text-white border-gray-700" />

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-200">Attach Roles</p>
                        <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($roles as $role)
                                <label
                                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-800 text-gray-200 border border-gray-700">
                                    <input type="checkbox" wire:model="selectedRoles" value="{{ $role->id }}"
                                        class="h-4 w-4 text-cyan-500 rounded focus:ring-cyan-400" />
                                    <span>{{ $role->label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                        <button type="button" wire:click="resetForm"
                            class="px-4 py-2 text-sm font-medium text-gray-200 bg-gray-800 border border-gray-700 rounded hover:bg-gray-700 transition">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded hover:bg-green-500 transition">
                            {{ $permissionId ? 'Update Permission' : 'Create Permission' }}
                        </button>
                    </div>
                </x-form>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-gray-900 border border-gray-800 shadow rounded-3xl p-5">
                <h2 class="text-lg font-semibold text-white">Permissions</h2>
                <div class="overflow-x-auto mt-4">
                    <table class="min-w-full divide-y divide-gray-700 text-sm">
                        <thead class="bg-gray-800 text-gray-300 uppercase tracking-wide">
                            <tr>
                                <th class="px-4 py-3 text-left">Label</th>
                                <th class="px-4 py-3 text-left">Name</th>
                                <th class="px-4 py-3 text-left">Module</th>
                                <th class="px-4 py-3 text-left">Roles</th>
                                <th class="px-4 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @forelse ($permissions as $permission)
                                <tr class="hover:bg-gray-800 bg-gray-700 transition">
                                    <td class="px-4 py-3 text-gray-100">{{ $permission->label }}</td>
                                    <td class="px-4 py-3 text-gray-200">{{ $permission->name }}</td>
                                    <td class="px-4 py-3 text-gray-200">{{ $permission->module ?? 'General' }}</td>
                                    <td class="px-4 py-3 text-gray-200">
                                        {{ $permission->roles->pluck('label')->join(', ') ?: 'None' }}
                                    </td>
                                    <td class="px-4 py-3 space-x-2">
                                        <button type="button" wire:click="editPermission('{{ $permission->id }}')"
                                            class="px-3 py-1 text-sm font-medium bg-cyan-600 rounded hover:bg-cyan-500 transition">
                                            Edit
                                        </button>
                                        <button type="button" wire:click="deletePermission('{{ $permission->id }}')"
                                            class="px-3 py-1 text-sm font-medium bg-red-600 rounded hover:bg-red-500 transition">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">No permissions found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $permissions->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>
</div>
