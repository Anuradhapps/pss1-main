@section('title', 'Users Management')

<div x-data="{ deleteModalOpen: false, userToDelete: null, userName: '' }" class="space-y-3">

    {{-- Header --}}
    <x-headings.basic_heading title="Users Management" icon="fas fa-users" />

    {{-- Filter Toolbar --}}
    <div x-data="{ showFilters: {{ $openFilter || request('openFilter') ? 'true' : 'false' }} }">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
            <button @click="showFilters = !showFilters"
                class="inline-flex items-center justify-center gap-2.5 px-4 py-2.5 text-sm font-semibold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm hover:border-primary/40 hover:bg-primary/5 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/40 transition-all w-full sm:w-auto group">
                <div
                    class="w-7 h-7 rounded-lg bg-primary/10 flex items-center justify-center text-primary transition-colors">
                    <i class="fas fa-filter text-xs"></i>
                </div>
                <span x-text="showFilters ? 'Hide Filters' : 'Filter Users'"></span>
                @if ($name || $email || $joined)
                    <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                @endif
                <i class="fas fa-chevron-down text-xs text-slate-400 transition-transform duration-300"
                    :class="{ 'rotate-180': showFilters }"></i>
            </button>

            <p class="text-sm text-slate-500 dark:text-slate-400 sm:ml-auto">
                <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $users->total() }}</span>
                {{ Str::plural('user', $users->total()) }} found
            </p>
        </div>

        {{-- Expandable Filter Panel --}}
        <div x-show="showFilters" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="mt-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm overflow-hidden"
            style="display: none;">

            <div class="p-5 flex flex-col gap-5">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    {{-- Name Filter --}}
                    <div class="flex flex-col">
                        <label
                            class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">
                            Search Name
                        </label>
                        <div class="relative">
                            <i
                                class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="search" wire:model.live.debounce.300ms="name" placeholder="Search by name..."
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-900 dark:text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-colors">
                        </div>
                    </div>

                    {{-- Email Filter --}}
                    <div class="flex flex-col">
                        <label
                            class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">
                            Search Email
                        </label>
                        <div class="relative">
                            <i
                                class="fas fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="email" wire:model.live.debounce.300ms="email"
                                placeholder="Search by email..."
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-900 dark:text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-colors">
                        </div>
                    </div>

                    {{-- Date range component --}}
                    <div class="flex flex-col">
                        <x-form.daterange id="joined" name="joined" label="Joined Date Range"
                            wire:model.lazy="joined" />
                    </div>
                </div>

                {{-- Actions --}}
                <div
                    class="flex flex-col sm:flex-row gap-3 justify-end items-center pt-5 mt-1 border-t border-slate-100 dark:border-slate-700/50">
                    <button type="button" wire:click="resetFilters" @click="showFilters = false"
                        class="w-full sm:w-auto inline-flex justify-center items-center gap-2 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 py-2 px-4 rounded-lg transition-colors focus:outline-none">
                        <i class="fas fa-undo opacity-70 text-xs"></i> Clear Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Data Table --}}
    @if ($users->isEmpty())
        <x-data.empty-state icon="fas fa-users-slash" title="No Users Found"
            description="We couldn't find any users matching your search criteria." />
    @else
        <x-data.table>
            <x-slot name="header">
                <th scope="col" class="px-6 py-2 font-bold text-xs uppercase tracking-wide">User Details</th>
                <th scope="col" class="px-6 py-2 font-bold text-xs uppercase tracking-wide hidden md:table-cell">
                    Role</th>
                <th scope="col" class="px-6 py-2 font-bold text-xs uppercase tracking-wide hidden lg:table-cell">
                    Joined Date</th>
                <th scope="col" class="px-6 py-2 font-bold text-xs uppercase tracking-wide text-center">Actions
                </th>
            </x-slot>

            @foreach ($users as $user)
                <tr class="hover:bg-slate-200 dark:hover:bg-slate-800/50 transition-colors group bg-gray-50">
                    <td class="px-6 py-0">
                        <div class="flex items-center gap-3.5">
                            @php
                                $firstRole = $user->roles->first();
                                $roleKey = $firstRole ? strtolower($firstRole->label) : null;

                                $roleStyles = [
                                    'collector' => [
                                        'avatar' => 'from-emerald-400 to-teal-500 text-white',
                                        'ring' => 'ring-emerald-200 dark:ring-emerald-800',
                                        'variant' => 'success',
                                    ],
                                    'deputy director' => [
                                        'avatar' => 'from-amber-400 to-orange-500 text-white',
                                        'ring' => 'ring-amber-200 dark:ring-amber-800',
                                        'variant' => 'warning',
                                    ],
                                    'admin' => [
                                        'avatar' => 'from-rose-400 to-red-500 text-white',
                                        'ring' => 'ring-rose-200 dark:ring-rose-800',
                                        'variant' => 'danger',
                                    ],
                                ];

                                $style = $roleStyles[$roleKey] ?? [
                                    'avatar' =>
                                        'from-slate-300 to-slate-400 text-slate-800 dark:from-slate-600 dark:to-slate-700 dark:text-slate-100',
                                    'ring' => 'ring-slate-200 dark:ring-slate-700',
                                    'variant' => 'gray',
                                ];
                            @endphp

                            <div
                                class="w-10 h-10 flex shrink-0 items-center justify-center rounded-xl font-bold text-sm bg-gradient-to-br {{ $style['avatar'] }} ring-2 {{ $style['ring'] }} shadow-sm">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>

                            <div class="flex flex-col min-w-0">
                                <h3
                                    class="text-sm font-bold my-0 py-0 text-slate-900 dark:text-white group-hover:text-primary transition-colors truncate">
                                    {{ $user->name }}
                                </h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 my-0 py-0 truncate">
                                    {{ $user->email }}
                                </p>

                                {{-- Mobile Only Role & Date --}}
                                <div class="md:hidden flex flex-wrap items-center gap-2 mt-2">
                                    <x-ui.badge variant="{{ $style['variant'] }}" class="text-xs px-2 py-0.5">
                                        {{ $firstRole->label ?? 'No Role' }}
                                    </x-ui.badge>
                                    <span class="inline-flex items-center gap-1 text-xs text-slate-400">
                                        <i class="far fa-clock"></i>
                                        {{ $user->created_at ? $user->created_at->format('j M Y') : '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-3.5 hidden md:table-cell">
                        <x-ui.badge variant="{{ $style['variant'] }}">
                            {{ $firstRole->label ?? 'No Role' }}
                        </x-ui.badge>
                    </td>

                    <td
                        class="px-6 py-3.5 hidden lg:table-cell text-sm font-medium text-slate-600 dark:text-slate-400 whitespace-nowrap">
                        <i class="far fa-calendar-alt text-slate-400 mr-1.5"></i>
                        {{ $user->created_at ? $user->created_at->format('jS M Y') : '-' }}
                    </td>

                    <td class="px-6 py-3.5">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.users.show', $user->id) }}"
                                class="flex items-center justify-center w-9 h-9 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-500 hover:text-white hover:bg-primary dark:hover:bg-primary transition-all border border-slate-200 dark:border-slate-700 hover:border-primary shadow-sm"
                                title="View Profile">
                                <i class="fas fa-user-circle"></i>
                            </a>

                            @if (has_role('collector') && $user->collector_count > 0)
                                <a href="{{ route('admin.collectors.view', $user->id) }}"
                                    class="flex items-center justify-center w-9 h-9 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-500 hover:text-white hover:bg-emerald-600 dark:hover:bg-emerald-500 transition-all border border-slate-200 dark:border-slate-700 hover:border-emerald-600 shadow-sm"
                                    title="View Collector Data">
                                    <i class="fas fa-clipboard-list"></i>
                                </a>
                            @endif

                            @if (auth()->id() !== $user->id)
                                <button type="button"
                                    @click="deleteModalOpen = true; userToDelete = '{{ $user->id }}'; userName = '{{ addslashes($user->name) }}'"
                                    class="flex items-center justify-center w-9 h-9 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-500 hover:text-white hover:bg-rose-600 dark:hover:bg-rose-500 transition-all border border-slate-200 dark:border-slate-700 hover:border-rose-600 shadow-sm"
                                    title="Delete User">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
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

    {{-- AlpineJS Delete Confirmation Modal --}}
    <div x-show="deleteModalOpen" class="relative z-50" aria-labelledby="modal-title" role="dialog"
        aria-modal="true" x-cloak>
        <div x-show="deleteModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="deleteModalOpen" @click.away="deleteModalOpen = false"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-slate-900 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200 dark:border-slate-800">
                    <div class="px-5 pb-4 pt-6 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-full bg-rose-100 dark:bg-rose-900/30 sm:mx-0">
                                <i class="fas fa-exclamation-triangle text-rose-600 dark:text-rose-500"></i>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-lg font-bold leading-6 text-slate-900 dark:text-white"
                                    id="modal-title">
                                    Delete User
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-slate-500 dark:text-slate-400">
                                        Are you sure you want to permanently delete
                                        <strong x-text="userName" class="text-slate-900 dark:text-white"></strong>?
                                        All of their data will be permanently removed. This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-slate-50 dark:bg-slate-800/50 px-5 py-3.5 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-200 dark:border-slate-700">
                        <button type="button"
                            @click="@this.call('deleteUser', userToDelete); deleteModalOpen = false"
                            class="inline-flex w-full justify-center items-center gap-2 rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-rose-500 sm:ml-3 sm:w-auto transition-colors">
                            <i class="fas fa-trash-alt text-xs"></i> Yes, Delete User
                        </button>
                        <button type="button" @click="deleteModalOpen = false"
                            class="mt-2 sm:mt-0 inline-flex w-full justify-center rounded-xl bg-white dark:bg-slate-800 px-4 py-2.5 text-sm font-semibold text-slate-900 dark:text-slate-300 shadow-sm ring-1 ring-inset ring-slate-300 dark:ring-slate-600 hover:bg-slate-50 dark:hover:bg-slate-700 sm:w-auto transition-colors">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
