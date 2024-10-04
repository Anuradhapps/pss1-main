<x-app-layout>
    <div class="flex justify-between">
        <h1 class="text-2xl font-bold mb-4 text-red-900">Chart</h1>
    </div>

    <div class="m-5">
        <x-form action="{{ route('chart.chartAi') }}">
            @csrf
           <livewire:location-select/>
            <x-form.submit>View Chart</x-form.submit>
        </x-form>
    </div>


</x-app-layout>
