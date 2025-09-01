<div x-data="{ isOpen: false }" class="relative">

    <!-- Notification Button -->
    <button @click="isOpen = !isOpen" wire:click="markAsRead"
        class="relative p-2 text-gray-300 rounded-full hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500 transition">
        <i class="fas fa-bell fa-lg"></i>
        @if ($unseenCount > 0)
            <span
                class="absolute top-0 right-0 w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full flex items-center justify-center ring-2 ring-gray-900 animate-pulse">
                {{ $unseenCount }}
            </span>
        @endif
    </button>

    <!-- Slide-Over Panel -->
    <div x-show="isOpen" x-transition.opacity @click.away="isOpen = false"
        class="fixed inset-0 z-50 flex items-end justify-end sm:items-center bg-black/50 backdrop-blur-sm">

        <div x-show="isOpen" x-transition:enter="transform transition ease-in-out duration-300"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-200" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="flex flex-col w-full h-full overflow-y-auto bg-gray-900 shadow-xl sm:max-w-md rounded-l-xl">

            <!-- Header -->
            <div class="flex items-center p-5 border-b border-gray-700">
                <button @click="isOpen = false"
                    class="text-gray-400 hover:text-white transition focus:outline-none mr-3">
                    <i class="fas fa-times fa-lg"></i>
                </button>
                <h2 class="flex items-center gap-2 text-lg font-semibold text-white">
                    <i class="fas fa-bell"></i> Notifications
                </h2>
            </div>

            <!-- Notification List -->
            <div class="flex-1 overflow-y-auto divide-y divide-gray-700">
                @forelse ($notifications as $notification)
                    <div class="relative px-5 py-4 transition group hover:bg-gray-800 rounded-lg">
                        @if (!empty($notification->link))
                            <a href="{{ $notification->link }}" class="absolute inset-0 z-10 rounded-lg"></a>
                        @endif

                        <div class="relative z-20 flex items-center gap-3">
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-white">{{ $notification->title }}</p>
                                <p class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            @if (!$notification->viewed)
                                <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-sm text-center text-gray-400">No notifications yet.</div>
                @endforelse
            </div>

        </div>
    </div>
</div>
