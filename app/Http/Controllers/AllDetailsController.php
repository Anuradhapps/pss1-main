<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Collector;
use App\Models\RiceSeason;

class AllDetailsController extends Controller
{
    public function index(Request $request)
    {
        $seasons = RiceSeason::query()
            ->select(['id', 'name'])
            ->orderByDesc('id')
            ->get();

        $selectedSeason = $request->integer('season_id');
        $grouped = collect();

        if ($selectedSeason && $seasons->contains('id', $selectedSeason)) {
            $collectors = Collector::query()
                ->where('rice_season_id', $selectedSeason)
                ->with([
                    'riceSeason:id,name',
                    'region:id,name',
                    'getProvince:id,name',
                    'getDistrict:id,name',
                    'getAsCenter:id,name',
                    'getAiRange:id,name',
                    'user:id,name,email',
                    'commonDataCollect.pestDataCollect',
                ])
                ->orderBy('region_id')
                ->orderBy('province')
                ->orderBy('district')
                ->orderBy('asc')
                ->orderBy('ai_range')
                ->get();

            $grouped = $collectors
                ->groupBy('rice_season_id')
                ->map(function ($seasonGroup) {

                    $first = $seasonGroup->first();

                    return [
                        'season' => $first->riceSeason?->name,

                        'regions' => $seasonGroup
                            ->groupBy('region_id')
                            ->map(function ($regionGroup) {

                                $first = $regionGroup->first();

                                return [
                                    'region' => $first->region?->name,

                                    'provinces' => $regionGroup
                                        ->groupBy('province')
                                        ->map(function ($provinceGroup) {

                                            $first = $provinceGroup->first();

                                            return [
                                                // NAME instead of province ID
                                                'province' => $first->getProvince?->name,

                                                'districts' => $provinceGroup
                                                    ->groupBy('district')
                                                    ->map(function ($districtGroup) {

                                                        $first = $districtGroup->first();

                                                        return [
                                                            // NAME instead of district ID
                                                            'district' => $first->getDistrict?->name,

                                                            'asc' => $districtGroup
                                                                ->groupBy('asc')
                                                                ->map(function ($ascGroup) {

                                                                    $first = $ascGroup->first();

                                                                    return [
                                                                        // NAME instead of ASC ID
                                                                        'asc' => $first->getAsCenter?->name,

                                                                        'ai_ranges' => $ascGroup
                                                                            ->groupBy('ai_range')
                                                                            ->map(function ($aiRangeGroup) {

                                                                                $first = $aiRangeGroup->first();

                                                                                return [
                                                                                    // NAME instead of AI Range ID
                                                                                    'ai_range' => $first->getAiRange?->name,

                                                                                    'collectors' => $aiRangeGroup->values(),
                                                                                ];
                                                                            })
                                                                            ->values(),
                                                                    ];
                                                                })
                                                                ->values(),
                                                        ];
                                                    })
                                                    ->values(),
                                            ];
                                        })
                                        ->values(),
                                ];
                            })
                            ->values(),
                    ];
                })
                ->values();
        }

        return view('allDetails.allDetailsInHierachy', [
            'data' => $grouped,
            'seasons' => $seasons,
            'selectedSeason' => $selectedSeason,
        ]);
    }
}
