@section('title', 'Edit Collector Info')

<x-app-layout>
    <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        <!-- Header Card -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 sm:p-8 mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 relative overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-10 right-20 w-32 h-32 bg-secondary/5 rounded-full blur-2xl pointer-events-none"></div>

            <div class="flex items-center gap-5 relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/50 dark:to-emerald-800/50 flex items-center justify-center text-emerald-700 dark:text-emerald-400 ring-1 ring-emerald-300 dark:ring-emerald-700 shadow-sm shrink-0">
                    <i class="fas fa-user-edit text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Collector Edit</h3>
                    <div class="flex items-center gap-2 mt-1.5">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                            <i class="fas fa-calendar-alt text-primary"></i> {{ $collector->riceSeason->name }} Season
                        </span>
                    </div>
                </div>
            </div>

            <div class="w-full sm:w-auto relative z-10">
                <a href="{{ route('admin.collector.records') }}"
                    class="inline-flex justify-center items-center gap-2 w-full sm:w-auto px-5 py-2.5 text-sm font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary dark:hover:text-primary transition-all">
                    <i class="fas fa-arrow-left text-xs"></i> Back to Collectors
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <x-form action="{{ route(has_role('admin') ? 'admin.collector.update' : 'collector.update', $collector->id) }}"
                method="POST" class="p-6 sm:p-8 md:p-10 space-y-10">
                @csrf
                @method('PUT')

                <!-- Contact & Assignment Section -->
                <div>
                    <h4 class="text-base font-bold text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 pb-3 mb-6 flex items-center gap-2">
                        <i class="fas fa-address-card text-primary opacity-80"></i> Contact & Assignment
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <!-- Phone Number -->
                        <x-form.input name="phone_no" label='Phone Number:' placeholder="Enter contact number">
                            {{ old('phone_no', $collector->phone_no) }}
                        </x-form.input>

                        <!-- Region -->
                        <x-form.select name="region" label='Region:' id="region">
                            <option value="1" {{ $collector->region_id == 1 ? 'selected' : '' }}>Provincial</option>
                            <option value="2" {{ $collector->region_id == 2 ? 'selected' : '' }}>Inter Provincial</option>
                            <option value="3" {{ $collector->region_id == 3 ? 'selected' : '' }}>Mahaweli</option>
                        </x-form.select>

                        @if (Auth::user()->name == 'npssoldata' || 'admin' || 'Admin')
                            <!-- Season -->
                            <div class="md:col-span-2">
                                <x-form.select name="season" label='Season:' id="season">
                                    <option value="">-- Select Season --</option>
                                    @foreach (['20212022' => '2021/2022 Maha', '20222022' => '2022 Yala', '20222023' => '2022/2023 Maha', '20232023' => '2023 Yala', '20232024' => '2023/2024 Maha', '20242024' => '2024 Yala', '20242025' => '2024/2025 Maha', '20252025' => '2025 Yala'] as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ $collector->rice_season_id == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </x-form.select>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Geographic Location Section -->
                <div>
                    <h4 class="text-base font-bold text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 pb-3 mb-6 flex items-center gap-2">
                        <i class="fas fa-map-marked-alt text-primary opacity-80"></i> Geographic Location
                    </h4>
                    
                    <div class="bg-slate-50 dark:bg-slate-800/40 p-6 rounded-2xl border border-slate-200 dark:border-slate-700/60 shadow-sm">
                        <livewire:location-select :selectedProvince="$collector->province" :selectedDistrict="$collector->district" :selectedAsCenter="$collector->asc" :selectedAiRange="$collector->ai_range" />
                        
                        <div class="mt-8">
                            <x-form.input name="village" label='Village / Local Area:' placeholder="Enter village or street name">
                                {{ old('village', $collector->village) }}
                            </x-form.input>
                        </div>
                    </div>
                </div>

                <!-- GPS Section -->
                <div>
                    <h4 class="text-base font-bold text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 pb-3 mb-6 flex items-center gap-2">
                        <i class="fas fa-satellite text-primary opacity-80"></i> GPS Coordinates
                    </h4>
                    <div class="bg-slate-50 dark:bg-slate-800/40 p-6 rounded-2xl border border-slate-200 dark:border-slate-700/60 shadow-sm">
                        <x-gpsFill :collector="$collector" />
                    </div>
                </div>

                <!-- Farming Details Section -->
                <div>
                    <h4 class="text-base font-bold text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 pb-3 mb-6 flex items-center gap-2">
                        <i class="fas fa-seedling text-primary opacity-80"></i> Farming Details
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-6">
                        <!-- Rice Variety -->
                        <x-form.input name="rice_variety" label='Rice Variety:' placeholder="e.g. BG 360">
                            {{ old('rice_variety', $collector->rice_variety) }}
                        </x-form.input>

                        <!-- Date Established -->
                        <x-form.date name="date_establish" label='Date Established:'>
                            {{ old('date_establish', $collector->date_establish) }}
                        </x-form.date>

                        <!-- Establish Method -->
                        <x-form.select name="established_method" label='Established Method:'>
                            <option value="">-- Select Method --</option>
                            <option value="Broadcast" {{ $collector->established_method == 'Broadcast' ? 'selected' : '' }}>Broadcast</option>
                            <option value="Transplant" {{ $collector->established_method == 'Transplant' ? 'selected' : '' }}>Transplant</option>
                            <option value="Parachute" {{ $collector->established_method == 'Parachute' ? 'selected' : '' }}>Parachute</option>
                            <option value="N/A" {{ $collector->established_method == 'N/A' ? 'selected' : '' }}>N/A</option>
                        </x-form.select>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-8 mt-10 border-t border-slate-200 dark:border-slate-800 flex justify-end">
                    <button type="submit"
                        class="w-full sm:w-auto md:min-w-[250px] inline-flex justify-center items-center gap-3 px-8 py-3.5 text-sm font-bold text-white bg-primary hover:bg-emerald-600 rounded-xl shadow-lg hover:shadow-primary/30 transition-all transform hover:-translate-y-0.5">
                        <i class="fas fa-save text-base"></i> Update Collector Info
                    </button>
                </div>

            </x-form>
        </div>
    </div>
</x-app-layout>
