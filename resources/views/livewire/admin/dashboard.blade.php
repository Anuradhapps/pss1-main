@section('title', 'Dashboard')

{{-- Top Heading --}}
<x-headings.topHeading title="Dashboard" icon="fas fa-home" class="bg-green-700" />

{{-- Description Card --}}
<div class="m-2  p-3 bg-gray-950 border border-gray-800  shadow-xl text-white space-y-5">
    <h2 class="border-b-[1px]  text-base sm:text-2xl font-bold tracking-wide text-green-300 flex gap-2 justify-center">
        🌿 Pest Surveillance Programme
    </h2>

    <div class=" text-base leading-relaxed space-y-2">
        <p class="text-gray-200 font-semibold  ">Objectives :</p>
        <p class="text-gray-400">
            <i class="fas fa-star text-white me-1"></i>
            The system provides an understanding of the
            Plant Protection Service's requirements for creating a new smartphone web app to collect data on pest
            surveillance purposes.
        </p>
        <p class="text-gray-400">
            <i class="fas fa-star text-white me-1"></i>
            The main purpose of the pest surveillance data collection web application is to record the density of
            target pests and damage intensity in the selected location throughout the cropping season on a regular basis
            (Weekly).
        </p>
    </div>
</div>

{{-- Count Cards Grid --}}
<div class="max-w-7xl mx-auto px-2 py-2">
    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
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
