@section('title', 'Profile')

<div class="space-y-6">

    <!-- Header Card -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-10 right-20 w-32 h-32 bg-secondary/5 rounded-full blur-2xl pointer-events-none"></div>

        <div class="flex items-center gap-4 relative z-10">
            <div class="w-12 h-12 rounded-xl bg-primary/10 dark:bg-primary/20 flex items-center justify-center text-primary dark:text-primary-light">
                <i class="fa-solid fa-id-card text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">User Profile</h1>
                <nav class="text-sm text-slate-500 dark:text-slate-400 mt-1 flex items-center space-x-2">
                    <a href="{{ route('admin.users.index') }}" class="hover:text-primary transition-colors">Users</a>
                    <span class="text-slate-400">›</span>
                    <span class="text-slate-700 dark:text-slate-300 font-medium">{{ $user->name }}</span>
                </nav>
            </div>
        </div>
    </div>

    <!-- Grid Layout -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        <!-- Profile Card -->
        <div class="p-6 text-center bg-white dark:bg-slate-900 shadow-sm rounded-2xl border border-slate-200 dark:border-slate-800 relative overflow-hidden h-fit">
            
            <!-- Subtle background accent -->
            <div class="absolute top-0 left-0 right-0 h-24 bg-gradient-to-br from-primary/20 to-emerald-400/10 dark:from-primary/10 dark:to-emerald-900/20"></div>

            <!-- User Image -->
            <div class="relative mt-6">
                @if (storage_exists($user->image))
                    <img src="{{ storage_url($user->image) }}" alt="{{ $user->name }}"
                        class="object-cover w-28 h-28 mx-auto border-4 border-white dark:border-slate-900 rounded-full shadow-md bg-white dark:bg-slate-800 relative z-10">
                @else
                    <div
                        class="flex items-center justify-center w-28 h-28 mx-auto text-3xl font-bold text-primary dark:text-primary-light bg-emerald-100 dark:bg-emerald-900/50 border-4 border-white dark:border-slate-900 rounded-full shadow-md relative z-10">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                @endif
            </div>

            <!-- User Name -->
            <h2 class="mt-4 text-xl font-bold text-slate-900 dark:text-white">{{ $user->name }}</h2>

            <!-- Email -->
            <div class="flex items-center justify-center gap-2 mt-2 text-sm text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-800/50 py-1.5 px-3 rounded-lg mx-auto w-fit">
                <i class="fas fa-envelope text-primary"></i>
                <span class="truncate max-w-[200px]">{{ $user->email }}</span>
            </div>

            <!-- Edit Button -->
            @if (can('edit_users') || (auth()->id() === $user->id && can('edit_own_account')))
                <a href="{{ route('admin.users.edit', ['user' => $user->id]) }}"
                    class="inline-block w-full px-4 py-2.5 mt-6 text-sm font-bold text-white transition-all rounded-xl shadow-sm bg-primary hover:bg-emerald-600 hover:shadow-primary/30">
                    <i class="mr-1 fas fa-user-edit"></i> Edit Profile
                </a>
            @endif
        </div>

        <!-- Activity Panel -->
        <div class="bg-white dark:bg-slate-900 shadow-sm border border-slate-200 dark:border-slate-800 lg:col-span-2 rounded-2xl overflow-hidden">
            @if (can('view_users_activity'))
                <livewire:admin.users.activity :user="$user" />
            @else
                <div class="p-8 text-center text-slate-500 dark:text-slate-400">
                    <i class="fas fa-lock text-3xl mb-3 text-slate-300 dark:text-slate-600"></i>
                    <p class="text-sm">You do not have permission to view activity logs.</p>
                </div>
            @endif
        </div>
    </div>

</div>
