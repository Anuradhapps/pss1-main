@section('title', 'Dashboard')

<!-- Header Section -->
<div
    class="flex flex-col items-start justify-between p-4 space-y-4 rounded-md shadow-md bg-gradient-to-r from-purple-900 to-purple-600 md:flex-row md:items-center md:space-y-0">
    <h1 class="text-3xl font-extrabold tracking-wide text-white">Dashboard</h1>
</div>

<!-- Description Card -->
<div class="p-6 mx-auto my-4 text-white bg-gray-900 rounded-lg shadow-md">
    <h4 class="text-xl font-semibold">Pest Surveillance Programme – Data Collection</h4>

    <p class="mt-3 text-base leading-relaxed text-gray-300">
        <strong>Objectives:</strong> The system provides an understanding of the Plant Protection Service's
        requirements for creating a new smartphone web app to collect data on pest surveillance purposes.
    </p>

    <p class="mt-3 text-base leading-relaxed text-gray-300">
        The main purpose of the pest surveillance data collection web application is to record the density of
        target pests and damage intensity in the selected location throughout the cropping season on a
        regular basis (Weekly).
    </p>
</div>

<!-- Count Cards Grid -->
<div
    class="grid grid-cols-1 gap-4 px-4 mx-auto sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 2xl:grid-cols-7 max-w-7xl">
    <livewire:count-card :cardName="'Users'" :iconName="'fas fa-users'" :color="'from-purple-700 to-purple-500'" />
    <livewire:count-card :cardName="'Collectors'" :iconName="'fas fa-user-check'" :color="'from-green-700 to-green-500'" />
    <livewire:count-card :cardName="'Provinces'" :iconName="'fas fa-map'" :color="'from-blue-700 to-blue-500'" />
    <livewire:count-card :cardName="'Districts'" :iconName="'fas fa-flag'" :color="'from-red-700 to-red-500'" />
    <livewire:count-card :cardName="'ASC'" :iconName="'fas fa-building'" :color="'from-yellow-600 to-yellow-400'" />
    <livewire:count-card :cardName="'AiRanges'" :iconName="'fas fa-map-pin'" :color="'from-pink-700 to-pink-500'" />
    <livewire:count-card :cardName="'Pests'" :iconName="'fas fa-bug'" :color="'from-indigo-700 to-indigo-500'" />
</div>
