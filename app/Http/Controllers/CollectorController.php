<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Collector;
use App\Models\District;
use App\Models\As_center;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CollectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        return view('collectors.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $id = Auth::user()->id;

        $collector  = Collector::where('user_id', $id)->first();
        // dd($collector);
        if (empty($collector)) {
            $districts = District::all();
            $ascs = As_center::all();
            return view('collectors.create', compact('districts', 'ascs'));
        } else {

            $districts = District::all();
            $selected_asc = $collector->asc;
            $ascs = As_center::where('district_id', $collector->district)->get();

            // return view('admin.collector.edit', compact('collector', 'districts', 'selected_asc', 'ascs'));

            return view('collectors.edit', compact('collector', 'districts', 'selected_asc', 'ascs'));
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'phone_no' => 'required|unique:collectors',
            'district' => 'required',
            'asc' => 'required',
            'ai_range' => 'required',
            'village' => 'required',
            //  'gps_lati' => 'required',
            //  'gps_long' => 'required',
              'rice_variety' => 'required',
            'date_establish' => 'required',
        ]);
        $dateEstablish = Carbon::createFromFormat('d-m-Y', $request->get('date_establish'))->format('Y-m-d');
        $collector = new Collector([
            'user_id' => Auth::user()->id,
            'phone_no' => $request->get('phone_no'),
            'district' => $request->get('district'),
            'asc' => $request->get('asc'),
            'ai_range' => $request->get('ai_range'),
            'village' => $request->get('village'),
            'gps_lati' => $request->get('gps_lati'),
            'gps_long' => $request->get('gps_long'),
            'rice_variety' => $request->get('rice_variety'),
            'date_establish' => $dateEstablish,
        ]);
        $collector->save();
        //return redirect('/collectors')->with('success', 'Collector added successfully!');
        return redirect()->route('admin.collector.index')->with('success', 'Collector Data created successfully.');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $collector = Collector::find($id);
        return view('collectors.show')->with('collectors', $collector);
    }
    public function view()
    {
        $collector = Collector::join('users', 'collectors.user_id', '=', 'users.id')
            ->join('districts', 'collectors.district', '=', 'districts.id')
            ->join('as_centers', 'collectors.asc', '=', 'as_centers.id')
            ->select('collectors.user_id','collectors.phone_no', 'collectors.ai_range', 'collectors.village', 'collectors.gps_lati', 'collectors.gps_long', 'collectors.rice_variety', 'collectors.date_establish', 'users.name', 'users.email', 'districts.name as dname', 'as_centers.name as asname')->get();
        return view('collectors.show-collectors')->with('collectors', $collector);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Collector $collector)
    {
        $districts = District::all();
        $selected_asc = $collector->asc;
        $ascs = As_center::where('district_id', $collector->district)->get();

        return view('collector.edit', compact('collector', 'districts', 'selected_asc', 'ascs'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Collector $collector)
    {
        $dateEstablish = Carbon::createFromFormat('d-m-Y', $request->get('date_establish'))->format('Y-m-d');

           $collector->phone_no = $request->phone_no;
           $collector->district = $request->district;
           $collector->asc =$request->asc;
           $collector->ai_range = $request->ai_range;
           $collector->village= $request->village;
           $collector->gps_lati = $request->gps_lati;
           $collector->gps_long = $request->gps_long;
           $collector->rice_variety = $request->rice_variety;
           $collector->date_establish = $dateEstablish;
           $collector->save();
        return redirect()->route('admin.collector.index')->with('success', 'Collector updated successfully.');
    }
   public function getAsCenters($Id)
    {
        $as_centers = As_center::where('district_id', $Id)->get();
        return response()->json($as_centers);
    }
  
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Collector::destroy($id);
        return redirect('collector')->with('flash_message', 'collector deleted!');
    }
}
