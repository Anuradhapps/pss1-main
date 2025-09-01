<x-minimal>
    <div class="md:px-20">
        {{-- @livewire('graph.chart') --}}

        {{-- <livewire:graph.pest-other-comparison /> --}}
        {{-- <livewire:test-livewire /> --}}
        @php
            $district = 0;
            $daysCount = 100;
        @endphp

        <livewire:pest-memo-card :districtId="$district" :days="$daysCount" />


    </div>
</x-minimal>
