@auth
    <div x-data="{ isOpen: false }">
        <div>
            <button @click="isOpen = !isOpen" class="pt-3 text-gray-900 focus:outline-none">
                @if (storage_exists(user()->image))
                    <img src="{{ storage_url(user()->image) }}" width="30" class="w-6 h-6 rounded-full">
                @else
                    {{ user()->name }}
                @endif
            </button>
        </div>

        <div x-show.transition="isOpen" @click.away="isOpen = false" class="absolute right-0 w-48 mt-1 mr-3 origin-top-right">
            <div class="relative z-30 bg-gray-300 border border-gray-100 shadow-xs rounded-b-md">

                @if (can('view_users_profiles'))
                    <x-dropdown-link :href="route('admin.users.show', ['user' => user()->id])">View Profile</x-dropdown-link>
                @endif

                @if (can('edit_own_account'))
                    <x-dropdown-link :href="route('admin.users.edit', ['user' => user()->id])">Edit Account</x-dropdown-link>
                @endif

                <hr>

                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="block px-4 py-2 text-smtext-white hover:bg-gray-400">Log
                    out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="post">
                    {{ csrf_field() }}
                </form>

            </div>

        </div>
    </div>
@endauth
