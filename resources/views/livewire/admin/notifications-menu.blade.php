<div x-data="{ isOpen: false }" class="relative">

    <!-- Notification Button -->
    <button @click="isOpen = !isOpen" wire:click="markAsRead"
        class="relative p-2 text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all duration-200 group">
        <i class="fas fa-bell text-lg group-hover:animate-bounce"></i>
        @if ($unseenCount > 0)
            <span
                class="absolute top-1 right-1 w-4 h-4 text-[10px] font-bold text-white bg-red-500 rounded-full flex items-center justify-center ring-2 ring-white dark:ring-slate-900 animate-pulse">
                {{ $unseenCount }}
            </span>
        @endif
    </button>

    <!-- Slide-Over Panel Backdrop -->
    <div x-show="isOpen" x-transition:enter="transition-opacity ease-linear duration-300" 
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        @click.away="isOpen = false"
        class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm" style="display: none;">
    </div>

    <!-- Slide-Over Panel -->
    <div x-show="isOpen" 
        x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500" 
        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
        class="fixed inset-y-0 right-0 z-50 flex flex-col w-full max-w-sm sm:max-w-md h-full bg-white dark:bg-slate-900 shadow-2xl border-l border-slate-200 dark:border-slate-800" style="display: none;">

        <!-- Header -->
        <div class="flex items-center justify-between p-5 border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50">
            <h2 class="flex items-center gap-2 text-lg font-bold text-slate-800 dark:text-white">
                <i class="fas fa-bell text-primary"></i> Notifications
            </h2>
            <button @click="isOpen = false"
                class="text-slate-400 hover:text-red-500 dark:hover:text-red-400 p-2 -mr-2 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors focus:outline-none">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Notification List -->
        <div class="flex-1 overflow-y-auto custom-scrollbar divide-y divide-slate-100 dark:divide-slate-800">
            @forelse ($notifications as $notification)
                <div class="relative px-5 py-4 transition-colors duration-200 hover:bg-slate-50 dark:hover:bg-slate-800/50 group">
                    @if (!empty($notification->link))
                        <a href="{{ $notification->link }}" class="absolute inset-0 z-10 rounded-lg"></a>
                    @endif

                    <div class="relative z-20 flex items-start gap-4">
                        <!-- Icon Placeholder (Optional) -->
                        <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-slate-800 dark:text-slate-100 mb-1 group-hover:text-primary transition-colors">{{ $notification->title }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1">
                                <i class="far fa-clock text-[10px]"></i> {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                        @if (!$notification->viewed)
                            <div class="flex-shrink-0 w-2 h-2 mt-1.5 bg-red-500 rounded-full ring-4 ring-red-500/20 shadow-[0_0_8px_rgba(239,68,68,0.6)]"></div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center h-48 text-center p-6">
                    <div class="w-16 h-16 mb-4 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-300 dark:text-slate-600">
                        <i class="fas fa-bell-slash text-2xl"></i>
                    </div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">You're all caught up!</p>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">No new notifications right now.</p>
                </div>
            @endforelse
        </div>

    </div>
</div>
