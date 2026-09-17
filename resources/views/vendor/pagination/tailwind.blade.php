@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}"
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
                <span class="flex-1 text-center px-4 py-2.5 text-sm font-bold text-slate-400 dark:text-slate-500 bg-slate-100 dark:bg-slate-800/80 rounded-xl cursor-not-allowed">
                    <i class="fas fa-chevron-left mr-1 text-[10px]"></i> Prev
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="flex-1 text-center px-4 py-2.5 text-sm font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-primary hover:text-primary transition-all rounded-xl shadow-sm">
                    <i class="fas fa-chevron-left mr-1 text-[10px]"></i> Prev
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="flex-1 text-center px-4 py-2.5 text-sm font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-primary hover:text-primary transition-all rounded-xl shadow-sm">
                    Next <i class="fas fa-chevron-right ml-1 text-[10px]"></i>
                </a>
            @else
                <span class="flex-1 text-center px-4 py-2.5 text-sm font-bold text-slate-400 dark:text-slate-500 bg-slate-100 dark:bg-slate-800/80 rounded-xl cursor-not-allowed">
                    Next <i class="fas fa-chevron-right ml-1 text-[10px]"></i>
                </span>
            @endif
        </div>

        {{-- Desktop View --}}
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between w-full">
            <div>
                <p class="text-[13px] font-medium text-slate-500 dark:text-slate-400">
                    Showing <span class="font-bold text-slate-900 dark:text-white">{{ $paginator->firstItem() ?: 0 }}</span> to <span class="font-bold text-slate-900 dark:text-white">{{ $paginator->lastItem() ?: 0 }}</span> of <span class="font-bold text-slate-900 dark:text-white">{{ $paginator->total() }}</span> results
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
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="flex items-center justify-center w-10 h-10 text-sm font-medium text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary transition-colors border-r border-slate-200 dark:border-slate-700">
                            <i class="fas fa-chevron-left text-[11px]"></i>
                        </a>
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
                                    <span class="flex items-center justify-center w-10 h-10 text-sm font-bold text-white bg-primary dark:bg-primary border-r border-primary">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="flex items-center justify-center w-10 h-10 text-sm font-medium text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary transition-colors border-r border-slate-200 dark:border-slate-700">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="flex items-center justify-center w-10 h-10 text-sm font-medium text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary transition-colors">
                            <i class="fas fa-chevron-right text-[11px]"></i>
                        </a>
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
