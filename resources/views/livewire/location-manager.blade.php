<div class="space-y-6 text-slate-900 dark:text-white bg-white dark:bg-slate-900 p-6 font-sans min-h-screen" x-data>

    {{-- =========================================================
         HEADER
    ========================================================== --}}
    <div class="mb-4 text-center p-2">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
            <i class="fas fa-location-dot text-red-700"></i>
            Location Manager
        </h1>
        <p class="text-slate-500 dark:text-slate-400">Province &rarr; District &rarr; ASC &rarr; AI Range</p>
    </div>

    {{-- =========================================================
         FLASH TOAST
    ========================================================== --}}
    @if ($successMessage)
        <div wire:key="flash-{{ $flashId }}" x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
            x-transition
            class="flex items-center justify-between bg-green-50 dark:bg-green-900/40 border border-green-300 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-3 rounded-md">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ $successMessage }}</span>
            </div>
            <button @click="show = false" wire:click="dismissFlash"
                class="text-green-700 dark:text-green-300 hover:opacity-70">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    @endif

    {{-- =========================================================
         BREADCRUMB (quick-jump / collapse shortcut)
    ========================================================== --}}
    @if ($selectedProvince || $selectedDistrict || $selectedAsCenter)
        <div
            class="flex flex-wrap items-center gap-2 text-sm bg-indigo-50 dark:bg-indigo-950/40 border border-indigo-200 dark:border-indigo-800 rounded-md px-4 py-2">
            <span class="text-slate-500 dark:text-slate-400 font-medium">Viewing:</span>

            @if ($selectedProvince)
                <button wire:click="selectProvince({{ $selectedProvince }}, '{{ addslashes($selectedProvinceName) }}')"
                    class="text-indigo-700 dark:text-indigo-300 hover:underline font-medium">
                    {{ $selectedProvinceName }}
                </button>
            @endif

            @if ($selectedDistrict)
                <span class="text-slate-400">/</span>
                <button wire:click="selectDistrict({{ $selectedDistrict }}, '{{ addslashes($selectedDistrictName) }}')"
                    class="text-purple-700 dark:text-purple-300 hover:underline font-medium">
                    {{ $selectedDistrictName }}
                </button>
            @endif

            @if ($selectedAsCenter)
                <span class="text-slate-400">/</span>
                <button wire:click="selectAsCenter({{ $selectedAsCenter }}, '{{ addslashes($selectedAsCenterName) }}')"
                    class="text-teal-700 dark:text-teal-300 hover:underline font-medium">
                    {{ $selectedAsCenterName }}
                </button>
            @endif

            <span class="text-slate-400 ml-auto text-xs">Click a crumb to collapse back to it</span>
        </div>
    @endif

    {{-- =========================================================
         PROVINCE TREE (everything lives inside this one panel now)
    ========================================================== --}}
    <div class="bg-slate-50 dark:bg-slate-800 p-4 rounded-lg border border-slate-200 dark:border-slate-700 shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-slate-700 dark:text-slate-300">Locations</h3>
            <div class="relative w-64">
                <input type="text" wire:model.debounce.300ms="searchProvince" placeholder="Search provinces..."
                    class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white p-2 pl-10 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200">
                <svg class="absolute left-3 top-2.5 h-5 w-5 text-slate-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        {{-- Add Province --}}
        <form wire:submit.prevent="addProvince" class="flex mb-6 space-x-3 items-end">
            <div class="flex-1">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">New Province
                    Name</label>
                <input type="text" wire:model.defer="newProvinceName" placeholder="Enter province name"
                    class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200" />
                @error('newProvinceName')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" wire:loading.attr="disabled" wire:target="addProvince"
                class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 disabled:opacity-50 text-white px-6 py-3 font-semibold rounded-md tracking-wide transition duration-200 flex items-center">
                <svg wire:loading wire:target="addProvince" class="w-5 h-5 mr-2 animate-spin" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                <svg wire:loading.remove wire:target="addProvince" class="w-5 h-5 mr-2" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Province
            </button>
        </form>

        {{-- ===================== PROVINCE LIST (LEVEL 1) ===================== --}}
        <ul class="space-y-3">
            @forelse ($provinces as $province)
                <li wire:key="province-{{ $province->id }}"
                    class="border rounded-lg overflow-hidden transition duration-200 {{ (int) $selectedProvince === $province->id ? 'border-indigo-500 ring-1 ring-indigo-500' : 'border-slate-200 dark:border-slate-700' }}"
                    x-data="{ showDeleteModal: false }">

                    {{-- Province row --}}
                    <div class="bg-slate-100 dark:bg-slate-800 p-4">
                        @if ($editingProvinceId === $province->id)
                            <form wire:submit.prevent="updateProvince" class="flex items-start space-x-3">
                                <div class="flex-1">
                                    <input type="text" wire:model.defer="editingProvinceName"
                                        class="w-full bg-white dark:bg-slate-900 text-slate-900 dark:text-white p-3 border border-slate-200 dark:border-slate-700 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200" />
                                    @error('editingProvinceName')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" wire:loading.attr="disabled" wire:target="updateProvince"
                                    class="bg-green-600 hover:bg-green-700 disabled:opacity-50 text-white p-2 rounded-md transition duration-200"
                                    aria-label="Save Province">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </button>
                                <button type="button" wire:click="cancelEditProvince"
                                    class="bg-slate-300 dark:bg-slate-600 hover:bg-slate-400 dark:hover:bg-slate-700 text-slate-800 dark:text-white p-2 rounded-md transition duration-200"
                                    aria-label="Cancel edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </form>
                        @else
                            <div class="flex justify-between items-center text-slate-900 dark:text-white">
                                <button
                                    wire:click="selectProvince({{ $province->id }}, '{{ addslashes($province->name) }}')"
                                    class="font-medium text-left hover:text-indigo-600 dark:hover:text-indigo-400 transition duration-200 flex-1 flex items-center">
                                    {{-- expand/collapse chevron --}}
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0 transition-transform duration-200 {{ (int) $selectedProvince === $province->id ? 'rotate-90 text-indigo-500' : 'text-slate-400' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    <i class="fas fa-map text-indigo-500 mr-2"></i>
                                    {{ $province->name }}
                                </button>
                                <div class="flex space-x-2">
                                    <button
                                        wire:click="selectProvince({{ $province->id }}, '{{ addslashes($province->name) }}')"
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-md text-sm font-medium transition duration-200">
                                        {{ (int) $selectedProvince === $province->id ? 'Collapse' : 'Expand' }}
                                    </button>
                                    <button
                                        wire:click="startEditProvince({{ $province->id }}, '{{ addslashes($province->name) }}')"
                                        class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-md transition duration-200"
                                        aria-label="Edit Province">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button @click="showDeleteModal = true"
                                        class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-md transition duration-200"
                                        aria-label="Delete Province">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>

                                    <div x-show="showDeleteModal" x-transition
                                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 z-50 px-4"
                                        style="display: none;">
                                        <div
                                            class="bg-slate-50 dark:bg-slate-800 p-6 border border-slate-200 dark:border-slate-700 rounded-lg max-w-md w-full">
                                            <h4
                                                class="text-lg font-semibold mb-4 text-center text-slate-900 dark:text-white">
                                                Confirm Deletion</h4>
                                            <p class="mb-6 text-center text-slate-700 dark:text-slate-300">
                                                Delete <strong>{{ $province->name }}</strong>? This will also affect
                                                any districts under it. This action cannot be undone.
                                            </p>
                                            <div class="flex justify-center space-x-4">
                                                <button @click="showDeleteModal = false"
                                                    class="bg-slate-300 dark:bg-slate-700 hover:bg-slate-400 dark:hover:bg-slate-600 text-slate-800 dark:text-white px-6 py-2 rounded-md font-medium transition duration-200">Cancel</button>
                                                <button  wire:click="deleteProvince({{ $province->id }})"
                                                    @click="showDeleteModal = false"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-md font-medium transition duration-200">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- ===================== NESTED: DISTRICTS (LEVEL 2) ===================== --}}
                    @if ((int) $selectedProvince === $province->id)
                        <div wire:key="district-branch-{{ $province->id }}"
                            class="bg-white dark:bg-slate-900 p-4 border-t border-slate-200 dark:border-slate-700">
                            <div class="ml-3 pl-4 border-l-2 border-indigo-300 dark:border-indigo-700 space-y-4">

                                <div class="flex justify-between items-center">
                                    <h4
                                        class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                                        Districts in {{ $selectedProvinceName }}
                                    </h4>
                                    <div class="relative w-56">
                                        <input type="text" wire:model.debounce.300ms="searchDistrict"
                                            placeholder="Search districts..."
                                            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white p-2 pl-9 text-sm rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-200">
                                        <svg class="absolute left-2.5 top-2 h-4 w-4 text-slate-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                </div>

                                <form wire:submit.prevent="addDistrict" class="flex space-x-2 items-end">
                                    <div class="flex-1">
                                        <input type="text" wire:model.defer="newDistrictName"
                                            placeholder="New district name"
                                            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white p-2 text-sm rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-200" />
                                        @error('newDistrictName')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <button type="submit" wire:loading.attr="disabled" wire:target="addDistrict"
                                        class="bg-purple-600 hover:bg-purple-700 disabled:opacity-50 text-white px-4 py-2 text-sm font-semibold rounded-md transition duration-200 flex items-center">
                                        <svg wire:loading wire:target="addDistrict" class="w-4 h-4 mr-1 animate-spin"
                                            fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                        Add
                                    </button>
                                </form>

                                <ul class="space-y-2">
                                    @forelse ($districts as $district)
                                        <li wire:key="district-{{ $district->id }}"
                                            class="border rounded-md overflow-hidden transition duration-200 {{ (int) $selectedDistrict === $district->id ? 'border-purple-500 ring-1 ring-purple-500' : 'border-slate-200 dark:border-slate-700' }}"
                                            x-data="{ showDeleteModal: false }">

                                            <div class="bg-slate-50 dark:bg-slate-800 p-3">
                                                @if ($editingDistrictId === $district->id)
                                                    <form wire:submit.prevent="updateDistrict"
                                                        class="flex items-start space-x-2">
                                                        <div class="flex-1">
                                                            <input type="text"
                                                                wire:model.defer="editingDistrictName"
                                                                class="w-full bg-white dark:bg-slate-900 text-slate-900 dark:text-white p-2 text-sm border border-slate-200 dark:border-slate-700 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-200" />
                                                            @error('editingDistrictName')
                                                                <span
                                                                    class="text-red-500 text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <button type="submit" wire:loading.attr="disabled"
                                                            wire:target="updateDistrict"
                                                            class="bg-green-600 hover:bg-green-700 disabled:opacity-50 text-white p-2 rounded-md transition duration-200"
                                                            aria-label="Save District">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        </button>
                                                        <button type="button" wire:click="cancelEditDistrict"
                                                            class="bg-slate-300 dark:bg-slate-600 hover:bg-slate-400 dark:hover:bg-slate-700 text-slate-800 dark:text-white p-2 rounded-md transition duration-200"
                                                            aria-label="Cancel edit">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @else
                                                    <div
                                                        class="flex justify-between items-center text-slate-900 dark:text-white">
                                                        <button
                                                            wire:click="selectDistrict({{ $district->id }}, '{{ addslashes($district->name) }}')"
                                                            class="font-medium text-sm text-left hover:text-purple-600 dark:hover:text-purple-400 transition duration-200 flex-1 flex items-center">
                                                            <svg class="w-3.5 h-3.5 mr-2 flex-shrink-0 transition-transform duration-200 {{ (int) $selectedDistrict === $district->id ? 'rotate-90 text-purple-500' : 'text-slate-400' }}"
                                                                fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                            </svg>
                                                            <i
                                                                class="fas fa-map-location-dot text-purple-500 mr-2 text-xs"></i>
                                                            {{ $district->name }}
                                                        </button>
                                                        <div class="flex space-x-1.5">
                                                            <button
                                                                wire:click="selectDistrict({{ $district->id }}, '{{ addslashes($district->name) }}')"
                                                                class="bg-purple-600 hover:bg-purple-700 text-white px-2.5 py-1.5 rounded-md text-xs font-medium transition duration-200">
                                                                {{ (int) $selectedDistrict === $district->id ? 'Collapse' : 'Expand' }}
                                                            </button>
                                                            <button
                                                                wire:click="startEditDistrict({{ $district->id }}, '{{ addslashes($district->name) }}')"
                                                                class="bg-blue-600 hover:bg-blue-700 text-white p-1.5 rounded-md transition duration-200"
                                                                aria-label="Edit District">
                                                                <svg class="w-4 h-4" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                                    </path>
                                                                </svg>
                                                            </button>
                                                            <button @click="showDeleteModal = true"
                                                                class="bg-red-600 hover:bg-red-700 text-white p-1.5 rounded-md transition duration-200"
                                                                aria-label="Delete District">
                                                                <svg class="w-4 h-4" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                    </path>
                                                                </svg>
                                                            </button>

                                                            <div x-show="showDeleteModal" x-transition
                                                                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 z-50 px-4"
                                                                style="display: none;">
                                                                <div
                                                                    class="bg-slate-50 dark:bg-slate-800 p-6 border border-slate-200 dark:border-slate-700 rounded-lg max-w-md w-full">
                                                                    <h4
                                                                        class="text-lg font-semibold mb-4 text-center text-slate-900 dark:text-white">
                                                                        Confirm Deletion</h4>
                                                                    <p
                                                                        class="mb-6 text-center text-slate-700 dark:text-slate-300">
                                                                        Delete <strong>{{ $district->name }}</strong>?
                                                                        This will also affect any ASCs under it. This
                                                                        action cannot be undone.
                                                                    </p>
                                                                    <div class="flex justify-center space-x-4">
                                                                        <button @click="showDeleteModal = false"
                                                                            class="bg-slate-300 dark:bg-slate-700 hover:bg-slate-400 dark:hover:bg-slate-600 text-slate-800 dark:text-white px-6 py-2 rounded-md font-medium transition duration-200">Cancel</button>
                                                                        <button
                                                                            wire:click="deleteDistrict({{ $district->id }})"
                                                                            @click="showDeleteModal = false"
                                                                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-md font-medium transition duration-200">Delete</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- ===================== NESTED: ASCs (LEVEL 3) ===================== --}}
                                            @if ((int) $selectedDistrict === $district->id)
                                                <div wire:key="asc-branch-{{ $district->id }}"
                                                    class="bg-white dark:bg-slate-900 p-3 border-t border-slate-200 dark:border-slate-700">
                                                    <div
                                                        class="ml-3 pl-4 border-l-2 border-purple-300 dark:border-purple-700 space-y-3">

                                                        <div class="flex justify-between items-center">
                                                            <h5
                                                                class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                                                                ASCs in {{ $selectedDistrictName }}
                                                            </h5>
                                                            <div class="relative w-48">
                                                                <input type="text"
                                                                    wire:model.debounce.300ms="searchAsCenter"
                                                                    placeholder="Search ASCs..."
                                                                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white p-1.5 pl-8 text-xs rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-200">
                                                                <svg class="absolute left-2 top-1.5 h-3.5 w-3.5 text-slate-400"
                                                                    fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                                                                    </path>
                                                                </svg>
                                                            </div>
                                                        </div>

                                                        <form wire:submit.prevent="addAsCenter"
                                                            class="flex space-x-2 items-end">
                                                            <div class="flex-1">
                                                                <input type="text"
                                                                    wire:model.defer="newAsCenterName"
                                                                    placeholder="New ASC name"
                                                                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white p-1.5 text-xs rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-200" />
                                                                @error('newAsCenterName')
                                                                    <span
                                                                        class="text-red-500 text-xs">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <button type="submit" wire:loading.attr="disabled"
                                                                wire:target="addAsCenter"
                                                                class="bg-teal-600 hover:bg-teal-700 disabled:opacity-50 text-white px-3 py-1.5 text-xs font-semibold rounded-md transition duration-200 flex items-center">
                                                                <svg wire:loading wire:target="addAsCenter"
                                                                    class="w-3.5 h-3.5 mr-1 animate-spin"
                                                                    fill="none" viewBox="0 0 24 24">
                                                                    <circle class="opacity-25" cx="12"
                                                                        cy="12" r="10" stroke="currentColor"
                                                                        stroke-width="4"></circle>
                                                                    <path class="opacity-75" fill="currentColor"
                                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z">
                                                                    </path>
                                                                </svg>
                                                                Add
                                                            </button>
                                                        </form>

                                                        <ul class="space-y-2">
                                                            @forelse ($asCenters as $asCenter)
                                                                <li wire:key="asc-{{ $asCenter->id }}"
                                                                    class="border rounded-md overflow-hidden transition duration-200 {{ (int) $selectedAsCenter === $asCenter->id ? 'border-teal-500 ring-1 ring-teal-500' : 'border-slate-200 dark:border-slate-700' }}"
                                                                    x-data="{ showDeleteModal: false }">

                                                                    <div class="bg-slate-50 dark:bg-slate-800 p-2.5">
                                                                        @if ($editingAsCenterId === $asCenter->id)
                                                                            <form wire:submit.prevent="updateAsCenter"
                                                                                class="flex items-start space-x-2">
                                                                                <div class="flex-1">
                                                                                    <input type="text"
                                                                                        wire:model.defer="editingAsCenterName"
                                                                                        class="w-full bg-white dark:bg-slate-900 text-slate-900 dark:text-white p-1.5 text-xs border border-slate-200 dark:border-slate-700 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-200" />
                                                                                    @error('editingAsCenterName')
                                                                                        <span
                                                                                            class="text-red-500 text-xs">{{ $message }}</span>
                                                                                    @enderror
                                                                                </div>
                                                                                <button type="submit"
                                                                                    wire:loading.attr="disabled"
                                                                                    wire:target="updateAsCenter"
                                                                                    class="bg-green-600 hover:bg-green-700 disabled:opacity-50 text-white p-1.5 rounded-md transition duration-200"
                                                                                    aria-label="Save ASC">
                                                                                    <svg class="w-3.5 h-3.5"
                                                                                        fill="none"
                                                                                        stroke="currentColor"
                                                                                        viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round"
                                                                                            stroke-linejoin="round"
                                                                                            stroke-width="2"
                                                                                            d="M5 13l4 4L19 7"></path>
                                                                                    </svg>
                                                                                </button>
                                                                                <button type="button"
                                                                                    wire:click="cancelEditAsCenter"
                                                                                    class="bg-slate-300 dark:bg-slate-600 hover:bg-slate-400 dark:hover:bg-slate-700 text-slate-800 dark:text-white p-1.5 rounded-md transition duration-200"
                                                                                    aria-label="Cancel edit">
                                                                                    <svg class="w-3.5 h-3.5"
                                                                                        fill="none"
                                                                                        stroke="currentColor"
                                                                                        viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round"
                                                                                            stroke-linejoin="round"
                                                                                            stroke-width="2"
                                                                                            d="M6 18L18 6M6 6l12 12">
                                                                                        </path>
                                                                                    </svg>
                                                                                </button>
                                                                            </form>
                                                                        @else
                                                                            <div
                                                                                class="flex justify-between items-center text-slate-900 dark:text-white">
                                                                                <button
                                                                                    wire:click="selectAsCenter({{ $asCenter->id }}, '{{ addslashes($asCenter->name) }}')"
                                                                                    class="font-medium text-xs text-left hover:text-teal-600 dark:hover:text-teal-400 transition duration-200 flex-1 flex items-center">
                                                                                    <svg class="w-3 h-3 mr-1.5 flex-shrink-0 transition-transform duration-200 {{ (int) $selectedAsCenter === $asCenter->id ? 'rotate-90 text-teal-500' : 'text-slate-400' }}"
                                                                                        fill="none"
                                                                                        stroke="currentColor"
                                                                                        viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round"
                                                                                            stroke-linejoin="round"
                                                                                            stroke-width="2"
                                                                                            d="M9 5l7 7-7 7"></path>
                                                                                    </svg>
                                                                                    <i
                                                                                        class="fas fa-syringe text-teal-500 mr-2 text-xs"></i>
                                                                                    {{ $asCenter->name }}
                                                                                </button>
                                                                                <div class="flex space-x-1">
                                                                                    <button
                                                                                        wire:click="selectAsCenter({{ $asCenter->id }}, '{{ addslashes($asCenter->name) }}')"
                                                                                        class="bg-teal-600 hover:bg-teal-700 text-white px-2 py-1 rounded-md text-xs font-medium transition duration-200">
                                                                                        {{ (int) $selectedAsCenter === $asCenter->id ? 'Collapse' : 'Expand' }}
                                                                                    </button>
                                                                                    <button
                                                                                        wire:click="startEditAsCenter({{ $asCenter->id }}, '{{ addslashes($asCenter->name) }}')"
                                                                                        class="bg-blue-600 hover:bg-blue-700 text-white p-1 rounded-md transition duration-200"
                                                                                        aria-label="Edit ASC">
                                                                                        <svg class="w-3.5 h-3.5"
                                                                                            fill="none"
                                                                                            stroke="currentColor"
                                                                                            viewBox="0 0 24 24">
                                                                                            <path
                                                                                                stroke-linecap="round"
                                                                                                stroke-linejoin="round"
                                                                                                stroke-width="2"
                                                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                                                            </path>
                                                                                        </svg>
                                                                                    </button>
                                                                                    <button
                                                                                        @click="showDeleteModal = true"
                                                                                        class="bg-red-600 hover:bg-red-700 text-white p-1 rounded-md transition duration-200"
                                                                                        aria-label="Delete ASC">
                                                                                        <svg class="w-3.5 h-3.5"
                                                                                            fill="none"
                                                                                            stroke="currentColor"
                                                                                            viewBox="0 0 24 24">
                                                                                            <path
                                                                                                stroke-linecap="round"
                                                                                                stroke-linejoin="round"
                                                                                                stroke-width="2"
                                                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                                            </path>
                                                                                        </svg>
                                                                                    </button>

                                                                                    <div x-show="showDeleteModal"
                                                                                        x-transition
                                                                                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 z-50 px-4"
                                                                                        style="display: none;">
                                                                                        <div
                                                                                            class="bg-slate-50 dark:bg-slate-800 p-6 border border-slate-200 dark:border-slate-700 rounded-lg max-w-md w-full">
                                                                                            <h4
                                                                                                class="text-lg font-semibold mb-4 text-center text-slate-900 dark:text-white">
                                                                                                Confirm Deletion</h4>
                                                                                            <p
                                                                                                class="mb-6 text-center text-slate-700 dark:text-slate-300">
                                                                                                Delete
                                                                                                <strong>{{ $asCenter->name }}</strong>?
                                                                                                This will also affect
                                                                                                any AI ranges under it.
                                                                                                This action cannot be
                                                                                                undone.
                                                                                            </p>
                                                                                            <div
                                                                                                class="flex justify-center space-x-4">
                                                                                                <button
                                                                                                    @click="showDeleteModal = false"
                                                                                                    class="bg-slate-300 dark:bg-slate-700 hover:bg-slate-400 dark:hover:bg-slate-600 text-slate-800 dark:text-white px-6 py-2 rounded-md font-medium transition duration-200">Cancel</button>
                                                                                                <button
                                                                                                    wire:click="deleteAsCenter({{ $asCenter->id }})"
                                                                                                    @click="showDeleteModal = false"
                                                                                                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-md font-medium transition duration-200">Delete</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>

                                                                    {{-- ===================== NESTED: AI RANGES (LEVEL 4 — LEAF) ===================== --}}
                                                                    @if ((int) $selectedAsCenter === $asCenter->id)
                                                                        <div wire:key="airange-branch-{{ $asCenter->id }}"
                                                                            class="bg-white dark:bg-slate-900 p-2.5 border-t border-slate-200 dark:border-slate-700">
                                                                            <div
                                                                                class="ml-3 pl-4 border-l-2 border-teal-300 dark:border-teal-700 space-y-2.5">

                                                                                <h6
                                                                                    class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                                                                                    AI Ranges in
                                                                                    {{ $selectedAsCenterName }}
                                                                                </h6>

                                                                                <form wire:submit.prevent="addAiRange"
                                                                                    class="flex space-x-2">
                                                                                    <div class="flex-1">
                                                                                        <input type="text"
                                                                                            wire:model.defer="newAiRangeName"
                                                                                            placeholder="New AI Range name"
                                                                                            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white p-1.5 text-xs rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 transition duration-200" />
                                                                                        @error('newAiRangeName')
                                                                                            <span
                                                                                                class="text-red-500 text-xs">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <button type="submit"
                                                                                        wire:loading.attr="disabled"
                                                                                        wire:target="addAiRange"
                                                                                        class="bg-yellow-600 hover:bg-yellow-700 disabled:opacity-50 text-white px-3 py-1.5 text-xs font-semibold rounded-md transition duration-200 flex items-center">
                                                                                        <svg wire:loading
                                                                                            wire:target="addAiRange"
                                                                                            class="w-3.5 h-3.5 mr-1 animate-spin"
                                                                                            fill="none"
                                                                                            viewBox="0 0 24 24">
                                                                                            <circle class="opacity-25"
                                                                                                cx="12"
                                                                                                cy="12" r="10"
                                                                                                stroke="currentColor"
                                                                                                stroke-width="4">
                                                                                            </circle>
                                                                                            <path class="opacity-75"
                                                                                                fill="currentColor"
                                                                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z">
                                                                                            </path>
                                                                                        </svg>
                                                                                        Add
                                                                                    </button>
                                                                                </form>

                                                                                <ul class="space-y-1.5">
                                                                                    @forelse ($aiRanges as $aiRange)
                                                                                        <li wire:key="airange-{{ $aiRange->id }}"
                                                                                            class="bg-slate-50 dark:bg-slate-800 p-2 rounded-md border border-slate-200 dark:border-slate-700"
                                                                                            x-data="{ showDeleteModal: false }">
                                                                                            @if ($editingAiRangeId === $aiRange->id)
                                                                                                <form
                                                                                                    wire:submit.prevent="updateAiRange"
                                                                                                    class="flex items-start space-x-2">
                                                                                                    <div
                                                                                                        class="flex-1">
                                                                                                        <input
                                                                                                            type="text"
                                                                                                            wire:model.defer="editingAiRangeName"
                                                                                                            class="w-full bg-white dark:bg-slate-900 text-slate-900 dark:text-white p-1.5 text-xs border border-slate-200 dark:border-slate-700 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200" />
                                                                                                        @error('editingAiRangeName')
                                                                                                            <span
                                                                                                                class="text-red-500 text-xs">{{ $message }}</span>
                                                                                                        @enderror
                                                                                                    </div>
                                                                                                    <button
                                                                                                        type="submit"
                                                                                                        wire:loading.attr="disabled"
                                                                                                        wire:target="updateAiRange"
                                                                                                        class="bg-green-600 hover:bg-green-700 disabled:opacity-50 text-white p-1.5 rounded-md transition duration-200"
                                                                                                        aria-label="Save AI Range">
                                                                                                        <svg class="w-3.5 h-3.5"
                                                                                                            fill="none"
                                                                                                            stroke="currentColor"
                                                                                                            viewBox="0 0 24 24">
                                                                                                            <path
                                                                                                                stroke-linecap="round"
                                                                                                                stroke-linejoin="round"
                                                                                                                stroke-width="2"
                                                                                                                d="M5 13l4 4L19 7">
                                                                                                            </path>
                                                                                                        </svg>
                                                                                                    </button>
                                                                                                    <button
                                                                                                        type="button"
                                                                                                        wire:click="cancelEditAiRange"
                                                                                                        class="bg-slate-300 dark:bg-slate-600 hover:bg-slate-400 dark:hover:bg-slate-700 text-slate-800 dark:text-white p-1.5 rounded-md transition duration-200"
                                                                                                        aria-label="Cancel edit">
                                                                                                        <svg class="w-3.5 h-3.5"
                                                                                                            fill="none"
                                                                                                            stroke="currentColor"
                                                                                                            viewBox="0 0 24 24">
                                                                                                            <path
                                                                                                                stroke-linecap="round"
                                                                                                                stroke-linejoin="round"
                                                                                                                stroke-width="2"
                                                                                                                d="M6 18L18 6M6 6l12 12">
                                                                                                            </path>
                                                                                                        </svg>
                                                                                                    </button>
                                                                                                </form>
                                                                                            @else
                                                                                                <div
                                                                                                    class="flex justify-between items-center text-slate-900 dark:text-white">
                                                                                                    <span
                                                                                                        class="text-xs font-medium flex items-center">
                                                                                                        <i
                                                                                                            class="fas fa-syringe fa-flip-horizontal text-yellow-500 mr-2 text-xs"></i>
                                                                                                        {{ $aiRange->name }}
                                                                                                    </span>
                                                                                                    <div
                                                                                                        class="flex space-x-1">
                                                                                                        <button
                                                                                                            wire:click="startEditAiRange({{ $aiRange->id }}, '{{ addslashes($aiRange->name) }}')"
                                                                                                            class="bg-blue-600 hover:bg-blue-700 text-white p-1 rounded-md transition duration-200"
                                                                                                            aria-label="Edit AI Range">
                                                                                                            <svg class="w-3 h-3"
                                                                                                                fill="none"
                                                                                                                stroke="currentColor"
                                                                                                                viewBox="0 0 24 24">
                                                                                                                <path
                                                                                                                    stroke-linecap="round"
                                                                                                                    stroke-linejoin="round"
                                                                                                                    stroke-width="2"
                                                                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                                                                                </path>
                                                                                                            </svg>
                                                                                                        </button>
                                                                                                        <button
                                                                                                            @click="showDeleteModal = true"
                                                                                                            class="bg-red-600 hover:bg-red-700 text-white p-1 rounded-md transition duration-200"
                                                                                                            aria-label="Delete AI Range">
                                                                                                            <svg class="w-3 h-3"
                                                                                                                fill="none"
                                                                                                                stroke="currentColor"
                                                                                                                viewBox="0 0 24 24">
                                                                                                                <path
                                                                                                                    stroke-linecap="round"
                                                                                                                    stroke-linejoin="round"
                                                                                                                    stroke-width="2"
                                                                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                                                                </path>
                                                                                                            </svg>
                                                                                                        </button>

                                                                                                        <div x-show="showDeleteModal"
                                                                                                            x-transition
                                                                                                            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 z-50 px-4"
                                                                                                            style="display: none;">
                                                                                                            <div
                                                                                                                class="bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white p-6 border border-slate-200 dark:border-slate-700 rounded-lg max-w-md w-full">
                                                                                                                <h4
                                                                                                                    class="text-lg font-semibold mb-4 text-center">
                                                                                                                    Confirm
                                                                                                                    Deletion
                                                                                                                </h4>
                                                                                                                <p
                                                                                                                    class="mb-6 text-center text-slate-700 dark:text-slate-300">
                                                                                                                    Delete
                                                                                                                    <strong>{{ $aiRange->name }}</strong>?
                                                                                                                    This
                                                                                                                    action
                                                                                                                    cannot
                                                                                                                    be
                                                                                                                    undone.
                                                                                                                </p>
                                                                                                                <div
                                                                                                                    class="flex justify-center space-x-4">
                                                                                                                    <button
                                                                                                                        @click="showDeleteModal = false"
                                                                                                                        class="bg-slate-300 dark:bg-slate-700 hover:bg-slate-400 dark:hover:bg-slate-600 text-slate-800 dark:text-white px-6 py-2 rounded-md font-medium transition duration-200">Cancel</button>
                                                                                                                    <button
                                                                                                                        wire:click="deleteAiRange({{ $aiRange->id }})"
                                                                                                                        @click="showDeleteModal = false"
                                                                                                                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-md font-medium transition duration-200">Delete</button>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endif
                                                                                        </li>
                                                                                    @empty
                                                                                        <li
                                                                                            class="text-center py-2 text-xs text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-800 rounded-md border border-slate-200 dark:border-slate-700">
                                                                                            No AI ranges for this ASC
                                                                                            yet.
                                                                                        </li>
                                                                                    @endforelse
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </li>
                                                            @empty
                                                                <li
                                                                    class="text-center py-3 text-xs text-slate-500 dark:text-slate-400">
                                                                    {{ $searchAsCenter ? 'No ASCs match your search.' : 'No ASCs for this district yet.' }}
                                                                </li>
                                                            @endforelse
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif
                                        </li>
                                    @empty
                                        <li class="text-center py-3 text-sm text-slate-500 dark:text-slate-400">
                                            {{ $searchDistrict ? 'No districts match your search.' : 'No districts for this province yet.' }}
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    @endif
                </li>
            @empty
                <li class="text-center py-6 text-slate-500 dark:text-slate-400">
                    {{ $searchProvince ? 'No provinces match your search.' : 'No provinces yet — add one above.' }}
                </li>
            @endforelse
        </ul>
    </div>
</div>
