<div class="w-full text-slate-700 dark:text-slate-300 flex flex-col gap-6 py-4 select-none">

    <!-- Section: Main -->
    <div class="px-3">
        <div class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-3">
            Overview
        </div>

        <nav class="space-y-1 text-sm">
            <x-nav.link route="dashboard" icon="fas fa-fw fa-house text-slate-400 dark:text-slate-500">
                Dashboard
            </x-nav.link>

            @if (has_role('deputyDirector'))
                <x-nav.link route="deputy.dashboard" icon="fas fa-fw fa-chart-pie text-slate-400 dark:text-slate-500">
                    Deputy Overview
                </x-nav.link>
            @endif

            @if (has_role('pda'))
                <x-nav.link route="pda.dashboard" icon="fas fa-fw fa-clipboard-check text-slate-400 dark:text-slate-500">
                    PDA Dashboard
                </x-nav.link>
            @endif

            @if (has_role('extensionAndTrainingDirector'))
                <x-nav.link route="extensionAndTrainingDirector.dashboard"
                    icon="fas fa-fw fa-graduation-cap text-slate-400 dark:text-slate-500">
                    Training Portal
                </x-nav.link>
            @endif
        </nav>
    </div>

    <!-- Section: Field Collection (Conditional) -->
    @if (has_role('collector'))
        <div class="px-3 border-t border-slate-200/60 dark:border-slate-800/80 pt-4">
            <div class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-3">
                Field Operations
            </div>

            <nav class="space-y-1 text-sm">
                <x-nav.link route="collector.index" icon="fas fa-fw fa-bug text-emerald-500">
                    <div class="flex flex-col">
                        <span class="font-medium leading-none">Rice Pest Data</span>
                        <span class="text-[11px] text-slate-400 dark:text-slate-500 font-normal mt-1">Collector
                            Portal</span>
                    </div>
                </x-nav.link>

                <x-nav.link route="help" icon="fas fa-fw fa-circle-question text-slate-400 dark:text-slate-500">
                    Help & Support
                </x-nav.link>
            </nav>
        </div>
    @endif

    <!-- Section: Administration (Conditional) -->
    @if (is_admin())
        <div class="px-3 border-t border-slate-200/60 dark:border-slate-800/80 pt-4">
            <div class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-3">
                Management
            </div>

            <nav class="space-y-1 text-sm">
                <x-nav.link route="admin.users.index" icon="fas fa-fw fa-users text-slate-400 dark:text-slate-500">
                    Users
                </x-nav.link>

                <x-nav.link route="admin.collector.records"
                    icon="fas fa-fw fa-clipboard-user text-slate-400 dark:text-slate-500">
                    Collectors
                </x-nav.link>

                <x-nav.link route="report.index" icon="fas fa-fw fa-file-lines text-slate-400 dark:text-slate-500">
                    Reports
                </x-nav.link>

                <x-nav.link route="chart.index" icon="fas fa-fw fa-chart-column text-slate-400 dark:text-slate-500">
                    Analytics
                </x-nav.link>

                <x-nav.link route="admin.conducted-programs"
                    icon="fas fa-fw fa-calendar-check text-slate-400 dark:text-slate-500">
                    Programs
                </x-nav.link>

                <!-- Settings Dropdown -->
                <x-nav.group label="System Settings" route="admin.settings"
                    icon="fas fa-fw fa-gears text-slate-400 dark:text-slate-500"
                    activeRoutes="admin.settings.*|location.settings">

                    <x-nav.group-item route="admin.settings.audit-trails.index" icon="fas fa-fw fa-list-check">
                        Audit Trails
                    </x-nav.group-item>

                    <x-nav.group-item route="admin.settings.roles.index" icon="fas fa-fw fa-user-shield">
                        Roles
                    </x-nav.group-item>

                    <x-nav.group-item route="admin.settings.permissions.index" icon="fas fa-fw fa-key">
                        Permissions
                    </x-nav.group-item>

                    <x-nav.group-item route="location.settings" icon="fas fa-fw fa-location-dot">
                        Location Settings
                    </x-nav.group-item>
                </x-nav.group>
            </nav>
        </div>
    @endif

</div>
