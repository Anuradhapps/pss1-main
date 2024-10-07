<x-app-layout>
    <div class="flex justify-between items-center px-3">
        <span class="bg-blue-100 text-blue-800 font-bold py-1 px-2 rounded">Ai Chart</span>

        <div>
            <a href="{{ url('admin/chart/table/' . $collector->id) }}"
               class="bg-gray-600 text-white font-bold py-2 px-4 rounded hover:bg-gray-700 text-sm mr-1">View Table</a>
            <a href="{{ route('chart.index') }}"
               class="bg-red-800 text-white font-bold py-2 px-4 rounded hover:bg-red-900 text-sm mr-1">Back</a>
        </div>
       
    </div>


    <div class="container px-2 mx-auto">
       
        
        <div class="p-4 m-1 bg-white rounded shadow">
            {!! $chart->container() !!}
        </div>

    </div>

    <script src="{{ $chart->cdn() }}"></script>

    {{ $chart->script() }}


</x-app-layout>
