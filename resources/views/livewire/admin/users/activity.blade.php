<div>
    <div class="p-6 mx-auto bg-gray-600 shadow-lg max-w-7xl rounded-xl">

        <h1 class="mb-6 text-3xl font-semibold text-white">Activity</h1>

        <div class="flex flex-col gap-4 mb-6 md:flex-row md:items-center md:justify-between">

            <div class="flex-1 max-w-lg">
                <x-form.input type="search" id="title" name="title" wire:model.debounce.300ms="title"
                    label="Search Actions" placeholder="Search Actions"
                    class="text-gray-100 placeholder-gray-400 bg-gray-800 border-gray-700 focus:border-emerald-400 focus:ring-emerald-400"
                    label-class="sr-only" />
            </div>

            <div class="flex flex-wrap gap-3">

                <button type="button" @click="isOpen = !isOpen"
                    class="inline-flex items-center px-3 py-1.5 bg-gray-800 hover:bg-gray-700 text-gray-100 rounded-md text-sm font-medium transition focus:outline-none focus:ring-2 focus:ring-emerald-400"
                    x-data="{ isOpen: @if ($openFilter || request('openFilter')) true @else false @endif }">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1 text-gray-100" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Advanced Search
                </button>

                <button type="button" wire:click="resetFilters" @click="isOpen = false"
                    class="inline-flex items-center px-3 py-1.5 bg-gray-800 hover:bg-gray-700 text-gray-100 rounded-md text-sm font-medium transition focus:outline-none focus:ring-2 focus:ring-emerald-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1 text-gray-100" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Reset Filters
                </button>

            </div>
        </div>

        <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" class="p-5 mb-6 bg-gray-800 rounded-md" wire:ignore.self>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">

                <x-form.select id="section" name="section" label="Section" wire:model="section"
                    class="text-gray-100 bg-gray-900 border-gray-700 focus:border-emerald-400 focus:ring-emerald-400"
                    label-class="text-gray-300">
                    <option value="" class="text-gray-100 bg-gray-900">Select Section</option>
                    @foreach ($sections as $section)
                        <option value="{{ $section }}" class="text-gray-100 bg-gray-900">{{ $section }}
                        </option>
                    @endforeach
                </x-form.select>

                <x-form.select id="type" name="type" label="Type" wire:model="type"
                    class="text-gray-100 bg-gray-900 border-gray-700 focus:border-emerald-400 focus:ring-emerald-400"
                    label-class="text-gray-300">
                    <option value="" class="text-gray-100 bg-gray-900">Select Type</option>
                    @foreach ($types as $type)
                        <option value="{{ $type }}" class="text-gray-100 bg-gray-900">{{ $type }}
                        </option>
                    @endforeach
                </x-form.select>

                <x-form.daterange id="created_at" name="created_at" label="Created Date Range"
                    wire:model.lazy="created_at"
                    class="text-gray-100 bg-gray-900 border-gray-700 focus:border-emerald-400 focus:ring-emerald-400"
                    label-class="text-gray-300">
                    {{ old('created_at', request('created_at')) }}
                </x-form.daterange>

            </div>
        </div>

        <div class="overflow-x-auto border border-gray-700 rounded-md shadow-md">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="px-4 py-3 text-xs font-semibold text-left text-gray-300 uppercase cursor-pointer hover:text-emerald-400"
                            wire:click.prevent="sortBy('title')">Action</th>
                        <th class="px-4 py-3 text-xs font-semibold text-left text-gray-300 uppercase cursor-pointer hover:text-emerald-400"
                            wire:click.prevent="sortBy('section')">Section</th>
                        <th class="px-4 py-3 text-xs font-semibold text-left text-gray-300 uppercase cursor-pointer hover:text-emerald-400"
                            wire:click.prevent="sortBy('type')">Type</th>
                        <th
                            class="px-4 py-3 text-xs font-semibold text-left text-gray-300 uppercase cursor-pointer hover:text-emerald-400">
                            View</th>
                        <th class="px-4 py-3 text-xs font-semibold text-left text-gray-300 uppercase cursor-pointer hover:text-emerald-400"
                            wire:click.prevent="sortBy('created_at')">Created At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700 ">
                    @forelse ($this->userlogs() as $log)
                        <tr class="transition duration-150 hover:bg-gray-700">
                            <td class="px-4 py-3 text-gray-100 whitespace-nowrap">{{ $log->title }}</td>
                            <td class="px-4 py-3 text-gray-400 whitespace-nowrap">{{ $log->section }}</td>
                            <td class="px-4 py-3 text-gray-400 whitespace-nowrap">{{ $log->type }}</td>
                            <td class="px-4 py-3 text-emerald-400 whitespace-nowrap">
                                @if ($log->link)
                                    <a href="{{ url($log->link) }}" target="_blank" rel="noopener noreferrer"
                                        class="hover:underline">View</a>
                                @else
                                    &mdash;
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-400 whitespace-nowrap" title="{{ $log->created_at }}">
                                {{ $log->created_at ? date('jS M Y H:i:s', strtotime($log->created_at)) : '' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                No activity logs found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $this->userlogs()->links() }}
        </div>

    </div>
</div>
