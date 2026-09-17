<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Collector;
use Illuminate\Http\Request;

class allDetailsController extends Controller
{
    public function index()
    {
        $collectors = Collector::with([
            'riceSeason',
            'region',
            'getProvince',
            'getDistrict',
            'getAsCenter',
            'getAiRange',
            'user',
            'commonDataCollect.pestDataCollect',
        ])
            ->orderByDesc('rice_season_id')
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

        return response()->json([
            'data' => $grouped,
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
