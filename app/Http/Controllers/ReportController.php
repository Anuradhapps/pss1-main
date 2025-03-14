<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\As_center;
use App\Models\Collector;
use App\Models\district;
use App\Models\Province;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public $thisSeasonId;
    public $thisSeason;
    public function __construct()
    {
        $season = new RiceSeasonController;
        $this->thisSeason = $season->getSeasson();
        $this->thisSeasonId = $season->getSeasson()['seasonId'];
    }



    public function index()
    {
        $collectors = Collector::where('rice_season_id', $this->thisSeasonId)
            ->join('common_data_collects', 'collectors.id', '=', 'common_data_collects.collector_id')
            ->join('pest_data_collects', 'common_data_collects.id', '=', 'pest_data_collects.common_data_collectors_id')
            ->where('common_data_collects.c_date', '>=', Carbon::now()->subWeeks(2))
            ->pluck('collectors.province')
            ->unique()
            ->toArray();

        $dataHaveProvinces = array_values($collectors);
        $provinces = Province::all();
        return view('report.index', ['dataHaveProvinces' => $dataHaveProvinces, 'provinces' => $provinces]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
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

    public function last2weeksDataexportToPDF($id)
    {

        $endDate = Carbon::today(); // Today's date
        $startDate = Carbon::today()->subWeeks(2); // 2 weeks before today
        $province = Province::find($id);
        // Fetch data from the database
        $result = [];
        $result['startDate'] = $startDate->toDateString();
        $result['endDate'] = $endDate->toDateString();
        $result['province'] = $province->name;

        $districtIdArray = Collector::where('rice_season_id', $this->thisSeasonId)->where('province', $id)->get()->pluck('district')->unique()->toArray();

        foreach ($districtIdArray as $districtId) {
            $dividCount = 0;
            $subresult = ['districtName' => null, 'ascNames' => [], 'pestData' => []];
            $district = district::where('id', $districtId)->get()->first();
            $subresult['districtName'] = $district->name;
            $asc = Collector::where('rice_season_id', $this->thisSeasonId)->where('district', $districtId)
                ->whereHas('commonDataCollect', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('c_date', [$startDate, $endDate]);
                })
                ->get()->pluck('asc')->unique()->toArray();
            foreach ($asc as $as) {
                $asc = As_center::find($as);
                $subresult['ascNames'][] = $asc->name;
            }

            $collectors = Collector::where('rice_season_id', $this->thisSeasonId)
                ->where('district', $districtId)
                ->whereHas('commonDataCollect', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('c_date', [$startDate, $endDate]);
                })
                ->get();

            $totTillers = 0;
            $totThripsCode = 0;
            $totGM = 0;
            $totLF = 0;
            $totYSB = 0;
            $totBPH = 0;
            $totPB = 0;
            foreach ($collectors as $collector) {
                $dividCount++;
                foreach ($collector->commonDataCollect()->latest()->first()->pestDataCollect as $pestData) {

                    switch ($pestData->pest_name) {
                        case 'Number_Of_Tillers':

                            $totTillers += $pestData->total;
                            break;
                        case 'Thrips':
                            $totThripsCode += $pestData->code;
                            break;
                        case 'Gall Midge':

                            $totGM += $pestData->total;
                            break;
                        case 'Leaffolder':
                            $totLF += $pestData->total;
                            break;
                        case 'Yellow Stem Borer':
                            $totYSB += $pestData->total;
                            break;
                        case 'BPH+WBPH':
                            $totBPH += $pestData->total;
                            break;
                        case 'Paddy Bug':
                            $totPB += $pestData->total;
                            break;
                        default:

                            break;
                    }
                }
            }

            $subresult['pestData']['Thrips'] = $totThripsCode;
            $subresult['pestData']['Gall_Midge'] = $totGM;
            $subresult['pestData']['Leaffolder'] = $totLF;
            $subresult['pestData']['Yellow_Stem_Borer'] = $totYSB;
            $subresult['pestData']['BPH+WBPH'] = $totBPH;
            $subresult['pestData']['Paddy_Bug'] = $totPB;
            $pestController = new PestDataCollectController();
            if ($totThripsCode != 0) {

                $totThripsCode = $totThripsCode / $dividCount;
                $availableNumbers = [1, 3, 5, 7, 9];

                // Floor the number and find the closest available number
                $flooredValue = floor($totThripsCode);

                // Find the closest available number
                $closestValue = null;
                foreach ($availableNumbers as $number) {
                    if ($closestValue === null || abs($number - $flooredValue) < abs($closestValue - $flooredValue)) {
                        $closestValue = $number;
                    }
                }

                $subresult['pestData']['Thrips'] = $closestValue;
            }

            if ($totGM != 0) {

                $gallMidgeCode = $pestController->getGallMidgeCode($totTillers, $totGM);

                $subresult['pestData']['Gall_Midge'] =  $gallMidgeCode['code'];
            }
            if ($totLF != 0) {
                $LeaffolderCode = $pestController->getLeaffolderCode($totTillers, $totLF);
                $subresult['pestData']['Leaffolder'] = $LeaffolderCode['code'];
            }
            if ($totYSB != 0) {
                $Yellow_Stem_Borer = $pestController->getYellowStemBorerCode($totTillers, $totYSB);
                $subresult['pestData']['Yellow_Stem_Borer'] = $Yellow_Stem_Borer['code'];
            }
            if ($totBPH != 0) {
                $BPH = $pestController->getBphWbphCode($totTillers, $totBPH);
                $subresult['pestData']['BPH+WBPH'] = $BPH['code'];
            }
            if ($totPB != 0) {
                $Paddy_Bug = $pestController->getPaddyBugCode($totTillers, $totPB);
                $subresult['pestData']['Paddy_Bug'] = $Paddy_Bug['code'];
            }
            $result['data'][] = $subresult;
        }

        // dd($result);
        // return view('report.reportThisWeek', ['records' => $result]);
        $pdf = Pdf::loadView('report.reportThisWeek', ['records' => $result])->setPaper('a4', 'landscape');
        return $pdf->download("PPS_Memo ({$province->name}) {$startDate->toDateString()} to {$endDate->toDateString()}.pdf");
    }

    public function collectorsList()
    {
        $collectors = Collector::all()->groupBy('district');
        dd($collectors);
        $pdf = Pdf::loadView('report.collectorsList', ['collectors' => $collectors])->setPaper('a4', 'landscape');
        return $pdf->download("collectorsList.pdf");
    }
    public function reportOfOtherInfo()
    {

        // return view('report.reportOfOtherInfo', ['records' => 'Totalresult']);

        $pdf = Pdf::loadView('report.reportOfOtherInfo', ['records' => 'Totalresult'])->setPaper('a4', 'landscape');
        return $pdf->download("reportOfOtherInfo.pdf");
    }
}
