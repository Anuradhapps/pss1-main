<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Collector;
use App\Models\district;
use App\Models\Province;
use App\Models\RiceSeason;
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
            ->where('common_data_collects.c_date', '<=', Carbon::now()->subWeeks(1))
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

    public function exportToPDF($id)
    {
        // Fetch data from the database


        $districtIdArray = Collector::where('rice_season_id', $this->thisSeasonId)->where('province', $id)->get()->pluck('district')->unique()->toArray();
        foreach($districtIdArray as $districtId){
            $district = district::where('id', $districtId)->get();

            Collector::where('rice_season_id', $this->thisSeasonId)->where('district', $districtId)->get()->pluck('asc')->unique()->toArray();
        }
        // if ($records->isEmpty()) {
        //     return 'No data found.';
        // }
        // Load a view and pass the data to it

        $pdf = Pdf::loadView('report.reportThisWeek', ['records' => $records])->setPaper('a4', 'landscape');

        // Stream the PDF file as a download
        return $pdf->download('data_export.pdf');
    }
}
