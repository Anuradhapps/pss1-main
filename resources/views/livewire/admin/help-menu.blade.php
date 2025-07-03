<div x-data="{ isOpen: false }" class="relative inline-block text-left">
    <!-- Icon Button with Tooltip -->
    <div class="relative group">
        <button @click="isOpen = !isOpen" class="p-2 transition rounded-full focus:outline-none hover:bg-red-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </button>
    </div>

    <!-- Dropdown -->
    <div x-show="isOpen" @click.away="isOpen = false" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 z-50 w-48 mt-2 bg-gray-700 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">

        <div class="py-1">
            <x-dropdown-link href="https://doa.gov.lk/pps-home-sinhala/" target="_blank">
                🌐 Go to DOA Site
            </x-dropdown-link>
        </div>
    </div>
</div>
