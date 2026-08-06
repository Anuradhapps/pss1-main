<x-form wire:submit.prevent="update" method="put" class="space-y-6">
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <x-form.input wire:model="siteName" name="siteName" label="Site Name" />
    </div>

    <div>
        <x-button class="rounded-md bg-indigo-600 px-6 py-2 text-white transition hover:bg-indigo-500">
            Update Application Settings
        </x-button>
    </div>
</x-form>

@include('errors.messages')
