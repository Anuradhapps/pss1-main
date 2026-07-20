<div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-slate-950/60 backdrop-blur-sm p-0 sm:p-4 overflow-hidden">
    <!-- Modal Panel -->
    <div class="flex flex-col w-full sm:w-auto sm:max-w-lg max-h-[85dvh] sm:max-h-[90dvh] rounded-t-2xl sm:rounded-2xl border border-slate-200 bg-white shadow-2xl dark:border-slate-800 dark:bg-slate-900 overflow-hidden">
        <form wire:submit.prevent="store" class="flex flex-col h-full overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center justify-between px-4 sm:px-6 py-3 sm:py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 flex-shrink-0">
                <div class="flex items-center gap-2.5 sm:gap-3">
                    <div class="flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-br from-green-500 to-green-600 text-white shadow-md shadow-green-500/30 flex-shrink-0">
                        <i class="{{ $program_id ? 'fas fa-pen' : 'fas fa-plus' }} text-xs sm:text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white truncate">
                            {{ $program_id ? 'Edit Program' : 'New Program' }}
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 hidden sm:block">
                            {{ $program_id ? 'Update program details' : 'Create a new training program' }}
                        </p>
                    </div>
                </div>
                <button wire:click="closeModal" type="button"
                    class="w-9 h-9 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all flex-shrink-0 ml-2">
                    <i class="fas fa-xmark text-lg"></i>
                </button>
            </div>

            {{-- Scrollable Body --}}
            <div class="flex-1 overflow-y-auto overscroll-contain px-4 sm:px-6 py-4 sm:py-5 space-y-4 sm:space-y-5">

                {{-- Program Name --}}
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 sm:mb-2">
                        <i class="fas fa-clipboard-list text-slate-400 mr-1.5 text-[10px] sm:text-xs"></i>
                        Program Name
                    </label>
                    <select wire:model="program_name"
                        class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 px-3 sm:px-4 py-2.5 sm:py-3 text-sm text-slate-900 dark:text-white shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all outline-none">
                        <option value="">Select program type</option>
                        <option value="Rice Pest Surveillance">Rice Pest Surveillance</option>
                        <option value="MF FF Program">MF FF Program</option>
                    </select>
                    @error('program_name')
                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle text-[10px]"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- District --}}
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 sm:mb-2">
                        <i class="fas fa-map-marker-alt text-slate-400 mr-1.5 text-[10px] sm:text-xs"></i>
                        District
                    </label>
                    <select wire:model="district"
                        class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 px-3 sm:px-4 py-2.5 sm:py-3 text-sm text-slate-900 dark:text-white shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all outline-none">
                        <option value="">Select district</option>
                        @foreach ($districts as $d)
                        <option value="{{ $d->name }}">{{ $d->name }}</option>
                        @endforeach
                    </select>
                    @error('district')
                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle text-[10px]"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Date --}}
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 sm:mb-2">
                        <i class="fas fa-calendar text-slate-400 mr-1.5 text-[10px] sm:text-xs"></i>
                        Conducted Date
                    </label>
                    <input type="date" wire:model="conducted_date"
                        class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 px-3 sm:px-4 py-2.5 sm:py-3 text-sm text-slate-900 dark:text-white shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all outline-none">
                    @error('conducted_date')
                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle text-[10px]"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Time Range --}}
                <div class="grid grid-cols-2 gap-3 sm:gap-4">
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 sm:mb-2">
                            <i class="fas fa-clock text-slate-400 mr-1.5 text-[10px] sm:text-xs"></i>
                            Start Time
                        </label>
                        <input type="time" wire:model="start_time"
                            class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 px-3 sm:px-4 py-2.5 sm:py-3 text-sm text-slate-900 dark:text-white shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all outline-none">
                        @error('start_time')
                        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle text-[10px]"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 sm:mb-2">
                            <i class="fas fa-clock text-slate-400 mr-1.5 text-[10px] sm:text-xs"></i>
                            End Time
                        </label>
                        <input type="time" wire:model="end_time"
                            class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 px-3 sm:px-4 py-2.5 sm:py-3 text-sm text-slate-900 dark:text-white shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all outline-none">
                        @error('end_time')
                        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle text-[10px]"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>

                {{-- Participants --}}
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 sm:mb-2">
                        <i class="fas fa-users text-slate-400 mr-1.5 text-[10px] sm:text-xs"></i>
                        Participants Count
                    </label>
                    <input type="number" wire:model="participants_count" min="0"
                        class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 px-3 sm:px-4 py-2.5 sm:py-3 text-sm text-slate-900 dark:text-white shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all outline-none"
                        placeholder="Enter number of participants">
                    @error('participants_count')
                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle text-[10px]"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Details --}}
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 sm:mb-2">
                        <i class="fas fa-align-left text-slate-400 mr-1.5 text-[10px] sm:text-xs"></i>
                        Additional Details
                    </label>
                    <textarea wire:model="other_details" rows="3"
                        class="w-full resize-none rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 px-3 sm:px-4 py-2.5 sm:py-3 text-sm text-slate-900 dark:text-white shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all outline-none"
                        placeholder="Enter any additional program details..."></textarea>
                    @error('other_details')
                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle text-[10px]"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Spacer to ensure bottom padding --}}
                <div class="h-2 sm:h-0"></div>
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-end gap-2 sm:gap-3 px-4 sm:px-6 py-3 sm:py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 flex-shrink-0">
                <button type="button" wire:click="closeModal"
                    class="px-4 sm:px-5 py-2.5 rounded-xl text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">
                    Cancel
                </button>
                <button type="submit"
                    class="inline-flex items-center gap-1.5 sm:gap-2 px-4 sm:px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white bg-green-600 hover:bg-green-700 transition-all shadow-md shadow-green-500/30 hover:shadow-lg active:scale-[0.98]">
                    <i class="fas fa-check text-xs"></i>
                    <span>{{ $program_id ? 'Update' : 'Create' }}</span>
                </button>
            </div>
        </form>
    </div>
</div>