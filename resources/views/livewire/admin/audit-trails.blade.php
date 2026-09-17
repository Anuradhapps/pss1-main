@section('title', 'Audit Trail')

<div class="space-y-6">
    <div class="flex flex-col gap-2 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-colors dark:border-slate-800 dark:bg-slate-900">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-300">
                <i class="fas fa-history text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Audit Trails</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Track user actions and system logs</p>
            </div>
        </div>
    </div>

    <div x-data="{ isOpen: @json($openFilter || request('openFilter')) }" class="space-y-4">
        <div class="flex flex-wrap gap-3">
            <button type="button" @click="isOpen = !isOpen"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
                <i class="fas fa-search text-xs text-blue-500"></i>
                <span>Advanced Search</span>
            </button>

            <button type="button" wire:click="resetFilters" @click="isOpen = false"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
                <i class="fas fa-rotate-left text-xs text-slate-400"></i>
                <span>Reset</span>
            </button>
        </div>

        <div x-show="isOpen" x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-2" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900" style="display:none;">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                <x-form.select id="user_id" name="user_id" label="User" wire:model="user_id">
                    <option value="">All</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </x-form.select>

                <x-form.select id="section" name="section" label="Section" wire:model="section">
                    <option value="">All</option>
                    @foreach ($sections as $section)
                        <option value="{{ $section }}">{{ $section }}</option>
                    @endforeach
                </x-form.select>

                <x-form.select id="type" name="type" label="Type" wire:model="type">
                    <option value="">All</option>
                    @foreach ($types as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </x-form.select>

                <x-form.daterange id="created_at" name="created_at" label="Date Range" wire:model.lazy="created_at">
                    {{ old('created_at', request('created_at')) }}
                </x-form.daterange>
            </div>
        </div>
    </div>

    @php($logs = $this->userlogs())
    @if ($logs->isEmpty())
        <x-data.empty-state icon="fas fa-clock-rotate-left" title="No Logs Found" description="Try broadening the filters or clearing the current search." />
    @else
        <x-data.table>
            <x-slot name="header">
                <th scope="col" class="px-6 py-4 font-bold"><button type="button" wire:click.prevent="sortBy('user_id')" class="hover:text-blue-600 dark:hover:text-blue-400">User</button></th>
                <th scope="col" class="px-6 py-4 font-bold"><button type="button" wire:click.prevent="sortBy('title')" class="hover:text-blue-600 dark:hover:text-blue-400">Action</button></th>
                <th scope="col" class="px-6 py-4 font-bold hidden md:table-cell"><button type="button" wire:click.prevent="sortBy('section')" class="hover:text-blue-600 dark:hover:text-blue-400">Section</button></th>
                <th scope="col" class="px-6 py-4 font-bold hidden lg:table-cell"><button type="button" wire:click.prevent="sortBy('type')" class="hover:text-blue-600 dark:hover:text-blue-400">Type</button></th>
                <th scope="col" class="px-6 py-4 font-bold hidden xl:table-cell"><button type="button" wire:click.prevent="sortBy('created_at')" class="hover:text-blue-600 dark:hover:text-blue-400">Created At</button></th>
            </x-slot>

            @forelse ($logs as $log)
                <tr class="transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/50">
                    <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">{{ $log->user->name ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">{{ $log->title }}</td>
                    <td class="hidden px-6 py-4 text-sm text-slate-600 dark:text-slate-300 md:table-cell">{{ $log->section }}</td>
                    <td class="hidden px-6 py-4 text-sm text-slate-600 dark:text-slate-300 lg:table-cell">{{ $log->type }}</td>
                    <td class="hidden px-6 py-4 text-sm text-slate-600 dark:text-slate-300 xl:table-cell">{{ $log->created_at ? $log->created_at->format('jS M Y H:i:s') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-6 text-center text-slate-500 dark:text-slate-400">No logs found.</td>
                </tr>
            @endforelse

            <x-slot name="footer">
                <div class="w-full">{{ $logs->links() }}</div>
            </x-slot>
        </x-data.table>
    @endif
</div>
