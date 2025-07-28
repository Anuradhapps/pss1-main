<!-- This is the improved Blade view section -->
<x-headings.topHeading title="{{ $district->name }} District Dashboard" icon="fas fa-clipboard"
    class="bg-gradient-to-r from-green-900 to-green-900 shadow-md" />

<div class="p-2 space-y-4 bg-gray-900 text-white min-h-screen text-sm">
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-dd.stat-box color="green" title="Total Users Count" :value="$totalUsersCount" />
        <x-dd.stat-box color="yellow" title="This Season Users" :value="$seasonUserCount" />
        <x-dd.stat-box color="red" title="Urgent Alerts" value="-" />
        <x-dd.stat-box color="blue" title="New Reports" :value="$newReports" />
    </div>

    <!-- Filter + User Table -->
    <div class="bg-gray-800 p-4 rounded shadow-md">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="text-xl font-semibold text-white">👥 Users in District</h2>
            <div class="flex flex-wrap gap-3 w-full sm:w-auto">
                <input type="text" wire:model.debounce.500ms="search" placeholder="🔍 Search by name"
                    class="w-full sm:w-64 px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400" />

                <select wire:model="selectedAiRange"
                    class="w-full sm:w-48 px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white">
                    <option value="">All AI Ranges</option>
                    @foreach ($aiRanges as $ai)
                        <option value="{{ $ai->id }}">{{ $ai->name }}</option>
                    @endforeach
                </select>

                <select wire:model="selectedSeason"
                    class="w-full sm:w-48 px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white">
                    <option value="">All Seasons</option>
                    @foreach ($seasons as $season)
                        <option value="{{ $season->id }}">{{ $season->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Users Table -->
        <div class="overflow-x-auto mt-4">
            <table class="w-full table-auto text-left">
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
                        <tr class="border-t border-gray-700 hover:bg-gray-700">
                            <td class="px-4 py-2">{{ $collector->user->name }}</td>
                            <td class="px-4 py-2">{{ $collector->getAiRange->name ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ ucfirst($collector->user->role) }}</td>
                            <td
                                class="px-4 py-2 font-medium {{ $collector->user->status === 'active' ? 'text-green-400' : 'text-red-400' }}">
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

    <!-- Charts and Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

        <x-dd.card title="🐛 Pest Counts by Type">
            <div class="h-64">
                <canvas id="pestChart" class="w-full h-full"></canvas>
            </div>

            <script>
                Livewire.on('refreshChart', () => {
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
                            responsive: true,
                            maintainAspectRatio: false,
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

        <x-dd.card title="Recent Conducted Programs">
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

        <x-dd.card title="System Logs">
            <ul class="text-gray-400 space-y-1 text-xs font-mono">
                @forelse ($recentActivities as $log)
                    <li>[{{ $log->created_at }}] - {{ $log->title }}: {{ $log->user->name ?? 'N/A' }}</li>
                @empty
                    <li>No logs found.</li>
                @endforelse
            </ul>
        </x-dd.card>
    </div>

    <!-- Actions -->
    <div class="flex flex-wrap gap-3 pt-4">
        <a href="#" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">⚙️ Manage Users</a>
        <a href="#" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">📑 View Reports</a>
        <a href="#" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg">📚 View Logs</a>
        <a href="#" class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg">➕ Add Report</a>
    </div>
</div>
