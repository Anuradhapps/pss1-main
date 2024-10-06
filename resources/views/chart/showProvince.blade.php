<x-app-layout>
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold mb-4 text-white">Province Chart</h1>
        <a href="{{ route('chart.index') }}"
           class="bg-red-800 text-white font-bold py-2 px-4 rounded hover:bg-red-900 text-sm mr-1">Back</a>
    </div>


    <div class="container px-2 mx-auto">

        <div class="p-4 m-1 bg-white rounded shadow">
            {!! $chart->container() !!}
        </div>

    </div>

    <script src="{{ $chart->cdn() }}"></script>

    {{ $chart->script() }}


</x-app-layout>
