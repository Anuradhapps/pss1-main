@auth
    <div x-data="{ isOpen: false }" class="relative ml-3">
        <!-- Profile Button -->
        <button @click="isOpen = !isOpen"
            class="flex items-center gap-2 px-3 py-1.5 transition-all duration-200 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-primary/50">
            <div class="flex items-center justify-center w-7 h-7 rounded-md bg-primary text-white font-bold text-xs">
                {{ strtoupper(substr(user()->name, 0, 1)) }}
            </div>
            <span class="text-sm font-semibold text-slate-700 dark:text-slate-200 hidden md:block">
                {{ user()->name }}
            </span>
            <i class="fas fa-chevron-down text-xs text-slate-500 dark:text-slate-400 ml-1 transition-transform duration-200" :class="isOpen ? 'rotate-180' : ''"></i>
        </button>

        <!-- Dropdown Panel -->
        <div x-show="isOpen" @click.away="isOpen = false" 
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]" 
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-75" 
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-[-10px]"
            class="absolute right-0 z-50 w-56 mt-3 origin-top-right bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-xl overflow-hidden" style="display: none;">

            <div class="p-2 space-y-1">
                <div class="px-3 py-2 mb-2 border-b border-slate-100 dark:border-slate-700">
                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Signed in as</p>
                    <p class="text-sm font-bold text-slate-800 dark:text-white truncate">{{ user()->email }}</p>
                </div>

                @if (can('view_users_profiles'))
                    <x-dropdown-link :href="route('admin.users.show', ['user' => user()->id])">
                        <i class="fas fa-user-circle w-5 text-center mr-2 opacity-70"></i> View Profile
                    </x-dropdown-link>
                @endif

                @if (can('edit_own_account'))
                    <x-dropdown-link :href="route('admin.users.edit', ['user' => user()->id])">
                        <i class="fas fa-user-edit w-5 text-center mr-2 opacity-70"></i> Edit Account
                    </x-dropdown-link>
                @endif

                <!-- Logout -->
                <div class="pt-1 mt-1 border-t border-slate-100 dark:border-slate-700">
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="flex items-center w-full px-4 py-2 text-sm font-medium text-red-600 dark:text-red-400 transition-colors duration-150 rounded-md hover:bg-red-50 dark:hover:bg-red-500/10">
                        <i class="fas fa-sign-out-alt w-5 text-center mr-2"></i> Log out
                    </a>
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </div>
@endauth
