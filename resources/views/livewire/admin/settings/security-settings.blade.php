<!-- Info Banner -->
<div class="bg-indigo-800 text-sm text-indigo-100 p-4 rounded-md">
    When a user is set to "Office Login Only", only the IPs listed below will be allowed access.
</div>

<!-- Form -->
<x-form wire:submit.prevent="update" method="put" class="space-y-4">

    <!-- Current IP -->
    <div class="text-sm text-gray-400">
        Your current IP address is: <span class="font-medium text-gray-100">{{ request()->ip() }}</span>
    </div>

    <!-- IP Rows -->
    <div class="space-y-4">
        @foreach ($ips as $index => $row)
            @error("ips.$index.ip")
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror

            <div
                class="bg-gray-800 p-4 rounded-lg shadow-inner grid grid-cols-1 md:grid-cols-[2fr_3fr_auto] gap-4 items-center">
                <!-- IP Input -->
                <x-form.input wire:model="ips.{{ $index }}.ip" label="IP Address"
                    class="bg-gray-900 border-gray-700 text-white" />

                <!-- Comment Input -->
                <x-form.input wire:model="ips.{{ $index }}.comment" label="Comment"
                    class="bg-gray-900 border-gray-700 text-white" />

                <!-- Remove Button -->
                <button type="button" wire:click="remove({{ $index }})"
                    class="text-red-500 hover:text-red-400 text-sm font-semibold rounded px-3 py-2 transition">
                    ✖
                </button>
            </div>
        @endforeach
    </div>

    <!-- Actions -->
    <div class="flex flex-wrap justify-between items-center gap-3 mt-6">
        <x-button color="indigo" wire:click="add" type="button">
            ➕ Add Row
        </x-button>

        <x-button class="bg-green-600 hover:bg-green-500 text-white">
            💾 Save
        </x-button>
    </div>
</x-form>

@include('errors.messages')
