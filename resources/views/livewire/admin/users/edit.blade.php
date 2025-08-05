@section('title', 'Edit User')

<div class="min-h-screen px-4 py-6 space-y-6 text-gray-100 bg-gray-900">

    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-400 flex items-center space-x-2">
        <i class="fas fa-users text-emerald-400"></i>
        <a href="{{ route('admin.users.index') }}" class="text-emerald-400 hover:underline">Users</a>
        <span class="mx-2 text-gray-500">›</span>
        <span class="text-white">Edit User</span>
    </nav>

    <!-- Page Heading -->
    <div class="flex items-center space-x-3">
        <i class="fas fa-user-cog text-white text-xl"></i>
        <h1 class="text-2xl font-bold text-white">Edit User - {{ $user->name }}</h1>
    </div>

    <!-- Grid Layout -->
    <div class="">

        <!-- Profile and Password Update -->
        <div class="grid sm:grid-cols-2 gap-4">
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
</div>
