<div class="px-2">

    <!-- Sidebar Logo -->
    <div class="flex items-center justify-center p-2 rounded bg-green-950 ">
        <a href="{{ route('admin') }}" class="text-lg font-bold text-gray-100">
            @php
                $applicationLogo = Cache::rememberForever(
                    'applicationLogo',
                    fn() => \App\Models\Setting::where('key', 'applicationLogo')->value('value'),
                );
                $applicationLogoDark = Cache::rememberForever(
                    'applicationLogoDark',
                    fn() => \App\Models\Setting::where('key', 'applicationLogoDark')->value('value'),
                );
            @endphp
            @if (storage_exists($applicationLogo))
                <picture>
                    <source srcset="{{ storage_url($applicationLogoDark) }}" media="(prefers-color-scheme: dark)">
                    <img src="{{ storage_url($applicationLogo) }}" alt="{{ config('app.name') }}" class="w-32">
                </picture>
            @else
                {{-- {{ config('app.name') }} --}}
                National Pest Surveillance System
            @endif
        </a>
    </div>

    <!-- Navigation Links -->
    <div class="space-y-2">
        <x-nav.link route="admin" icon="fas fa-home" class="text-purple-300 hover:bg-purple-800">Dashboard</x-nav.link>

        @if (has_role('collector'))
            <x-nav.link route="collector.create" icon="fas fa-user-tie"
                class="text-purple-300 hover:bg-purple-800">Collector</x-nav.link>
        @endif

        @if (can('view_users'))
            <x-nav.link route="admin.users.index" icon="fas fa-users"
                class="text-purple-300 hover:bg-purple-800">Users</x-nav.link>
        @endif

        {{-- @if (can('view_pests'))
            <x-nav.link route="pest.index" icon="fas fa-bug"
                class="text-purple-300 hover:bg-purple-800">Pest</x-nav.link>
        @endif --}}

        @if (can('view_collectors'))
            <x-nav.link route="admin.collector.records" icon="fas fa-user-tie"
                class="text-purple-300 hover:bg-purple-800">Collectors</x-nav.link>
        @endif

        @if (can('view_reports'))
            <x-nav.link route="report.index" icon="fas fa-file-alt"
                class="text-purple-300 hover:bg-purple-800">Reports</x-nav.link>
        @endif

        @if (can('view_data_charts'))
            <x-nav.link route="chart.index" icon="fas fa-chart-bar"
                class="text-purple-300 hover:bg-purple-800">Data/Charts</x-nav.link>
        @endif

        <!-- Settings Section -->
        @if (can('view_audit_trails') || can('view_sent_emails'))
            <x-nav.group label="Settings" route="admin.settings" icon="fas fa-cogs"
                class="text-purple-300 hover:bg-purple-800">
                @if (can('view_audit_trails'))
                    <x-nav.group-item route="admin.settings.audit-trails.index" icon="far fa-circle">Audit
                        Trails</x-nav.group-item>
                @endif
                @if (can('view_sent_emails'))
                    <x-nav.group-item route="admin.settings.sent-emails" icon="far fa-circle">Sent
                        Emails</x-nav.group-item>
                @endif
                @if (is_admin())
                    <x-nav.group-item route="admin.settings" icon="far fa-circle">System Settings</x-nav.group-item>
                    <x-nav.group-item route="admin.settings.roles.index" icon="far fa-circle">Roles</x-nav.group-item>
                @endif
            </x-nav.group>
        @endif
    </div>

</div>
