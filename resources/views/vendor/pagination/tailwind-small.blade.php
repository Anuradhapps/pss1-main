@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}"
        class="flex items-center justify-between p-2 mt-4 text-xs bg-white rounded-md shadow-sm">
        {{-- Previous Page Link --}}
        <div class="flex justify-between flex-1 sm:hidden">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="px-2 py-1 text-gray-400 border border-gray-300 rounded">←</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="px-2 py-1 text-gray-600 border border-gray-300 rounded hover:bg-gray-100">←</a>
            @endif

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="px-2 py-1 text-gray-600 border border-gray-300 rounded hover:bg-gray-100">→</a>
            @else
                <span class="px-2 py-1 text-gray-400 border border-gray-300 rounded">→</span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-gray-500">
                    Showing
                    <span class="font-semibold">{{ $paginator->firstItem() }}</span>
                    to
                    <span class="font-semibold">{{ $paginator->lastItem() }}</span>
                    of
                    <span class="font-semibold">{{ $paginator->total() }}</span>
                    results
                </p>
            </div>

            <div>
                <span class="inline-flex space-x-1 border border-gray-300 rounded">
                    {{-- Previous --}}
                    @if ($paginator->onFirstPage())
                        <span class="px-2 py-1 text-gray-400">←</span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}"
                            class="px-2 py-1 text-gray-600 hover:bg-gray-100">←</a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="px-2 py-1 text-gray-400">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span
                                        class="px-2 py-1 font-semibold text-white bg-blue-600 rounded">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}"
                                        class="px-2 py-1 text-gray-600 hover:bg-gray-100">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}"
                            class="px-2 py-1 text-gray-600 hover:bg-gray-100">→</a>
                    @else
                        <span class="px-2 py-1 text-gray-400">→</span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
