<div class="fixed inset-0 z-50 flex items-center justify-center px-4 py-8 overflow-y-auto bg-black bg-opacity-50">
    <!-- Modal Panel -->
    <div class="w-full max-w-2xl overflow-hidden bg-gray-900 shadow-lg rounded-xl">
        <form wire:submit.prevent="store">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-700">
                <h2 class="text-xl font-semibold text-white">
                    {{ $program_id ? '✏️ Edit Program' : '➕ Create New Program' }}
                </h2>
            </div>

            <!-- Body -->
            <div class="px-6 py-4 space-y-5 text-white">
                <!-- Program Name -->
                <div>
                    <label for="program_name" class="block text-sm font-medium">Program Name</label>
                    <select id="program_name" wire:model="program_name"
                        class="w-full mt-1 text-sm bg-gray-800 border border-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Select Program --</option>
                        <option value="Rice Pest Surveillance">Rice Pest Surveillance</option>
                        <option value="MF FF Program">MF FF Program</option>
                    </select>
                    @error('program_name')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- District -->
                <div>
                    <label for="district" class="block text-sm font-medium">District</label>
                    <select id="district" wire:model="district"
                        class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Select District --</option>
                        @foreach ($districts as $d)
                            <option value="{{ $d->name }}">{{ $d->name }}</option>
                        @endforeach
                    </select>
                    @error('district')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date -->
                <div>
                    <label for="conducted_date" class="block text-sm font-medium">Date</label>
                    <input type="date" id="conducted_date" wire:model="conducted_date"
                        class="w-full mt-1 text-white bg-gray-800 border border-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    @error('conducted_date')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Time -->
                <div class="flex flex-col gap-4 sm:flex-row">
                    <div class="flex-1">
                        <label for="start_time" class="block text-sm font-medium">Start Time</label>
                        <input type="time" id="start_time" wire:model="start_time"
                            class="w-full mt-1 text-white bg-gray-800 border border-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        @error('start_time')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex-1">
                        <label for="end_time" class="block text-sm font-medium">End Time</label>
                        <input type="time" id="end_time" wire:model="end_time"
                            class="w-full mt-1 text-white bg-gray-800 border border-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        @error('end_time')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <!-- Participants Count -->
                <div>
                    <label for="participants_count" class="block text-sm font-medium">Participants Count</label>
                    <input type="number" id="participants_count" wire:model="participants_count"
                        class="w-full mt-1 text-white bg-gray-800 border border-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter number of participants" min="0">
                    @error('participants_count')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Other Details -->
                <div>
                    <label for="other_details" class="block text-sm font-medium">Other Details</label>
                    <textarea id="other_details" wire:model="other_details" rows="4"
                        class="w-full mt-1 text-white bg-gray-800 border border-gray-700 rounded-lg resize-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter any additional details here..."></textarea>
                    @error('other_details')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-3 px-6 py-4 border-t border-gray-700">
                <button type="button" wire:click="closeModal"
                    class="px-4 py-2 text-sm font-semibold text-white bg-gray-700 rounded hover:bg-gray-600">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded hover:bg-green-700">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
