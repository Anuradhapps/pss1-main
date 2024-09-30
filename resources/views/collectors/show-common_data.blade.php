<x-app-layout>

   
                <div class="p-6  border-b border-gray-200 overflow-x-auto">

                    <table  class="table-auto">

                        <thead>
                            <tr>
                                <th>
                                    Date
                                </th>
                                <th>
                                    
                                        Temperature
                                    
                                </th>
                                <th>
                                    
                                        Numbrer of rainy days
                                        
                                  
                                </th>
                                <th>
                                  
                                        Growth stage code
                                        
                                  
                                </th>
                                <th>
                                    
                                        More info.
                                   
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($commons ) && $commons->count())
                                {{ $count = 1 }}
                                @foreach ($commons as $row)
                                    <tr>


                                        <th>{{ $row->c_date }}</th>
                                        <td class="py-4 px-6"> {{ $row->temperature }}</td>
                                        <td class="py-4 px-6"> {{ $row->numbrer_r_day }}</td>
                                        <td class="py-4 px-6"> {{ $row->growth_s_c }}</td>
                                        <td class="py-4 px-6"> <a href="{{ route('admin.collector.pest.show', $row->id) }}">More>> </a>
                                        </td>
                                    </tr>
                                   
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">There are no data.</td>
                                </tr>
                            @endif
                        </tbody>





                    </table>
                </div>
        

</x-app-layout>
