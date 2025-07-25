@section('title', 'Dashboard')

{{-- Top Heading --}}
<x-headings.topHeading title="Dashboard" icon="fas fa-home"
    class="bg-gradient-to-r from-green-700 to-green-500 shadow-md" />

{{-- Description Card --}}
<div class="m-4 p-6 rounded-xl bg-gray-900 border border-gray-800 shadow-2xl text-white space-y-5 " data-aos="fade-up">
    <h2
        class="text-xl sm:text-2xl font-bold text-center text-green-300 flex items-center justify-center gap-2 border-b pb-2 border-green-500">
        <i class="fas fa-seedling"></i> Pest Surveillance Programme
    </h2>

    <div class="text-base leading-relaxed space-y-3">
        <p class="text-gray-300 font-semibold">Objectives:</p>

        <div class="flex items-start gap-2 text-gray-400">
            <i class="fas fa-star text-yellow-400 mt-1"></i>
            <p>
                This system enables the Plant Protection Service to efficiently gather field data via a mobile-friendly
                web application focused on pest surveillance.
            </p>
        </div>

        <div class="flex items-start gap-2 text-gray-400">
            <i class="fas fa-star text-yellow-400 mt-1"></i>
            <p>
                It aims to record pest density and damage intensity weekly throughout the cropping season across
                selected locations.
            </p>
        </div>
    </div>
</div>

{{-- Count Cards Grid --}}
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6" data-aos="fade-up"
        data-aos-delay="100">
        <livewire:count-card :cardName="'Users'" :iconName="'fas fa-users'" :color="'from-purple-700 to-purple-500'" />
        <livewire:count-card :cardName="'Collectors'" :iconName="'fas fa-user-check'" :color="'from-green-700 to-green-500'" />
        <livewire:count-card :cardName="'Provinces'" :iconName="'fas fa-map'" :color="'from-blue-700 to-blue-500'" />
        <livewire:count-card :cardName="'Districts'" :iconName="'fas fa-flag'" :color="'from-red-700 to-red-500'" />
        <livewire:count-card :cardName="'ASC'" :iconName="'fas fa-building'" :color="'from-yellow-600 to-yellow-400'" />
        <livewire:count-card :cardName="'AiRanges'" :iconName="'fas fa-map-pin'" :color="'from-pink-700 to-pink-500'" />
        <livewire:count-card :cardName="'Pests'" :iconName="'fas fa-bug'" :color="'from-indigo-700 to-indigo-500'" />
        <livewire:count-card :cardName="'ConductedPrograms'" :iconName="'fas fa-chalkboard-teacher'" :color="'from-orange-700 to-orange-500'" />
    </div>
</div>
