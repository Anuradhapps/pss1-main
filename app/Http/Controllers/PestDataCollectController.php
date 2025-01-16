<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Collector;
use App\Models\CommonDataCollect;
use App\Models\Pest;
use App\Models\PestDataCollect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PestDataCollectController extends Controller
{
    public $totalTillers;

    public $thripsCode;

    public $totalPests;
    public $mean;
    public $code;
    public  $thisSeasonId;
    public $thisSeason;
    public function __construct()
    {
        $season = new RiceSeasonController;
        $this->thisSeason =  $season->getSeasson();
        $this->thisSeasonId =  $season->getSeasson()['seasonId'];
    }
    public function index()
    {
        $user = Auth::user();
        $collector = Collector::where('user_id', $user->id)->where('rice_season_id', $this->thisSeasonId)->latest()->first();
        if ($collector) {
            $CommonData = CommonDataCollect::where('user_id', '=', $user->id)->latest()->get();

            return view('pestData.index', ['CommonData' => $CommonData]);
        }
        if (is_admin()) {
            return redirect()->route('admin.collector.create')->with('error', 'Please Create Collector');
        } else {
            return redirect()->route('collector.create')->with('error', 'Please Create Collector');
        }
    }
    public function view($id)
    {
        $collector = Collector::find($id);
        if ($collector) {
            $CommonData = CommonDataCollect::where('collector_id', '=', $collector->id)->latest()->get();

            return view('pestData.index', ['CommonData' => $CommonData, 'collectorId' => $id, 'collector' => $collector]);
        }
        if (is_admin()) {
            return redirect()->route('admin.collector.create')->with('error', 'Please Create Collector');
        } else {
            return redirect()->route('collector.create')->with('error', 'Please Create Collector');
        }
    }

    public function create($id)
    {
        $pests = Pest::all();
        return view('pestData.create', ['pests' => $pests, 'collectorId' => $id]);
    }

    public function store($id, Request $request)
    {
        $user = Auth::user();
        $collector = Collector::find($id);
        $validatedRequest = $request->validate([
            'date_collected' => 'required',
            'growth_s_c' => 'required',
            'numbrer_r_day' => 'required',
            'Number_Of_Tillers_location_1' => 'required',
            'Number_Of_Tillers_location_2' => 'required',
            'Number_Of_Tillers_location_3' => 'required',
            'Number_Of_Tillers_location_4' => 'required',
            'Number_Of_Tillers_location_5' => 'required',
            'Number_Of_Tillers_location_6' => 'required',
            'Number_Of_Tillers_location_7' => 'required',
            'Number_Of_Tillers_location_8' => 'required',
            'Number_Of_Tillers_location_9' => 'required',
            'Number_Of_Tillers_location_10' => 'required',
        ]);

        $CommonDataCollect = CommonDataCollect::create([
            'user_id' => Auth::user()->id,
            'collector_id' => $collector->id,
            'c_date' => Carbon::createFromFormat('d-m-Y', $validatedRequest['date_collected']),
            'temperature' => $request->input('temperature') ?: 0,
            'growth_s_c' => $validatedRequest['growth_s_c'],
            'numbrer_r_day' => $validatedRequest['numbrer_r_day'],
            'otherinfo' => $request->input('otherinfo'),
        ]);

        $this->totalTillers =
            $request->input('Number_Of_Tillers_location_1', 0) +
            $request->input('Number_Of_Tillers_location_2', 0) +
            $request->input('Number_Of_Tillers_location_3', 0) +
            $request->input('Number_Of_Tillers_location_4', 0) +
            $request->input('Number_Of_Tillers_location_5', 0) +
            $request->input('Number_Of_Tillers_location_6', 0) +
            $request->input('Number_Of_Tillers_location_7', 0) +
            $request->input('Number_Of_Tillers_location_8', 0) +
            $request->input('Number_Of_Tillers_location_9', 0) +
            $request->input('Number_Of_Tillers_location_10', 0);

        PestDataCollect::create([
            'common_data_collectors_id' => $CommonDataCollect->id,
            'pest_name' => 'Number_Of_Tillers', // This should just get the name from the Pest model
            'location_1' => $request->input('Number_Of_Tillers_location_1') ?: 0,
            'location_2' => $request->input('Number_Of_Tillers_location_2') ?: 0,
            'location_3' => $request->input('Number_Of_Tillers_location_3') ?: 0,
            'location_4' => $request->input('Number_Of_Tillers_location_4') ?: 0,
            'location_5' => $request->input('Number_Of_Tillers_location_5') ?: 0,
            'location_6' => $request->input('Number_Of_Tillers_location_6') ?: 0,
            'location_7' => $request->input('Number_Of_Tillers_location_7') ?: 0,
            'location_8' => $request->input('Number_Of_Tillers_location_8') ?: 0,
            'location_9' => $request->input('Number_Of_Tillers_location_9') ?: 0,
            'location_10' => $request->input('Number_Of_Tillers_location_10') ?: 0,
            'total' => $this->totalTillers,
            'mean' => 0,
            'code' => 0

        ]);
        $pests = Pest::all();
        foreach ($pests as $pest) {
            if ($pest->name == 'Thrips') {
                $this->thripsCode = $request->input($pest->id . 'all_location');
                PestDataCollect::create([
                    'common_data_collectors_id' => $CommonDataCollect->id,
                    'pest_name' => $pest->name, // This should just get the name from the Pest model
                    'location_1' => 0,
                    'location_2' => 0,
                    'location_3' => 0,
                    'location_4' => 0,
                    'location_5' => 0,
                    'location_6' => 0,
                    'location_7' => 0,
                    'location_8' => 0,
                    'location_9' => 0,
                    'location_10' => 0,
                    'total' => 0,
                    'mean' => 0,
                    'code' => $this->thripsCode ?: 0
                ]);
            } else {
                for ($i = 1; $i <= 10; $i++) {
                    $this->totalPests += $request->input($pest->id . '_location_' . $i, 0);
                };
                switch ($pest->name) {
                    case 'Gall Midge':
                        $gallmidge = $this->getGallMidgeCode($this->totalTillers, $this->totalPests);
                        $this->mean = $gallmidge['mean'];
                        $this->code = $gallmidge['code'];
                        break;
                    case 'Leaffolder':
                        $leaffolder = $this->getLeaffolderCode($this->totalTillers, $this->totalPests);
                        $this->mean = $leaffolder['mean'];
                        $this->code = $leaffolder['code'];
                        break;
                    case 'Yellow Stem Borer':
                        $yellowStemBorer = $this->getYellowStemBorerCode($this->totalTillers, $this->totalPests);
                        $this->mean = $yellowStemBorer['mean'];
                        $this->code = $yellowStemBorer['code'];
                        break;
                    case 'BPH+WBPH':
                        $bphWbph = $this->getBphWbphCode($this->totalTillers, $this->totalPests);
                        $this->mean = $bphWbph['mean'];
                        $this->code = $bphWbph['code'];
                        break;
                    case 'Paddy Bug':
                        $paddyBug = $this->getPaddyBugCode($this->totalTillers, $this->totalPests);
                        $this->mean = $paddyBug['mean'];
                        $this->code = $paddyBug['code'];
                        break;
                    default:
                        $this->mean = 0;
                        $this->code = 0;
                        break;
                }


                PestDataCollect::create([
                    'common_data_collectors_id' => $CommonDataCollect->id,
                    'pest_name' => $pest->name, // This should just get the name from the Pest model
                    'location_1' => $request->input($pest->id . '_location_1') ?: 0,
                    'location_2' => $request->input($pest->id . '_location_2') ?: 0,
                    'location_3' => $request->input($pest->id . '_location_3') ?: 0,
                    'location_4' => $request->input($pest->id . '_location_4') ?: 0,
                    'location_5' => $request->input($pest->id . '_location_5') ?: 0,
                    'location_6' => $request->input($pest->id . '_location_6') ?: 0,
                    'location_7' => $request->input($pest->id . '_location_7') ?: 0,
                    'location_8' => $request->input($pest->id . '_location_8') ?: 0,
                    'location_9' => $request->input($pest->id . '_location_9') ?: 0,
                    'location_10' => $request->input($pest->id . '_location_10') ?: 0,
                    'total' => $this->totalPests,
                    'mean' => $this->mean,
                    'code' => $this->code

                ]);
                $this->totalPests = 0;
            }
        }

        return redirect()->route('pestdata.view', $id)->with('success', 'Pest Data created successfully.');
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

    public function update(Request $request, $Id) {}

    public function destroy($id)
    {
        // CommonDataCollect::findOrFail($id)->delete();
        $commonData = CommonDataCollect::findOrFail($id);
        $collectorId = $commonData->collector_id;
        $commonData->delete();
        return redirect()->route('pestdata.view', $collectorId)->with('success', 'Pest Data deleted successfully.');
    }
    public function adminDestroy($id)
    {
        CommonDataCollect::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Pest data deleted successfully.');
    }

    public function getGallMidgeCode($tillerTotal, $pestTotal)
    {

        // Calculate mean
        $mean = ($pestTotal / $tillerTotal) * 100;

        // Initialize code
        $code = 0;

        // Check ranges and assign the code
        if ($mean == 0) {
            $code = 0;
        } elseif ($mean > 0 && $mean <= 1) {
            $code = 1;
        } elseif ($mean > 1 && $mean < 6) {
            $code = 3;
        } elseif ($mean >= 6 && $mean < 11) {
            $code = 5;
        } elseif ($mean >= 11 && $mean < 26) {
            $code = 7;
        } elseif ($mean >= 26) {
            $code = 9;
        } else {
            $code = 0;
        }

        // Return mean and code
        return ['mean' => $mean, 'code' => $code];
    }
    public function getLeaffolderCode($tillerTotal, $pestTotal)
    {
        $mean = ($pestTotal / $tillerTotal) * 100;
        $code = 0;
        if ($mean == 0) {
            $code = 0;
        } elseif ($mean > 0 && $mean < 6) {
            $code = 1;
        } elseif ($mean >= 6 && $mean < 11) {
            $code = 3;
        } elseif ($mean >= 11 && $mean < 21) {
            $code = 5;
        } elseif ($mean >= 21 && $mean < 51) {
            $code = 7;
        } elseif ($mean >= 51) {
            $code = 9;
        } else {
            $code = 0;
        }


        return ['mean' => $mean, 'code' => $code];
    }
    public function getYellowStemBorerCode($tillerTotal, $pestTotal)
    {
        $mean = ($pestTotal / $tillerTotal) * 100;
        $code = 0;
        if ($mean == 0) {
            $code = 0;
        } elseif ($mean > 0 && $mean < 2) {
            $code = 1;
        } elseif ($mean >= 2 && $mean < 4) {
            $code = 3;
        } elseif ($mean >= 4 && $mean < 11) {
            $code = 5;
        } elseif ($mean >= 11 && $mean < 51) {
            $code = 7;
        } elseif ($mean >= 51) {
            $code = 9;
        } else {
            $code = 0;
        }
        return ['mean' => $mean, 'code' => $code];
    }
    public function getBphWbphCode($tillerTotal, $pestTotal)
    {
        $mean = $pestTotal / $tillerTotal;
        $code = 0;
        if ($mean == 0) {
            $code = 0;
        } elseif ($mean > 0 && $mean < 2) {
            $code = 1;
        } elseif ($mean >= 2 && $mean < 6) {
            $code = 3;
        } elseif ($mean >= 6 && $mean < 11) {
            $code = 5;
        } elseif ($mean >= 11 && $mean < 21) {
            $code = 7;
        } elseif ($mean >= 21) {
            $code = 9;
        } else {
            $code = 0;
        }
        return ['mean' => $mean, 'code' => $code];
    }
    public function getPaddyBugCode($tillerTotal, $pestTotal)
    {
        $mean = $pestTotal / 10;
        $code = 0;
        if ($mean == 0) {
            $code = 0;
        } elseif ($mean > 0 && $mean < 2) {
            $code = 1;
        } elseif ($mean >= 2 && $mean < 5) {
            $code = 3;
        } elseif ($mean >= 5 && $mean < 16) {
            $code = 5;
        } elseif ($mean >= 16 && $mean < 21) {
            $code = 7;
        } elseif ($mean >= 21) {
            $code = 9;
        } else {
            $code = 0;
        }
        return ['mean' => $mean, 'code' => $code];
    }
}
