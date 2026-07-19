@section('title', 'System Settings')

<div class="space-y-6">
    <div class="flex flex-col gap-2 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-colors dark:border-slate-800 dark:bg-slate-900">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-300">
                <i class="fas fa-cog text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">System Settings</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Manage system-wide configurations</p>
            </div>
        </div>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-colors dark:border-slate-800 dark:bg-slate-900">
            <h2 class="mb-4 text-lg font-semibold text-slate-900 dark:text-white">Application Settings</h2>
            <livewire:admin.settings.application-settings />
        </div>

    </div>
