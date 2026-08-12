@section('title', 'Conducted Programs')

<div class="space-y-6">
    @if (empty($users))
        <!-- Programs List View -->
        <div class="space-y-2">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                {{-- Page Header --}}
                <div class="min-w-0 flex-1">
                    <x-headings.basic_heading title="Conducted Programs" icon="fas fa-calendar-check" class="w-full" />
                </div>

                {{-- Create Button --}}
                <button wire:click="create"
                    class="inline-flex w-full shrink-0 items-center justify-center gap-2
               rounded-xl bg-green-600 px-5 py-2.5
               text-sm font-semibold text-white
               shadow-lg shadow-green-500/30
               transition-all duration-200
               hover:bg-green-700 hover:shadow-xl
               active:scale-[0.98]
               sm:w-auto">
                    <i class="fas fa-plus text-xs"></i>
                    <span>Create Program</span>
                </button>

            </div>



            {{-- Flash Message --}}
            @if (session()->has('message'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
                    class="flex items-center rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 shadow-sm dark:border-green-500/20 dark:bg-green-500/10 dark:text-green-300">
                    <i class="fas fa-check-circle mr-2 text-green-600 dark:text-green-400"></i>
                    {{ session('message') }}
                </div>
            @endif

            {{-- Modal --}}
            @if ($isModalOpen)
                @include('livewire.admin.programs.create-modal')
            @endif

            {{-- Programs Table --}}
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left">
                        <thead>
                            <tr
                                class="bg-slate-50/80 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                                <th
                                    class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Program Name</th>
                                <th
                                    class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Location</th>
                                <th
                                    class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Participants</th>
                                <th
                                    class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Date</th>
                                <th
                                    class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse ($programs as $program)
                                <tr
                                    class="group bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all duration-200">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-9 h-9 rounded-lg bg-green-100 dark:bg-green-500/20 flex items-center justify-center text-green-600 dark:text-green-400 flex-shrink-0">
                                                <i class="fas fa-clipboard-list text-sm"></i>
                                            </div>
                                            <span
                                                class="text-sm font-semibold text-slate-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">{{ $program->program_name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div
                                            class="flex items-center gap-1.5 text-sm text-slate-600 dark:text-slate-300">
                                            <i class="fas fa-map-marker-alt text-slate-400 text-xs"></i>
                                            {{ $program->district }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400">
                                            <i class="fas fa-users text-[10px]"></i>
                                            {{ $program->participants_count }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div
                                            class="flex items-center gap-1.5 text-sm text-slate-600 dark:text-slate-300">
                                            <i class="fas fa-calendar text-slate-400 text-xs"></i>
                                            {{ \Carbon\Carbon::parse($program->conducted_date)->format('M d, Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-1">
                                            <button wire:click="edit({{ $program->id }})"
                                                class="w-9 h-9 rounded-lg flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-500/10 transition-all"
                                                title="Edit">
                                                <i class="fas fa-pen text-sm"></i>
                                            </button>
                                            <button wire:click="viewUsers({{ $program->id }})"
                                                class="w-9 h-9 rounded-lg flex items-center justify-center text-slate-400 hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-500/10 transition-all"
                                                title="View Participants">
                                                <i class="fas fa-eye text-sm"></i>
                                            </button>
                                            <button x-data
                                                @click="if (confirm('Are you sure you want to delete this program?')) $wire.delete({{ $program->id }})"
                                                class="w-9 h-9 rounded-lg flex items-center justify-center text-slate-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all"
                                                title="Delete">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div
                                                class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                                                <i
                                                    class="fas fa-clipboard-list text-slate-400 dark:text-slate-600 text-2xl"></i>
                                            </div>
                                            <p class="text-sm text-slate-500 dark:text-slate-400">No programs found</p>
                                            <button wire:click="create"
                                                class="text-sm text-green-600 hover:text-green-700 font-medium">Create
                                                your first program</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-800">
                    {{ $programs->links() }}
                </div>
            </div>

        </div>
    @else
        <!-- Participants Detail View -->
        <div class="space-y-6">


            {{-- Program Header Card --}}
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div
                                class="flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-green-600 text-white shadow-lg shadow-green-500/30">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-slate-900 dark:text-white">
                                    {{ $fullProgram->program_name }}</h2>
                                <div class="flex flex-wrap items-center gap-2 mt-1">
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400">
                                        <i class="fas fa-calendar text-[10px]"></i>
                                        {{ \Carbon\Carbon::parse($fullProgram->conducted_date)->format('M d, Y') }}
                                    </span>
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400">
                                        <i class="fas fa-map-marker-alt text-[10px]"></i>
                                        {{ $fullProgram->district }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <button wire:click="closeP"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-sm font-medium rounded-xl transition-all">
                            <i class="fas fa-times"></i>
                            <span>Close</span>
                        </button>
                    </div>
                </div>

                {{-- Stats Grid --}}
                <div class="p-6 grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div
                        class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-4 border border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-3 mb-2">
                            <div
                                class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-500/20 flex items-center justify-center text-blue-600 dark:text-blue-400">
                                <i class="fas fa-users text-sm"></i>
                            </div>
                            <span
                                class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total</span>
                        </div>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">
                            {{ $fullProgram->participants_count }}</p>
                    </div>
                    <div
                        class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-4 border border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-3 mb-2">
                            <div
                                class="w-8 h-8 rounded-lg bg-green-100 dark:bg-green-500/20 flex items-center justify-center text-green-600 dark:text-green-400">
                                <i class="fas fa-user-check text-sm"></i>
                            </div>
                            <span
                                class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Registered</span>
                        </div>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $users->count() }}</p>
                    </div>
                    <div
                        class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-4 border border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-3 mb-2">
                            <div
                                class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-500/20 flex items-center justify-center text-amber-600 dark:text-amber-400">
                                <i class="fas fa-percentage text-sm"></i>
                            </div>
                            <span
                                class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Rate</span>
                        </div>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">
                            {{ round(($users->count() / max($fullProgram->participants_count, 1)) * 100) }}%</p>
                    </div>
                    <div
                        class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-4 border border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-3 mb-2">
                            <div
                                class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-500/20 flex items-center justify-center text-purple-600 dark:text-purple-400">
                                <i class="fas fa-calendar-day text-sm"></i>
                            </div>
                            <span
                                class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Date</span>
                        </div>
                        <p class="text-lg font-bold text-slate-900 dark:text-white">
                            {{ \Carbon\Carbon::parse($fullProgram->conducted_date)->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- Participants List --}}
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-xl bg-green-100 dark:bg-green-500/20 text-green-600 dark:text-green-400">
                            <i class="fas fa-user-check text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Registered Officers</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">{{ $users->count() }} participants
                            </p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @forelse ($users as $user)
                            <div
                                class="flex items-center justify-between p-4 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl hover:border-green-300 dark:hover:border-green-700 transition-all group">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-bold text-sm shadow-md shadow-green-500/20">
                                        {{ $loop->iteration }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-slate-900 dark:text-white">
                                            {{ $user->name }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ $user->email }}
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('admin.users.show', $user->id) }}"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-lg transition-all shadow-sm hover:shadow-md">
                                    <i class="fas fa-user text-[10px]"></i>
                                    Profile
                                </a>
                            </div>
                        @empty
                            <div class="col-span-2 flex flex-col items-center gap-3 py-12 text-center">
                                <div
                                    class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                                    <i class="fas fa-user-slash text-slate-400 dark:text-slate-600 text-2xl"></i>
                                </div>
                                <p class="text-sm text-slate-500 dark:text-slate-400">No registered participants found
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    @endif
</div>
