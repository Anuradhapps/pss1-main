@section('title', 'Users')

<div class="p-4 space-y-6 text-white">

    <!-- Header Card -->
    <livewire:count-card :cardName="'Users'" :iconName="'fas fa-users'" :color="'from-purple-900 to-purple-700'" />

    <!-- Search + Filter Section -->
    <div class="p-4 space-y-4 bg-gray-800 shadow-md rounded-2xl">

        <!-- Search Input -->
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="md:col-span-2">
                <x-form.input type="search" name="name" wire:model="name" label="none"
                    placeholder="🔍 Search users by name" />
            </div>
        </div>

        <!-- Advanced Filters -->
        <div x-data="{ isOpen: {{ $openFilter || request('openFilter') ? 'true' : 'false' }} }">
            <div class="flex flex-wrap items-center gap-3">
                <button @click="isOpen = !isOpen"
                    class="px-3 py-2 text-sm transition bg-gray-700 rounded-lg hover:bg-gray-600">
                    <i class="mr-1 fas fa-filter"></i> Advanced Filters
                </button>

                <button wire:click="resetFilters" @click="isOpen = false"
                    class="px-3 py-2 text-sm transition bg-red-700 rounded-lg hover:bg-red-800">
                    <i class="mr-1 fas fa-sync-alt"></i> Reset
                </button>
            </div>

            <div x-show="isOpen" x-transition class="p-4 mt-4 space-y-4 bg-gray-700 rounded-lg">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <x-form.input type="email" id="email" name="email" label="Email" wire:model="email" />
                    <x-form.daterange id="joined" name="joined" label="Joined Date Range"
                        wire:model.lazy="joined" />
                </div>
            </div>
        </div>
    </div>

    <!-- User Table -->
    <div class="overflow-x-auto bg-gray-900 shadow rounded-2xl">
        <table class="w-full text-sm text-left text-white">
            <thead class="text-xs text-gray-400 uppercase bg-gray-800">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Joined</th>
                    <th class="px-4 py-3">Roles</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-700">
                @foreach ($this->users() as $user)
                    <tr class="transition hover:bg-gray-700">
                        <!-- Name with avatar -->
                        <td class="flex items-center gap-3 px-4 py-3 whitespace-nowrap">
                            @if (storage_exists($user->image))
                                <img src="{{ storage_url($user->image) }}" class="object-cover w-8 h-8 rounded-full" />
                            @else
                                <div class="flex items-center justify-center w-8 h-8 text-sm bg-gray-600 rounded-full">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <span>{{ $user->name }}</span>
                        </td>

                        <!-- Email -->
                        <td class="px-4 py-3 whitespace-nowrap">{{ $user->email }}</td>

                        <!-- Joined -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if (!empty($user->invite_token))
                                <small
                                    class="text-gray-400">Invited<br>{{ date('jS M Y H:i', strtotime($user->invited_at)) }}</small>
                            @else
                                {{ $user->created_at ? date('jS M Y', strtotime($user->created_at)) : '' }}
                            @endif
                        </td>

                        <!-- Roles -->
                        <td class="px-4 py-3 space-x-1">
                            @foreach ($user->roles as $role)
                                <span class="inline-block px-2 py-1 text-xs text-white bg-purple-700 rounded-full">
                                    {{ $role->label }}
                                </span>
                            @endforeach
                        </td>

                        <!-- Actions -->
                        <td class="px-4 py-3 text-center">
                            <div class="flex flex-wrap justify-center gap-2">
                                @can('view_users_profiles')
                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                        class="px-3 py-1 text-xs bg-blue-600 rounded hover:bg-blue-700">Profile</a>
                                @endcan

                                @if (can('edit_users') || (auth()->id() === $user->id && can('edit_own_account')))
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="px-3 py-1 text-xs bg-yellow-500 rounded hover:bg-yellow-600">Edit</a>
                                @endif

                                @if (can('add_users') && !empty($user->invite_token))
                                    <x-modal>
                                        <x-slot name="trigger">
                                            <a href="#" @click="on = true"
                                                class="px-3 py-1 text-xs text-white bg-indigo-600 rounded hover:bg-indigo-700">
                                                Resend Invite
                                            </a>
                                        </x-slot>
                                        <x-slot name="title">Resend Invite Email</x-slot>
                                        <x-slot name="footer">
                                            <button @click="on = false" class="btn">Cancel</button>
                                            <button wire:click="resendInvite('{{ $user->id }}')"
                                                class="btn btn-primary">
                                                Send
                                            </button>
                                        </x-slot>
                                    </x-modal>
                                @endif

                                @if (can('delete_users') && auth()->id() !== $user->id)
                                    <x-modal>
                                        <x-slot name="trigger">
                                            <a href="#" @click="on = true"
                                                class="px-3 py-1 text-xs text-white bg-red-600 rounded hover:bg-red-700">
                                                Delete
                                            </a>
                                        </x-slot>
                                        <x-slot name="title">Confirm Delete</x-slot>
                                        <x-slot name="content">
                                            Are you sure you want to delete <b>{{ $user->name }}</b>?
                                        </x-slot>
                                        <x-slot name="footer">
                                            <button @click="on = false" class="btn">Cancel</button>
                                            <button wire:click="deleteUser('{{ $user->id }}')" class="btn btn-red">
                                                Delete
                                            </button>
                                        </x-slot>
                                    </x-modal>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pt-4">
        {{ $this->users()->links('pagination::tailwind') }}
    </div>
</div>
