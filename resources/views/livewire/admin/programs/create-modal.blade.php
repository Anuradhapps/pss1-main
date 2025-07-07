<div class="fixed inset-0 z-50 flex items-center justify-center px-4 py-8 overflow-y-auto bg-black bg-opacity-50">
    <!-- Modal Panel -->
    <div class="w-full max-w-2xl overflow-hidden bg-white shadow-lg dark:bg-gray-900 rounded-xl">
        <form wire:submit.prevent="store">
            <!-- Header -->
            <div class="px-6 py-4 border-b dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
                    {{ $program_id ? 'Edit Program' : 'Create New Program' }}
                </h2>
            </div>

            <!-- Body -->
            <div class="px-6 py-4 space-y-4">
                <!-- Program Name -->
                <div>
                    <label for="program_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Program Name
                    </label>
                    <select id="program_name" wire:model="program_name"
                        class="w-full mt-1 text-sm text-gray-900 bg-gray-100 border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Select Program --</option>
                        <option value="Rice Pest Surveillance">Rice Pest Surveillance</option>
                        <option value="MF FF Program">MF FF Program</option>
                    </select>
                    @error('program_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>


                <!-- District -->
                <div>
                    <label for="district"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">District</label>
                    <select id="district" wire:model="district"
                        class="w-full mt-1 text-gray-900 bg-gray-100 border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Select District --</option>
                        @foreach ($districts as $d)
                            <option value="{{ $d->name }}">{{ $d->name }}</option>
                        @endforeach
                    </select>
                    @error('district')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Date -->
                <div>
                    <label for="conducted_date"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                    <input type="date" id="conducted_date" wire:model="conducted_date"
                        class="w-full mt-1 text-gray-900 bg-gray-100 border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                    @error('conducted_date')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Time -->
                <div class="flex flex-row gap-4">
                    <div class="flex-1">
                        <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start
                            Time</label>
                        <input type="time" id="start_time" wire:model="start_time"
                            class="w-full mt-1 text-gray-900 bg-gray-100 border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                        @error('start_time')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex-1">
                        <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End
                            Time</label>
                        <input type="time" id="end_time" wire:model="end_time"
                            class="w-full mt-1 text-gray-900 bg-gray-100 border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                        @error('end_time')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <!-- other_details -->
                <div>
                    <label for="other_details" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Other Details
                    </label>
                    <textarea id="other_details" wire:model="other_details" rows="4"
                        class="w-full mt-1 text-sm text-gray-900 bg-gray-100 border-gray-300 rounded-lg resize-none dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter any additional details here..."></textarea>
                    @error('other_details')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

            </div>


            <!-- Footer -->
            <div class="flex justify-end gap-3 px-6 py-4 border-t dark:border-gray-700">
                <button type="button" wire:click="closeModal"
                    class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 transition bg-gray-200 rounded-md dark:text-gray-200 dark:bg-gray-800 hover:bg-gray-300 dark:hover:bg-gray-700">
                    Cancel
                </button>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition bg-green-600 rounded-md hover:bg-green-700">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
