<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Charts\ChartAi;
use App\Charts\ChartASC;
use App\Charts\ChartDistrict;
use App\Charts\ChartProvince;
use App\Charts\ChartSeason;
use App\Models\AiRange;
use App\Models\As_center;
use App\Models\Collector;
use App\Models\CommonDataCollect;
use App\Models\district;
use App\Models\PestDataCollect;
use App\Models\Province;
use App\Models\RiceSeason;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Chart\Chart;

class ChartController extends Controller
{
    public $season;
    public function __construct()
    {
        $season = new RiceSeasonController;
        $this->season =  $season->getSeasson();
    }
    public function index()
    {
        return view('chart.index');
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

    public function chart(ChartAi $chartAi, ChartASC $chartASC, ChartDistrict $chartDistrict, ChartProvince $chartProvince, ChartSeason $chartSeason, Request $request)
    {
        $request->validate([
            'season' => 'required',
        ]);

        if ($request->province && $request->district && $request->as_center && $request->ai_range && $request->season) {
            $aiCollector = Collector::where('ai_range', '=', $request->ai_range)->where('rice_season_id', '=', $request->season)->get()->first();
            if ($aiCollector == null) {
                return redirect()->route('chart.index')->with('error', 'No collector found');
            } else {
                try {
                    $pestData = $aiCollector->user->commonDataCollect[0]->pestDataCollect->toArray();
                } catch (Exception $e) {
                    return redirect()->route('chart.index')->with('error', 'No data found');
                }
        
                return view('chart.showAi', ['chart' => $chartAi->build($aiCollector), 'collector' => $aiCollector]);
            }
        } 
        
        elseif ($request->province && $request->district && $request->as_center && $request->season) {
            $ascCollectors  = Collector::where('asc', '=', $request->as_center)->where('rice_season_id', '=', $request->season)->get();
            if ($ascCollectors->count() == 0) {
                return redirect()->route('chart.index')->with('error', 'No data found');
            } else {
                $noOfTillers=0;
                $thrips=0;
                $gallMidge=0;
                $leaffolder=0;
                $yellowStemBorer=0;
                $bphWbph=0;
                $paddyBug=0;
                
                foreach($ascCollectors as $ascCollector){
                    foreach($ascCollector->commonDataCollect as $commonData){ 
                             
                        foreach($commonData->pestDataCollect as $pestData){
                      
                            if($pestData->pest_name == 'Number_Of_Tillers'){  
                                $noOfTillers += $pestData->total;
                            }
                            elseif($pestData->pest_name == 'Thrips'){
                                $thrips += $pestData->total;
                            }
                            elseif($pestData->pest_name == 'Gall Midge'){
                                $gallMidge += $pestData->total;
                            }
                            elseif($pestData->pest_name == 'Leaffolder'){
                                $leaffolder += $pestData->total;
                            }
                            elseif($pestData->pest_name == 'Yellow Stem Borer'){
                                $yellowStemBorer += $pestData->total;
                            }
                            elseif($pestData->pest_name == 'BPH+WBPH'){
                                $bphWbph += $pestData->total;
                            }
                            elseif($pestData->pest_name == 'Paddy Bug'){
                                $paddyBug += $pestData->total;
                            }
                        }
                    } 
                }
                dd($noOfTillers,
                $thrips,
                $gallMidge,
                $leaffolder,
                $yellowStemBorer,
                $bphWbph,
                $paddyBug);
                // dd('ASC',$ascCollectors[0]->commonDataCollect[0]->pestDataCollect[0]->pest_name);
                return view('chart.showASC', ['chart' => $chartASC->build($ascCollectors)]);
            }
        } 
        
        elseif ($request->province && $request->district && $request->season) {
            $districtCollectors = Collector::where('district', '=', $request->district)->where('rice_season_id', '=', $request->season)->get();
            if ($districtCollectors->count() == 0) {
                return redirect()->route('chart.index')->with('error', 'No data found');
            } else {
                dd('District',$districtCollectors);
                return view('chart.showDistrict', ['chart' => $chartDistrict->build($districtCollectors)]);
            }
        } 
        
        elseif ($request->province && $request->season) {
            $provinceCollectors = Collector::where('province', '=', $request->province)->where('rice_season_id', '=', $request->season)->get();
            
            if ( $provinceCollectors->count() == 0) {
                return redirect()->route('chart.index')->with('error', 'No data found');
            } else {
                dd('Province',$provinceCollectors);
                return view('chart.showProvince', ['chart' => $chartProvince->build( $provinceCollectors)]);
            }
        }
        
        elseif ($request->season) {
            $seasonCollectors = Collector::where('rice_season_id', '=', $request->season)->get();
            
            if ( $seasonCollectors->count() == 0) {
                return redirect()->route('chart.index')->with('error', 'No data found');
            } else {
                dd('Season',$seasonCollectors);
                return view('chart.showSeason', ['chart' => $chartSeason->build( $seasonCollectors)]);
            }
        } 
        
        
        else {
            return redirect()->route('chart.index')->with('error', 'No data found');
        }
    }    
}
