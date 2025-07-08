@section('title', 'Users')

<div class="space-y-3 text-white ">
    <div
        class="flex flex-col items-start justify-between p-4 space-y-4 rounded-md shadow-md bg-gradient-to-r from-purple-700 to-purple-500 md:flex-row md:items-center md:space-y-0">
        <h1 class="text-3xl font-extrabold tracking-wide text-white">Users</h1>
    </div>

    <!-- Search + Filter Section -->
    <div class="p-4 space-y-4 bg-gray-800 shadow-md rounded-2xl">

        <!-- Search Input -->

        <x-form.input type="search" name="name" wire:model="name" label="none" placeholder="🔍 Search users by name" />



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
    <div class="bg-gray-900 shadow rounded-2xl">
        <table class="w-full text-sm text-left text-white">
            <thead class="text-xs text-gray-400 uppercase bg-gray-800">
                <tr>
                    <th class="px-4 py-4">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Joined</th>
                    <th class="px-4 py-3">Roles</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>

            <tbody class="">
                @foreach ($this->users() as $user)
                    <tr class="group hover:bg-gray-900 hover:text-white">
                        <!-- Name with avatar -->
                        <td class="flex items-center">
                            <span
                                class="flex items-center justify-center w-8 h-8 mr-2 text-white transition bg-gray-500 rounded-full group-hover:bg-white group-hover:text-gray-900">
                                {{ ($this->users()->currentPage() - 1) * $this->users()->perPage() + $loop->iteration }}
                            </span>
                            <span class="transition group-hover:text-white">{{ $user->name }}</span>
                        </td>

                        <!-- Email -->
                        <td class="transition group-hover:text-white">{{ $user->email }}</td>

                        <!-- Joined -->
                        <td class="transition group-hover:text-white">
                            {{ $user->created_at ? date('jS M Y', strtotime($user->created_at)) : '' }}
                        </td>

                        <!-- Roles -->
                        <td>
                            @foreach ($user->roles as $role)
                                <span
                                    class="inline-block px-2 py-1 text-xs text-white bg-purple-700 rounded-full group-hover:bg-purple-600">
                                    {{ $role->label }}
                                </span>
                            @endforeach
                        </td>

                        <!-- Actions -->
                        <td class="text-center">
                            <div class="flex justify-center gap-2">

                                <a href="{{ route('admin.users.show', $user->id) }}"
                                    class="px-3 py-1 text-xs text-black bg-blue-400 rounded hover:bg-blue-700 group-hover:text-white">
                                    Profile
                                </a>
                                @php
                                    $hasCollector = $user->collector();
                                @endphp

                                @if ($hasCollector->count() > 0)
                                    <a href="{{ route('admin.collectors.view', $user->id) }}"
                                        class="px-3 py-1 text-xs text-black bg-green-400 rounded hover:bg-orange-700 group-hover:text-white">
                                        View Collectors
                                    </a>
                                @else
                                    <div class="px-3 py-1 text-xs text-white bg-red-900 rounded group-hover:text-white">
                                        No Collector Data
                                    </div>
                                @endif





                                @if (auth()->id() !== $user->id)
                                    <x-modal>
                                        <x-slot name="trigger">
                                            <a href="#" @click="on = true"
                                                class="px-3 py-1 text-xs text-black bg-red-500 rounded hover:bg-red-700 group-hover:text-white">
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
