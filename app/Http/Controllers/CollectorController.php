<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AiRange;
use Illuminate\Support\Facades\Auth;
use App\Models\Collector;
use App\Models\district;
use App\Models\As_center;
use App\Models\Province;
use App\Models\RiceSeason;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CollectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public  $thisSeasonId;
    public $thisSeason;
    public function __construct()
    {
        $season = new RiceSeasonController;
        $this->thisSeason =  $season->getSeasson();
        $this->thisSeasonId =  $this->thisSeason['seasonId'];
    }

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
        $collector  = Collector::where('user_id', $id)->where('rice_season_id', $this->thisSeasonId)->latest()->first();

        if (empty($collector) || $collector->rice_season_id != $this->thisSeasonId) {
            $season = $this->thisSeason['seasonName'];
            return view('collectors.create', ['season' => $season]);
        } else {
            $collectors = Collector::where('user_id', $id)
                ->orderBy('rice_season_id', 'desc')
                ->get();
            return view('collectors.index', ['collectors' => $collectors, 'success' => 'Collector Created successfully!']);
        }
    }
    public function newCollector()
    {
        $season = $this->thisSeason['seasonName'];
        return view('collectors.create', ['season' => $season]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        if (!RiceSeason::find($this->thisSeason['seasonId'])) {
            RiceSeason::create([
                'id' => $this->thisSeason['seasonId'],
                'name' => $this->thisSeason['seasonName'],
                'start_date' => $this->thisSeason['startDate'],
                'end_date' => $this->thisSeason['endDate'],
            ]);
        }


        $request->validate([
            'phone_no' => 'required|unique:collectors',
            'region' => 'required',
            'province' => 'required',
            'district' => 'required',
            'as_center' => 'required',
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
            'rice_season_id' => $this->thisSeasonId,
            'phone_no' => $request->get('phone_no'),
            'region_id' => $request->get('region'),
            'province' => $request->get('province'),
            'district' => $request->get('district'),
            'asc' => $request->get('as_center'),
            'ai_range' => $request->get('ai_range'),
            'village' => $request->get('village'),
            'gps_lati' => $request->get('gps_lati'),
            'gps_long' => $request->get('gps_long'),
            'rice_variety' => $request->get('rice_variety'),
            'date_establish' => $dateEstablish,
        ]);

        $collector->save();
        if (has_role('collector')) {
            $id = Auth::user()->id;
            $collectors  = Collector::where('user_id', $id)->get();
            return view('collectors.index', ['collectors' => $collectors, 'success' => 'Collector Created successfully!']);
        } elseif (has_role('admin')) {
            $collectors = Collector::all();
            return redirect(route('admin.collector.records'))->with('success', 'Collector updated successfully.');
        }
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
            ->select('collectors.user_id', 'collectors.phone_no', 'collectors.ai_range', 'collectors.village', 'collectors.gps_lati', 'collectors.gps_long', 'collectors.rice_variety', 'collectors.date_establish', 'users.name', 'users.email', 'districts.name as dname', 'as_centers.name as asname')->get();
        return view('collectors.show-collectors')->with('collectors', $collector);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $collector = Collector::find($id);
        $seasonId = $collector->rice_season_id;
        $season = RiceSeason::find($seasonId)->name;
        $provinces = Province::all();
        $districts = district::all();
        $as_centers = As_center::all();
        $ai_ranges = AiRange::all();
        return view('collectors.edit', compact('collector',  'provinces', 'districts', 'as_centers', 'ai_ranges', 'season'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $collectorId)
    {
        $collector = Collector::findorfail($collectorId);
        $request->validate([
            'phone_no' => 'required',
            'region' => 'required',
            'province' => 'required',
            'district' => 'required',
            'as_center' => 'required',
            'ai_range' => 'required',
            'village' => 'required',
            'gps_lati' => 'required',
            'gps_long' => 'required',
            'rice_variety' => 'required',
            'date_establish' => 'required',
        ]);

        $dateEstablish = Carbon::createFromFormat('d-m-Y', $request->get('date_establish'))->format('Y-m-d');
        $collector->phone_no = $request->phone_no;
        $collector->region_id = $request->region;
        $collector->province = $request->province;
        $collector->district = $request->district;
        $collector->asc = $request->as_center;
        $collector->ai_range = $request->ai_range;
        $collector->village = $request->village;
        $collector->gps_lati = $request->gps_lati;
        $collector->gps_long = $request->gps_long;
        $collector->rice_variety = $request->rice_variety;
        $collector->date_establish = $dateEstablish;
        $collector->save();
        if (has_role('collector')) {
            $id = Auth::user()->id;
            $collectors  = Collector::where('user_id', $id)->get();
            return view('collectors.index', ['collectors' => $collectors, 'success' => 'Collector updated successfully.']);

            // return redirect()->route('collector.index', ['collectors' => $collectors])->with('success', 'Collector updated successfully.');
        } elseif (has_role('admin')) {
            $collectors = Collector::all();
            return redirect(route('admin.collector.records'));
        }
    }

    // In your controller


    public function getDistricts($provinceId)
    {
        $districts = District::where('province_id', $provinceId)->get();
        return response()->json($districts);
    }

    public function getAsCenters($districtId)
    {
        $ascs = As_center::where('district_id', $districtId)->get();
        return response()->json($ascs);
    }

    public function getAiRanges($ascId)
    {
        $airRanges = AiRange::where('as_center_id', $ascId)->get();
        return response()->json($airRanges);
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
        return redirect(route('admin.collector.records'));
        // return redirect('collector')->with('flash_message', 'collector deleted!');
    }

    public function getCollectorCount($seasonId = null, $provinceId = null, $districtId = null, $asCenterId = null, $aiRangeId = null)
    {
        if ($seasonId = null) {
            $collectorCount = Collector::all()->count();
            return $collectorCount;
        } elseif ($provinceId != null) {
            $collectorCount = Collector::where('rice_season_id', $seasonId)->where('province', $provinceId)->count();
        } elseif ($districtId != null) {
            $collectorCount = Collector::where('rice_season_id', $seasonId)->where('district', $districtId)->count();
        } elseif ($asCenterId != null) {
            $collectorCount = Collector::where('rice_season_id', $seasonId)->where('asc', $asCenterId)->count();
        } elseif ($aiRangeId != null) {
            $collectorCount = Collector::where('rice_season_id', $seasonId)->where('ai_range', $aiRangeId)->count();
        } else {
            dd('No Collector data found');
        }
    }
}
