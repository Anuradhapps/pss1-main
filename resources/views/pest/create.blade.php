<x-app-layout>
    <div class="flex justify-between">
        <h1 class="text-2xl font-bold mb-4 text-red-900">Create</h1>
        <a href="{{ route('pest.index') }}" class="btn btn-primary ">Back</a>
    </div>
    {{-- <x-form method="POST" action="{{ route('admin.collector.update', $collector) }}"> --}}
    <x-form method="POST" action="{{ route('pest.store') }}">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2 sm:col-span-1">
                <x-form.input name="name" label="Pest Name :"></x-form.input>
            </div>
            <div class="col-span-2 sm:col-span-1">
                <x-form.submit>Add</x-form.submit>
            </div>
        </div>
    </x-form>

</x-app-layout>
