<div class="space-y-6 text-white bg-gray-900 p-6 font-sans">

    {{-- District selector --}}
    <div class="bg-gray-800 p-4 border border-gray-700">
        <label class="block font-semibold mb-2 text-gray-200">District</label>
        <select wire:model="selectedDistrict"
            class="w-full bg-gray-900 border border-gray-700 text-white p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">-- Select District --</option>
            @foreach ($districts as $district)
                <option value="{{ $district->id }}">{{ $district->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- ASC Management --}}
    @if ($selectedDistrict)
        <div class="bg-gray-800 p-4 border border-gray-700">
            <h3 class="text-xl font-semibold mb-3 text-gray-300">ASC Management</h3>

            <div class="flex mb-4 space-x-3">
                <input type="text" wire:model="newAsCenterName" placeholder="New ASC Name"
                    class="flex-1 bg-gray-900 border border-gray-700 text-white p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                <button wire:click="addAsCenter"
                    class="bg-green-700 hover:bg-green-800 px-5 py-3 font-semibold tracking-wide transition duration-200">
                    Add ASC
                </button>
            </div>

            <ul class="space-y-4">
                @foreach ($asCenters as $asCenter)
                    <li class="border-b border-gray-700 pb-3" x-data="{ showDeleteAscModal: false }">
                        @if ($editingAsCenterId === $asCenter->id)
                            {{-- ASC Edit Mode --}}
                            <div class="flex items-center space-x-3">
                                <input type="text" wire:model.defer="editingAsCenterName"
                                    class="flex-1 bg-gray-700 text-white p-2 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                                <button wire:click="updateAsCenter" class="text-green-400 hover:text-green-500"
                                    aria-label="Save ASC">
                                    💾
                                </button>
                                <button wire:click="$set('editingAsCenterId', null)"
                                    class="text-gray-500 hover:text-gray-400" aria-label="Cancel edit">
                                    ❌
                                </button>
                            </div>

                            {{-- AI Range Add --}}
                            <div class="mt-4 flex space-x-3">
                                <input type="text" wire:model="newAiRangeName" placeholder="New AI Range Name"
                                    class="flex-1 bg-gray-900 border border-gray-700 text-white p-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" />
                                <button wire:click="addAiRange"
                                    class="bg-yellow-700 hover:bg-yellow-800 px-4 py-2 font-semibold text-sm tracking-wide transition duration-200">
                                    Add AI Range
                                </button>
                            </div>

                            {{-- AI List --}}
                            <ul class="mt-4 pl-5 space-y-2 border-l-4 border-yellow-500">
                                @foreach ($aiRanges as $aiRange)
                                    <li class="flex items-center justify-between" x-data="{ showDeleteAiModal: false }">
                                        @if ($editingAiRangeId === $aiRange->id)
                                            <input type="text" wire:model.defer="editingAiRangeName"
                                                class="flex-1 bg-gray-700 text-white p-2 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                                            <button wire:click="updateAiRange"
                                                class="text-green-400 hover:text-green-500"
                                                aria-label="Save AI Range">💾</button>
                                            <button wire:click="$set('editingAiRangeId', null)"
                                                class="text-gray-500 hover:text-gray-400"
                                                aria-label="Cancel edit">❌</button>
                                        @else
                                            <span>{{ $aiRange->name }}</span>
                                            <div class="space-x-3">
                                                <button
                                                    wire:click="startEditAiRange({{ $aiRange->id }}, '{{ addslashes($aiRange->name) }}')"
                                                    class="text-blue-400 hover:text-blue-500"
                                                    aria-label="Edit AI Range">✏️</button>

                                                <!-- Delete AI Range Modal Trigger -->
                                                <button @click="showDeleteAiModal = true"
                                                    class="text-red-400 hover:text-red-500"
                                                    aria-label="Delete AI Range">🗑️</button>

                                                <!-- Delete AI Range Modal -->
                                                <div x-show="showDeleteAiModal" x-transition
                                                    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 z-50"
                                                    style="display:none;">
                                                    <div
                                                        class="bg-gray-800 p-6 border border-gray-700 max-w-sm w-full text-center">
                                                        <h4 class="text-lg font-semibold mb-4">Confirm Delete</h4>
                                                        <p class="mb-6">Are you sure you want to delete
                                                            <strong>{{ $aiRange->name }}</strong>?</p>
                                                        <div class="flex justify-center space-x-4">
                                                            <button @click="showDeleteAiModal = false"
                                                                class="bg-gray-700 hover:bg-gray-600 px-4 py-2 font-semibold">Cancel</button>
                                                            <button wire:click="deleteAiRange({{ $aiRange->id }})"
                                                                @click="showDeleteAiModal = false"
                                                                class="bg-red-600 hover:bg-red-700 px-4 py-2 font-semibold">Delete</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            {{-- ASC Display Mode --}}
                            <div class="flex justify-between items-center" x-data="{ showDeleteAscModal: false }">
                                <span>{{ $asCenter->name }}</span>
                                <div class="space-x-3">
                                    <button
                                        wire:click="startEditAsCenter({{ $asCenter->id }}, '{{ addslashes($asCenter->name) }}')"
                                        class="text-blue-400 hover:text-blue-500" aria-label="Edit ASC">✏️</button>

                                    <!-- Delete ASC Modal Trigger -->
                                    <button @click="showDeleteAscModal = true" class="text-red-400 hover:text-red-500"
                                        aria-label="Delete ASC">🗑️</button>

                                    <!-- Delete ASC Modal -->
                                    <div x-show="showDeleteAscModal" x-transition
                                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 z-50"
                                        style="display:none;">
                                        <div class="bg-gray-800 p-6 border border-gray-700 max-w-sm w-full text-center">
                                            <h4 class="text-lg font-semibold mb-4">Confirm Delete</h4>
                                            <p class="mb-6">Are you sure you want to delete
                                                <strong>{{ $asCenter->name }}</strong>?</p>
                                            <div class="flex justify-center space-x-4">
                                                <button @click="showDeleteAscModal = false"
                                                    class="bg-gray-700 hover:bg-gray-600 px-4 py-2 font-semibold">Cancel</button>
                                                <button wire:click="deleteAsCenter({{ $asCenter->id }})"
                                                    @click="showDeleteAscModal = false"
                                                    class="bg-red-600 hover:bg-red-700 px-4 py-2 font-semibold">Delete</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

</div>
