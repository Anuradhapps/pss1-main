@section('title', 'Dashboard')
<h1 class="p-5 text-3xl font-bold text-red-100 border shadow-2xl bg-purple-950">Dashboard</h1>

<div class="card">
    <h4 class="">Pest Surveillance Program – Data Collection</h4>

    <p class=""><b>Objectives</b></p>
    <p class="">The system provides an understanding of the Plant Protection Service's requirements for
        creating a new smartphone
        app for data collection for pest surveillance purposes.</p>
    <p class=""> The main purpose of the pest surveillance data
        collection web application is to record the density of target pests in the selected location throughout the
        cropping season on a regular basis. </p>
</div>
<div class="flex flex-wrap gap-2 py-6">
    <livewire:count-card :cardName="'Users'" :iconName="''" :color="'from-purple-900 to-purple-700'" />
    <livewire:count-card :cardName="'Collectors'" :iconName="''" :color="'from-green-900 to-green-700'" />

    <livewire:count-card :cardName="'Provinces'" :iconName="''" :color="'from-blue-900 to-blue-700'" />
    <livewire:count-card :cardName="'Districts'" :iconName="''" :color="'from-red-900 to-red-700'" />
    <livewire:count-card :cardName="'ASC'" :iconName="''" :color="'from-yellow-900 to-yellow-700'" />
    <livewire:count-card :cardName="'AiRanges'" :iconName="''" :color="'from-pink-900 to-pink-700'" />
    <livewire:count-card :cardName="'Pests'" :iconName="''" :color="'from-indigo-900 to-indigo-700'" />
</div>
