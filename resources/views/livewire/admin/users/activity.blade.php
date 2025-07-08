<div>
    <div class="p-6 mx-auto bg-gray-600 shadow-lg max-w-7xl rounded-xl">

        <h1 class="mb-6 text-3xl font-semibold text-white">Activity</h1>


        <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" class="p-5 mb-6 bg-gray-800 rounded-md" wire:ignore.self>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">



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
        <div class="mb-4 text-sm text-gray-100">
            Page {{ $this->userlogs()->currentPage() }} of {{ $this->userlogs()->lastPage() }}
        </div>


        <div class="overflow-x-auto border border-gray-700 rounded-md shadow-md">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="px-4 py-3 text-xs font-semibold text-left text-gray-300 uppercase cursor-pointer hover:text-emerald-400"
                            wire:click.prevent="sortBy('title')">Action</th>

                        <th class="px-4 py-3 text-xs font-semibold text-left text-gray-300 uppercase cursor-pointer hover:text-emerald-400"
                            wire:click.prevent="sortBy('type')">Type</th>

                        <th class="px-4 py-3 text-xs font-semibold text-left text-gray-300 uppercase cursor-pointer hover:text-emerald-400"
                            wire:click.prevent="sortBy('created_at')">Created At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700 ">
                    @forelse ($this->userlogs() as $log)
                        <tr class="transition duration-150 hover:bg-green-500">
                            <td class="px-4 py-3 text-gray-900 whitespace-nowrap">{{ $log->title }}</td>
                            <td class="px-4 py-3 text-gray-900 whitespace-nowrap">{{ $log->type }}</td>
                            <td class="px-4 py-3 text-gray-900 whitespace-nowrap" title="{{ $log->created_at }}">
                                {{ $log->created_at ? date('jS M Y H:i:s', strtotime($log->created_at)) : '' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-900">
                                No activity logs found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $this->userlogs()->links('pagination::tailwind-small') }}

        </div>

    </div>
</div>
