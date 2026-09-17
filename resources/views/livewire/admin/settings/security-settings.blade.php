<!-- Info Banner -->
<div class="rounded-2xl border border-indigo-200 bg-indigo-50 p-4 text-sm text-indigo-900 dark:border-indigo-500/20 dark:bg-indigo-500/10 dark:text-indigo-100">
    When a user is set to "Office Login Only", only the IPs listed below will be allowed access.
</div>

<!-- Form -->
<x-form wire:submit.prevent="update" method="put" class="space-y-4">

    <!-- Current IP -->
    <div class="text-sm text-slate-500 dark:text-slate-400">
        Your current IP address is: <span class="font-medium text-slate-900 dark:text-white">{{ request()->ip() }}</span>
    </div>

    <!-- IP Rows -->
    <div class="space-y-4">
        @foreach ($ips as $index => $row)
            @error("ips.$index.ip")
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror

            <div class="grid grid-cols-1 items-center gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 md:grid-cols-[2fr_3fr_auto]">
                <!-- IP Input -->
                <x-form.input wire:model="ips.{{ $index }}.ip" label="IP Address" />

                <!-- Comment Input -->
                <x-form.input wire:model="ips.{{ $index }}.comment" label="Comment" />

                <!-- Remove Button -->
                <button type="button" wire:click="remove({{ $index }})"
                    class="rounded-lg px-3 py-2 text-sm font-semibold text-rose-600 transition hover:bg-rose-50 hover:text-rose-500 dark:hover:bg-rose-500/10">
                    Remove
                </button>
            </div>
        @endforeach
    </div>

    <!-- Actions -->
    <div class="flex flex-wrap justify-between items-center gap-3 mt-6">
            <x-button color="indigo" wire:click="add" type="button">
            Add Row
        </x-button>

        <x-button class="bg-green-600 hover:bg-green-500 text-white">
            Save
        </x-button>
    </div>
</x-form>

@include('errors.messages')
