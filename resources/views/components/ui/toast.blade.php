<div
    x-data="{ 
        show: false, 
        message: '', 
        type: 'success',
        init() {
            window.addEventListener('notify', event => {
                this.message = event.detail.message;
                this.type = event.detail.type || 'success';
                this.show = true;
                setTimeout(() => this.show = false, 3000);
            });
            
            // Handle session flash messages on load
            @if(session()->has('success'))
                this.message = '{{ session('success') }}';
                this.type = 'success';
                this.show = true;
                setTimeout(() => this.show = false, 3000);
            @elseif(session()->has('error'))
                this.message = '{{ session('error') }}';
                this.type = 'error';
                this.show = true;
                setTimeout(() => this.show = false, 3000);
            @endif
        }
    }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    style="display: none;"
    class="fixed bottom-4 right-4 z-[100] flex w-full max-w-sm flex-col gap-4 sm:bottom-4 sm:right-4"
>
    <div
        :class="{
            'bg-emerald-50 text-emerald-800 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-300 dark:border-emerald-800': type === 'success',
            'bg-red-50 text-red-800 border-red-200 dark:bg-red-900/30 dark:text-red-300 dark:border-red-800': type === 'error',
            'bg-blue-50 text-blue-800 border-blue-200 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800': type === 'info'
        }"
        class="flex items-center w-full gap-3 rounded-xl border p-4 shadow-lg backdrop-blur-sm"
    >
        <!-- Icon -->
        <div class="flex-shrink-0">
            <template x-if="type === 'success'">
                <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
            </template>
            <template x-if="type === 'error'">
                <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
            </template>
            <template x-if="type === 'info'">
                <i class="fas fa-info-circle text-blue-500 text-xl"></i>
            </template>
        </div>
        
        <!-- Message -->
        <p class="flex-1 text-sm font-medium" x-text="message"></p>
        
        <!-- Close Button -->
        <button 
            @click="show = false"
            class="flex-shrink-0 inline-flex rounded-lg p-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2 opacity-70 hover:opacity-100 transition-opacity"
            :class="{
                'hover:bg-emerald-100 focus:ring-emerald-500 dark:hover:bg-emerald-800/50': type === 'success',
                'hover:bg-red-100 focus:ring-red-500 dark:hover:bg-red-800/50': type === 'error',
                'hover:bg-blue-100 focus:ring-blue-500 dark:hover:bg-blue-800/50': type === 'info'
            }"
        >
            <span class="sr-only">Close</span>
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
