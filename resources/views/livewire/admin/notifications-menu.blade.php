@if (can('view_notifications'))
    <div x-data="{ isOpen: false }" class="relative">
        <!-- Notification Button -->
        <button wire:click="open" @click="isOpen = !isOpen"
            class="relative p-2 transition rounded-full focus:outline-none hover:bg-red-500">
            <!-- Notification Count -->
            @if ($unseenCount > 0)
                <span
                    class="absolute top-0 block w-4 h-4 text-xs leading-tight text-center text-white bg-red-600 rounded-full left-4 ring-2 ring-white animate-pulse">
                    {{ $unseenCount }}
                </span>
            @endif

            <!-- Bell Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
        </button>

        <!-- Notification Slide-Over Panel -->
        <div x-show="isOpen" x-transition.opacity @click.away="isOpen = false"
            class="fixed inset-0 z-50 flex items-end justify-end sm:items-center bg-black/50 backdrop-blur-sm">
            <div x-show="isOpen" x-transition:enter="transform transition ease-in-out duration-300"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in-out duration-200"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                class="flex flex-col w-full h-full overflow-y-auto text-white bg-gray-800 shadow-xl sm:max-w-md">

                <!-- Header -->
                <div class="flex items-center justify-between p-5 border-b border-gray-700">
                    <h2 class="text-lg font-semibold">🔔 Notifications</h2>
                    <button @click="isOpen = false"
                        class="text-gray-400 transition hover:text-white focus:outline-none">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Notification List -->
                <div class="flex-1 overflow-y-auto divide-y divide-gray-700">
                    @if (count($notifications) === 0)
                        <div class="p-6 text-sm text-center text-gray-400">No notifications yet.</div>
                    @else
                        @foreach ($notifications as $notification)
                            <div class="relative px-5 py-4 transition group hover:bg-gray-700">
                                @if (!empty($notification->link))
                                    <a href="{{ $notification->link }}" class="absolute inset-0 z-10"></a>
                                @endif

                                <div class="relative z-20 flex items-center gap-3">
                                    @if (!empty($notification->assignedFrom->image))
                                        <img src="{{ storage_url($notification->assignedFrom->image) }}" alt="User"
                                            class="object-cover w-10 h-10 rounded-full">
                                    @else
                                        <div
                                            class="flex items-center justify-center w-10 h-10 text-sm font-bold text-white uppercase bg-gray-600 rounded-full">
                                            {{ substr($notification->assignedFrom->name ?? 'U', 0, 1) }}
                                        </div>
                                    @endif

                                    <div>
                                        <p class="text-sm font-medium text-white">
                                            {{ $notification->title }}
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
