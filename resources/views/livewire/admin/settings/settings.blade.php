@section('title', 'System Settings')

<div class="">
    <!-- Page Title -->
    <div class="mb-4 text-center bg-gray-950 p-2 rounded-md">
        <h1 class="text-3xl font-bold text-white">⚙️ System Settings</h1>
        <p class="text-gray-400 mt-1">Manage system-wide configurations</p>
    </div>

    <!-- Settings Cards -->
    <div class="grid gap-6 md:grid-cols-2">
        <!-- Application Settings -->
        <div class="bg-gray-900 shadow rounded-xl p-6">
            <h2 class="text-xl font-semibold text-gray-100 mb-4">🛠️ Application Settings</h2>
            <livewire:admin.settings.application-settings />
        </div>

        {{-- <!-- Application Logo -->
        <div class="bg-gray-900 shadow rounded-xl p-6">
            <h2 class="text-xl font-semibold text-gray-100 mb-4">🖼️ Application Logo</h2>
            <livewire:admin.settings.application-logo />
        </div>

        <!-- Login Logo -->
        <div class="bg-gray-900 shadow rounded-xl p-6">
            <h2 class="text-xl font-semibold text-gray-100 mb-4">🔒 Login Logo</h2>
            <livewire:admin.settings.login-logo />
        </div>

        <!-- Security Settings -->
        <div class="bg-gray-900 shadow rounded-xl p-6">
            <h2 class="text-xl font-semibold text-gray-100 mb-4">🛡️ Security Settings</h2>
            <livewire:admin.settings.security-settings />
        </div>
    </div> --}}
    </div>
