<x-app-layout>
    <div class="flex justify-between">
        <h1 class="text-2xl font-bold mb-4 text-white">Chart</h1>
    </div>

    {{-- Check if an error message is set in the session and display it --}}
    <x-error-massage />
    <div>&#x2705; = Already Have Data</div>
    <div class="m-5 flex gap-5">
        <x-form action="{{ route('chart.show') }}">
            @csrf
            <x-form.select name="season" label="season" id="season" required>
                <option value="">-- Select Season --</option>
                @foreach ($seasons as $season)
                    <option value="{{ $season->id }}">{{ $season->name }}</option>
                @endforeach
            </x-form.select>
            @livewire('location-select',['liveProvinces'=>$liveProvinces,'liveDistricts'=>$liveDistricts,'liveAsCenters'=>$liveAsCenters,'liveAiRanges'=>$liveAiRanges])
            <x-form.submit>View Chart</x-form.submit>
        </x-form>
    </div>

    {{-- JavaScript to hide the error message after 5 seconds --}}


</x-app-layout>