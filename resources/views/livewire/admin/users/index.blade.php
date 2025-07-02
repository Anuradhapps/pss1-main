@section('title', 'Users')

<div class="p-4 space-y-6 text-white">

    <!-- Header -->
    <div
        class="flex flex-col p-4 rounded-md shadow md:flex-row md:items-center md:justify-between bg-gradient-to-r from-purple-900 to-purple-600">
        <livewire:count-card :cardName="'Users'" :iconName="'fas fa-users'" :color="'from-purple-900 to-purple-700'" />
        {{-- @if (can('add_users')) <livewire:admin.users.invite /> @endif --}}
    </div>

    <!-- Search Bar & Filters -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="md:col-span-2">
            <x-form.input type="search" name="name" wire:model="name" label="none" placeholder="🔍 Search Users">
                {{ old('name', request('name')) }}
            </x-form.input>
        </div>
    </div>

    <!-- Advanced Filter -->
    <div class="mb-4" x-data="{ isOpen: {{ $openFilter || request('openFilter') ? 'true' : 'false' }} }">
        <div class="flex flex-wrap items-center gap-2 mb-2">
            <button @click="isOpen = !isOpen"
                class="flex items-center gap-2 px-3 py-1.5 text-xs font-medium rounded bg-gray-800 hover:bg-gray-700 transition">
                <i class="text-gray-300 fas fa-filter"></i> Advanced Search
            </button>
            <button wire:click="resetFilters" @click="isOpen = false"
                class="flex items-center gap-2 px-3 py-1.5 text-xs font-medium rounded bg-red-800 hover:bg-red-900 transition">
                <i class="text-white fas fa-sync-alt"></i> Reset
            </button>
        </div>

        <div x-show="isOpen" x-transition class="p-4 bg-gray-700 rounded-md shadow">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                <x-form.input type="email" id="email" name="email" label="Email" wire:model="email">
                    {{ old('email', request('email')) }}
                </x-form.input>

                <x-form.daterange id="joined" name="joined" label="Joined Date Range" wire:model.lazy="joined">
                    {{ old('joined', request('joined')) }}
                </x-form.daterange>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="overflow-x-auto bg-gray-900 rounded-lg shadow">
        <table class="min-w-full text-sm text-left text-gray-100">
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
                    <tr class="transition duration-200 hover:bg-gray-600 ">
                        <!-- Name + Avatar -->
                        <td class="flex items-center gap-2 px-4 py-3 whitespace-nowrap">
                            @if (storage_exists($user->image))
                                <img src="{{ storage_url($user->image) }}" class="object-cover w-8 h-8 rounded-full" />
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
                        <td class="px-4 py-3">
                            @foreach ($user->roles as $role)
                                <span
                                    class="inline-block px-2 py-0.5 text-xs font-medium bg-purple-700 text-white rounded-full">
                                    {{ $role->label }}
                                </span>
                            @endforeach
                        </td>

                        <!-- Actions -->
                        <td class="px-4 py-3 text-center">
                            <div class="flex flex-wrap justify-center gap-2">
                                @if (can('view_users_profiles'))
                                    <a href="{{ route('admin.users.show', ['user' => $user->id]) }}"
                                        class="px-3 py-1 text-xs text-white transition bg-blue-600 rounded hover:bg-blue-700">Profile</a>
                                @endif

                                @if (can('edit_users') || (auth()->id() === $user->id && can('edit_own_account')))
                                    <a href="{{ route('admin.users.edit', ['user' => $user->id]) }}"
                                        class="px-3 py-1 text-xs text-white transition bg-yellow-500 rounded hover:bg-yellow-600">Edit</a>
                                @endif

                                @if (can('add_users') && !empty($user->invite_token))
                                    <x-modal>
                                        <x-slot name="trigger">
                                            <a href="#" @click="on = true"
                                                class="px-3 py-1 text-xs text-white transition bg-indigo-600 rounded hover:bg-indigo-700">
                                                Resend Invite
                                            </a>
                                        </x-slot>
                                        <x-slot name="title">Resend Invite Email</x-slot>
                                        <x-slot name="footer">
                                            <button @click="on = false">Cancel</button>
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
                                                class="px-3 py-1 text-xs text-white transition bg-red-600 rounded hover:bg-red-700">
                                                Delete
                                            </a>
                                        </x-slot>
                                        <x-slot name="title">Confirm Delete</x-slot>
                                        <x-slot name="content">
                                            Are you sure you want to delete <b>{{ $user->name }}</b>?
                                        </x-slot>
                                        <x-slot name="footer">
                                            <button @click="on = false">Cancel</button>
                                            <button wire:click="deleteUser('{{ $user->id }}')"
                                                class="btn btn-red">Delete</button>
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
    <div class="mt-4">
        {{ $this->users()->links('pagination::tailwind') }}
    </div>
</div>
