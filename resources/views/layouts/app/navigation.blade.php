<div class="min-h-screen max-w-64 w-full  sticky top-0 text-white">

    <!-- Logo Section -->
    <div class="flex items-center border-l-4 border-green-500 justify-center mb-6 space-x-2 px-2 py-1">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 w-full">
            <!-- Icon -->
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-16 object-contain" />

            <!-- App Name -->
            <p class=" text-white font-mono">
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

                <x-nav.group-item route="admin.settings" icon="fas fa-sliders-h">System Settings</x-nav.group-item>


                <x-nav.group-item route="admin.settings.roles.index" icon="fas fa-user-shield">Roles</x-nav.group-item>

            </x-nav.group>
        @endif



    </nav>
</div>
