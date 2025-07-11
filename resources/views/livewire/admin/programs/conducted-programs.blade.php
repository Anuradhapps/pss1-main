@if (empty($users))
    <div class="max-w-6xl p-3 mx-auto bg-gray-800 border border-gray-700 rounded-lg shadow-md items-top">

        <!-- Header -->
        <div class="flex flex-col justify-between mb-6 sm:flex-row sm:items-center">
            <h1 class="text-2xl font-bold text-white">📋 Conducted Programs</h1>
            <button wire:click="create"
                class="inline-flex items-center px-4 py-2 mt-4 text-sm font-medium text-white transition bg-blue-700 rounded-md sm:mt-0 hover:bg-blue-600">
                ➕ Create New Program
            </button>
        </div>

        <!-- Session Flash Message -->
        @if (session()->has('message'))
            <div class="px-4 py-3 mb-4 text-sm text-green-200 bg-green-700 border border-green-600 rounded">
                ✅ {{ session('message') }}
            </div>
        @endif

        <!-- Modal -->
        @if ($isModalOpen)
            @include('livewire.admin.programs.create-modal')
        @endif

        <!-- Table -->
        <div class="overflow-x-auto border border-gray-700 rounded-md">
            <table class="min-w-full text-sm divide-y divide-gray-700">
                <thead class="text-xs tracking-wider text-gray-300 uppercase bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left">Program Name</th>
                        <th class="px-6 py-3 text-left">Location</th>
                        <th class="px-6 py-3 text-left">Participants</th>
                        <th class="px-6 py-3 text-left">Date</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse ($programs as $program)
                        <tr class="transition hover:bg-gray-400">
                            <td class="px-6 py-4">{{ $program->program_name }}</td>
                            <td class="px-6 py-4">{{ $program->district }}</td>
                            <td class="px-6 py-4">{{ $program->participants_count }}</td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($program->conducted_date)->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 space-x-2 text-right">
                                <button wire:click="edit({{ $program->id }})"
                                    class="px-3 py-1 text-xs font-semibold text-white bg-blue-700 rounded hover:bg-blue-600">
                                    Edit
                                </button>
                                <button wire:click="viewUsers({{ $program->id }})"
                                    class="px-3 py-1 text-xs font-semibold text-white bg-green-700 rounded hover:bg-blue-600">
                                    view
                                </button>

                                <button x-data
                                    @click = "if (confirm('Are you sure you want to delete this program?')) $wire.delete({{ $program->id }})"
                                    class="px-3 py-1 text-xs font-semibold text-white bg-red-700 rounded hover:bg-red-600">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-400">
                                🚫 No programs found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $programs->links('pagination::tailwind') }}
        </div>

    </div>
@endif


@if (!empty($users))

    <div class="w-full mx-auto p-6 bg-gray-800 border border-gray-700 rounded-lg shadow-lg">
        <div class="flex items-center justify-between mb-4">

            <h2 class="text-2xl font-semibold text-white flex items-center gap-2">
                {{ $fullProgram->program_name }} - {{ $fullProgram->district }}
            </h2>
            <button wire:click="closeP"
                class="text-sm text-gray-400 hover:text-red-400 transition duration-150 ease-in-out">
                ✖ Close
            </button>


        </div>
        <div class="flex items-center justify-between mb-4">

            <h1 class="text-sm font-semibold text-white flex items-center gap-2">
                Conducted Date : {{ $fullProgram->conducted_date }}
                </h2>
                <h2 class="text-sm font-semibold text-white flex items-center gap-2">
                    👥 Participants {{ $users->count() }}
                </h2>

        </div>

        <ul class="space-y-1 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-600 scrollbar-track-gray-700 pr-2">
            @forelse ($users as $user)
                <li
                    class="flex items-center justify-between px-2 py-1 bg-gray-700 hover:bg-gray-600 rounded-md transition">
                    <div>
                        <p class="text-white font-medium">{{ $user->name }}</p>
                        <p class="text-sm text-gray-300">{{ $user->email }}</p>
                    </div>
                    <div class="text-gray-400">
                        🧑‍💼
                    </div>
                </li>
            @empty
                <li class="px-4 py-3 text-gray-300 bg-gray-700 rounded-md">
                    No participants found.
                </li>
            @endforelse
        </ul>
    </div>


@endif
