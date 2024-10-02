<x-app-layout>
    <div class="flex justify-between">
        <h1 class="text-2xl font-bold mb-4 text-red-900">Chart</h1>
    </div>

    <div class="m-5">
       @foreach ($datas as $data)
           <div>{{ $data->village }}</div>
       @endforeach
    </div>


</x-app-layout>