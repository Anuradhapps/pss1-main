@section('title', 'Profile')

<div class="min-h-screen px-4 py-6 text-gray-200 bg-gray-900">

    <!-- Breadcrumb -->
    <nav class="mb-4 text-sm text-gray-400">
        <a href="{{ route('admin.users.index') }}" class="text-emerald-400 hover:underline">Users</a>
        <span class="mx-2">›</span>
        <span class="text-gray-300">{{ $user->name }}</span>
    </nav>

    <!-- Grid Layout -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        <!-- Profile Card -->
        <div class="p-6 text-center bg-gray-800 shadow-md rounded-xl">

            <!-- User Image -->
            @if (storage_exists($user->image))
                <img src="{{ storage_url($user->image) }}" alt="{{ $user->name }}"
                    class="object-cover w-24 h-24 mx-auto border-2 rounded-full shadow border-emerald-500">
            @else
                <div
                    class="flex items-center justify-center w-24 h-24 mx-auto text-2xl text-white bg-gray-700 rounded-full shadow">
                    <i class="fas fa-user"></i>
                </div>
            @endif

            <!-- User Name -->
            <h2 class="mt-4 text-xl font-bold text-white">{{ $user->name }}</h2>

            <!-- Email -->
            <div class="flex items-center justify-center gap-2 mt-2 text-sm text-gray-400">
                <i class="fas fa-envelope text-emerald-400"></i>
                <span class="truncate max-w-[200px]">{{ $user->email }}</span>
            </div>

            <!-- Edit Button -->
            @if (can('edit_users') || (auth()->id() === $user->id && can('edit_own_account')))
                <a href="{{ route('admin.users.edit', ['user' => $user->id]) }}"
                    class="inline-block px-4 py-2 mt-4 text-sm text-white transition rounded-full shadow bg-emerald-600 hover:bg-emerald-700">
                    <i class="mr-1 fas fa-edit"></i> Edit Profile
                </a>
            @endif

        </div>

        <!-- Activity Panel -->
        <div class="bg-gray-600 shadow-md lg:col-span-2 rounded-xl">
            @if (can('view_users_activity'))
                <livewire:admin.users.activity :user="$user" />
            @else
                <p class="text-sm text-gray-400">You do not have permission to view activity.</p>
            @endif
        </div>
    </div>

</div>
