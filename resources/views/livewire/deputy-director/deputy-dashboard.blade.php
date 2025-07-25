<div class="p-6 space-y-8 bg-gray-900 text-white min-h-screen text-sm">

    {{-- Header --}}
    <div class="flex justify-between items-center flex-wrap gap-4">
        <h1 class="text-3xl font-bold text-white">📍 Deputy Director Dashboard</h1>
        <button wire:click="$refresh"
            class="px-4 py-2 text-sm font-medium bg-blue-600 rounded-lg hover:bg-blue-700 transition">
            🔄 Refresh
        </button>
    </div>

    {{-- District Info --}}
    <div class="bg-gray-800 rounded-xl p-6 shadow-md">
        <h2 class="text-xl font-semibold text-white mb-4">🗺️ District Information</h2>
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 text-gray-300">
            <div><span class="font-semibold text-white">District Name:</span> {{ $district->name }}</div>
            <div><span class="font-semibold text-white">District Code:</span> {{ $district->code ?? 'N/A' }}</div>
            <div><span class="font-semibold text-white">Region:</span> {{ $district->region->name ?? 'N/A' }}</div>
            <div><span class="font-semibold text-white">Province:</span> {{ $district->province->name ?? 'N/A' }}</div>
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-dd.stat-box color="green" title="Active Users" :value="$activeUsers" />
        <x-dd.stat-box color="yellow" title="Pending Tasks" value="-" />
        <x-dd.stat-box color="red" title="Urgent Alerts" value="-" />
        <x-dd.stat-box color="blue" title="New Reports" :value="$newReports" />
    </div>

    {{-- Filter + User Table --}}
    <div class="bg-gray-800 rounded-xl p-6 shadow-md space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="text-xl font-semibold text-white">👥 Users in District</h2>
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                <input type="text" wire:model.debounce.300ms="search" placeholder="🔍 Search by name"
                    class="w-full sm:w-64 px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring focus:ring-blue-500" />

                <select wire:model="selectedAiRange"
                    class="w-full sm:w-48 px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring focus:ring-blue-500">
                    <option value="">All AI Ranges</option>
                    @foreach ($aiRanges as $ai)
                        <option value="{{ $ai->id }}">{{ $ai->name }}</option>
                    @endforeach
                </select>
                <select wire:model="selectedSeason"
                    class="w-full sm:w-48 px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring focus:ring-blue-500">
                    <option value="">All Seasons</option>
                    @foreach ($seasons as $season)
                        <option value="{{ $season->id }}">{{ $season->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Users Table --}}
        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left border-collapse">
                <thead class="bg-gray-700 text-gray-300">
                    <tr>
                        <th class="px-4 py-2">👤 Name</th>
                        <th class="px-4 py-2">📍 AI Range</th>
                        <th class="px-4 py-2">🎓 Role</th>
                        <th class="px-4 py-2">🟢 Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($filteredCollectors as $collector)
                        <tr class="border-t border-gray-700 hover:bg-gray-700 transition">
                            <td class="px-4 py-2">{{ $collector->user->name }}</td>
                            <td class="px-4 py-2">{{ $collector->getAiRange->name ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ $collector->user->role }}</td>
                            <td class="px-4 py-2 font-medium text-green-400">
                                {{ $collector->user->status === 'active' ? '✅ Active' : '❌ Inactive' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-center text-gray-400">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Cards Section --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Audit Trails --}}
        <x-dd.card title="📝 Recent Activities">
            <ul class="space-y-2 text-gray-300 text-sm">
                @forelse ($recentActivities as $activity)
                    <li>🕒 <strong class="text-white">{{ $activity->user->name ?? 'N/A' }}</strong>
                        {{ $activity->title }} – <span
                            class="text-gray-500">{{ $activity->created_at->diffForHumans() }}</span></li>
                @empty
                    <li>No recent activities found.</li>
                @endforelse
            </ul>
        </x-dd.card>

        {{-- Pest Summary --}}
        <x-dd.card title="🐛 Pest Data Summary">
            <ul class="space-y-2 text-gray-300 text-sm">
                @foreach ($pestSummary as $summary)
                    <li>
                        <span class="text-blue-400">{{ $summary->season }}</span> <span
                            class="text-gray-500 ml-2">🗓️</span>
                        <span>{{ $summary->records }} records, {{ $summary->total_pests }} pests counted</span>
                    </li>
                @endforeach
            </ul>
        </x-dd.card>


        {{-- Chart --}}
        <x-dd.card title="📈 Pest Counts by Type">
            <div class="h-64">
                <canvas id="pestChart" class="w-full h-full"></canvas>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const ctx = document.getElementById('pestChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: @json($pestChartData->pluck('name')),
                            datasets: [{
                                label: 'Total Pests Counted',
                                data: @json($pestChartData->pluck('total_count')),
                                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                                borderColor: 'rgba(59, 130, 246, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
            </script>
        </x-dd.card>


        {{-- Reports --}}
        <x-dd.card title="📄 Latest Reports">
            <ul class="space-y-2 text-gray-300 text-sm">
                @foreach ($pestSummary as $summary)
                    <li>
                        <span class="text-blue-400">{{ $summary->season }}</span> <span
                            class="text-gray-500 ml-2">🗓️</span>
                        <span>{{ $summary->records }} records, {{ $summary->total_pests }} pests counted</span>
                    </li>
                @endforeach
            </ul>
        </x-dd.card>
    </div>

    {{-- Logs --}}
    <x-dd.card title="📚 System Logs">
        <ul class="text-gray-400 space-y-1 text-xs font-mono">
            @forelse ($recentActivities as $log)
                <li>[{{ $log->created_at }}] - {{ $log->title }}: {{ $log->user->name ?? 'N/A' }}</li>
            @empty
                <li>No logs found.</li>
            @endforelse
        </ul>
    </x-dd.card>

    {{-- Conducted Programs --}}
    <x-dd.card title="🎓 Recent Conducted Programs">
        <ul class="space-y-2 text-gray-300 text-sm">
            @forelse ($recentPrograms as $program)
                <li>
                    <strong class="text-white">{{ $program->program_name }}</strong> –
                    <span class="text-gray-500">{{ $program->conducted_date }}</span>
                    <span class="ml-2">Participants: {{ $program->participants_count }}</span>
                </li>
            @empty
                <li>No recent programs found.</li>
            @endforelse
        </ul>
    </x-dd.card>

    {{-- Actions --}}
    <div class="flex flex-wrap gap-3 pt-4">
        <a href="#" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition">⚙️ Manage
            Users</a>
        <a href="#" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">📑 View
            Reports</a>
        <a href="#" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition">📚 View
            Logs</a>
        <a href="#" class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition">➕ Add New
            Report</a>
    </div>

</div>
