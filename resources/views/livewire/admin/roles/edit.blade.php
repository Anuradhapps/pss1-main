@section('title', 'Edit Role')




<div class="mb-6 flex flex-wrap items-center justify-between">
    <a href="{{ route('admin.settings.roles.index') }}" class="text-indigo-500 transition hover:text-indigo-400">
        &larr; Roles
    </a>
    <div class="text-sm text-slate-500 dark:text-slate-400">
        <span class="text-red-600">*</span> required fields
    </div>
</div>

<div
    class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-colors dark:border-slate-800 dark:bg-slate-900">
    <x-form wire:submit.prevent="update" method="put" class="space-y-6">
        <div class="mb-6 md:max-w-md">
            @if ($role?->label == 'Admin')
                <x-form.input wire:model="label" label="Role" name="label" disabled />
            @else
                <x-form.input wire:model="label" label="Role" name="label" required />
            @endif
        </div>

        <div
            class="space-y-6 rounded-2xl border border-slate-200 bg-slate-50 p-4 shadow-inner transition-colors dark:border-slate-800 dark:bg-slate-950/40">
            @foreach ($modules as $module)
                <div class="space-y-3">
                    <h3
                        class="border-b border-slate-200 pb-2 text-lg font-semibold text-indigo-600 dark:border-slate-800 dark:text-indigo-400">
                        {{ $module }}
                    </h3>
                    <div
                        class="overflow-hidden rounded-xl border border-slate-200 bg-white transition-colors dark:border-slate-800 dark:bg-slate-900">
                        <table class="min-w-full text-sm text-slate-700 dark:text-slate-300">
                            <thead
                                class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500 dark:bg-slate-800/60 dark:text-slate-400">
                                <tr>
                                    <th class="px-4 py-3 text-left">Permission</th>
                                    <th class="px-4 py-3 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach (\App\Models\Roles\Permission::where('module', $module)->orderby('name')->get() as $perm)
                                    <tr class="transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                        <td class="px-4 py-3">{{ $perm->label }}</td>
                                        <td class="px-4 py-3 text-center">
                                            <input type="checkbox" wire:model="permission" value="{{ $perm->id }}"
                                                class="h-5 w-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 dark:border-slate-600 dark:bg-slate-900" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            <x-form.submit
                class="w-full rounded-xl bg-indigo-600 px-6 py-3 text-lg font-semibold transition hover:bg-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-500/30 md:w-auto">
                Update Role
            </x-form.submit>
        </div>
    </x-form>
</div>
