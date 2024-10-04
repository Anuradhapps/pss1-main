<x-app-layout>
    <div class="flex justify-between">
        <h1 class="text-2xl font-bold mb-4 text-red-900">Chart</h1>
    </div>

    <div class="container px-2 mx-auto">

        <div class="p-4 m-1 bg-white rounded shadow">
            {!! $chart->container() !!}
        </div>

    </div>

    <script src="{{ $chart->cdn() }}"></script>

    {{ $chart->script() }}


</x-app-layout>
