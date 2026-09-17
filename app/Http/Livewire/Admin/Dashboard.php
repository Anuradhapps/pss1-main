<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Base;
use App\Services\PestInfoService;
use Illuminate\Contracts\View\View;
use App\Models\district;
use App\Models\CommonDataCollect;
use Carbon\Carbon;

class Dashboard extends Base
{
    protected PestInfoService $service;

    public function boot(PestInfoService $service)
    {
        $this->service = $service;
    }

    public function render(): View
    {
        $days = 7;

        // Only consider districts that actually had data collected in the window,
        // same behavior as the original grouping logic.
        $districts = CommonDataCollect::with('collector.getDistrict')
            ->where('created_at', '>=', Carbon::now()->subDays($days))
            ->get()
            ->pluck('collector.getDistrict')
            ->filter()
            ->unique('id');

        $districtSummaries = [];

        foreach ($districts as $district) {
            $average = $this->service->avaragePestCodeByDistrictAndDuration(
                $district->id,
                $days
            );

            $districtSummaries[$district->name] = $average['pests'] ?? [];
        }

        ksort($districtSummaries);

        return view('livewire.admin.dashboard', [
            'districtSummaries' => $districtSummaries,
        ]);
    }
}
