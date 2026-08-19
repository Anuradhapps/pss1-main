@section('title', 'Conducted Programs')

<div class="space-y-4 sm:space-y-6 text-slate-800 dark:text-slate-100 antialiased">
    @if (empty($users))
        <!-- Programs List View -->
        <div class="space-y-4">
            {{-- Header Actions Bar --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="min-w-0 flex-1">
                    <x-headings.basic_heading title="Conducted Programs" icon="fas fa-calendar-check" class="w-full" />
                </div>

                <button wire:click="create"
                    class="inline-flex w-full sm:w-auto shrink-0 items-center justify-center gap-2 rounded-lg bg-emerald-600 px-4 py-2.5 text-xs font-semibold uppercase tracking-wider text-white shadow-sm transition-all duration-150 hover:bg-emerald-500 hover:shadow active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-emerald-500/40">
                    <i class="fas fa-plus text-xs"></i>
                    <span>Create Program</span>
                </button>
            </div>

            {{-- Flash Message --}}
            @if (session()->has('message'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="flex items-center justify-between rounded-lg border border-emerald-200 dark:border-emerald-500/20 bg-emerald-50/80 dark:bg-emerald-950/40 px-4 py-3 text-xs font-medium text-emerald-900 dark:text-emerald-300 shadow-xs">
                    <div class="flex items-center gap-2.5">
                        <i class="fas fa-check-circle text-emerald-600 dark:text-emerald-400 text-sm"></i>
                        <span>{{ session('message') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-700 dark:text-emerald-400 hover:opacity-75">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
            @endif

            {{-- Modal --}}
            @if ($isModalOpen)
                @include('livewire.admin.programs.create-modal')
            @endif

            {{-- Programs Table View --}}
            <div
                class="overflow-hidden rounded-xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-xs">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="border-b border-slate-200/80 dark:border-slate-800 bg-slate-50/80 dark:bg-slate-800/40 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                <th class="px-4 py-3 sm:px-5">Program Name</th>
                                <th class="px-4 py-3 sm:px-5">Location</th>
                                <th class="px-4 py-3 sm:px-5">Participants</th>
                                <th class="px-4 py-3 sm:px-5">Date</th>
                                <th class="px-4 py-3 sm:px-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-xs sm:text-sm">
                            @forelse ($programs as $program)
                                <tr class="group hover:bg-slate-50/80 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="px-4 py-3 sm:px-5">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                                                <i class="fas fa-clipboard-list text-xs"></i>
                                            </div>
                                            <span
                                                class="font-semibold text-slate-900 dark:text-slate-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                                {{ $program->program_name }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 sm:px-5">
                                        <span
                                            class="inline-flex items-center gap-1.5 text-xs text-slate-600 dark:text-slate-300">
                                            <i class="fas fa-map-marker-alt text-slate-400 text-[10px]"></i>
                                            {{ $program->district }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 sm:px-5">
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400 border border-blue-200/50 dark:border-blue-500/20">
                                            <i class="fas fa-users text-[9px]"></i>
                                            {{ $program->participants_count }}
                                        </span>
                                    </td>
                                    <td
                                        class="px-4 py-3 sm:px-5 whitespace-nowrap text-xs text-slate-500 dark:text-slate-400">
                                        <div class="flex items-center gap-1.5">
                                            <i class="fas fa-calendar text-slate-400 text-[10px]"></i>
                                            {{ \Carbon\Carbon::parse($program->conducted_date)->format('M d, Y') }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 sm:px-5 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center gap-1">
                                            <button wire:click="edit({{ $program->id }})"
                                                class="flex h-7 w-7 items-center justify-center rounded-md text-slate-400 hover:bg-slate-100 hover:text-blue-600 dark:hover:bg-slate-800 dark:hover:text-blue-400 transition-all"
                                                title="Edit Program">
                                                <i class="fas fa-pen text-xs"></i>
                                            </button>
                                            <button wire:click="viewUsers({{ $program->id }})"
                                                class="flex h-7 w-7 items-center justify-center rounded-md text-slate-400 hover:bg-emerald-50 hover:text-emerald-600 dark:hover:bg-emerald-500/10 dark:hover:text-emerald-400 transition-all"
                                                title="View Participants">
                                                <i class="fas fa-eye text-xs"></i>
                                            </button>
                                            <button x-data
                                                @click="if (confirm('Are you sure you want to delete this program?')) $wire.delete({{ $program->id }})"
                                                class="flex h-7 w-7 items-center justify-center rounded-md text-slate-400 hover:bg-rose-50 hover:text-rose-600 dark:hover:bg-rose-500/10 dark:hover:text-rose-400 transition-all"
                                                title="Delete Program">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-10 text-center">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <div
                                                class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-800/80 text-slate-400">
                                                <i class="fas fa-clipboard-list text-lg"></i>
                                            </div>
                                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400">No
                                                conducted programs found</p>
                                            <button wire:click="create"
                                                class="mt-1 text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:underline">
                                                Create your first program
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($programs->hasPages())
                    <div class="border-t border-slate-200/80 dark:border-slate-800 px-4 py-3 sm:px-5">
                        {{ $programs->links() }}
                    </div>
                @endif
            </div>
        </div>
    @else
        <!-- Participants Detail View -->
        <div class="space-y-4 sm:space-y-2">
            {{-- Program Details Header Card --}}
            <div
                class="overflow-hidden rounded-xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-xs">
                <div class="border-b border-slate-200/80 dark:border-slate-800 p-4 sm:p-5">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3.5">
                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-700 text-white shadow-sm">
                                <i class="fas fa-users text-sm"></i>
                            </div>
                            <div>
                                <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white leading-tight">
                                    {{ $fullProgram->program_name }}
                                </h2>
                                <div class="flex flex-wrap items-center gap-2 mt-1">
                                    <span
                                        class="inline-flex items-center gap-1 text-[11px] font-medium text-slate-500 dark:text-slate-400">
                                        <i class="fas fa-calendar text-[10px]"></i>
                                        {{ \Carbon\Carbon::parse($fullProgram->conducted_date)->format('M d, Y') }}
                                    </span>
                                    <span class="text-slate-300 dark:text-slate-700">•</span>
                                    <span
                                        class="inline-flex items-center gap-1 text-[11px] font-medium text-slate-500 dark:text-slate-400">
                                        <i class="fas fa-map-marker-alt text-[10px]"></i>
                                        {{ $fullProgram->district }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <button wire:click="closeP"
                            class="inline-flex items-center justify-center gap-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 px-3.5 py-1.5 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700/80 transition-colors">
                            <i class="fas fa-arrow-left text-[11px]"></i>
                            <span>Back to List</span>
                        </button>
                    </div>
                </div>

                {{-- Stats Bar --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 p-4 sm:p-5 bg-slate-50/50 dark:bg-slate-900/50">
                    <div
                        class="rounded-lg border border-slate-200/60 dark:border-slate-800 bg-white dark:bg-slate-800/60 p-3.5 shadow-2xs">
                        <div
                            class="flex items-center gap-2 mb-1 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <i class="fas fa-users text-blue-500"></i>
                            <span>Capacity</span>
                        </div>
                        <p class="text-xl font-bold text-slate-900 dark:text-white">
                            {{ $fullProgram->participants_count }}
                        </p>
                    </div>

                    <div
                        class="rounded-lg border border-slate-200/60 dark:border-slate-800 bg-white dark:bg-slate-800/60 p-3.5 shadow-2xs">
                        <div
                            class="flex items-center gap-2 mb-1 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <i class="fas fa-user-check text-emerald-500"></i>
                            <span>Registered</span>
                        </div>
                        <p class="text-xl font-bold text-slate-900 dark:text-white">
                            {{ $users->count() }}
                        </p>
                    </div>

                    <div
                        class="rounded-lg border border-slate-200/60 dark:border-slate-800 bg-white dark:bg-slate-800/60 p-3.5 shadow-2xs">
                        <div
                            class="flex items-center gap-2 mb-1 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <i class="fas fa-percentage text-amber-500"></i>
                            <span>Turnout</span>
                        </div>
                        <p class="text-xl font-bold text-slate-900 dark:text-white">
                            {{ round(($users->count() / max($fullProgram->participants_count, 1)) * 100) }}%
                        </p>
                    </div>

                    <div
                        class="rounded-lg border border-slate-200/60 dark:border-slate-800 bg-white dark:bg-slate-800/60 p-3.5 shadow-2xs">
                        <div
                            class="flex items-center gap-2 mb-1 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <i class="fas fa-calendar-day text-purple-500"></i>
                            <span>Status</span>
                        </div>
                        <p class="text-sm font-bold text-emerald-600 dark:text-emerald-400">
                            Completed
                        </p>
                    </div>
                </div>
            </div>

            {{-- Registered Officers Section --}}
            <div
                class="overflow-hidden rounded-xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-xs">
                <div
                    class="border-b border-slate-200/80 dark:border-slate-800 px-4 py-3.5 sm:px-5 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div
                            class="flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                            <i class="fas fa-user-check text-xs"></i>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white">Registered Officers</h3>
                    </div>
                    <span
                        class="rounded-full bg-slate-100 dark:bg-slate-800 px-2.5 py-0.5 text-xs font-semibold text-slate-600 dark:text-slate-400">
                        {{ $users->count() }} Total
                    </span>
                </div>

                <div class="p-4 sm:p-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @forelse ($users as $user)
                            <div
                                class="flex items-center justify-between rounded-lg border border-slate-200/70 dark:border-slate-800 bg-white dark:bg-slate-800/40 p-3 hover:border-emerald-500/50 dark:hover:border-emerald-500/30 transition-all">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div
                                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700 text-xs font-bold text-slate-700 dark:text-slate-200">
                                        {{ $loop->iteration }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="truncate text-xs font-semibold text-slate-900 dark:text-white">
                                            {{ $user->name }}
                                        </p>
                                        <p class="truncate text-[11px] text-slate-500 dark:text-slate-400">
                                            {{ $user->email }}
                                        </p>
                                    </div>
                                </div>
                                <a href="{{ route('admin.users.show', $user->id) }}"
                                    class="ml-2 inline-flex shrink-0 items-center gap-1 rounded-md bg-slate-100 dark:bg-slate-700/60 px-2.5 py-1 text-[11px] font-medium text-slate-700 dark:text-slate-300 hover:bg-emerald-600 hover:text-white dark:hover:bg-emerald-600 transition-colors">
                                    <i class="fas fa-user text-[9px]"></i>
                                    <span>Profile</span>
                                </a>
                            </div>
                        @empty
                            <div class="col-span-full py-8 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400">
                                        <i class="fas fa-user-slash text-sm"></i>
                                    </div>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">No registered participants
                                        found for this program.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
