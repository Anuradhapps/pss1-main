<div>
    <div class="p-4 bg-white rounded-lg shadow-md dark:bg-gray-900">

        <!-- Header -->
        <div class="flex flex-col items-start justify-between gap-4 mb-6 sm:flex-row sm:items-center">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">📋 Conducted Programs</h1>
            <button wire:click="create"
                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition bg-blue-600 rounded-md shadow hover:bg-blue-700">
                ➕ Create New Program
            </button>
        </div>

        <!-- Session Message -->
        @if (session()->has('message'))
            <div class="px-4 py-3 mb-4 text-sm text-green-700 bg-green-100 border border-green-400 rounded">
                ✅ {{ session('message') }}
            </div>
        @endif

        <!-- Modal -->
        @if ($isModalOpen)
            @include('livewire.admin.programs.create-modal')
        @endif

        <!-- Table -->
        <div class="overflow-x-auto rounded-md shadow">
            <table class="min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="text-xs text-gray-500 uppercase bg-gray-100 dark:bg-gray-800 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3 text-left">📌 Program Name</th>
                        <th class="px-6 py-3 text-left">📍 Location</th>
                        <th class="px-6 py-3 text-left">📅 Date</th>
                        <th class="px-6 py-3 text-left">⏰ Time</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-800">
                    @forelse ($programs as $program)
                        <tr>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-200">{{ $program->program_name }}</td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-200">
                                {{ $program->district }}
                            </td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-200">
                                {{ \Carbon\Carbon::parse($program->conducted_date)->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-200">
                                {{ \Carbon\Carbon::parse($program->start_time)->format('h:i A') }} -
                                {{ \Carbon\Carbon::parse($program->end_time)->format('h:i A') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button wire:click="edit({{ $program->id }})"
                                    class="mr-4 font-semibold text-indigo-600 hover:text-indigo-800">Edit</button>
                                <button wire:click="delete({{ $program->id }})"
                                    onclick="return confirm('Are you sure you want to delete this program?')"
                                    class="font-semibold text-red-600 hover:text-red-800">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                🚫 No programs found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $programs->links() }}
        </div>

    </div>

</div>
