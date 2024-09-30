<x-app-layout>
    <div class="m-5">
        <h1 class="text-2xl font-bold mb-4">Update Collector</h1>
        <x-form method="POST" action="{{ route('admin.collector.update', $collector) }}">
         
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2 sm:col-span-1">
                    <x-form.input name="phone_no" label="AI Range:">{{ $collector->phone_no }}</x-form.input>
                   
                </div>
              
                <div class="col-span-2 sm:col-span-1">
    
                    <x-form.select id="district" label="District" class="block mt-1 w-full" name="district">
                        <option value="">-- Select District --</option>
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}"
                                {{ $district->id == $collector->district ? 'selected' : '' }}>
                                {{ $district->name }}</option>
                        @endforeach
                    </x-form.select>
                </div>
                <div class="col-span-2 sm:col-span-1">
    
                    <x-form.select id="asc" label="ASC/Unit" class="block mt-1 w-full" name="asc">
                        <option value="">-- Select ASC --</option>
                        @foreach ($ascs as $asc)
                            <option value="{{ $asc->id }}"
                                {{ $asc->id == $selected_asc ? 'selected' : '' }}>
                                {{ $asc->name }}</option>
                        @endforeach
                    </x-form.select>
                    
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <x-form.input name="ai_range" label="AI Range:">{{ old('ai_range', $collector->ai_range)}}</x-form.input>
                   
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <x-form.input name="village" label="Village:">{{ old('village', $collector->village) }}</x-form.input>
                   
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <x-form.input name="gps_lati" label="GPS Latitude:">{{ old('gps_lati', $collector->gps_lati) }}</x-form.input>
                   
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <x-form.input name="gps_long" label="GPS Longitude:">{{ old('gps_long', $collector->gps_long) }}</x-form.input>
                   
                </div>
                <div class="col-span-2 sm:col-span-1">
                   
                    <x-form.input name="rice_variety" label="Rice Variety:">{{ old('rice_variety', $collector->rice_variety) }}</x-form.input>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <x-form.date name="date_establish" label="Date Established:">{{ old('date_establish', $collector->date_establish) }}</x-form.date>
                   
                </div>
                <div class="col-span-2 sm:col-span-1">
    
                    <x-form.submit>Update</x-form.submit>
    
                </div>
            </div>
        </x-form>
    </div>

    

</x-app-layout>
