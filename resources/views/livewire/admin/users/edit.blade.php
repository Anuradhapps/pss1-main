@section('title', 'Edit User')

<div class="min-h-screen px-4 py-6 space-y-6 text-gray-200 bg-gray-900">

    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-400">
        <a href="{{ route('admin.users.index') }}" class="text-emerald-400 hover:underline">Users</a>
        <span class="mx-2">›</span>
        <span>Edit User</span>
    </nav>

    <!-- Page Heading -->
    <h1 class="text-2xl font-bold text-white">Edit User - {{ $user->name }}</h1>

    <!-- Grid Layout -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

        <!-- Profile and Password Update -->
        <div class="space-y-6">
            <!-- Profile Edit -->
            <div class="bg-gray-800 shadow-md rounded-xl">
                <livewire:admin.users.edit.profile :user="$user" />
            </div>

            <!-- Change Password -->
            <div class="p-4 bg-gray-800 shadow-md rounded-xl">
                <livewire:admin.users.edit.change-password :user="$user" />
            </div>
        </div>

        <!-- 2FA, Roles, Admin Settings -->
        {{--
        <div class="space-y-6">
            <!-- Two-Factor Authentication -->
            <div class="p-6 bg-gray-800 shadow-md rounded-xl">
                <h2 class="mb-4 text-lg font-semibold text-white">Two-Factor Authentication</h2>
                <livewire:admin.users.edit.two-factor-authentication :user="$user" />
            </div>

            @if (is_admin())
                <!-- Admin Settings -->
                <div class="p-6 bg-gray-800 shadow-md rounded-xl">
                    <h2 class="mb-4 text-lg font-semibold text-white">Admin Settings</h2>
                    <livewire:admin.users.edit.admin-settings :user="$user" />
                </div>

                <!-- Role Management -->
                <div class="p-6 bg-gray-800 shadow-md rounded-xl">
                    <h2 class="mb-4 text-lg font-semibold text-white">Roles</h2>
                    <livewire:admin.users.edit.roles :user="$user" />
                </div>
            @endif
        </div> --}}

    </div>
</div>
