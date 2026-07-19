<div class="w-full text-slate-800 dark:text-slate-200 flex flex-col gap-1">
    
    <div class="px-3 mb-2">
        <div class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2 px-3">
            Main Menu
        </div>
        <nav class="space-y-1">
            <x-nav.link route="dashboard" icon="fas fa-home">Dashboard</x-nav.link>

            @if (has_role('deputyDirector'))
                <x-nav.link route="deputy.dashboard" icon="fas fa-clipboard">View Data</x-nav.link>
            @endif
            @if (has_role('extensionAndTrainingDirector'))
                <x-nav.link route="extensionAndTrainingDirector.dashboard" icon="fas fa-clipboard">View Data</x-nav.link>
            @endif

            @if (has_role('collector'))
                <x-nav.link route="collector.index" icon="fas fa-user-tie">
                    <div class="flex flex-col">
                        <span>Rice Pest</span>
                        <span class="text-[10px] uppercase font-bold tracking-wider opacity-70">Data Collector</span>
                    </div>
                </x-nav.link>
                <x-nav.link route="help" icon="fas fa-question-circle">Help Guide</x-nav.link>
            @endif
        </nav>
    </div>

    @if (is_admin())
    <div class="px-3 mt-4">
        <div class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2 px-3">
            Administration
        </div>
        <nav class="space-y-1">
            <x-nav.link route="admin.users.index" icon="fas fa-users">Users</x-nav.link>
            <x-nav.link route="admin.collector.records" icon="fa-solid fa-chalkboard-user">Collectors</x-nav.link>
            <x-nav.link route="report.index" icon="fas fa-file-alt">Reports</x-nav.link>
            <x-nav.link route="chart.index" icon="fas fa-chart-bar">Analytics</x-nav.link>
            <x-nav.link route="admin.conducted-programs" icon="fas fa-calendar-check">Programs</x-nav.link>

            <!-- Settings Dropdown -->
            <x-nav.group label="Settings" route="admin.settings" icon="fas fa-cogs">
                <x-nav.group-item route="admin.settings.audit-trails.index" icon="fas fa-shield-alt">
                    Audit Trails
                </x-nav.group-item>
                <x-nav.group-item route="location.settings" icon="fas fa-map-marked-alt">
                    Location Settings
                </x-nav.group-item>
            </x-nav.group>
        </nav>
    </div>
    @endif

</div>
