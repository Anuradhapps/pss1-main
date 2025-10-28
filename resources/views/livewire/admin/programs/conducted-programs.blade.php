@section('title', 'Conducted Programs')

<div class="bg-gray-900 min-h-screen text-gray-100">
    @if (empty($users))
        <!-- Programs List View -->
        <div>
            <!-- Header -->

            <div class="flex justify-between bg-green-700 p-2">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-calendar-check text-green-100"></i>
                    <h1 class="text-2xl text-white font-bold">Conducted Programs</h1>
                </div>
                <button wire:click="create"
                    class="inline-flex items-center px-4 py-2 mt-4 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors sm:mt-0">
                    <i class="fa-solid fa-plus mr-2"></i> Create New Program
                </button>
            </div>
            <div class="p-2">
                <!-- Flash Message -->
                @if (session()->has('message'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
                        class="px-4 py-3 mb-4 text-sm text-green-100 bg-green-800 border border-green-700 flex items-center">
                        <i class="fa-solid fa-check-circle mr-2"></i> {{ session('message') }}
                    </div>
                @endif

                <!-- Modal -->
                @if ($isModalOpen)
                    @include('livewire.admin.programs.create-modal')
                @endif

                <!-- Table -->
                <div class="overflow-x-auto border border-gray-700">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-800">
                            <tr class="text-xs text-gray-300 uppercase tracking-wider">
                                <th class="px-6 py-3 bg-gray-800 text-left">Program Name</th>
                                <th class="px-6 py-3 bg-gray-800 text-left">Location</th>
                                <th class="px-6 py-3 bg-gray-800 text-left">Participants</th>
                                <th class="px-6 py-3 bg-gray-800 text-left">Date</th>
                                <th class="px-6 py-3 bg-gray-800 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700 bg-gray-950">
                            @forelse ($programs as $program)
                                <tr class="hover:bg-gray-800 transition-colors bg-emerald-900">
                                    <td class="text-white px-6 py-4 font-medium ">{{ $program->program_name }}</td>
                                    <td class="text-white px-6 py-4 ">{{ $program->district }}</td>
                                    <td class="px-6 py-4">{{ $program->participants_count }}</td>
                                    <td class="px-6 py-4 text-white">
                                        {{ \Carbon\Carbon::parse($program->conducted_date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 space-x-2 text-right">
                                        <button wire:click="edit({{ $program->id }})"
                                            class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                                            <i class="fa-solid fa-pen mr-1"></i> Edit
                                        </button>
                                        <button wire:click="viewUsers({{ $program->id }})"
                                            class="px-3 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 transition-colors">
                                            <i class="fa-solid fa-eye mr-1"></i> View
                                        </button>
                                        <button x-data
                                            @click="if (confirm('Are you sure you want to delete this program?')) $wire.delete({{ $program->id }})"
                                            class="px-3 py-1 text-xs font-medium text-white bg-red-600 hover:bg-red-700 transition-colors">
                                            <i class="fa-solid fa-trash mr-1"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-black">
                                        <i class="fa-solid fa-exclamation-circle mr-2 text-black"></i> No programs found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4 border-t border-gray-700 pt-4">
                    {{ $programs->links('vendor.pagination.tailwind') }}
                </div>
            </div>

        </div>
    @else
        <!-- Participants Detail View -->
        <div class=" p-4 mx-auto bg-gray-800 border border-gray-700 shadow-lg">
            <!-- Header -->
            <div class="flex flex-col justify-between mb-4 sm:flex-row sm:items-center border-b border-gray-700 pb-4">
                <div>
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-users text-teal-400"></i>
                        {{ $fullProgram->program_name }}
                    </h2>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <span class="text-xs px-2 py-1 bg-gray-700 text-gray-300">
                            <i class="fa-solid fa-calendar mr-1"></i> {{ $fullProgram->conducted_date }}
                        </span>
                        <span class="text-xs px-2 py-1 bg-gray-700 text-gray-300">
                            <i class="fa-solid fa-location-dot mr-1"></i> {{ $fullProgram->district }}
                        </span>
                    </div>
                </div>
                <button wire:click="closeP"
                    class="inline-flex items-center px-3 py-2 mt-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 transition-colors sm:mt-0">
                    <i class="fa-solid fa-times mr-2"></i> Close
                </button>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-gray-700 p-3 border-l-4 border-blue-500">
                    <div class="text-sm text-gray-400">Total Participants</div>
                    <div class="text-xl font-bold">{{ $fullProgram->participants_count }}</div>
                </div>
                <div class="bg-gray-700 p-3 border-l-4 border-green-500">
                    <div class="text-sm text-gray-400">Registered Users</div>
                    <div class="text-xl font-bold">{{ $users->count() }}</div>
                </div>
                <div class="bg-gray-700 p-3 border-l-4 border-yellow-500">
                    <div class="text-sm text-gray-400">Registration Rate</div>
                    <div class="text-xl font-bold">
                        {{ round(($users->count() / max($fullProgram->participants_count, 1)) * 100) }}%
                    </div>
                </div>
                <div class="bg-gray-700 p-3 border-l-4 border-purple-500">
                    <div class="text-sm text-gray-400">Program Date</div>
                    <div class="text-xl font-bold">
                        {{ \Carbon\Carbon::parse($fullProgram->conducted_date)->format('M d, Y') }}
                    </div>
                </div>
            </div>

            <!-- Participants List -->
            <div class="mb-4">
                <h3 class="text-lg font-medium border-b border-gray-700 pb-2 mb-3 flex items-center">
                    <i class="fa-solid fa-user-check mr-2 text-teal-400"></i>
                    Registered Officers
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @forelse ($users as $user)
                        <div
                            class="flex items-center justify-between p-3 bg-gray-700 hover:bg-gray-600 transition-colors">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 flex items-center justify-center bg-teal-800 text-white font-bold">
                                    {{ $loop->iteration }}
                                </div>
                                <div>
                                    <div class="font-medium">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $user->email }}</div>
                                </div>
                            </div>
                            <a href="{{ route('admin.users.show', $user->id) }}"
                                class="px-3 py-1 text-xs font-medium text-white bg-teal-600 hover:bg-teal-700 transition-colors">
                                <i class="fa-solid fa-user mr-1"></i> Profile
                            </a>
                        </div>
                    @empty
                        <div class="col-span-2 p-4 text-center text-gray-400 bg-gray-700">
                            <i class="fa-solid fa-user-slash mr-2"></i> No registered participants found
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
</div>
