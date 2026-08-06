@if (can('view_search'))
    <form action="#" method="get">
        <div class="w-56 rounded-md text-slate-900 md:w-96">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-2">
                    <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input wire:model.debounce.500ms="query" type="search"
                    class="w-full rounded-md border border-slate-300 bg-white py-2 pl-10 text-slate-900 focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100"
                    placeholder="Search">
            </div>
        </div>

        @if (strlen($query) > 2)
            <ul
                class="absolute z-50 mt-2 w-96 divide-y divide-slate-200 rounded-md border border-slate-200 bg-white text-sm text-slate-700 shadow-lg dark:divide-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">

                @foreach ($searchResults as $result)
                    <li class="p-1">
                        <a href="{{ $result['route'] }}"
                            class="flex items-center px-4 py-4 transition duration-150 ease-in-out hover:bg-slate-100 dark:hover:bg-slate-700">{{ $result['section'] }}:
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
