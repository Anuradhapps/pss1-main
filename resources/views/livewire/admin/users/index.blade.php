@section('title', 'Users')

<div class=" text-white">
    <x-headings.topHeading title="Users" icon="fas fa-user"
        class="bg-gradient-to-r from-green-700 to-green-500 shadow-md" />

    <!-- Filter -->
    <div class="p-2 bg-teal-800">
        <div x-data="{ isOpen: {{ $openFilter || request('openFilter') ? 'true' : 'false' }} }">
            <div class="flex flex-wrap items-center gap-3">
                <button @click="isOpen = !isOpen" class="px-3 py-2 text-sm transition bg-gray-800 hover:bg-orange-600">
                    <i class="mr-1 fas fa-filter"></i> Advanced Filters
                </button>

                <button wire:click="resetFilters" @click="isOpen = false"
                    class="px-3 py-2 text-sm transition bg-red-600 hover:bg-red-800">
                    <i class="mr-1 fas fa-sync-alt"></i> Reset
                </button>
            </div>

            <div class="flex sm:flex-row gap-1 flex-col mt-3" x-show="isOpen" x-transition>
                <x-form.input type="search" name="name" wire:model="name" label="Name"
                    placeholder="Search users by name" />
                <x-form.input type="email" id="email" name="email" label="Email" wire:model="email"
                    placeholder="Search users by Email" />
                <x-form.daterange id="joined" name="joined" label="Joined Date Range" wire:model.lazy="joined" />
            </div>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 p-4">
        @foreach ($users as $user)
            <div class="p-3 bg-gray-800 shadow hover:shadow-lg transition duration-300 text-white">
                <div class="flex items-center gap-3 mb-3">
                    @php
                        $firstRole = $user->roles->first();
                        $iconcolor = 'bg-gray-600';
                        if ($firstRole) {
                            switch (strtolower($firstRole->label)) {
                                case 'collector':
                                    $iconcolor = 'bg-green-600';
                                    break;
                                case 'deputy director':
                                    $iconcolor = 'bg-orange-600';
                                    break;
                                case 'admin':
                                    $iconcolor = 'bg-red-600';
                                    break;
                            }
                        }
                    @endphp

                    <div class="w-10 h-10 flex items-center justify-center {{ $iconcolor }} rounded-full font-bold"
                        title="{{ $firstRole->label ?? 'No Role' }}">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold m-0 p-0">{{ $user->name }}</h3>
                        <p class="text-xs m-0 p-0 text-gray-400">{{ $user->email }}</p>
                    </div>
                </div>

                <p class="mb-2 text-sm">
                    <span class="font-medium text-gray-300">Joined:</span>
                    {{ $user->created_at ? date('jS M Y', strtotime($user->created_at)) : '-' }}
                </p>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.users.show', $user->id) }}"
                        class="px-3 py-1 text-xs font-medium bg-blue-600 hover:bg-blue-700 transition">
                        Profile
                    </a>

                    @php $hasCollector = $user->collector(); @endphp
                    @if (has_role('collector'))
                        @if ($hasCollector->count() > 0)
                            <a href="{{ route('admin.collectors.view', $user->id) }}"
                                class="px-3 py-1 text-xs font-medium bg-green-600 rounded hover:bg-green-700">
                                View Collectors
                            </a>
                        @else
                            <div class="px-3 py-1 text-xs bg-yellow-600 rounded">No Collector Data</div>
                        @endif
                    @endif

                    @if (auth()->id() !== $user->id)
                        <x-modal>
                            <x-slot name="trigger">
                                <a href="#" @click="on = true"
                                    class="px-3 py-1 text-xs font-medium bg-red-600 hover:bg-red-700">
                                    Delete
                                </a>
                            </x-slot>
                            <x-slot name="title">Confirm Delete</x-slot>
                            <x-slot name="content">
                                Are you sure you want to delete <b>{{ $user->name }}</b>?
                            </x-slot>
                            <x-slot name="footer">
                                <button @click="on = false"
                                    class="px-3 py-1 text-xs font-medium border-white border  hover:bg-gray-800">Cancel</button>
                                <button wire:click="deleteUser('{{ $user->id }}')"
                                    class="px-3 py-1 text-xs font-medium bg-red-600 hover:bg-red-700">
                                    Delete
                                </button>
                            </x-slot>
                        </x-modal>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->withQueryString()->links() }}
    </div>

    <!-- User Cards -->

</div>
