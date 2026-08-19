<x-app-layout>

    <x-headings.chart_heading title="Season Chart" icon="fas fa-chart-line" back-route="chart.index" />


    <div class="container mx-auto">

        <div class="p-4 m-1 bg-white rounded shadow">
            {!! $chart->container() !!}
        </div>

    </div>

    <script src="{{ $chart->cdn() }}"></script>

    {{ $chart->script() }}


</x-app-layout>
