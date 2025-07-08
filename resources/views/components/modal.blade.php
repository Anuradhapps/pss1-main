@props([
    'title' => '',
    'content' => '',
    'footer' => '',
    'height' => 'max-h-[80vh] sm:max-h-[90vh] w-full sm:w-3/4 lg:w-1/2',
])

<div x-data="{ on: false }" x-init="$watch('on', value => document.body.classList.toggle('overflow-hidden', value))">
    {{ $trigger }}

    <!-- Modal backdrop -->
    <div x-show="on" class="fixed inset-0 z-40 transition-opacity bg-black/60 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="on = false"
        @keydown.escape.window="on = false" x-on:close-modal.window="on = false">
    </div>

    <!-- Modal panel -->
    <div x-show="on" class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-6"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-4" aria-modal="true" role="dialog">

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden {{ $height }}"
            @click.away="on = false" @keydown.escape.window="on = false">

            <div class="flex flex-col h-full">
                <!-- Header -->
                <header class="px-6 py-4 text-center border-b dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ $title }}
                    </h2>
                </header>

                <!-- Content -->
                <main class="flex-grow px-6 py-4 overflow-y-auto text-sm text-gray-800 dark:text-gray-200">
                    {{ $content }}
                </main>

                <!-- Footer -->
                <footer
                    class="flex justify-center gap-4 px-6 py-4 border-t dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    {{ $footer }}
                </footer>
            </div>

        </div>
    </div>
</div>
