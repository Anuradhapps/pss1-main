<?php

namespace App\Services;

use App\Http\Controllers\RiceSeasonController;
use App\Models\Collector;
use App\Models\district;

class toPDFService
{


    public function collectorsList(?int $district = null, ?int $region = null)
    {

        $currentseason = new RiceSeasonController;
        $season =  $currentseason->getSeasson();
        // Build query with eager loading
        $query = Collector::with([
            'user',
            'getAsCenter',
            'getAiRange',
            'commonDataCollect',
            'riceSeason',
            'getDistrict'
        ])->whereHas('user', fn($q) => $q->where('name', '!=', 'npssoldata'));

        $query->where(
            'rice_season_id',
            $season['seasonId']
        );
        // Apply filters only if provided
        if ($district) {
            $query->where('district', $district);
        }
        if ($region) {
            $query->where('region_id', $region);
        }

        // Fetch and group by district_id
        $collectors = $query->get()->groupBy('district');

        $result = [];

        foreach ($collectors as $districtId => $collectorGroup) {
            $district = District::find($districtId);
            $subresult = [
                'district' => $district ? $district->name : 'Unknown',
                'collectors' => []
            ];

            foreach ($collectorGroup as $collector) {
                $subresult['collectors'][] = [
                    $collector->user->name ?? '',
                    $collector->getAsCenter->name ?? '',
                    $collector->getAiRange->name ?? '',
                    $collector->phone_no ?? '',
                    $collector->date_establish ?? '',
                    $collector->user->email ?? '',
                    $collector->commonDataCollect->count() ?? 0,
                    $collector->riceSeason->name ?? '',
                ];
            }

            $result[] = $subresult;
        }
        return $result;
    }
}
