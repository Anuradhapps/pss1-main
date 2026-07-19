<div class="min-h-screen w-full sticky top-0 text-slate-800 dark:text-slate-200">

    <!-- Logo Section -->
    <div class="flex items-center border-l-4 border-primary justify-center mb-6 px-4 py-3 bg-slate-50 dark:bg-slate-800/50 transition-colors">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 w-full group">
            <!-- Icon -->
            <img src="{{ asset('images/LOGO.png') }}" alt="Logo" class="h-12 w-12 object-contain transition-transform group-hover:scale-105" />

            <!-- App Name -->
            <p class="text-slate-900 dark:text-white font-bold text-lg tracking-tight transition-colors">
                {{ config('app.name') }}
            </p>
        </a>
    </div>


    <!-- Navigation Links -->
    <nav class="space-y-1 text-sm px-1">

        <x-nav.link route="dashboard" icon="fas fa-home">Dashboard</x-nav.link>

        @if (has_role('deputyDirector'))
            <x-nav.link route="deputy.dashboard" icon="fas fa-clipboard">View Data</x-nav.link>
        @endif
        @if (has_role('extensionAndTrainingDirector'))
            <x-nav.link route="extensionAndTrainingDirector.dashboard" icon="fas fa-clipboard">View Data</x-nav.link>
        @endif

        @if (has_role('collector'))
            <x-nav.link route="collector.index" icon="fas fa-user-tie">
                <div>Rice Pest</div>
                <div class="text-xs opacity-70">Data Collector</div>
            </x-nav.link>
            <x-nav.link route="help" icon="fas fa-question-circle">Help</x-nav.link>
        @endif

        @if (is_admin())
            <x-nav.link route="admin.users.index" icon="fas fa-users">Users</x-nav.link>
            <x-nav.link route="admin.collector.records" icon="fa-solid fa-chalkboard-user">Collectors</x-nav.link>
            <x-nav.link route="report.index" icon="fas fa-file-alt">Reports</x-nav.link>
            <x-nav.link route="chart.index" icon="fas fa-chart-bar">Data/Charts</x-nav.link>
            <x-nav.link route="admin.conducted-programs" icon="fas fa-calendar-check">Conducted Programs</x-nav.link>

            <!-- Settings Dropdown -->
            <x-nav.group label="Settings" route="admin.settings" icon="fas fa-cogs">
                <x-nav.group-item route="admin.settings.audit-trails.index" icon="fas fa-clipboard-list">Audit
                    Trails</x-nav.group-item>

                {{-- <x-nav.group-item route="admin.settings" icon="fas fa-sliders-h">System Settings</x-nav.group-item> --}}


                {{-- <x-nav.group-item route="admin.settings.roles.index" icon="fas fa-user-shield">Roles</x-nav.group-item> --}}
                <x-nav.group-item route="location.settings" icon="fas fa-location-dot">
                    Location Settings
                </x-nav.group-item>

            </x-nav.group>
        @endif



    </nav>
</div>
