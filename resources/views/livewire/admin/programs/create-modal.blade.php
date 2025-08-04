<div class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto bg-gray-900 bg-opacity-80">
    <!-- Compact Modal Panel -->
    <div
        class="w-full max-w-2xl max-h-[90vh] overflow-hidden bg-gray-800 border border-gray-700 shadow-xl flex flex-col">
        <form wire:submit.prevent="store" class="flex flex-col h-full">
            <!-- Header -->
            <div class="px-4 py-3 bg-gray-900 border-b border-gray-700">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-white">
                        <i class="mr-2 {{ $program_id ? 'fa-solid fa-pen' : 'fa-solid fa-plus' }}"></i>
                        {{ $program_id ? 'Edit Program' : 'New Program' }}
                    </h2>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-white">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>

            <!-- Scrollable Body -->
            <div class="flex-1 overflow-y-auto px-4 py-3 space-y-3">
                <!-- Program Name -->
                <div>
                    <label class="block mb-1 text-xs font-medium text-gray-400">Program Name</label>
                    <select wire:model="program_name"
                        class="w-full px-2 py-1 text-sm text-white bg-gray-700 border border-gray-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        <option value="">-- Select --</option>
                        <option value="Rice Pest Surveillance">Rice Pest Surveillance</option>
                        <option value="MF FF Program">MF FF Program</option>
                    </select>
                    @error('program_name')
                        <p class="mt-1 text-xs text-red-400"><i
                                class="fa-solid fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- District -->
                <div>
                    <label class="block mb-1 text-xs font-medium text-gray-400">District</label>
                    <select wire:model="district"
                        class="w-full px-2 py-1 text-sm text-white bg-gray-700 border border-gray-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        <option value="">-- Select --</option>
                        @foreach ($districts as $d)
                            <option value="{{ $d->name }}">{{ $d->name }}</option>
                        @endforeach
                    </select>
                    @error('district')
                        <p class="mt-1 text-xs text-red-400"><i
                                class="fa-solid fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date -->
                <div>
                    <label class="block mb-1 text-xs font-medium text-gray-400">Date</label>
                    <input type="date" wire:model="conducted_date"
                        class="w-full px-2 py-1 text-sm text-white bg-gray-700 border border-gray-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    @error('conducted_date')
                        <p class="mt-1 text-xs text-red-400"><i
                                class="fa-solid fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Time -->
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block mb-1 text-xs font-medium text-gray-400">Start Time</label>
                        <input type="time" wire:model="start_time"
                            class="w-full px-2 py-1 text-sm text-white bg-gray-700 border border-gray-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        @error('start_time')
                            <p class="mt-1 text-xs text-red-400"><i
                                    class="fa-solid fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-medium text-gray-400">End Time</label>
                        <input type="time" wire:model="end_time"
                            class="w-full px-2 py-1 text-sm text-white bg-gray-700 border border-gray-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        @error('end_time')
                            <p class="mt-1 text-xs text-red-400"><i
                                    class="fa-solid fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Participants -->
                <div>
                    <label class="block mb-1 text-xs font-medium text-gray-400">Participants</label>
                    <input type="number" wire:model="participants_count" min="0"
                        class="w-full px-2 py-1 text-sm text-white bg-gray-700 border border-gray-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    @error('participants_count')
                        <p class="mt-1 text-xs text-red-400"><i
                                class="fa-solid fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Details -->
                <div>
                    <label class="block mb-1 text-xs font-medium text-gray-400">Details</label>
                    <textarea wire:model="other_details" rows="2"
                        class="w-full px-2 py-1 text-sm text-white bg-gray-700 border border-gray-600 resize-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"></textarea>
                    @error('other_details')
                        <p class="mt-1 text-xs text-red-400"><i
                                class="fa-solid fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-2 px-4 py-3 bg-gray-900 border-t border-gray-700">
                <button type="button" wire:click="closeModal"
                    class="px-3 py-1 text-xs font-medium text-gray-300 bg-gray-700 hover:bg-gray-600 transition-colors">
                    Cancel
                </button>
                <button type="submit"
                    class="px-3 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 transition-colors">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
