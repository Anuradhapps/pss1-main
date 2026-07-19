<div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-slate-950/70 p-4 backdrop-blur-sm">
    <!-- Compact Modal Panel -->
    <div class="flex max-h-[90vh] w-full max-w-2xl flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl dark:border-slate-800 dark:bg-slate-900">
        <form wire:submit.prevent="store" class="flex flex-col h-full">
            <!-- Header -->
            <div class="border-b border-slate-200 px-4 py-3 dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                        <i class="mr-2 {{ $program_id ? 'fa-solid fa-pen' : 'fa-solid fa-plus' }}"></i>
                        {{ $program_id ? 'Edit Program' : 'New Program' }}
                    </h2>
                    <button wire:click="closeModal" class="text-slate-400 transition hover:text-slate-900 dark:hover:text-white">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>

            <!-- Scrollable Body -->
            <div class="flex-1 overflow-y-auto px-4 py-3 space-y-3">
                <!-- Program Name -->
                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-500 dark:text-slate-400">Program Name</label>
                    <select wire:model="program_name"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary focus:ring-primary/30 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
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
                    <label class="block mb-1 text-xs font-medium text-slate-500 dark:text-slate-400">District</label>
                    <select wire:model="district"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary focus:ring-primary/30 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
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
                    <label class="block mb-1 text-xs font-medium text-slate-500 dark:text-slate-400">Date</label>
                    <input type="date" wire:model="conducted_date"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary focus:ring-primary/30 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                    @error('conducted_date')
                        <p class="mt-1 text-xs text-red-400"><i
                                class="fa-solid fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Time -->
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block mb-1 text-xs font-medium text-slate-500 dark:text-slate-400">Start Time</label>
                        <input type="time" wire:model="start_time"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary focus:ring-primary/30 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                        @error('start_time')
                            <p class="mt-1 text-xs text-red-400"><i
                                    class="fa-solid fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-medium text-slate-500 dark:text-slate-400">End Time</label>
                        <input type="time" wire:model="end_time"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary focus:ring-primary/30 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                        @error('end_time')
                            <p class="mt-1 text-xs text-red-400"><i
                                    class="fa-solid fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Participants -->
                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-500 dark:text-slate-400">Participants</label>
                    <input type="number" wire:model="participants_count" min="0"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary focus:ring-primary/30 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                    @error('participants_count')
                        <p class="mt-1 text-xs text-red-400"><i
                                class="fa-solid fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Details -->
                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-500 dark:text-slate-400">Details</label>
                    <textarea wire:model="other_details" rows="2"
                        class="w-full resize-none rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary focus:ring-primary/30 dark:border-slate-700 dark:bg-slate-900 dark:text-white"></textarea>
                    @error('other_details')
                        <p class="mt-1 text-xs text-red-400"><i
                                class="fa-solid fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-2 border-t border-slate-200 px-4 py-3 dark:border-slate-800">
                <button type="button" wire:click="closeModal"
                    class="rounded-lg bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 transition-colors hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                    Cancel
                </button>
                <button type="submit"
                    class="rounded-lg bg-emerald-600 px-3 py-1 text-xs font-medium text-white transition-colors hover:bg-emerald-500">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
