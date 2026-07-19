<div class="space-y-6">
    @section('title', 'Edit User')

    <!-- Header Card -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-10 right-20 w-32 h-32 bg-secondary/5 rounded-full blur-2xl pointer-events-none"></div>

        <div class="flex items-center gap-4 relative z-10">
            <div class="w-12 h-12 rounded-xl bg-primary/10 dark:bg-primary/20 flex items-center justify-center text-primary dark:text-primary-light">
                <i class="fa-solid fa-user-edit text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Edit User</h1>
                <nav class="text-sm text-slate-500 dark:text-slate-400 mt-1 flex items-center space-x-2">
                    <a href="{{ route('admin.users.index') }}" class="hover:text-primary transition-colors">Users</a>
                    <span class="text-slate-400">›</span>
                    <span class="text-slate-700 dark:text-slate-300 font-medium">{{ $user->name }}</span>
                </nav>
            </div>
        </div>
    </div>

    <!-- Grid Layout -->
    <div class="grid lg:grid-cols-2 gap-6">
            <!-- Profile Edit -->


            <livewire:admin.users.edit.profile :user="$user" />



            <!-- Change Password -->


            <livewire:admin.users.edit.change-password :user="$user" />

        </div>

        <!-- Optional 2FA, Roles, Admin Settings -->
        {{--
        <div class="space-y-6">
            <!-- Two-Factor Authentication -->
            <div class="bg-gray-800 shadow-md border border-gray-700">
                <div class="flex items-center px-4 py-2 border-b border-gray-700 bg-gray-700 text-white text-sm font-semibold uppercase tracking-wide">
                    <i class="fas fa-shield-alt mr-2 text-blue-400"></i> Two-Factor Authentication
                </div>
                <div class="p-4">
                    <livewire:admin.users.edit.two-factor-authentication :user="$user" />
                </div>
            </div>

            @if (is_admin())
                <!-- Admin Settings -->
                <div class="bg-gray-800 shadow-md border border-gray-700">
                    <div class="flex items-center px-4 py-2 border-b border-gray-700 bg-gray-700 text-white text-sm font-semibold uppercase tracking-wide">
                        <i class="fas fa-tools mr-2 text-purple-400"></i> Admin Settings
                    </div>
                    <div class="p-4">
                        <livewire:admin.users.edit.admin-settings :user="$user" />
                    </div>
                </div>

                <!-- Role Management -->
                <div class="bg-gray-800 shadow-md border border-gray-700">
                    <div class="flex items-center px-4 py-2 border-b border-gray-700 bg-gray-700 text-white text-sm font-semibold uppercase tracking-wide">
                        <i class="fas fa-user-tag mr-2 text-pink-400"></i> Role Management
                    </div>
                    <div class="p-4">
                        <livewire:admin.users.edit.roles :user="$user" />
                    </div>
                </div>
            @endif
        </div>
        --}}
</div>
