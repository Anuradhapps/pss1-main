<x-app-layout>
    <div class="flex justify-between">
        <h1 class="text-2xl font-bold mb-4 text-white">Chart</h1>
    </div>

    {{-- Check if an error message is set in the session and display it --}}
    <x-error-massage />
    <div class="m-5">
        <x-form action="{{ route('chart.chartAi') }}">
            @csrf
            <livewire:location-select />
            <x-form.submit>View Chart</x-form.submit>
        </x-form>
    </div>

    {{-- JavaScript to hide the error message after 5 seconds --}}


</x-app-layout>