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
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Chart\Chart;

class ChartController extends Controller
{
    public function index()
    {
        $provinces = Province::all();
        return view('chart.index', ['provinces' => $provinces]);
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

    public function chart(ChartAi $chartAi,ChartASC $chartASC,ChartDistrict $chartDistrict,ChartProvince $chartProvince, Request $request)
    {

        if ($request->province && $request->district && $request->as_center && $request->ai_range) {
            $collector = Collector::where('ai_range', '=', $request->ai_range)->with('user')->get()->first();
            return view('chart.showAi', ['chart' => $chartAi->build($collector), 'collector' => $collector]);
        } elseif ($request->province && $request->district && $request->as_center) {
            $collector = Collector::where('asc', '=', $request->as_center)->with('user')->get()->first();
            return view('chart.showASC', ['chart' => $chartASC->build($collector)]);
        } elseif ($request->province && $request->district) {
            $collector = Collector::where('district', '=', $request->district)->with('user')->get()->first();
            return view('chart.showDistrict', ['chart' => $chartDistrict->build($collector)]);
        } elseif ($request->province) {
            $collector = Collector::where('province', '=', $request->province)->with('user')->get()->first();
            return view('chart.showProvince', ['chart' => $chartProvince->build($collector)]);
        } else {
            return redirect()->route('chart.index')->with('error', 'No data found');
        }
    }
}
