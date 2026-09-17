<div>
    <div class="p-6 h-full flex flex-col">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <i class="fas fa-history text-primary text-xl"></i> Activity Logs
            </h2>
            <div class="text-sm text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-800/50 px-3 py-1 rounded-lg border border-slate-200 dark:border-slate-700">
                Page {{ $this->userlogs()->currentPage() }} of {{ $this->userlogs()->lastPage() }}
            </div>
        </div>

        <!-- Filter Panel (If any) -->
        <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" class="p-4 mb-6 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl" wire:ignore.self>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">

                <x-form.select id="type" name="type" label="Type" wire:model="type">
                    <option value="">Select Type</option>
                    @foreach ($types as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </x-form.select>

                <x-form.daterange id="created_at" name="created_at" label="Created Date Range" wire:model.lazy="created_at">
                    {{ old('created_at', request('created_at')) }}
                </x-form.daterange>

            </div>
        </div>

        <!-- Data Table -->
        @if($this->userlogs()->isEmpty())
            <div class="mt-4">
                <x-data.empty-state 
                    icon="fas fa-clipboard-list" 
                    title="No Activity Logs" 
                    description="We couldn't find any activity logs for this user." 
                />
            </div>
        @else
            <x-data.table>
                <x-slot name="header">
                    <th scope="col" class="px-6 py-4 font-bold text-left cursor-pointer hover:text-primary transition-colors" wire:click.prevent="sortBy('title')">
                        Action <i class="fas fa-sort text-[10px] opacity-50 ml-1"></i>
                    </th>
                    <th scope="col" class="px-6 py-4 font-bold text-left cursor-pointer hover:text-primary transition-colors" wire:click.prevent="sortBy('type')">
                        Type <i class="fas fa-sort text-[10px] opacity-50 ml-1"></i>
                    </th>
                    <th scope="col" class="px-6 py-4 font-bold text-left cursor-pointer hover:text-primary transition-colors" wire:click.prevent="sortBy('created_at')">
                        Created At <i class="fas fa-sort text-[10px] opacity-50 ml-1"></i>
                    </th>
                </x-slot>

                @foreach ($this->userlogs() as $log)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group">
                        <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">{{ $log->title }}</td>
                        <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                            <span class="px-2.5 py-1 text-[11px] font-semibold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-md border border-slate-200 dark:border-slate-700">
                                {{ $log->type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400" title="{{ $log->created_at }}">
                            <div class="flex items-center gap-2">
                                <i class="far fa-calendar-alt text-slate-400"></i>
                                {{ $log->created_at ? date('jS M Y H:i', strtotime($log->created_at)) : '' }}
                            </div>
                        </td>
                    </tr>
                @endforeach
                
                <x-slot name="footer">
                    <div class="w-full">
                        {{ $this->userlogs()->links() }}
                    </div>
                </x-slot>
            </x-data.table>
        @endif

    </div>
</div>
