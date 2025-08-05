<div class="space-y-6 text-white bg-gray-900 p-6 font-sans min-h-screen">
    <div class="mb-4 text-center p-2">
        <h1 class="text-3xl font-bold text-white"><i class="fas fa-location-dot text-red-700"></i> Location Manager
        </h1>
        <p class="text-gray-400">Add, Remove, Edit Locations</p>
    </div>

    {{-- District selector --}}
    <div class="bg-gray-800 p-4 rounded-lg border border-gray-700 shadow-lg">
        <label class="block font-semibold mb-2 text-gray-200">District</label>
        <select wire:model="selectedDistrict"
            class="w-full bg-gray-900 border border-gray-700 text-white p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200">
            <option value="">-- Select District --</option>
            @foreach ($districts as $district)
                <option value="{{ $district->id }}">{{ $district->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- ASC Management --}}
    @if ($selectedDistrict)
        <div class="bg-gray-800 p-4 rounded-lg border border-gray-700 shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-300">ASC Management</h3>
                <div class="relative w-64">
                    <input type="text" wire:model.debounce.300ms="searchAsCenter" placeholder="Search ASCs..."
                        class="w-full bg-gray-900 border border-gray-700 text-white p-2 pl-10 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200">
                    <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            {{-- Add ASC Section --}}
            <div class="flex mb-6 space-x-3 items-end">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-300 mb-1">New ASC Name</label>
                    <input type="text" wire:model="newAsCenterName" placeholder="Enter ASC name"
                        class="w-full bg-gray-900 border border-gray-700 text-white p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200" />
                </div>
                <button wire:click="addAsCenter"
                    class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 px-6 py-3 font-semibold rounded-md tracking-wide transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add ASC
                </button>
            </div>

            {{-- ASC List --}}
            <ul class="space-y-3">
                @forelse ($asCenters as $asCenter)
                    <li class="border border-gray-700 rounded-lg overflow-hidden" x-data="{ showDeleteAscModal: false }">
                        <div class="bg-gray-750 hover:bg-gray-700 transition duration-200 p-4">
                            @if ($editingAsCenterId === $asCenter->id)
                                {{-- ASC Edit Mode --}}
                                <div class="flex items-center space-x-3 mb-4">
                                    <input type="text" wire:model.defer="editingAsCenterName"
                                        class="flex-1 bg-gray-900 text-white p-3 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200" />
                                    <button wire:click="updateAsCenter"
                                        class="bg-green-600 hover:bg-green-700 p-2 rounded-md transition duration-200"
                                        aria-label="Save ASC">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                    <button wire:click="$set('editingAsCenterId', null)"
                                        class="bg-gray-600 hover:bg-gray-700 p-2 rounded-md transition duration-200"
                                        aria-label="Cancel edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>

                                {{-- AI Range Management --}}
                                <div class="mt-4">
                                    <h4 class="text-lg font-semibold mb-3 text-gray-300">
                                        AI Ranges
                                    </h4>

                                    {{-- Add AI Range --}}
                                    <div class="flex mb-4 space-x-3">
                                        <div class="flex-1">
                                            <input type="text" wire:model="newAiRangeName"
                                                placeholder="New AI Range Name"
                                                class="w-full bg-gray-900 border border-gray-700 text-white p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 transition duration-200" />
                                        </div>
                                        <button wire:click="addAiRange"
                                            class="bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 px-4 py-3 font-semibold rounded-md tracking-wide transition duration-200 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Add Range
                                        </button>
                                    </div>

                                    {{-- AI Ranges List --}}
                                    <ul class="space-y-2">
                                        @forelse ($aiRanges as $aiRange)
                                            <li class="bg-gray-900 p-3 rounded-md border border-gray-700"
                                                x-data="{ showDeleteAiModal: false }">
                                                @if ($editingAiRangeId === $aiRange->id)
                                                    <div class="flex items-center space-x-3">
                                                        <input type="text" wire:model.defer="editingAiRangeName"
                                                            class="flex-1 bg-gray-800 text-white p-2 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200" />
                                                        <button wire:click="updateAiRange"
                                                            class="bg-green-600 hover:bg-green-700 p-2 rounded-md transition duration-200"
                                                            aria-label="Save AI Range">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        </button>
                                                        <button wire:click="$set('editingAiRangeId', null)"
                                                            class="bg-gray-600 hover:bg-gray-700 p-2 rounded-md transition duration-200"
                                                            aria-label="Cancel edit">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                @else
                                                    <div class="flex justify-between items-center">
                                                        <span class="font-medium">{{ $aiRange->name }}</span>
                                                        <div class="flex space-x-2">
                                                            <button
                                                                wire:click="startEditAiRange({{ $aiRange->id }}, '{{ addslashes($aiRange->name) }}')"
                                                                class="bg-blue-600 hover:bg-blue-700 p-2 rounded-md transition duration-200"
                                                                aria-label="Edit AI Range">
                                                                <svg class="w-4 h-4" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                                    </path>
                                                                </svg>
                                                            </button>
                                                            <button {{-- @click="showDeleteAiModal = true" --}}
                                                                wire:click="deleteAiRange({{ $aiRange->id }})"
                                                                class="bg-red-600 hover:bg-red-700 p-2 rounded-md transition duration-200"
                                                                aria-label="Delete AI Range">
                                                                <svg class="w-4 h-4" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                    </path>
                                                                </svg>
                                                            </button>
                                                            <!-- Inside the AI Range list item, after the edit/delete buttons -->
                                                            <div x-show="showDeleteAiModal" x-transition
                                                                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 z-50 px-4"
                                                                style="display: none;">
                                                                <div
                                                                    class="bg-gray-800 p-6 border border-gray-700 rounded-lg max-w-md w-full">
                                                                    <h4 class="text-lg font-semibold mb-4 text-center">
                                                                        Confirm Deletion</h4>
                                                                    <p class="mb-6 text-center">Are you sure you want
                                                                        to delete
                                                                        <strong>{{ $aiRange->name }}</strong>? This
                                                                        action cannot be undone.
                                                                    </p>
                                                                    <div class="flex justify-center space-x-4">
                                                                        <button @click="showDeleteAiModal = false"
                                                                            class="bg-gray-700 hover:bg-gray-600 px-6 py-2 rounded-md font-medium transition duration-200">
                                                                            Cancel
                                                                        </button>
                                                                        <button
                                                                            wire:click="deleteAiRange({{ $aiRange->id }})"
                                                                            @click="showDeleteAiModal = false"
                                                                            class="bg-red-600 hover:bg-red-700 px-6 py-2 rounded-md font-medium transition duration-200">
                                                                            Delete
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                @endif
                                            </li>
                                        @empty
                                            <li
                                                class="text-center py-3 text-gray-400 bg-gray-900 rounded-md border border-gray-700">
                                                No AI ranges found for this ASC
                                            </li>
                                        @endforelse
                                    </ul>
                                </div>
                            @else
                                {{-- ASC Display Mode --}}
                                <div class="flex justify-between items-center">
                                    <span class="font-medium">{{ $asCenter->name }}</span>
                                    <div class="flex space-x-2">
                                        <button
                                            wire:click="startEditAsCenter({{ $asCenter->id }}, '{{ addslashes($asCenter->name) }}')"
                                            class="bg-blue-600 hover:bg-blue-700 p-2 rounded-md transition duration-200"
                                            aria-label="Edit ASC">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>
                                        <button @click="showDeleteAscModal = true"
                                            class="bg-red-600 hover:bg-red-700 p-2 rounded-md transition duration-200"
                                            aria-label="Delete ASC">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                        {{-- Delete ASC Modal --}}
                                        <div x-show="showDeleteAscModal" x-transition
                                            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 z-50 px-4"
                                            style="display: none;">
                                            <div
                                                class="bg-gray-800 p-6 border border-gray-700 rounded-lg max-w-md w-full">
                                                <h4 class="text-lg font-semibold mb-4 text-center">Confirm Deletion
                                                </h4>
                                                <p class="mb-6 text-center">Are you sure you want to delete
                                                    <strong>{{ $asCenter->name }}</strong>? This action cannot be
                                                    undone.
                                                </p>
                                                <div class="flex justify-center space-x-4">
                                                    <button @click="showDeleteAscModal = false"
                                                        class="bg-gray-700 hover:bg-gray-600 px-6 py-2 rounded-md font-medium transition duration-200">
                                                        Cancel
                                                    </button>
                                                    <button wire:click="deleteAsCenter({{ $asCenter->id }})"
                                                        @click="showDeleteAscModal = false"
                                                        class="bg-red-600 hover:bg-red-700 px-6 py-2 rounded-md font-medium transition duration-200">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>


                    </li>
                @empty
                    <li class="text-center py-6 text-gray-400">
                        @if ($searchAsCenter)
                            No ASCs found matching your search.
                        @else
                            No ASCs available for this district.
                        @endif
                    </li>
                @endforelse
            </ul>
        </div>
    @endif

</div>
