<div>
    @if ($paginator->hasPages())
        @php(isset($this->numberOfPaginatorsRendered[$paginator->getPageName()]) ? $this->numberOfPaginatorsRendered[$paginator->getPageName()]++ : ($this->numberOfPaginatorsRendered[$paginator->getPageName()] = 1))

        <nav role="navigation" aria-label="Pagination Navigation"
            class="flex flex-col sm:flex-row items-center justify-between gap-4">

            {{-- Mobile & Tablet Summary (Shows on small screens) --}}
            <div class="w-full text-center sm:hidden mb-2">
                <p class="text-[13px] font-medium text-slate-500 dark:text-slate-400">
                    Showing <span class="font-bold text-slate-900 dark:text-white">{{ $paginator->firstItem() ?: 0 }}</span> to <span class="font-bold text-slate-900 dark:text-white">{{ $paginator->lastItem() ?: 0 }}</span> of <span class="font-bold text-slate-900 dark:text-white">{{ $paginator->total() }}</span> results
                </p>
            </div>

            {{-- Mobile View Buttons --}}
            <div class="flex justify-between w-full sm:hidden gap-3">
                @if ($paginator->onFirstPage())
                    <span class="flex-1 flex items-center justify-center px-4 py-2.5 text-sm font-bold text-slate-400 dark:text-slate-500 bg-slate-100 dark:bg-slate-800/80 rounded-xl cursor-not-allowed">
                        <i class="fas fa-chevron-left mr-2 text-[10px]"></i> Prev
                    </span>
                @else
                    <button wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled"
                        class="flex-1 flex items-center justify-center px-4 py-2.5 text-sm font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-primary hover:text-primary transition-all rounded-xl shadow-sm">
                        <i class="fas fa-chevron-left mr-2 text-[10px]"></i> Prev
                    </button>
                @endif

                @if ($paginator->hasMorePages())
                    <button wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled"
                        class="flex-1 flex items-center justify-center px-4 py-2.5 text-sm font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-primary hover:text-primary transition-all rounded-xl shadow-sm">
                        Next <i class="fas fa-chevron-right ml-2 text-[10px]"></i>
                    </button>
                @else
                    <span class="flex-1 flex items-center justify-center px-4 py-2.5 text-sm font-bold text-slate-400 dark:text-slate-500 bg-slate-100 dark:bg-slate-800/80 rounded-xl cursor-not-allowed">
                        Next <i class="fas fa-chevron-right ml-2 text-[10px]"></i>
                    </span>
                @endif
            </div>

            {{-- Desktop View --}}
            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between w-full">
                <div>
                    <p class="text-[13px] font-medium text-slate-500 dark:text-slate-400">
                        {!! __('Showing') !!} <span class="font-bold text-slate-900 dark:text-white">{{ $paginator->firstItem() ?: 0 }}</span> {!! __('to') !!} <span class="font-bold text-slate-900 dark:text-white">{{ $paginator->lastItem() ?: 0 }}</span> {!! __('of') !!} <span class="font-bold text-slate-900 dark:text-white">{{ $paginator->total() }}</span> {!! __('results') !!}
                    </p>
                </div>

                <div>
                    <span class="inline-flex shadow-sm rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700">
                        {{-- Previous --}}
                        @if ($paginator->onFirstPage())
                            <span class="flex items-center justify-center w-10 h-10 text-sm font-medium text-slate-300 dark:text-slate-600 bg-white dark:bg-slate-900/50 cursor-not-allowed">
                                <i class="fas fa-chevron-left text-[11px]"></i>
                            </span>
                        @else
                            <button wire:click="previousPage('{{ $paginator->getPageName() }}')" rel="prev"
                                class="flex items-center justify-center w-10 h-10 text-sm font-medium text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary transition-colors border-r border-slate-200 dark:border-slate-700">
                                <i class="fas fa-chevron-left text-[11px]"></i>
                            </button>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($elements as $element)
                            @if (is_string($element))
                                <span class="flex items-center justify-center w-10 h-10 text-sm font-medium text-slate-400 dark:text-slate-500 bg-white dark:bg-slate-900/50 cursor-not-allowed border-r border-slate-200 dark:border-slate-700">
                                    {{ $element }}
                                </span>
                            @endif

                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $paginator->currentPage())
                                        <span class="flex items-center justify-center w-10 h-10 text-sm font-bold text-white bg-primary dark:bg-primary border-r border-primary cursor-default">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <button wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                            class="flex items-center justify-center w-10 h-10 text-sm font-medium text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary transition-colors border-r border-slate-200 dark:border-slate-700">
                                            {{ $page }}
                                        </button>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if ($paginator->hasMorePages())
                            <button wire:click="nextPage('{{ $paginator->getPageName() }}')" rel="next"
                                class="flex items-center justify-center w-10 h-10 text-sm font-medium text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary transition-colors">
                                <i class="fas fa-chevron-right text-[11px]"></i>
                            </button>
                        @else
                            <span class="flex items-center justify-center w-10 h-10 text-sm font-medium text-slate-300 dark:text-slate-600 bg-white dark:bg-slate-900/50 cursor-not-allowed">
                                <i class="fas fa-chevron-right text-[11px]"></i>
                            </span>
                        @endif
                    </span>
                </div>
            </div>
        </nav>
    @endif
</div>
