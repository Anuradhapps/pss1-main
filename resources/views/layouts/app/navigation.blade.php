<button @click.stop="sidebarOpen = !sidebarOpen" class="pt-4 pl-1 pr-2 md:hidden focus:outline-none">
    <svg class="w-6 text-white transition duration-150 ease-in-out" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
        fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
    </svg>
</button>

<div class="py-4">
    <a href="{{ route('admin') }}" class="font-bold text-gray-100">
        @php
            //cache the logo setting to reduce calling the database
            $applicationLogo = Cache::rememberForever('applicationLogo', function () {
                return \App\Models\Setting::where('key', 'applicationLogo')->value('value');
            });

            $applicationLogoDark = Cache::rememberForever('applicationLogoDark', function () {
                return \App\Models\Setting::where('key', 'applicationLogoDark')->value('value');
            });
        @endphp

        @if (storage_exists($applicationLogo))
            <picture>
                <source srcset="{{ storage_url($applicationLogoDark) }}" media="(prefers-color-scheme: dark)">
                <img src="{{ storage_url($applicationLogo) }}" alt="{{ config('app.name') }}">
            </picture>
        @else
            {{ config('app.name') }}
        @endif
    </a>
</div>



<x-nav.link route="admin" icon="fas fa-home">Dashboard</x-nav.link>
@if (has_role('collector'))
    <x-nav.link route="collector.create" icon="fas fa-user-tie">Collector Info</x-nav.link>
    <x-nav.link route="pestdata.index" icon="fa fa-id-card">Pest Data</x-nav.link>
@endif

@if (has_role('admin'))
    <x-nav.link route="admin.users.index" icon="fas fa-users">Users</x-nav.link>
    <x-nav.link route="pest.index" icon="fas fa-bug">Pest</x-nav.link>
    <x-nav.link route="admin.collector.records" icon="fas fa-user-tie">Collectors</x-nav.link>
    <x-nav.link route="report.index" icon="fas fa-file-alt">Report</x-nav.link>
    <x-nav.link route="chart.index" icon="fas fa-chart-bar">Data/Charts</x-nav.link>
@endif
@if (can('view_audit_trails') || can('view_sent_emails'))
    <x-nav.group label="Settings" route="admin.settings" icon="fas fa-cogs">
        @if (can('view_audit_trails'))
            <x-nav.group-item route="admin.settings.audit-trails.index" icon="far fa-circle">Audit Trails
            </x-nav.group-item>
        @endif

        @if (can('view_sent_emails'))
            <x-nav.group-item route="admin.settings.sent-emails" icon="far fa-circle">Sent Emails</x-nav.group-item>
        @endif

        @if (is_admin())
            <x-nav.group-item route="admin.settings" icon="far fa-circle">System Settings</x-nav.group-item>
            <x-nav.group-item route="admin.settings.roles.index" icon="far fa-circle">Roles</x-nav.group-item>
        @endif
    </x-nav.group>
@endif
