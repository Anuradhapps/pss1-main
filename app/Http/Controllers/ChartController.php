<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Charts\ChartAi;
use App\Charts\ChartASC;
use App\Charts\ChartDistrict;
use App\Charts\ChartProvince;
use App\Models\AiRange;
use App\Models\As_center;
use App\Models\Collector;
use App\Models\CommonDataCollect;
use App\Models\district;
use App\Models\PestDataCollect;
use App\Models\Province;
use App\Models\RiceSeason;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Chart\Chart;

class ChartController extends Controller
{
public $season;
    public function __construct(){
        $season = new RiceSeasonController;
        $this->season =  $season->getSeasson();
    }
    public function index()
    {
        $liveProvinces = Collector::distinct()->pluck('province')->toArray();
        $liveDistricts = Collector::distinct()->pluck('district')->toArray();
        $liveAsCenters = Collector::distinct()->pluck('asc')->toArray();
        $liveAiRanges = Collector::distinct()->pluck('ai_range')->toArray();
        $seasons = RiceSeason::all();
        $provinces = Province::all();
        return view('chart.index', ['provinces' => $provinces, 'liveProvinces' => $liveProvinces, 'liveDistricts' => $liveDistricts, 'liveAsCenters' => $liveAsCenters, 'liveAiRanges' => $liveAiRanges,'seasons'=>$seasons]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Request $request)
    {

        //    $collector = Collector::where('ai_range', '=', $request->ai_range)->with('user')->get()->first();
        //    $commonData = CommonDataCollect::where('user_id', '=', $collector->user_id)->get();
        //    return view('chart.show', ['collector' => $collector,'commonData' => $commonData]);
        return view('chart.show');
    }

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

    public function chart(ChartAi $chartAi, ChartASC $chartASC, ChartDistrict $chartDistrict, ChartProvince $chartProvince, Request $request)
    {
        $request->validate([
            'season'=>'required',
            'province' => 'required',
        ]);

        if ($request->province && $request->district && $request->as_center && $request->ai_range && $request->season) {
            $collector = Collector::where('ai_range', '=', $request->ai_range)->where('rice_season_id', '=', $request->season)->get()->first();
            if ($collector == null) {
                return redirect()->route('chart.index')->with('error', 'No data found');
            } else {
                return view('chart.showAi', ['chart' => $chartAi->build($collector), 'collector' => $collector]);
            }
        } elseif ($request->province && $request->district && $request->as_center) {
            $collectors = $this->getAscChartData($request->as_center);
            return view('chart.showASC', ['chart' => $chartASC->build($collectors)]);
        } elseif ($request->province && $request->district) {
            $collector = Collector::where('district', '=', $request->district)->with('user')->get()->first();
            if ($collector == null) {
                return redirect()->route('chart.index')->with('error', 'No data found');
            }
            return view('chart.showDistrict', ['chart' => $chartDistrict->build($collector)]);
        } elseif ($request->province) {
            $riceSeason = new RiceSeasonController;
            dd($riceSeason->getSeasson()['seasonId']);

            $collector = Collector::where('province', '=', $request->province)->with('user')->get()->first();
            if ($collector == null) {
                return redirect()->route('chart.index')->with('error', 'No data found');
            }
            return view('chart.showProvince', ['chart' => $chartProvince->build($collector)]);
        } else {
            return redirect()->route('chart.index')->with('error', 'No data found');
        }
    }

    public function chartTable($id)
    {
        // $collector = Collector::find($id);
        $collector = Collector::where('id', '=', $id)->where('rice_season_id', '=', $this->season['seasonId'])->latest()->get()->first();

        return view('chart.dataTable', ['collector' => $collector]);
    }


    public function getAscChartData($aiRangeId)
    {
        $collectors = Collector::where('asc', '=', $aiRangeId)->get();
        if ($collectors == null) {
            return redirect()->route('chart.index')->with('error', 'No data found');
        }
        return $collectors;
    }
}
