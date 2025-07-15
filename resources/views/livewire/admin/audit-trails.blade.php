@section('title', 'Audit Trail')

<div class="dark bg-gray-950 min-h-screen text-gray-100 px-4 py-6 space-y-6">

    <!-- Title -->
    <div class="text-center">
        <h1 class="text-3xl font-bold text-white">📊 Audit Trails</h1>
        <p class="text-sm text-gray-400 mt-1">Track user actions and system logs</p>
    </div>

    <!-- Search Input -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2">
            <x-form.input type="search" id="title" name="title" wire:model="title" label="none"
                placeholder="🔍 Search Actions" class="bg-gray-800 text-white border-gray-700">
                {{ old('title', request('title')) }}
            </x-form.input>
        </div>
    </div>

    <!-- Advanced Filter Toggle -->
    <div x-data="{ isOpen: @json($openFilter || request('openFilter')) }" class="space-y-4">

        <div class="flex gap-3">
            <!-- Toggle -->
            <button type="button" @click="isOpen = !isOpen"
                class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium bg-gray-800 hover:bg-gray-700 text-gray-200 rounded-md transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Advanced Search
            </button>

            <!-- Reset -->
            <button type="button" wire:click="resetFilters" @click="isOpen = false"
                class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium bg-gray-800 hover:bg-gray-700 text-gray-200 rounded-md transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Reset
            </button>
        </div>

        <!-- Filter Panel -->
        <div x-show="isOpen" x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" class="bg-gray-800 p-4 rounded-md space-y-4">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- User Select -->
                <x-form.select id="user_id" name="user_id" label="User" wire:model="user_id"
                    class="bg-gray-900 text-white border-gray-700">
                    <option value="">All</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </x-form.select>

                <!-- Section Select -->
                <x-form.select id="section" name="section" label="Section" wire:model="section"
                    class="bg-gray-900 text-white border-gray-700">
                    <option value="">All</option>
                    @foreach ($sections as $section)
                        <option value="{{ $section }}">{{ $section }}</option>
                    @endforeach
                </x-form.select>

                <!-- Type Select -->
                <x-form.select id="type" name="type" label="Type" wire:model="type"
                    class="bg-gray-900 text-white border-gray-700">
                    <option value="">All</option>
                    @foreach ($types as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </x-form.select>

                <!-- Date Range -->
                <x-form.daterange id="created_at" name="created_at" label="Date Range" wire:model.lazy="created_at"
                    class="bg-gray-900 text-white border-gray-700">
                    {{ old('created_at', request('created_at')) }}
                </x-form.daterange>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto bg-gray-900 rounded-lg shadow mt-4">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-800 text-gray-300 text-sm uppercase">
                <tr>
                    <th class="px-4 py-2 text-left">
                        <a href="#" wire:click.prevent="sortBy('user_id')" class="hover:underline">User</a>
                    </th>
                    <th class="px-4 py-2 text-left">
                        <a href="#" wire:click.prevent="sortBy('title')" class="hover:underline">Action</a>
                    </th>
                    <th class="px-4 py-2 text-left">
                        <a href="#" wire:click.prevent="sortBy('section')" class="hover:underline">Section</a>
                    </th>
                    <th class="px-4 py-2 text-left">
                        <a href="#" wire:click.prevent="sortBy('type')" class="hover:underline">Type</a>
                    </th>
                    <th class="px-4 py-2 text-left">
                        <a href="#" wire:click.prevent="sortBy('created_at')" class="hover:underline">Created
                            At</a>
                    </th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-800">
                @forelse ($this->userlogs() as $log)
                    <tr class="hover:bg-gray-800 transition">
                        <td class="px-4 py-2">{{ $log->user->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $log->title }}</td>
                        <td class="px-4 py-2">{{ $log->section }}</td>
                        <td class="px-4 py-2">{{ $log->type }}</td>
                        <td class="px-4 py-2">{{ $log->created_at ? $log->created_at->format('jS M Y H:i:s') : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">No logs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $this->userlogs()->links('vendor.pagination.tailwind') }}
    </div>

</div>
