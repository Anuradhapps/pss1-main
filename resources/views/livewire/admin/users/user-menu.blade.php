@auth
    <div x-data="{ isOpen: false }" class="relative ml-3">
        <!-- Icon Button with Tooltip -->
        <div class="relative group">
            <!-- Profile Button -->
            <button @click="isOpen = !isOpen"
                class="flex items-center justify-center p-1 transition duration-200 bg-teal-800 border border-white  hover:bg-gray-900 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                {{-- @if (storage_exists(user()->image))
                    <img src="{{ storage_url(user()->image) }}" alt="Profile" class="object-cover w-8 h-8 rounded">
                @else --}}
                <span class="text-sm px-3 font-bold text-white">
                    {{-- {{ strtoupper(substr(user()->name, 0, 1)) }} --}}
                    {{ user()->name }}
                </span>
                {{-- @endif --}}
            </button>
        </div>



        <!-- Dropdown Panel -->
        <div x-show="isOpen" @click.away="isOpen = false" x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute right-0 z-50 w-48 mt-2 origin-top-right bg-gray-900 border border-gray-700 shadow-lg">

            <div class="py-2 text-sm text-gray-200 m-1">
                @if (can('view_users_profiles'))
                    <x-dropdown-link :href="route('admin.users.show', ['user' => user()->id])">
                        <i class="fas fa-user mr-2 "></i> View Profile
                    </x-dropdown-link>
                @endif

                @if (can('edit_own_account'))
                    <x-dropdown-link :href="route('admin.users.edit', ['user' => user()->id])">
                        <i class="fas fa-pen mr-2"></i> Edit Account
                    </x-dropdown-link>
                @endif

                <!-- Logout -->
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="block px-4 py-2 text-sm text-red-400 transition hover:text-white hover:bg-red-700">
                    <i class="fas fa-sign-out-alt mr-2"></i> Log out
                </a>


                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </div>
@endauth
