<!-- Errors -->
@include('errors.messages')

<!-- Form -->
<x-form wire:submit.prevent="update" method="put" class="space-y-6">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Light Mode Logo -->
        <div>
            <h4 class="text-lg font-medium text-gray-200 mb-2">🌞 Light Mode Logo</h4>

            <!-- Upload Box -->
            <div
                class="flex items-center justify-center px-6 py-6 border-2 border-dashed border-gray-700 rounded-lg bg-gray-800">
                <div class="text-center space-y-2">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path
                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <div class="text-sm text-gray-300">
                        <label for="applicationLogo" class="cursor-pointer font-medium text-indigo-500 hover:underline">
                            Upload a file
                            <input wire:model="applicationLogo" id="applicationLogo" name="applicationLogo"
                                type="file" class="sr-only">
                        </label>
                    </div>
                    <p class="text-xs text-gray-500">PNG, JPG, or GIF (Max 2MB)</p>
                </div>
            </div>

            <!-- Preview -->
            <div class="mt-4 bg-gray-800 p-3 rounded-md text-center">
                @if ($applicationLogo)
                    <p class="text-sm text-gray-400 mb-2">Preview:</p>
                    <img src="{{ $applicationLogo->temporaryUrl() }}" class="mx-auto max-h-40 rounded-md">
                @elseif(storage_exists($existingApplicationLogo))
                    <img src="{{ storage_url($existingApplicationLogo) }}" class="mx-auto max-h-40 rounded-md">
                @else
                    <p class="text-sm text-gray-500 italic">No logo uploaded yet.</p>
                @endif
            </div>
        </div>

        <!-- Dark Mode Logo -->
        <div>
            <h4 class="text-lg font-medium text-gray-200 mb-2">🌙 Dark Mode Logo</h4>

            <!-- Upload Box -->
            <div
                class="flex items-center justify-center px-6 py-6 border-2 border-dashed border-gray-700 rounded-lg bg-gray-800">
                <div class="text-center space-y-2">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                        viewBox="0 0 48 48">
                        <path
                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <div class="text-sm text-gray-300">
                        <label for="applicationLogoDark"
                            class="cursor-pointer font-medium text-indigo-500 hover:underline">
                            Upload a file
                            <input wire:model="applicationLogoDark" id="applicationLogoDark" name="applicationLogoDark"
                                type="file" class="sr-only">
                        </label>
                    </div>
                    <p class="text-xs text-gray-500">PNG, JPG, or GIF (Max 2MB)</p>
                </div>
            </div>

            <!-- Preview -->
            <div class="mt-4 bg-gray-800 p-3 rounded-md text-center">
                @if ($applicationLogoDark)
                    <p class="text-sm text-gray-400 mb-2">Preview:</p>
                    <img src="{{ $applicationLogoDark->temporaryUrl() }}" class="mx-auto max-h-40 rounded-md">
                @elseif(storage_exists($existingApplicationLogoDark))
                    <img src="{{ storage_url($existingApplicationLogoDark) }}" class="mx-auto max-h-40 rounded-md">
                @else
                    <p class="text-sm text-gray-500 italic">No logo uploaded yet.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Submit -->
    <div>
        <x-button class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2 rounded-md">
            Save Logos
        </x-button>
    </div>

</x-form>
