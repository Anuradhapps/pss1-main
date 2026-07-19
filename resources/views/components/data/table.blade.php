<div class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden transition-colors duration-300">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
            <thead class="text-xs uppercase border-b border-slate-200 dark:border-slate-700 backdrop-blur-sm">
                <tr class="!bg-slate-50/80 dark:!bg-slate-800/80 !text-slate-700 dark:!text-slate-300">
                    {{ $header }}
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800/50 bg-white dark:bg-slate-900">
                {{ $slot }}
            </tbody>
        </table>
    </div>
    
    @if(isset($footer) && $footer->isNotEmpty())
        <div class="p-4 border-t border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 flex items-center justify-between">
            {{ $footer }}
        </div>
    @endif
</div>
