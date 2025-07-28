<div>
    @if ($paginator->hasPages())
        @php(isset($this->numberOfPaginatorsRendered[$paginator->getPageName()]) ? $this->numberOfPaginatorsRendered[$paginator->getPageName()]++ : ($this->numberOfPaginatorsRendered[$paginator->getPageName()] = 1))

        <nav role="navigation" aria-label="Pagination Navigation"
            class="flex flex-col sm:flex-row items-center justify-between gap-2 sm:gap-0 bg-gray-900 p-2 text-gray-300">

            {{-- Mobile Pagination Controls --}}
            <div class="flex justify-between flex-1 sm:hidden w-full">
                <span>
                    @if ($paginator->onFirstPage())
                        <span
                            class="inline-flex items-center px-4 py-2 text-sm font-medium bg-gray-800 border border-gray-700 cursor-not-allowed select-none">
                            {!! __('pagination.previous') !!}
                        </span>
                    @else
                        <button wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled"
                            dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.before"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium bg-gray-800 border border-gray-700 hover:bg-gray-700 hover:text-white transition">
                            {!! __('pagination.previous') !!}
                        </button>
                    @endif
                </span>

                <span>
                    @if ($paginator->hasMorePages())
                        <button wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled"
                            dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.before"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium bg-gray-800 border border-gray-700 hover:bg-gray-700 hover:text-white transition">
                            {!! __('pagination.next') !!}
                        </button>
                    @else
                        <span
                            class="inline-flex items-center px-4 py-2 text-sm font-medium bg-gray-800 border border-gray-700 cursor-not-allowed select-none">
                            {!! __('pagination.next') !!}
                        </span>
                    @endif
                </span>
            </div>

            {{-- Desktop Pagination Info --}}
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between w-full text-gray-400 text-sm">
                <p>
                    {!! __('Showing') !!}
                    <span class="font-semibold text-gray-300">{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span class="font-semibold text-gray-300">{{ $paginator->lastItem() }}</span>
                    {!! __('of') !!}
                    <span class="font-semibold text-gray-300">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>

                {{-- Desktop Pagination Buttons --}}
                <div class="inline-flex shadow-sm">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span
                                class="inline-flex items-center px-3 py-2 text-sm font-medium bg-gray-800 border border-gray-700 cursor-not-allowed select-none">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <button wire:click="previousPage('{{ $paginator->getPageName() }}')" rel="prev"
                            dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium bg-gray-800 border border-gray-700 hover:bg-gray-700 hover:text-white transition"
                            aria-label="{{ __('pagination.previous') }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span
                                    class="inline-flex items-center px-4 py-2 -ml-px text-sm font-medium bg-gray-800 border border-gray-700 cursor-default select-none">{{ $element }}</span>
                            </span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span
                                            class="inline-flex items-center px-4 py-2 -ml-px text-sm font-semibold bg-gray-700 border border-gray-600 cursor-default select-none">{{ $page }}</span>
                                    </span>
                                @else
                                    <button
                                        wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                        class="inline-flex items-center px-4 py-2 -ml-px text-sm font-medium bg-gray-800 border border-gray-700 hover:bg-gray-700 hover:text-white transition"
                                        aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </button>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <button wire:click="nextPage('{{ $paginator->getPageName() }}')" rel="next"
                            dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after"
                            class="inline-flex items-center px-3 py-2 -ml-px text-sm font-medium bg-gray-800 border border-gray-700 hover:bg-gray-700 hover:text-white transition"
                            aria-label="{{ __('pagination.next') }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span
                                class="inline-flex items-center px-3 py-2 -ml-px text-sm font-medium bg-gray-800 border border-gray-700 cursor-not-allowed select-none">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </div>
            </div>
        </nav>
    @endif
</div>
