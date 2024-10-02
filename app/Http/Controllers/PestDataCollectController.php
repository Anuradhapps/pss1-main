<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\CommonDataCollect;
use App\Models\Pest;
use App\Models\PestDataCollect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PestDataCollectController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $CommonData = CommonDataCollect::where('user_id', '=', $user->id)->latest()->get();

        return view('pestData.index', ['CommonData' => $CommonData]);
    }

    public function create()
    {
        $pests = Pest::all();
        return view('pestData.create', ['pests' => $pests]);
    }

    public function store(Request $request)
    {


        $validatedRequest = $request->validate([
            'date_collected' => 'required',
            'growth_s_c' => 'required',
            'numbrer_r_day' => 'required',
        ]);

        $CommonDataCollect = CommonDataCollect::create([
            'user_id' => Auth::user()->id,
            'c_date' =>Carbon::createFromFormat('d-m-Y', $validatedRequest['date_collected']) ,
            'temperature' => $request->input('temperature')?:0,
            'growth_s_c' => $validatedRequest['growth_s_c'],
            'numbrer_r_day' => $validatedRequest['numbrer_r_day'],
            'otherinfo' => $request->input('otherinfo'),
        ]);

        PestDataCollect::create([
            'common_data_collectors_id' => $CommonDataCollect->id,
            'pest_name' => 'Number_Of_Tillers', // This should just get the name from the Pest model
            'location_one' => $request->input('Number_Of_Tillers_location_1')?:0,
            'location_two' => $request->input('Number_Of_Tillers_location_2')?:0,
            'location_three' => $request->input('Number_Of_Tillers_location_3')?:0,
            'location_four' => $request->input('Number_Of_Tillers_location_4')?:0,
            'location_five' => $request->input('Number_Of_Tillers_location_5')?:0,
            'location_six' => $request->input('Number_Of_Tillers_location_6')?:0,
            'location_seven' => $request->input('Number_Of_Tillers_location_7')?:0,
            'location_eight' => $request->input('Number_Of_Tillers_location_8')?:0,
            'location_nine' => $request->input('Number_Of_Tillers_location_9')?:0,
            'location_ten' => $request->input('Number_Of_Tillers_location_10')?:0,
            'total' =>
            $request->input('Number_Of_Tillers_location_1', 0) +
                $request->input('Number_Of_Tillers_location_2', 0) +
                $request->input('Number_Of_Tillers_location_3', 0) +
                $request->input('Number_Of_Tillers_location_4', 0) +
                $request->input('Number_Of_Tillers_location_5', 0) +
                $request->input('Number_Of_Tillers_location_6', 0) +
                $request->input('Number_Of_Tillers_location_7', 0) +
                $request->input('Number_Of_Tillers_location_8', 0) +
                $request->input('Number_Of_Tillers_location_9', 0) +
                $request->input('Number_Of_Tillers_location_10', 0)
        ]);
        $pests = Pest::all();
        foreach ($pests as $pest) {
            if ($pest->name == 'Thrips') {
                PestDataCollect::create([
                    'common_data_collectors_id' => $CommonDataCollect->id,
                    'pest_name' => $pest->name, // This should just get the name from the Pest model
                    'location_one' => 0,
                    'location_two' => 0,
                    'location_three' => 0,
                    'location_four' => 0,
                    'location_five' => 0,
                    'location_six' => 0,
                    'location_seven' => 0,
                    'location_eight' => 0,
                    'location_nine' => 0,
                    'location_ten' => 0,
                    'total' => $request->input($pest->id . 'all_location')
                ]);
            } else {
                PestDataCollect::create([
                    'common_data_collectors_id' => $CommonDataCollect->id,
                    'pest_name' => $pest->name, // This should just get the name from the Pest model
                    'location_one' => $request->input($pest->id . '_location_1')?:0,
                    'location_two' => $request->input($pest->id . '_location_2')?:0,
                    'location_three' => $request->input($pest->id . '_location_3')?:0,
                    'location_four' => $request->input($pest->id . '_location_4')?:0,
                    'location_five' => $request->input($pest->id . '_location_5')?:0,
                    'location_six' => $request->input($pest->id . '_location_6')?:0,
                    'location_seven' => $request->input($pest->id . '_location_7')?:0,
                    'location_eight' => $request->input($pest->id . '_location_8')?:0,
                    'location_nine' => $request->input($pest->id . '_location_9')?:0,
                    'location_ten' => $request->input($pest->id . '_location_10')?:0,
                    'total' =>
                    $request->input($pest->id . '_location_1', 0) +
                        $request->input($pest->id . '_location_2', 0) +
                        $request->input($pest->id . '_location_3', 0) +
                        $request->input($pest->id . '_location_4', 0) +
                        $request->input($pest->id . '_location_5', 0) +
                        $request->input($pest->id . '_location_6', 0) +
                        $request->input($pest->id . '_location_7', 0) +
                        $request->input($pest->id . '_location_8', 0) +
                        $request->input($pest->id . '_location_9', 0) +
                        $request->input($pest->id . '_location_10', 0)
                ]);
            }
        }

        return redirect()->route('pestdata.index')->with('success', 'Pest Data created successfully.');
    }

    public function show($Id)
    {
        $pests = Pest::all();
        $commonData = CommonDataCollect::findOrFail($Id);

        $pestsData = PestDataCollect::where('common_data_collectors_id', '=', $Id)->get();
        return view('pestData.show', ['pestsData' => $pestsData, 'commonData' => $commonData, 'pests' => $pests]);
    }

    public function edit($Id)
    {
        $pests = Pest::all();
        $commonData = CommonDataCollect::findOrFail($Id);
        $pestsData = PestDataCollect::where('common_data_collectors_id', '=', $Id)->get();
        return view('pestData.edit', ['pestsData' => $pestsData, 'commonData' => $commonData, 'pests' => $pests]);
    }

    public function update(Request $request, $Id)
    {
      
        $commonData = CommonDataCollect::findOrFail($Id);
        $commonData->update([
            'c_date' =>Carbon::createFromFormat('d-m-Y', $request->input('date_collected')),
            'temperature' => $request->input('temperature'),
            'numbrer_r_day'=> $request->input('numbrer_r_day'),
            'growth_s_c'=>$request->input('growth_s_c'),
            'otherinfo' => $request->input('otherinfo'),
            
        ]);
        $pestsData = PestDataCollect::where('common_data_collectors_id', '=', $Id)->get();
        foreach ($pestsData as $pestData) {

            if ($pestData->name == 'Thrips'){
                $pestData->update([
                    'location_one' => 0,
                    'location_two' => 0,
                    'location_three' => 0,
                    'location_four' => 0,
                    'location_five' => 0,
                    'location_six' => 0,
                    'location_seven' => 0,
                    'location_eight' => 0,
                    'location_nine' => 0,
                    'location_ten' => 0,
                    'total' => $request->input($pestData->name . 'all_location')
                ]);
            }else{
                
                $pestData->update([
                    
                    'location_one' => $request->input($pestData->pest_name . '_location_1')?:0,
                    'location_two' => $request->input(key: $pestData->pest_name . '_location_2')?:0,
                    'location_three' => $request->input($pestData->pest_name . '_location_3')?:0,  
                    'location_four' => $request->input($pestData->pest_name . '_location_4')?:0,
                    'location_five' => $request->input($pestData->pest_name . '_location_5')?:0,
                    'location_six' => $request->input($pestData->pest_name . '_location_6')?:0,
                    'location_seven' => $request->input($pestData->pest_name . '_location_7')?:0,
                    'location_eight' => $request->input($pestData->pest_name . '_location_8')?:0,
                    'location_nine' => $request->input($pestData->pest_name . '_location_9')?:0,
                    'location_ten' => $request->input($pestData->pest_name . '_location_10')?:0,
                    'total' =>
                    $request->input($pestData->pest_name . '_location_1', 0) +
                        $request->input($pestData->pest_name . '_location_2', 0) +
                        $request->input($pestData->pest_name . '_location_3', 0) +
                        $request->input($pestData->pest_name . '_location_4', 0) +
                        $request->input($pestData->pest_name . '_location_5', 0) +
                        $request->input($pestData->pest_name . '_location_6', 0) +
                        $request->input($pestData->pest_name . '_location_7', 0) +
                        $request->input($pestData->pest_name . '_location_8', 0) +
                        $request->input($pestData->pest_name . '_location_9', 0) +
                        $request->input($pestData->pest_name . '_location_10', 0)
                ]);
            }
           
        }

        return redirect()->route('pestdata.index')->with('success', 'Pest Data updated successfully.');
    }

    public function destroy($id)
    {
        CommonDataCollect::findOrFail($id)->delete();
        return redirect()->route('pestdata.index')->with('success', 'Pest Data deleted successfully.');
    }
}
