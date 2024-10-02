<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AiRange;
use App\Models\As_center;
use App\Models\district;
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
}