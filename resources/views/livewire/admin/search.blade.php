@if (can('view_search'))
    <form action="#" method="get">
        <div class="w-56 text-gray-900 rounded-md md:w-96">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input wire:model.debounce.500ms="query" type="search"
                    class="w-full py-2 pl-10 text-gray-300 bg-gray-700 rounded-md focus:outline-none"
                    placeholder="Search">
            </div>
        </div>

        @if (strlen($query) > 2)
            <ul
                class="absolute z-50 mt-2 text-sm text-gray-200 bg-gray-500 border border-gray-400 divide-y divide-gray-200 rounded-md w-96">

                @foreach ($searchResults as $result)
                    <li class="p-1">
                        <a href="{{ $result['route'] }}"
                            class="flex items-center px-4 py-4 transition duration-150 ease-in-out hover:bg-gray-600">{{ $result['section'] }}:
                            {{ $result['label'] }}</a>
                    </li>
                @endforeach

                @if (count($searchResults) === 0)
                    <li class="p-1">No results</li>
                @endif
            </ul>
        @endif

    </form>
@endif
