@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}"
        class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">

        {{-- Mobile View --}}
        <div class="flex justify-between w-full sm:hidden">
            @if ($paginator->onFirstPage())
                <span
                    class="px-4 py-2 text-sm font-medium text-gray-500 bg-gray-800 border border-gray-700 cursor-not-allowed">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="px-4 py-2 text-sm font-medium text-white bg-gray-800 border border-gray-700 hover:bg-gray-700 transition">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="px-4 py-2 text-sm font-medium text-white bg-gray-800 border border-gray-700 hover:bg-gray-700 transition">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span
                    class="px-4 py-2 text-sm font-medium text-gray-500 bg-gray-800 border border-gray-700 cursor-not-allowed">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        {{-- Desktop View --}}
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between w-full">
            <div>
                <p class="text-sm text-gray-400">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-semibold text-white">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-semibold text-white">{{ $paginator->lastItem() }}</span>
                    @else
                        <span class="font-semibold text-white">{{ $paginator->count() }}</span>
                    @endif
                    {!! __('of') !!}
                    <span class="font-semibold text-white">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div>
                <span class="inline-flex shadow-sm">
                    {{-- Previous --}}
                    @if ($paginator->onFirstPage())
                        <span
                            class="px-3 py-2 text-sm font-medium text-gray-500 bg-gray-800 border border-gray-700 cursor-not-allowed">
                            ‹
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                            class="px-3 py-2 text-sm font-medium text-white bg-gray-800 border border-gray-700 hover:bg-gray-700 transition">
                            ‹
                        </a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span
                                class="px-3 py-2 text-sm font-medium text-gray-500 bg-gray-800 border border-gray-700 cursor-not-allowed">
                                {{ $element }}
                            </span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span
                                        class="px-3 py-2 text-sm font-bold text-white bg-gray-700 border border-gray-700">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                        class="px-3 py-2 text-sm font-medium text-white bg-gray-800 border border-gray-700 hover:bg-gray-700 transition">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                            class="px-3 py-2 text-sm font-medium text-white bg-gray-800 border border-gray-700 hover:bg-gray-700 transition">
                            ›
                        </a>
                    @else
                        <span
                            class="px-3 py-2 text-sm font-medium text-gray-500 bg-gray-800 border border-gray-700 cursor-not-allowed">
                            ›
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
