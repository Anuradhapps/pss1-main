@section('title', 'Collector')

<div class="">
    <!-- Header -->
    <x-headings.topHeading title="Collectors" icon="fa-solid fa-chalkboard-user"
        class="bg-gradient-to-r from-green-800 to-green-600 shadow-md" />
    <div class="m-2 space-y-2">
        <!-- Search -->

        <div class="flex gap-4 justify-end  items-center">
            <div>
                <i class="fas fa-search text-gray-400 text-2xl"></i>
            </div>
            <div class="w-96">
                <x-form.input type="search" id="roles" name="query" wire:model="query" label="none"
                    placeholder="Search by Name, District, ASC or AI Range">
                    {{ old('query', request('query')) }}
                </x-form.input>
            </div>
        </div>


        <!-- Table -->
        <div class="overflow-x-auto bg-gray-900 border border-gray-800 text-white">
            <table class="min-w-full text-sm divide-y divide-gray-700">
                <thead class="bg-gray-800 text-xs uppercase tracking-wider">
                    <tr class="bg-pink-900">
                        <th>
                            <a href="#" wire:click.prevent="sortBy('name')"
                                class="flex items-center justify-between">
                                <span>Name & Count</span>
                                <span class="text-gray-300">&#9650;&#9660;</span>
                            </a>
                        </th>
                        <th>
                            <a href="#" wire:click.prevent="sortBy('districts.name')"
                                class="flex items-center justify-between">
                                <span>District</span>
                                <span class="text-gray-300">&#9650;&#9660;</span>
                            </a>
                        </th>
                        <th>
                            <a href="#" wire:click.prevent="sortBy('as_centers.name')"
                                class="flex items-center justify-between">
                                <span>ASC</span>
                                <span class="text-gray-300">&#9650;&#9660;</span>
                            </a>
                        </th>
                        <th>
                            <a href="#" wire:click.prevent="sortBy('ai_ranges.name')"
                                class="flex items-center justify-between">
                                <span>AI Range</span>
                                <span class="text-gray-300">&#9650;&#9660;</span>
                            </a>
                        </th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-800">
                    @foreach ($this->collectors() as $collector)
                        <tr class="hover:bg-gray-800 transition bg-emerald-900">
                            <td class="p-0 ps-2 pe-2 py-1">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <div class="font-semibold">{{ $collector->name }}</div>
                                        <div class="text-xs text-gray-400 italic">{{ $collector->regionName }} -
                                            {{ $collector->riceSeasonName }}</div>
                                    </div>
                                    <div
                                        class="ml-2 w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold
                                    {{ $collector->commonDataCollect->count() == 0 ? 'bg-red-600' : ($collector->commonDataCollect->count() >= 7 ? 'bg-green-600' : 'bg-yellow-500') }}">
                                        {{ $collector->commonDataCollect->count() }}
                                    </div>
                                </div>
                            </td>

                            <td class="p-0 ps-2">{{ $collector->dname }}</td>
                            <td class="p-0 ps-2">{{ $collector->asname }}</td>
                            <td class="p-0 ps-2">{{ $collector->ainame }}</td>

                            <td class="text-center p-0 ps-2 space-x-1 whitespace-nowrap">
                                <!-- Collector Edit -->
                                <a href="{{ route('admin.collector.edit', $collector->id) }}" title="Edit Collector"
                                    class="hover:text-orange-700 text-orange-400 transition">
                                    <i class="fas fa-user-edit text-xl"></i>
                                </a>

                                <!-- User Edit -->
                                <a href="{{ route('admin.users.edit', ['user' => $collector->user->id]) }}"
                                    title="Edit User" class="hover:text-green-700 text-green-400 transition">
                                    <i class="fas fa-user-cog text-xl"></i>
                                </a>

                                <!-- Pest Data -->
                                @php $hasCommonData = $collector->commonDataCollect->count() > 0; @endphp
                                <a href="{{ $hasCommonData ? route('chart.ai.show', [$collector->id, 'yes']) : 'javascript:void(0);' }}"
                                    title="{{ $hasCommonData ? 'View Pest Data' : 'Common Data Required' }}"
                                    class="{{ $hasCommonData ? 'text-blue-400 hover:text-blue-700' : 'text-gray-500 cursor-not-allowed' }}">
                                    <i class="fas fa-bug text-xl"></i>
                                </a>

                                <!-- Delete -->
                                <form action="{{ route('admin.collector.destroy', $collector->id) }}" method="POST"
                                    class="inline-block" onsubmit="return confirmDelete(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Delete Collector"
                                        class="text-red-500 hover:text-red-700 transition">
                                        <i class="fas fa-trash-alt text-xl"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="p-3 bg-gray-800 border-t border-gray-700">
                {{ $this->collectors()->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Confirm delete script -->
<script>
    function confirmDelete(event) {
        if (!confirm('Are you sure you want to delete this collector?')) {
            event.preventDefault();
        }
    }
</script>
