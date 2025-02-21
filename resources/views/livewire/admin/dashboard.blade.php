@section('title', 'Dashboard')
<div
    class="flex flex-col items-start justify-between p-3 space-y-4 rounded-md shadow-md bg-gradient-to-r from-purple-900 to-purple-600 md:flex-row md:items-center md:space-y-0">
    <h1 class="text-2xl font-bold text-white">Dashboard</h1>
</div>


<div class="p-3 my-2 bg-white rounded-lg shadow-md">
    <h4 class="text-lg font-semibold text-gray-800">Pest Surveillance Program – Data Collection</h4>

    <p class="mt-2 text-sm text-gray-700">
        <b>Objectives:</b> The system provides an understanding of the Plant Protection Service's requirements for
        creating a new smartphone app for data collection for pest surveillance purposes.
    </p>
    <p class="mt-2 text-sm text-gray-700">
        The main purpose of the pest surveillance data collection web application is to record the density of target
        pests in the selected location throughout the cropping season on a regular basis.
    </p>
</div>

<div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
    <livewire:count-card :cardName="'Users'" :iconName="'users'" :color="'from-purple-600 to-purple-400'" />
    <livewire:count-card :cardName="'Collectors'" :iconName="'user-check'" :color="'from-green-600 to-green-400'" />
    <livewire:count-card :cardName="'Provinces'" :iconName="'map'" :color="'from-blue-600 to-blue-400'" />
    <livewire:count-card :cardName="'Districts'" :iconName="'flag'" :color="'from-red-600 to-red-400'" />
    <livewire:count-card :cardName="'ASC'" :iconName="'building'" :color="'from-yellow-600 to-yellow-400'" />
    <livewire:count-card :cardName="'AiRanges'" :iconName="'map-pin'" :color="'from-pink-600 to-pink-400'" />
    <livewire:count-card :cardName="'Pests'" :iconName="'bug'" :color="'from-indigo-600 to-indigo-400'" />
</div>
