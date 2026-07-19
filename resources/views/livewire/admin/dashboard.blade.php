@section('title', 'Admin Dashboard')

<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-10 right-20 w-32 h-32 bg-secondary/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="flex items-center gap-4 relative z-10">
            <div class="w-12 h-12 rounded-xl bg-primary/10 dark:bg-primary/20 flex items-center justify-center text-primary dark:text-primary-light">
                <i class="fas fa-chart-line text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">System Dashboard</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">National Pest Surveillance Programme Overview</p>
            </div>
        </div>
    </div>

    {{-- Description Section --}}
    <x-ui.card padding="p-6" class="border-t-4 border-primary shadow-lg" data-aos="fade-up">
        <h2 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-lg bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                <i class="fas fa-seedling"></i>
            </div>
            Programme Objectives
        </h2>

        <div class="grid md:grid-cols-2 gap-6 mt-6">
            <div class="flex items-start gap-4">
                <div class="w-8 h-8 shrink-0 rounded-full bg-primary/10 flex items-center justify-center text-primary mt-0.5">
                    1
                </div>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed text-sm">
                    The system provides an understanding of the Plant Protection Service's requirements for creating a
                    new smartphone web app to collect data on pest surveillance purposes.
                </p>
            </div>
            <div class="flex items-start gap-4">
                <div class="w-8 h-8 shrink-0 rounded-full bg-primary/10 flex items-center justify-center text-primary mt-0.5">
                    2
                </div>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed text-sm">
                    The main purpose of the pest surveillance data collection web application is to record the density of
                    target pests and damage intensity in the selected location throughout the cropping season on a
                    regular basis (Weekly).
                </p>
            </div>
        </div>
    </x-ui.card>

    {{-- Count Cards Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" data-aos="fade-up" data-aos-delay="100">
        <livewire:count-card :cardName="'Users'" :iconName="'fas fa-users'" :color="'from-purple-600 to-indigo-600'" />
        <livewire:count-card :cardName="'Collectors'" :iconName="'fas fa-user-check'" :color="'from-emerald-500 to-teal-500'" />
        <livewire:count-card :cardName="'Provinces'" :iconName="'fas fa-map'" :color="'from-sky-500 to-blue-600'" />
        <livewire:count-card :cardName="'Districts'" :iconName="'fas fa-flag'" :color="'from-rose-500 to-red-600'" />
        
        <livewire:count-card :cardName="'ASC'" :iconName="'fas fa-building'" :color="'from-amber-500 to-orange-500'" />
        <livewire:count-card :cardName="'AiRanges'" :iconName="'fas fa-map-pin'" :color="'from-pink-500 to-rose-500'" />
        <livewire:count-card :cardName="'Pests'" :iconName="'fas fa-bug'" :color="'from-violet-500 to-purple-600'" />
        <livewire:count-card :cardName="'ConductedPrograms'" :iconName="'fas fa-chalkboard-teacher'" :color="'from-cyan-500 to-blue-500'" />
    </div>
</div>
