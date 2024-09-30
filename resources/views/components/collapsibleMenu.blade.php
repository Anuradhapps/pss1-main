<div x-data="{ open: false }" class="mb-4">
    <button @click="open = !open" class="flex justify-between items-center w-full bg-gray-200 p-2 rounded-lg">
        <span class="font-medium">{{ $title }}</span>
        <svg
            x-bind:class="open ? 'rotate-180' : 'rotate-0'"
            class="transition-transform duration-200 w-4 h-4"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
        </svg>
    </button>
    
    <div x-show="open" class="mt-2 p-2 border-l-4 border-blue-500 bg-blue-50 rounded-lg">
       {{ $slot }}
    </div>
</div>