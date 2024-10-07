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
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Chart\Chart;

class ChartController extends Controller
{
    public function index()
    {
        $liveProvinces = Collector::distinct()->pluck('province')->toArray();
        $liveDistricts = Collector::distinct()->pluck('district')->toArray();
        $liveAsCenters = Collector::distinct()->pluck('asc')->toArray();
        $liveAiRanges = Collector::distinct()->pluck('ai_range')->toArray();

        $provinces = Province::all();
        return view('chart.index', ['provinces' => $provinces, 'liveProvinces' => $liveProvinces, 'liveDistricts' => $liveDistricts, 'liveAsCenters' => $liveAsCenters, 'liveAiRanges' => $liveAiRanges]);
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

        if ($request->province && $request->district && $request->as_center && $request->ai_range) {
            $collector=$this->getAiChartData($request->ai_range);
            return view('chart.showAi', ['chart' => $chartAi->build($collector), 'collector' => $collector]);
        } 
        
        
        elseif ($request->province && $request->district && $request->as_center) {
            $collectors = $this->getAscChartData($request->as_center);
            return view('chart.showASC', ['chart' => $chartASC->build($collectors)]);
        } 
        
        
        elseif ($request->province && $request->district) {
            $collector = Collector::where('district', '=', $request->district)->with('user')->get()->first();
            if ($collector == null) {
                return redirect()->route('chart.index')->with('error', 'No data found');
            }
            return view('chart.showDistrict', ['chart' => $chartDistrict->build($collector)]);
        } 
        
        
        elseif ($request->province) {
            $collector = Collector::where('province', '=', $request->province)->with('user')->get()->first();
            if ($collector == null) {
                return redirect()->route('chart.index')->with('error', 'No data found');
            }
            return view('chart.showProvince', ['chart' => $chartProvince->build($collector)]);
        } 
        
        
        else {
            return redirect()->route('chart.index')->with('error', 'No data found');
        }
    }

    public function chartTable($id)
    {
        $collector = Collector::find($id);
       
        return view('chart.dataTable', ['collector' => $collector]);
    }

    public function getAiChartData($aiRangeId){
        dd($this->getSeasson());
        $collector = Collector::where('ai_range', '=', $aiRangeId)->with('user')->get()->first();
        if ($collector == null) {
            return redirect()->route('chart.index')->with('error', 'No data found');
        }
        return $collector;
    }
    public function getAscChartData($aiRangeId){
        $collectors = Collector::where('asc', '=', $aiRangeId)->get();
            if ($collectors == null) {
                return redirect()->route('chart.index')->with('error', 'No data found');
            }
        dd($collectors);
        return $collectors;
    }

    public function getSeasson() {
        // Get the current date
        $date = Carbon::now();
        // $date = Carbon::create(2022-01-01);
        
        // Extract the current year and month
        $currentYear = $date->year;
        $currentMonth = $date->month;
        
        // Check if the date is between February 1 and September 30
        if ($date->between(Carbon::create($currentYear, 2, 1), Carbon::create($currentYear, 9, 30))) {
            // Yala season (March 1 to September 30)
            return [
                'startDate' => "$currentYear-02-01",
                'endDate' => "$currentYear-09-30",
                'seasonName' => "$currentYear Yala",
                'seasonId'=>$currentYear
            ];
        } else {
            // Maha season (October 1 to February 28/29)
            if ($currentMonth === 1) {
                // If it's January, we are still in the previous year's Maha season
                $previousYear = $currentYear - 1;
                return [
                    'startDate' => "$previousYear-10-01",
                    'endDate' => "$currentYear-02-28",
                    'seasonName' => "$previousYear/$currentYear Maha",
                    'seasonId'=>"$previousYear-$currentYear"
                ];
            } else {
                // Otherwise, we are in the current year's Maha season
                $nextYear = $currentYear + 1;
                return [
                    'startDate' => "$currentYear-10-01",
                    'endDate' => Carbon::create($nextYear, 2, 28)->isLeapYear() ? "$nextYear-02-29" : "$nextYear-02-28",
                    'seasonName' => "$currentYear/$nextYear Maha",
                    'seasonId'=>"$currentYear-$nextYear"
                ];
            }
        }
    }
    
}
