<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Collector;
use Illuminate\Http\Request;

class ACollectorController extends Controller
{
    public function index(Request $request)
    {
        $sortColumn = $request->get('sort_by', 'id');  // Default to sorting by 'name'
        $sortDirection = $request->get('sort_direction', 'asc');  // Default to 'asc'
    
        // $collectors = Collector::join('provinces', 'collectors.province', '=', 'provinces.id')
        //     ->join('districts', 'collectors.district', '=', 'districts.id')
        //     ->join('as_centers', 'collectors.asc', '=', 'as_centers.id')
        //     ->join('ai_ranges', 'collectors.ai_range', '=', 'ai_ranges.id')
        //     ->orderBy($sortColumn, $sortDirection)->paginate(10);
        // Query the database and apply sorting
        $collectors = Collector::orderBy($sortColumn, $sortDirection)->paginate(10);
       
        return view('admin-Collector.index',compact('collectors', 'sortColumn', 'sortDirection'));
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
        $collector = Collector::findOrFail($id);
        return view('collectors.edit',['collector' => $collector]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        Collector::findOrFail($id)->delete();
        return redirect()->route('aCollector.index')->with('success', 'Collecter deleted successfully.');
    }
}