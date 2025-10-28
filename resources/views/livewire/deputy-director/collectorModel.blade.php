@if ($showModal && $selectedCollector)
    <div class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50"
        wire:key="modal-{{ $selectedCollector->id }}">

        <div
            class="bg-gray-800 text-white shadow-2xl w-full max-w-2xl m-4 sm:mx-auto p-6 max-h-screen overflow-y-auto border border-gray-700">

            {{-- Header --}}
            <h2
                class="text-2xl font-semibold text-green-400 text-center uppercase tracking-wider mb-6 border-b border-gray-600 pb-3">
                Collector Details
            </h2>

            {{-- Collector Info --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-300 mb-6">
                <div><span class="text-white font-medium">Name:</span> {{ $selectedCollector->user->name ?? 'N/A' }}
                </div>
                <div><span class="text-white font-medium">Email:</span> {{ $selectedCollector->user->email ?? 'N/A' }}
                </div>
                <div><span class="text-white font-medium">AI Range:</span>
                    {{ $selectedCollector->getAiRange->name ?? 'N/A' }}</div>
                <div><span class="text-white font-medium">Season:</span>
                    {{ $selectedCollector->riceSeason->name ?? 'N/A' }}</div>
                <div><span class="text-white font-medium">Phone Number:</span>
                    {{ $selectedCollector->phone_no ?? 'N/A' }}</div>
                <div><span class="text-white font-medium">Total Data Entries:</span>
                    {{ $selectedCollector->commonDataCollect->count() }}</div>
            </div>

            {{-- Data Collection Dates --}}
            <div>
                @if ($selectedCollector->commonDataCollect->isEmpty())
                    <div
                        class="flex items-center gap-3 bg-red-700 border border-red-500 text-white px-4 py-3 text-sm font-medium">
                        <svg class="h-5 w-5 text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4m0 4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                        </svg>
                        <span>No data has been submitted for this season.</span>
                    </div>
                @else
                    <h3
                        class="text-lg font-semibold text-green-300 mb-3 border-b border-green-500 pb-1 uppercase tracking-wide">
                        📅 Data Collection Timeline
                    </h3>
                    <ul class="space-y-3">
                        @foreach ($selectedCollector->commonDataCollect as $entry)
                            <li class="bg-gray-700 p-3 flex gap-4 items-start border border-gray-600">
                                <span class="text-green-400 font-bold">{{ $loop->iteration }}.</span>
                                <div class="sm:flex gap-2 text-sm">
                                    <p class="text-white"><span class="text-gray-400">Field Date:</span>
                                        {{ $entry->c_date }}</p>
                                    <p class="text-white"><span class="text-gray-400">Submitted:</span>
                                        {{ \Carbon\Carbon::parse($entry->created_at)->format('Y-m-d H:i') }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Close Button --}}
            <div class="mt-6 flex justify-end">
                <button wire:click="closeModal"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 transition-colors duration-200 font-semibold uppercase tracking-wide border border-red-500">
                    Close
                </button>
            </div>
        </div>
    </div>
@endif
