<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\CommonDataCollect;
use App\Models\Collector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommonDataCollectController extends Controller
{
    public function index()
    {
        $userId = (Auth::user()->id);
        // $companies = Collector::orderBy('id','desc')->paginate(5);
        $commons = CommonDataCollect::where('user_id', '=', $userId)->get();
        //$commons = CommonDataCollect::all();


        return view('collectors.common_data', compact('commons'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($Id)
    {
        dd($Id);
        $commons = CommonDataCollect::where('user_id', '=', $Id)->get();

        return view('collectors.show-common_data', compact('commons'));
    }

    public function edit(CommonDataCollect $commonDataCollect)
    {
        //
    }

    public function update(Request $request, CommonDataCollect $commonDataCollect)
    {
        //
    }

    public function destroy(CommonDataCollect $commonDataCollect)
    {
        //
    }
    public function updateLocation(Request $request)
    {
        try {
            $geoLocation = Validator::make(
                $request->all(),
                [
                    'latitude' => 'required',
                    'longitude' => 'required',
                    'id' => 'required'

                ]
            );
            if ($geoLocation->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'error' => $geoLocation->error()
                ], 401);
            }

            $location = Collector::where('user_id', $request->id)->update([
                'gps_lati' => $request->latitude,
                'gps_long' => $request->longitude,
                'user_id' => $request->id
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Location updated Successfully'

            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()

            ], 500);
        }
    }
}
