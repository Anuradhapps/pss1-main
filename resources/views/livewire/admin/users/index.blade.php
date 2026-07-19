@section('title', 'Users Management')

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-primary/10 dark:bg-primary/20 flex items-center justify-center text-primary dark:text-primary-light">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">System Users</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Manage administrators, directors, and collectors.</p>
            </div>
        </div>
        
        <!-- Quick Filters -->
        <div x-data="{ isOpen: {{ $openFilter || request('openFilter') ? 'true' : 'false' }} }" class="w-full sm:w-auto">
            <div class="flex items-center gap-3">
                <x-ui.button variant="outline" @click="isOpen = !isOpen" class="w-full sm:w-auto">
                    <i class="mr-2 fas fa-filter"></i> Filters
                </x-ui.button>
                <x-ui.button variant="ghost" wire:click="resetFilters" @click="isOpen = false">
                    <i class="mr-2 fas fa-sync-alt"></i> Reset
                </x-ui.button>
            </div>

            <div x-show="isOpen" x-collapse class="mt-4 absolute sm:static right-0 z-10 w-full sm:w-[400px]">
                <x-ui.card padding="p-4" class="shadow-xl sm:shadow-none border border-slate-200 dark:border-slate-700">
                    <div class="space-y-4">
                        <x-forms.input type="search" name="name" wire:model.live.debounce.300ms="name" label="Name" placeholder="Search users by name" icon="fas fa-search" />
                        <x-forms.input type="email" id="email" name="email" label="Email" wire:model.live.debounce.300ms="email" placeholder="Search users by Email" icon="fas fa-envelope" />
                        <!-- Date range component not updated, keep as is for functionality -->
                        <x-form.daterange id="joined" name="joined" label="Joined Date Range" wire:model.lazy="joined" />
                    </div>
                </x-ui.card>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    @if($users->isEmpty())
        <x-data.empty-state 
            icon="fas fa-users-slash" 
            title="No Users Found" 
            description="We couldn't find any users matching your search criteria." 
        />
    @else
        <x-data.table>
            <x-slot name="header">
                <th scope="col" class="px-6 py-4">User</th>
                <th scope="col" class="px-6 py-4 hidden sm:table-cell">Role</th>
                <th scope="col" class="px-6 py-4 hidden md:table-cell">Joined</th>
                <th scope="col" class="px-6 py-4 text-center">Actions</th>
            </x-slot>

            @foreach ($users as $user)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @php
                                $firstRole = $user->roles->first();
                                $iconcolor = 'bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-300';
                                $badgeVariant = 'gray';
                                
                                if ($firstRole) {
                                    switch (strtolower($firstRole->label)) {
                                        case 'collector':
                                            $iconcolor = 'bg-success/20 text-success';
                                            $badgeVariant = 'success';
                                            break;
                                        case 'deputy director':
                                            $iconcolor = 'bg-warning/20 text-warning';
                                            $badgeVariant = 'warning';
                                            break;
                                        case 'admin':
                                            $iconcolor = 'bg-danger/20 text-danger';
                                            $badgeVariant = 'danger';
                                            break;
                                    }
                                }
                            @endphp

                            <div class="w-10 h-10 flex shrink-0 items-center justify-center rounded-xl font-bold {{ $iconcolor }}">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>

                            <div>
                                <h3 class="text-sm font-semibold text-slate-900 dark:text-white">{{ $user->name }}</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 hidden sm:table-cell">
                        <x-ui.badge variant="{{ $badgeVariant }}">
                            {{ $firstRole->label ?? 'No Role' }}
                        </x-ui.badge>
                    </td>

                    <td class="px-6 py-4 hidden md:table-cell text-sm text-slate-600 dark:text-slate-400">
                        {{ $user->created_at ? $user->created_at->format('jS M Y') : '-' }}
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="text-slate-400 hover:text-primary transition-colors" title="View Profile">
                                <i class="fas fa-user-circle text-lg"></i>
                            </a>

                            @if (has_role('collector') && $user->collector()->count() > 0)
                                <a href="{{ route('admin.collectors.view', $user->id) }}" class="text-slate-400 hover:text-success transition-colors" title="View Collector Data">
                                    <i class="fas fa-clipboard-list text-lg"></i>
                                </a>
                            @endif

                            @if (auth()->id() !== $user->id)
                                <form wire:submit.prevent="deleteUser('{{ $user->id }}')" class="inline-block">
                                    <button type="submit" wire:confirm="Are you sure you want to permanently delete {{ $user->name }}?" class="text-slate-400 hover:text-danger transition-colors" title="Delete User">
                                        <i class="fas fa-trash-alt text-lg"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            
            <x-slot name="footer">
                <div class="w-full">
                    {{ $users->withQueryString()->links() }}
                </div>
            </x-slot>
        </x-data.table>
    @endif
</div>
