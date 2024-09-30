
<x-app-layout>
    
    <table class="table-auto">
        <thead>
            <tr>

                <th scope="col" class="py-2 px-2">
                    <div class="flex items-center">Pest Name</div>
                </th>
                <th scope="col" class="py-2 px-2">
                    <div class="flex items-center">L - 01 </div>
                </th>
                <th scope="col" class="py-2 px-2">
                    <div class="flex items-center">L - 02</div>
                </th>
                <th scope="col" class="py-2 px-2">
                    <div class="flex items-center">L - 03</div>
                </th>
                <th scope="col" class="py-2 px-2">
                    <div class="flex items-center">L - 04</div>
                </th>
                <th scope="col" class="py-2 px-2">
                    <div class="flex items-center">L - 05</div>
                </th>
                <th scope="col" class="py-2 px-2">
                    <div class="flex items-center">L - 06</div>
                </th>
                <th scope="col" class="py-2 px-2">
                    <div class="flex items-center">L - 07</div>
                </th>
                <th scope="col" class="py-2 px-2">
                    <div class="flex items-center">L - 08</div>
                </th>
                <th scope="col" class="py-2 px-2">
                    <div class="flex items-center">L - 09</div>
                </th>
                <th scope="col" class="py-2 px-2">
                    <div class="flex items-center">L - 10</div>
                </th>
                <th scope="col" class="py-2 px-2">
                    <div class="flex items-center">Total</div>
                </th>
                <th scope="col" class="py-2 px-2">
                    <div class="flex items-center">Mean</div>
                </th>
                <th scope="col" class="py-2 px-2">
                    <div class="flex items-center">Code</div>
                </th>
            </tr>
        </thead>
       
        <tbody>
            @foreach ($pests as $pest)

            <tr>
                <td>{{ $pest->pest_name }}</td>
                <td>{{ $pest->location_one }}</td>
                <td>{{ $pest->location_two }}</td>
                <td>{{ $pest->location_three }}</td>
                <td>{{ $pest->location_four }}</td>
                <td>{{ $pest->location_five }}</td>
                <td>{{ $pest->location_six }}</td>
                <td>{{ $pest->location_seven }}</td>
                <td>{{ $pest->location_eight }}</td>
                <td>{{ $pest->location_nine }}</td>
                <td>{{ $pest->location_ten }}</td>
                <td>{{ $pest->total }}</td>
                <td></td>
                
                <td></td>
            </tr>
            @endforeach

        </tbody>
    </table>


</x-app-layout>
