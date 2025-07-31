@if ($showModal && $selectedCollector)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-80"
        wire:key="modal-{{ $selectedCollector->id }}">

        <div
            class="relative w-full max-w-md sm:max-w-2xl mx-2 p-4 sm:p-6 bg-gray-900 text-white border border-gray-700 overflow-y-auto max-h-[90vh] sm:max-h-screen">

            {{-- Close Button --}}
            <button wire:click="closeModal"
                class="absolute top-2 right-2 text-gray-400 hover:text-red-500 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Header --}}
            <h2
                class="text-xl sm:text-2xl font-bold text-center text-green-400 mb-4 sm:mb-6 border-b border-gray-700 pb-2 tracking-wide uppercase select-none">
                Collector Details
            </h2>

            {{-- Collector Info --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 text-sm mb-4 sm:mb-6">
                <div><span class="text-gray-400">Name:</span> {{ $selectedCollector->user->name ?? 'N/A' }}</div>
                <div><span class="text-gray-400">Email:</span> {{ $selectedCollector->user->email ?? 'N/A' }}</div>
                <div><span class="text-gray-400">AI Range:</span> {{ $selectedCollector->getAiRange->name ?? 'N/A' }}
                </div>
                <div><span class="text-gray-400">Season:</span> {{ $selectedCollector->riceSeason->name ?? 'N/A' }}
                </div>
                <div><span class="text-gray-400">Phone:</span> {{ $selectedCollector->phone_no ?? 'N/A' }}</div>
                <div><span class="text-gray-400">Total Entries:</span>
                    {{ $selectedCollector->commonDataCollect->count() }}</div>
            </div>

            {{-- Data Timeline --}}
            <div class="text-sm">
                @if ($selectedCollector->commonDataCollect->isEmpty())
                    <div
                        class="flex items-center gap-2 bg-red-800 border border-red-700 text-red-300 px-3 py-2 select-none">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-yellow-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4m0 4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                        </svg>
                        <span>No data submitted for this season.</span>
                    </div>
                @else
                    <h3
                        class="text-base sm:text-lg font-semibold text-sky-400 mb-2 sm:mb-3 tracking-wide border-b border-gray-700 pb-1 select-none">
                        📅 Data Collection Timeline
                    </h3>
                    <ul class="space-y-2">
                        @foreach ($selectedCollector->commonDataCollect as $entry)
                            <li class="bg-gray-800 border border-gray-700 p-2 flex items-start gap-2 select-none">
                                <span class="text-green-400 font-bold">{{ $loop->iteration }}.</span>
                                <div class="flex flex-col sm:flex-row justify-between gap-2 w-full">
                                    <p class="m-0 p-0"><span class="text-gray-400">Field Date:</span>
                                        {{ $entry->c_date }}</p>
                                    <p class="m-0 p-0"><span class="text-gray-400">Submitted:</span>
                                        {{ \Carbon\Carbon::parse($entry->created_at)->format('Y-m-d H:i') }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Footer Close Button --}}
            <div class="mt-4 sm:mt-6 text-right">
                <button wire:click="closeModal"
                    class="inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 bg-red-600 hover:bg-red-700 text-xs sm:text-sm uppercase font-semibold tracking-wide border border-red-500 transition-all focus:outline-none focus:ring-2 focus:ring-red-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Close
                </button>
            </div>
        </div>
    </div>
@endif
