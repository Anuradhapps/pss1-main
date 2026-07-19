<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Base;
use Illuminate\Contracts\View\View;
use App\Models\district;
use App\Models\CommonDataCollect;
use Carbon\Carbon;
use App\Http\Controllers\PestDataCollectController;

class Dashboard extends Base
{
    public function render(): View
    {
        // Fetch common data for last 7 days
        $lastWeekData = CommonDataCollect::with(['collector.getDistrict', 'pestDataCollect'])
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->get();

        // Group by district name
        $groupedByDistrict = $lastWeekData->groupBy(function($data) {
            return $data->collector->getDistrict->name ?? 'Unknown District';
        });

        // Compute pest risk codes for each district
        $pestController = app(PestDataCollectController::class);
        $districtSummaries = [];
        
        foreach ($groupedByDistrict as $districtName => $commonDatas) {
            $summary = $pestController->avarageCalculateByCommonData($commonDatas);
            $districtSummaries[$districtName] = $summary['pests'];
        }

        // Sort alphabetically by district
        ksort($districtSummaries);

        return view('livewire.admin.dashboard', [
            'districtSummaries' => $districtSummaries
        ]);
    }
}
