<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Pest;
use Illuminate\Http\Request;

class PestController extends Controller
{
    public function index()
    {
        $pests = Pest::latest()->get();
        return view('pest.index', ['pests' => $pests]);
    }

    public function create()
    {
        return view('pest.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Pest::create($request->all());
        return redirect()->route('pest.index')->with('success', 'Pest created successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $pest = Pest::findOrFail($id);
        return view('pest.edit', ['pest' => $pest]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $pest = Pest::findOrFail($id);
        $pest->update($request->all());
        return redirect()->route('pest.index')->with('success', 'Pest updated successfully.');
    }

    public function destroy($id)
    {
       Pest::findOrFail($id)->delete();
       return redirect()->route('pest.index')->with('success', 'Pest deleted successfully.');
    }
}