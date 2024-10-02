<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AiRange;
use App\Models\As_center;
use App\Models\Collector;
use App\Models\district;
use App\Models\PestDataCollect;
use App\Models\Province;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function index()
    {
        $provinces = Province::all();
        // $district = district::all();
        // $as_centers = As_center::all();
        // $ai_ranges= AiRange::all();

        return view('chart.index',['provinces' => $provinces]);
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
           $datas = Collector::where('ai_range', '=', $request->ai_range)->get();
           return view('chart.show', ['datas' => $datas]);
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
}