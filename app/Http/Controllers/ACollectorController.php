<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Collector;
use Illuminate\Http\Request;

class ACollectorController extends Controller
{
    public function index()
    {
        $collectors = Collector::all();
        return view('admin-Collector.index',['collectors' => $collectors]);
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