@props([
    'title' => '',
    'content' => '',
    'footer' => '',
    'height' => 'max-h-[80vh] sm:max-h-[90vh] w-full sm:w-3/4 lg:w-1/2',
])

<div x-data="{ on: false }" x-init="$watch('on', value => document.body.classList.toggle('overflow-hidden', value))" @keydown.escape.window="on = false"
    x-on:close-modal.window="on = false" aria-modal="true" role="dialog" aria-labelledby="modal-title"
    aria-describedby="modal-desc">

    {{ $trigger }}

    <!-- Modal backdrop -->
    <div x-show="on" class="fixed inset-0 z-40 transition-opacity bg-black/60 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="on = false"
        style="display: none;">
    </div>

    <!-- Modal panel -->
    <div x-show="on" class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-6"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-4" style="display: none;">

        <div class="bg-white dark:bg-slate-900 shadow-2xl rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 {{ $height }} max-w-full transition-colors duration-300"
            @click.away="on = false">

            <div class="flex flex-col h-full">
                <!-- Header -->
                <header class="px-6 py-5 text-center border-b border-slate-100 dark:border-slate-800">
                    <h2 id="modal-title" class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">
                        {{ $title }}
                    </h2>
                </header>

                <!-- Content -->
                <main id="modal-desc"
                    class="flex-grow px-6 py-5 overflow-y-auto text-sm text-slate-700 dark:text-slate-300">
                    {{ $content }}
                </main>

                <!-- Footer -->
                <footer
                    class="flex justify-center gap-4 px-6 py-5 border-t border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50">
                    {{ $footer }}
                </footer>
            </div>

        </div>
    </div>
</div>
