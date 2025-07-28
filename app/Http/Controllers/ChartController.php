<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Charts\AllSeasonChart;
use App\Charts\ChartAi;
use App\Charts\ChartASC;
use App\Charts\ChartDistrict;
use App\Charts\ChartProvince;
use App\Charts\ChartSeason;
use App\Models\Collector;
use App\Models\district;
use App\Models\Province;
use App\Models\RiceSeason;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    protected $PestDataCollectController;
    public $season;
    public function __construct()
    {
        $season = new RiceSeasonController;
        $this->season = $season->getSeasson();
        $this->PestDataCollectController = new PestDataCollectController();
    }
    public function index()
    {
        $allProvinces = Province::all()->pluck('name')->unique();
        $allDistricts = district::all()->pluck('name')->unique();
        $dataHaveProvinces = [];
        $dataHaveDistricts = [];
        foreach (Province::all() as $province) {
            $collectors = Collector::where('province', '=', $province->id)->get();
            if ($collectors->count() != 0) {
                array_push($dataHaveProvinces, $province->name);
            }
        }
        foreach (district::all() as $district) {
            $collectors = Collector::where('district', '=', $district->id)->get();
            if ($collectors->count() != 0) {
                array_push($dataHaveDistricts, $district->name);
            }
        }


        return view('chart.index', ['allProvinces' => $allProvinces, 'allDistricts' => $allDistricts, 'dataHaveProvinces' => $dataHaveProvinces, 'dataHaveDistricts' => $dataHaveDistricts]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Request $request) {}

    public function edit($id)
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

    public function chart(ChartAi $chartAi, ChartASC $chartASC, ChartDistrict $chartDistrict, ChartProvince $chartProvince, ChartSeason $chartSeason, Request $request)
    {
        $request->validate([
            'season' => 'required',
        ]);

        if ($request->province && $request->district && $request->as_center && $request->ai_range && $request->season) {
            $aiCollector = Collector::where('ai_range', '=', $request->ai_range)->where('rice_season_id', '=', $request->season)->get();
            if ($aiCollector == null) {
                return redirect()->route('chart.index')->with('error', 'No collector found');
            } else {
                return view('chart.collectors', ['collectors' => $aiCollector]);
            }
        } elseif ($request->province && $request->district && $request->as_center && $request->season) {
            $ascCollectors = Collector::where('asc', '=', $request->as_center)->where('rice_season_id', '=', $request->season)->get();
            if ($ascCollectors->count() == 0) {
                return redirect()->route('chart.index')->with('error', 'No data found');
            } else {
                $pestData = $this->PestDataCollectController->avarageCalculate($ascCollectors);
                $pestData['as_center'] = $request->as_center;
                $pestData['season'] = $request->season;
                return view('chart.showASC', ['chart' => $chartASC->build($pestData)]);
            }
        } elseif ($request->province && $request->district && $request->season) {
            $districtCollectors = Collector::where('district', '=', $request->district)->where('rice_season_id', '=', $request->season)->get();
            if ($districtCollectors->count() == 0) {
                return redirect()->route('chart.index')->with('error', 'No data found');
            } else {
                $pestData = $this->PestDataCollectController->avarageCalculate($districtCollectors);
                $pestData['district'] = $request->district;
                $pestData['season'] = $request->season;

                return view('chart.showDistrict', ['chart' => $chartDistrict->build($pestData)]);
            }
        } elseif ($request->province && $request->season) {
            $provinceCollectors = Collector::where('province', '=', $request->province)->where('rice_season_id', '=', $request->season)->get();

            if ($provinceCollectors->count() == 0) {
                return redirect()->route('chart.index')->with('error', 'No data found');
            } else {
                $pestData = $this->PestDataCollectController->avarageCalculate($provinceCollectors);
                $pestData['province'] = $request->province;
                $pestData['season'] = $request->season;
                return view('chart.showProvince', ['chart' => $chartProvince->build($pestData)]);
            }
        } elseif ($request->season) {
            $seasonCollectors = Collector::where('rice_season_id', '=', $request->season)->get();

            if ($seasonCollectors->count() == 0) {
                return redirect()->route('chart.index')->with('error', 'No data found');
            } else {
                $pestData = $this->PestDataCollectController->avarageCalculate($seasonCollectors);
                $pestData['season'] = $request->season;
                return view('chart.showSeason', ['chart' => $chartSeason->build($pestData)]);
            }
        } else {
            return redirect()->route('chart.index')->with('error', 'No data found');
        }
    }

    public function allSeasonChart(AllSeasonChart $allSeasonChart, Request $request)
    {
        $collectorCount = 0;
        $seasons = RiceSeason::all();
        $sortBy = $request->get('sort_by');
        $collectors = null;
        $pestData = null;
        $result = ['location' => null, 'pestNames' => null, 'data' => []];
        $collectorCount = 0;
        if ($sortBy == 'allIsland') {
            $result['location'] = 'All Island';
            foreach ($seasons as $season) {
                $collectors = Collector::where('rice_season_id', '=', $season->id)->get();
                if (!$collectors->count() == 0) {
                    $collectorCount += $collectors->count();
                    $pestData = $this->PestDataCollectController->avarageCalculate($collectors);
                    $result['pestNames'] = array_keys($pestData['pests']);
                    $pestCodes = array_values($pestData['pests']);
                    array_push($result['data'], ['seasonName' => $season->name, 'pestCodes' => $pestCodes, 'collectorCount' => $collectors->count()]);
                }
            }
            if ($collectorCount == 0) {
                return redirect()->route('chart.index')->with('error', 'No data found');
            }
            return view('chart.AllSeasonChart', ['chart' => $allSeasonChart->build($result)]);
        } elseif ($sortBy == 'province') {
            $provinceName = $request->get('province');
            $province = Province::where('name', '=', $provinceName)->get()->first();
            $result['location'] = $provinceName;
            foreach ($seasons as $season) {
                $collectors = Collector::where('rice_season_id', '=', $season->id)->where('province', '=', $province->id)->get();
                if (!$collectors->count() == 0) {
                    $collectorCount += $collectors->count();
                    $pestData = $this->PestDataCollectController->avarageCalculate($collectors);
                    $result['pestNames'] = array_keys($pestData['pests']);
                    $pestCodes = array_values($pestData['pests']);
                    array_push($result['data'], ['seasonName' => $season->name, 'pestCodes' => $pestCodes, 'collectorCount' => $collectors->count()]);
                }
            }
            if ($collectorCount == 0) {
                return redirect()->route('chart.index')->with('error', 'No data found');
            }

            return view('chart.AllSeasonChart', ['chart' => $allSeasonChart->build($result)]);
        } elseif ($sortBy == 'district') {
            $districtName = $request->get('district');
            $district = district::where('name', '=', $districtName)->get()->first();
            $result['location'] = $districtName;
            foreach ($seasons as $season) {

                $collectors = Collector::where('rice_season_id', '=', $season->id)->where('district', '=', $district->id)->get();
                if (!$collectors->count() == 0) {
                    $collectorCount += $collectors->count();
                    $pestData = $this->PestDataCollectController->avarageCalculate($collectors);
                    $result['pestNames'] = array_keys($pestData['pests']);
                    $pestCodes = array_values($pestData['pests']);
                    array_push($result['data'], ['seasonName' => $season->name, 'pestCodes' => $pestCodes, 'collectorCount' => $collectors->count()]);
                }
            }
            if ($collectorCount == 0) {
                return redirect()->route('chart.index')->with('error', 'No data found');
            }

            return view('chart.AllSeasonChart', ['chart' => $allSeasonChart->build($result)]);
        } else {
        }
    }



    function chartAiShow($id, ChartAi $chartAi)
    {
        $aiCollector = Collector::findOrFail($id);
        if ($aiCollector->commonDataCollect->count() == 0) {
            return redirect()->route('chart.index')->with('error', 'No data found');
        }
        return view('chart.showAi', ['chart' => $chartAi->build($aiCollector), 'collector' => $aiCollector]);
    }
}
