<!-- Errors -->
@include('errors.messages')

<!-- Form -->
<x-form wire:submit.prevent="update" method="put" class="space-y-6">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Light Mode Logo -->
        <div
            class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-colors dark:border-slate-700 dark:bg-slate-900">
            <h4 class="mb-2 text-lg font-medium text-slate-800 dark:text-slate-100">🌞 Light Mode Logo</h4>

            <div
                class="flex items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 px-6 py-6 transition-colors dark:border-slate-600 dark:bg-slate-800/70">
                <div class="text-center space-y-2">
                    <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none"
                        viewBox="0 0 48 48">
                        <path
                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <div class="text-sm text-slate-700 dark:text-slate-300">
                        <label for="applicationLogo" class="cursor-pointer font-medium text-indigo-500 hover:underline">
                            Upload a file
                            <input wire:model="applicationLogo" id="applicationLogo" name="applicationLogo"
                                type="file" class="sr-only">
                        </label>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">PNG, JPG, or GIF (Max 2MB)</p>
                </div>
            </div>

            <div
                class="mt-4 rounded-xl border border-slate-200 bg-slate-50 p-3 text-center transition-colors dark:border-slate-700 dark:bg-slate-800/70">
                @if ($applicationLogo)
                    <p class="mb-2 text-sm text-slate-600 dark:text-slate-300">Preview:</p>
                    <img src="{{ $applicationLogo->temporaryUrl() }}" class="mx-auto max-h-40 rounded-md">
                @elseif(storage_exists($existingApplicationLogo))
                    <img src="{{ storage_url($existingApplicationLogo) }}" class="mx-auto max-h-40 rounded-md">
                @else
                    <p class="text-sm italic text-slate-500 dark:text-slate-400">No logo uploaded yet.</p>
                @endif
            </div>
        </div>

        <div
            class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-colors dark:border-slate-700 dark:bg-slate-900">
            <h4 class="mb-2 text-lg font-medium text-slate-800 dark:text-slate-100">🌙 Dark Mode Logo</h4>

            <div
                class="flex items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 px-6 py-6 transition-colors dark:border-slate-600 dark:bg-slate-800/70">
                <div class="text-center space-y-2">
                    <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none"
                        viewBox="0 0 48 48">
                        <path
                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <div class="text-sm text-slate-700 dark:text-slate-300">
                        <label for="applicationLogoDark"
                            class="cursor-pointer font-medium text-indigo-500 hover:underline">
                            Upload a file
                            <input wire:model="applicationLogoDark" id="applicationLogoDark" name="applicationLogoDark"
                                type="file" class="sr-only">
                        </label>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">PNG, JPG, or GIF (Max 2MB)</p>
                </div>
            </div>

            <div
                class="mt-4 rounded-xl border border-slate-200 bg-slate-50 p-3 text-center transition-colors dark:border-slate-700 dark:bg-slate-800/70">
                @if ($applicationLogoDark)
                    <p class="mb-2 text-sm text-slate-600 dark:text-slate-300">Preview:</p>
                    <img src="{{ $applicationLogoDark->temporaryUrl() }}" class="mx-auto max-h-40 rounded-md">
                @elseif(storage_exists($existingApplicationLogoDark))
                    <img src="{{ storage_url($existingApplicationLogoDark) }}" class="mx-auto max-h-40 rounded-md">
                @else
                    <p class="text-sm italic text-slate-500 dark:text-slate-400">No logo uploaded yet.</p>
                @endif
            </div>
        </div>
    </div>

    <div>
        <x-button class="rounded-md bg-indigo-600 px-6 py-2 text-white hover:bg-indigo-500">
            Save Logos
        </x-button>
    </div>

</x-form>
