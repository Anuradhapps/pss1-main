<x-app-layout>
  

    <div class="p-6  border-b border-gray-200 overflow-x-auto">
<table class="table-auto">
  <thead>
    <tr>
      <th> No.</th>
      <th>Name</th>
      <th> Email</th>
      <th> Phone No.</th>
        <th> District</th>
      <th> ASC</th>
      <th> AI Range</th>
      <th>  Village</th>
      <th>Rice Variety</th>
      <th>   Latitude    </th>
      <th>Longitude</th>
      <th> More info.</th>
    </tr>
  </thead>
  <tbody>
     @if (!empty($collectors) && $collectors->count())
                    {{ $count = 1 }}
                    @foreach ($collectors as $row)
                        <tr >


                            <th >
                                {{ $count++ }}</th>
                            <td class="py-4 px-6"> {{ $row->name }}</td>
                            <td class="py-4 px-6"> {{ $row->email }}</td>
                            <td class="py-4 px-6"> {{ $row->phone_no }}</td>
                            <td class="py-4 px-6"> {{ $row->dname }}</td>
                            <td class="py-4 px-6"> {{ $row->asname }}</td>
                            <td class="py-4 px-6"> {{ $row->ai_range }}</td>
                            <td class="py-4 px-6"> {{ $row->village }}</td>
                            <td class="py-4 px-6"> {{ $row->rice_variety }}</td>
                            <td class="py-4 px-6"> {{ $row->gps_lati }}</td>
                            <td class="py-4 px-6"> {{ $row->gps_long }}</td>
                            <td class="py-4 px-6"> <a {{-- href="{{ route('admin.collector.visit.commondata', $row->user_id) }}">More>> --}}
                                    href="{{ route('admin.collector.common.show', $row->user_id) }}"> More>>
                                </a>
                            </td>


                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9">There are no data.</td>
                    </tr>
                @endif
  </tbody>
</table>
        
    </div>

</x-app-layout>
