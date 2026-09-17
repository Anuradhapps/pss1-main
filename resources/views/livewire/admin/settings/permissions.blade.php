<div
    class="min-h-screen bg-slate-50 p-6 text-slate-800 transition-colors duration-300 dark:bg-slate-950 dark:text-slate-100 space-y-6">
    <div class="text-center">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white"><i class="fas fa-shield-alt text-green-400"></i>
            Permissions</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Create, update, and attach permissions to roles.</p>
    </div>

    <div class="grid gap-4 md:grid-cols-[1.5fr_auto]">
        <div class="space-y-4">
            <div
                class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition-colors dark:border-slate-800 dark:bg-slate-900">
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="sm:col-span-2">
                        <x-form.input wire:model="search" label="Search" name="search" placeholder="Search permissions"
                            class="border-slate-300 bg-white text-slate-900 dark:border-slate-700 dark:bg-slate-900 dark:text-white" />
                    </div>
                    <div>
                        <x-form.select wire:model="roleFilter" id="roleFilter" name="roleFilter" label="Role Filter"
                            class="border-slate-300 bg-white text-slate-900 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                            <option value="">All Roles</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->label }}</option>
                            @endforeach
                        </x-form.select>
                    </div>
                </div>
            </div>

            <div
                class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition-colors dark:border-slate-800 dark:bg-slate-900">
                <div class="mb-4 flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Permission Details</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Create or edit a permission and attach it
                            to roles.</p>
                    </div>
                    <button wire:click="resetForm" type="button"
                        class="rounded border border-slate-300 bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                        Reset
                    </button>
                </div>

                <x-form wire:submit.prevent="savePermission" class="space-y-4">
                    <div class="grid gap-4 md:grid-cols-2">
                        <x-form.input wire:model="label" name="label" label="Label" required
                            class="border-slate-300 bg-white text-slate-900 dark:border-slate-700 dark:bg-slate-900 dark:text-white" />
                        <x-form.input wire:model="name" name="name" label="Name" required
                            class="border-slate-300 bg-white text-slate-900 dark:border-slate-700 dark:bg-slate-900 dark:text-white" />
                    </div>

                    <x-form.input wire:model="module" name="module" label="Module"
                        class="border-slate-300 bg-white text-slate-900 dark:border-slate-700 dark:bg-slate-900 dark:text-white" />

                    <div class="space-y-2">
                        <p class="text-sm font-medium text-slate-700 dark:text-slate-200">Attach Roles</p>
                        <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($roles as $role)
                                <label
                                    class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-slate-700 transition-colors dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                                    <input type="checkbox" wire:model="selectedRoles" value="{{ $role->id }}"
                                        class="h-4 w-4 rounded text-cyan-500 focus:ring-cyan-400" />
                                    <span>{{ $role->label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                        <button type="button" wire:click="resetForm"
                            class="rounded border border-slate-300 bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                            Cancel
                        </button>
                        <button type="submit"
                            class="rounded bg-green-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-green-500">
                            {{ $permissionId ? 'Update Permission' : 'Create Permission' }}
                        </button>
                    </div>
                </x-form>
            </div>
        </div>

        <div class="space-y-4">
            <div
                class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition-colors dark:border-slate-800 dark:bg-slate-900">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Permissions</h2>
                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-700">
                        <thead
                            class="bg-slate-50 uppercase tracking-wide text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                            <tr>
                                <th class="px-4 py-3 text-left">Label</th>
                                <th class="px-4 py-3 text-left">Name</th>
                                <th class="px-4 py-3 text-left">Module</th>
                                <th class="px-4 py-3 text-left">Roles</th>
                                <th class="px-4 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                            @forelse ($permissions as $permission)
                                <tr
                                    class="bg-white transition hover:bg-slate-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                                    <td class="px-4 py-3 text-slate-700 dark:text-slate-100">{{ $permission->label }}
                                    </td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-200">{{ $permission->name }}
                                    </td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-200">
                                        {{ $permission->module ?? 'General' }}</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-200">
                                        {{ $permission->roles->pluck('label')->join(', ') ?: 'None' }}
                                    </td>
                                    <td class="space-x-2 px-4 py-3">
                                        <button type="button" wire:click="editPermission('{{ $permission->id }}')"
                                            class="rounded bg-cyan-600 px-3 py-1 text-sm font-medium text-white transition hover:bg-cyan-500">
                                            Edit
                                        </button>
                                        <button type="button" wire:click="deletePermission('{{ $permission->id }}')"
                                            class="rounded bg-red-600 px-3 py-1 text-sm font-medium text-white transition hover:bg-red-500">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-slate-500 dark:text-slate-400">
                                        No permissions found.
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
