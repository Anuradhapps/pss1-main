@section('title', 'Conducted Programs')

<div class="space-y-6">
    @if (empty($users))
        <!-- Programs List View -->
        <div>
            <!-- Header -->

            <div class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-colors dark:border-slate-800 dark:bg-slate-900 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-calendar-check text-emerald-500"></i>
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Conducted Programs</h1>
                </div>
                <button wire:click="create"
                    class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-500 sm:mt-0">
                    <i class="fa-solid fa-plus mr-2"></i> Create New Program
                </button>
            </div>
            <div class="space-y-4">
                <!-- Flash Message -->
                @if (session()->has('message'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
                        class="flex items-center rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900 shadow-sm dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-100">
                        <i class="fa-solid fa-check-circle mr-2"></i> {{ session('message') }}
                    </div>
                @endif

                <!-- Modal -->
                @if ($isModalOpen)
                    @include('livewire.admin.programs.create-modal')
                @endif

                <!-- Table -->
                <div class="overflow-hidden rounded-2xl border border-slate-200 shadow-sm dark:border-slate-800">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
                        <thead class="bg-slate-50 dark:bg-slate-900">
                            <tr class="text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                <th class="px-6 py-3 text-left">Program Name</th>
                                <th class="px-6 py-3 text-left">Location</th>
                                <th class="px-6 py-3 text-left">Participants</th>
                                <th class="px-6 py-3 text-left">Date</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white dark:divide-slate-800 dark:bg-slate-900">
                            @forelse ($programs as $program)
                                <tr class="transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                    <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $program->program_name }}</td>
                                    <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $program->district }}</td>
                                    <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $program->participants_count }}</td>
                                    <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                        {{ \Carbon\Carbon::parse($program->conducted_date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 space-x-2 text-right">
                                        <button wire:click="edit({{ $program->id }})"
                                            class="rounded-lg bg-blue-600 px-3 py-1 text-xs font-medium text-white transition-colors hover:bg-blue-500">
                                            <i class="fa-solid fa-pen mr-1"></i> Edit
                                        </button>
                                        <button wire:click="viewUsers({{ $program->id }})"
                                            class="rounded-lg bg-emerald-600 px-3 py-1 text-xs font-medium text-white transition-colors hover:bg-emerald-500">
                                            <i class="fa-solid fa-eye mr-1"></i> View
                                        </button>
                                        <button x-data
                                            @click="if (confirm('Are you sure you want to delete this program?')) $wire.delete({{ $program->id }})"
                                            class="rounded-lg bg-rose-600 px-3 py-1 text-xs font-medium text-white transition-colors hover:bg-rose-500">
                                            <i class="fa-solid fa-trash mr-1"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-slate-500 dark:text-slate-400">
                                        <i class="fa-solid fa-exclamation-circle mr-2"></i> No programs found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4 border-t border-slate-200 pt-4 dark:border-slate-800">
                    {{ $programs->links() }}
                </div>
            </div>

        </div>
    @else
        <!-- Participants Detail View -->
        <div class="mx-auto rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <!-- Header -->
            <div class="flex flex-col justify-between gap-4 border-b border-slate-200 pb-4 sm:flex-row sm:items-center dark:border-slate-800">
                <div>
                    <h2 class="flex items-center gap-2 text-xl font-bold text-slate-900 dark:text-white">
                        <i class="fa-solid fa-users text-teal-500"></i>
                        {{ $fullProgram->program_name }}
                    </h2>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <span class="rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                            <i class="fa-solid fa-calendar mr-1"></i> {{ $fullProgram->conducted_date }}
                        </span>
                        <span class="rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                            <i class="fa-solid fa-location-dot mr-1"></i> {{ $fullProgram->district }}
                        </span>
                    </div>
                </div>
                <button wire:click="closeP"
                    class="inline-flex items-center rounded-xl bg-rose-600 px-3 py-2 text-sm font-medium text-white transition-colors hover:bg-rose-500 sm:mt-0">
                    <i class="fa-solid fa-times mr-2"></i> Close
                </button>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-800 dark:bg-slate-950/40">
                    <div class="text-sm text-slate-500 dark:text-slate-400">Total Participants</div>
                    <div class="text-xl font-bold text-slate-900 dark:text-white">{{ $fullProgram->participants_count }}</div>
                </div>
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-800 dark:bg-slate-950/40">
                    <div class="text-sm text-slate-500 dark:text-slate-400">Registered Users</div>
                    <div class="text-xl font-bold text-slate-900 dark:text-white">{{ $users->count() }}</div>
                </div>
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-800 dark:bg-slate-950/40">
                    <div class="text-sm text-slate-500 dark:text-slate-400">Registration Rate</div>
                    <div class="text-xl font-bold text-slate-900 dark:text-white">
                        {{ round(($users->count() / max($fullProgram->participants_count, 1)) * 100) }}%
                    </div>
                </div>
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-800 dark:bg-slate-950/40">
                    <div class="text-sm text-slate-500 dark:text-slate-400">Program Date</div>
                    <div class="text-xl font-bold text-slate-900 dark:text-white">
                        {{ \Carbon\Carbon::parse($fullProgram->conducted_date)->format('M d, Y') }}
                    </div>
                </div>
            </div>

            <!-- Participants List -->
            <div class="mb-4">
                <h3 class="mb-3 flex items-center border-b border-slate-200 pb-2 text-lg font-medium text-slate-900 dark:border-slate-800 dark:text-white">
                    <i class="fa-solid fa-user-check mr-2 text-teal-500"></i>
                    Registered Officers
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @forelse ($users as $user)
                        <div
                            class="flex items-center justify-between rounded-xl border border-slate-200 bg-white p-3 transition-colors hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:hover:bg-slate-800/50">
                            <div class="flex items-center space-x-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-teal-600 text-white font-bold">
                                    {{ $loop->iteration }}
                                </div>
                                <div>
                                    <div class="font-medium text-slate-900 dark:text-white">{{ $user->name }}</div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400">{{ $user->email }}</div>
                                </div>
                            </div>
                            <a href="{{ route('admin.users.show', $user->id) }}"
                                class="rounded-lg bg-teal-600 px-3 py-1 text-xs font-medium text-white transition-colors hover:bg-teal-500">
                                <i class="fa-solid fa-user mr-1"></i> Profile
                            </a>
                        </div>
                    @empty
                        <div class="col-span-2 rounded-xl border border-slate-200 bg-slate-50 p-4 text-center text-slate-500 dark:border-slate-800 dark:bg-slate-950/40 dark:text-slate-400">
                            <i class="fa-solid fa-user-slash mr-2"></i> No registered participants found
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
</div>
