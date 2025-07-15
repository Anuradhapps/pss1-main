@section('title', 'Edit Role')



<div class="flex flex-wrap justify-between items-center mb-6">
    <a href="{{ route('admin.settings.roles.index') }}" class="text-indigo-400 hover:text-indigo-600 transition">
        &larr; Roles
    </a>
    <div class="text-sm text-gray-400">
        <span class="text-red-600">*</span> required fields
    </div>
</div>

<x-form wire:submit.prevent="update" method="put" class="bg-gray-900 rounded-lg shadow-lg p-6">

    <div class="mb-6 md:max-w-md">
        @if ($role?->label == 'Admin')
            <x-form.input wire:model="label" label="Role" name="label" disabled />
        @else
            <x-form.input wire:model="label" label="Role" name="label" required />
        @endif
    </div>

    @if (true)
        <div class="max-w-full overflow-x-auto rounded-md border border-gray-700 p-4 bg-gray-800 shadow-inner">
            @foreach ($modules as $module)
                <h3 class="text-lg font-semibold mb-2 text-indigo-400 border-b border-indigo-600 pb-1">
                    {{ $module }}</h3>
                <table class="min-w-full mb-6 text-gray-300 table-auto">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th class="text-left px-4 py-2">Permission</th>
                            <th class="text-center px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (\App\Models\Roles\Permission::where('module', $module)->orderby('name')->get() as $perm)
                            <tr class="hover:bg-gray-700 transition">
                                <td class="px-4 py-2">{{ $perm->label }}</td>
                                <td class="px-4 py-2 text-center">
                                    <input type="checkbox" wire:model="permission" value="{{ $perm->id }}"
                                        class="w-5 h-5 text-indigo-500 rounded focus:ring-indigo-400" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        </div>
    @endif

    <div class="mt-6">
        <x-form.submit
            class="w-full md:w-auto px-6 py-3 text-lg font-semibold bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-500 focus:outline-none rounded-md transition">
            Update Role
        </x-form.submit>
    </div>

</x-form>
