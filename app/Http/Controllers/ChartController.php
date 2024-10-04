<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Charts\ChartAi;
use App\Models\AiRange;
use App\Models\As_center;
use App\Models\Collector;
use App\Models\CommonDataCollect;
use App\Models\district;
use App\Models\PestDataCollect;
use App\Models\Province;
use Illuminate\Http\Request;

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

    public function chartAi(ChartAi $chartAi, Request $request)
    {
        $collector = Collector::where('ai_range', '=', $request->ai_range)->with('user')->get()->first();
        // dd($collector->user->commonDataCollect[0]->PestDataCollect[0]);
        return view('chart.show', ['chart' => $chartAi->build($collector)]);
    }
}
