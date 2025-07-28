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
        // Get the currently authenticated user
        $user = Auth::user();

        // Retrieve the collector for the current season, if available
        $collector = Collector::where('user_id', $user->id)
            ->where('rice_season_id', $this->thisSeasonId)
            ->latest()
            ->first();

        // If a collector exists for the user and season
        if ($collector) {
            // Retrieve all common data entries for the user (latest first)
            $commonData = CommonDataCollect::where('user_id', $user->id)
                ->latest()
                ->get();

            // Return the pest data index view with the retrieved common data
            return view('pestData.index', ['CommonData' => $commonData]);
        }

        // If no collector exists, redirect based on role with an error message
        if (is_admin()) {
            // Redirect admin to create a new collector
            return redirect()->route('admin.collector.create')
                ->with('error', 'Please create a Collector first.');
        }

        // Redirect regular collector to their collector creation form
        return redirect()->route('collector.create')
            ->with('error', 'Please create a Collector first.');
    }

    public function view($id)
    {
        // Attempt to find the collector by ID
        $collector = Collector::find($id);

        // If collector is found
        if ($collector) {
            $pestCodes = $this->avarageCalculate(collect([$collector]));


            // Extract and format labels and data
            $labels = collect($pestCodes['pests'])->keys()->map(function ($key) {
                return ucwords(preg_replace('/(?<!^)[A-Z]/', ' $0', $key)); // camelCase to "Camel Case"
            })->toArray();

            $data = array_values($pestCodes['pests']); // Get just the values
            $commonData = CommonDataCollect::where('collector_id', $collector->id)
                ->latest()
                ->paginate(10); // If you're paginating CommonData

            return view('pestData.index', [
                'CommonData' => $commonData,
                'collectorId' => $collector->id,
                'collector' => $collector,
                'pestLabels' => $labels,
                'pestCode' => $data,
            ]);
        }


        // If collector not found, redirect based on role with an error message
        if (is_admin()) {
            return redirect()->route('admin.collector.create')
                ->with('error', 'Please create a Collector first.');
        }

        return redirect()->route('collector.create')
            ->with('error', 'Please create a Collector first.');
    }


    public function create($id)
    {
        // Retrieve all pest records to display in the form
        $pests = Pest::all();

        // Return the pest data creation view with the pest list and collector ID
        return view('pestData.create', [
            'pests' => $pests,
            'collectorId' => $id,
        ]);
    }


    public function store($id, Request $request)
    {
        $user = Auth::user();
        $collector = Collector::find($id);

        if (!$collector) {
            return redirect()->back()->withErrors('Collector not found.');
        }

        $validated = $request->validate([
            'date_collected' => 'required|date_format:d-m-Y',
            'growth_s_c' => 'required',
            'numbrer_r_day' => 'required|numeric',
            // Validate tiller locations as numeric
            'Number_Of_Tillers_location_1' => 'required|numeric',
            'Number_Of_Tillers_location_2' => 'required|numeric',
            'Number_Of_Tillers_location_3' => 'required|numeric',
            'Number_Of_Tillers_location_4' => 'required|numeric',
            'Number_Of_Tillers_location_5' => 'required|numeric',
            'Number_Of_Tillers_location_6' => 'required|numeric',
            'Number_Of_Tillers_location_7' => 'required|numeric',
            'Number_Of_Tillers_location_8' => 'required|numeric',
            'Number_Of_Tillers_location_9' => 'required|numeric',
            'Number_Of_Tillers_location_10' => 'required|numeric',
            // Add other inputs if needed (temperature, otherinfo)
        ]);

        // Create CommonDataCollect record
        $commonDataCollect = CommonDataCollect::create([
            'user_id' => $user->id,
            'collector_id' => $collector->id,
            'c_date' => Carbon::createFromFormat('d-m-Y', $validated['date_collected']),
            'temperature' => $request->input('temperature', 0),
            'growth_s_c' => $validated['growth_s_c'],
            'numbrer_r_day' => $validated['numbrer_r_day'],
            'otherinfo' => $request->input('otherinfo'),
        ]);

        // Collect and sum tillers locations
        $tillerLocations = collect(range(1, 10))
            ->map(fn($i) => intval($request->input("Number_Of_Tillers_location_{$i}", 0)));

        $totalTillers = $tillerLocations->sum();

        // Create PestDataCollect record for Number_Of_Tillers
        PestDataCollect::create([
            'common_data_collectors_id' => $commonDataCollect->id,
            'pest_name' => 'Number_Of_Tillers',
            'location_1' => $tillerLocations[0],
            'location_2' => $tillerLocations[1],
            'location_3' => $tillerLocations[2],
            'location_4' => $tillerLocations[3],
            'location_5' => $tillerLocations[4],
            'location_6' => $tillerLocations[5],
            'location_7' => $tillerLocations[6],
            'location_8' => $tillerLocations[7],
            'location_9' => $tillerLocations[8],
            'location_10' => $tillerLocations[9],
            'total' => $totalTillers,
            'mean' => 0,
            'code' => 0,
        ]);

        // Fetch all pests
        $pests = Pest::all();

        foreach ($pests as $pest) {
            if ($pest->name === 'Thrips') {
                $thripsCode = intval($request->input($pest->id . 'all_location', 0));

                PestDataCollect::create([
                    'common_data_collectors_id' => $commonDataCollect->id,
                    'pest_name' => $pest->name,
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
                    'code' => $thripsCode,
                ]);

                continue;
            }

            // Sum pest counts for locations 1 to 10
            $pestCounts = collect(range(1, 10))
                ->map(fn($i) => intval($request->input("{$pest->id}_location_{$i}", 0)));

            $totalPests = $pestCounts->sum();

            // Calculate mean and code based on pest type
            [$mean, $code] = $this->calculatePestCode($pest->name, $totalTillers, $totalPests);

            PestDataCollect::create([
                'common_data_collectors_id' => $commonDataCollect->id,
                'pest_name' => $pest->name,
                'location_1' => $pestCounts[0],
                'location_2' => $pestCounts[1],
                'location_3' => $pestCounts[2],
                'location_4' => $pestCounts[3],
                'location_5' => $pestCounts[4],
                'location_6' => $pestCounts[5],
                'location_7' => $pestCounts[6],
                'location_8' => $pestCounts[7],
                'location_9' => $pestCounts[8],
                'location_10' => $pestCounts[9],
                'total' => $totalPests,
                'mean' => $mean,
                'code' => $code,
            ]);
        }

        return redirect()->route('pestdata.view', $id)
            ->with('success', 'Pest Data created successfully.');
    }


    private function calculatePestCode(string $pestName, int $totalTillers, int $totalPests): array
    {
        switch ($pestName) {
            case 'Gall Midge':
                $result = $this->getGallMidgeCode($totalTillers, $totalPests);
                break;
            case 'Leaffolder':
                $result = $this->getLeaffolderCode($totalTillers, $totalPests);
                break;
            case 'Yellow Stem Borer':
                $result = $this->getYellowStemBorerCode($totalTillers, $totalPests);
                break;
            case 'BPH+WBPH':
                $result = $this->getBphWbphCode($totalTillers, $totalPests);
                break;
            case 'Paddy Bug':
                $result = $this->getPaddyBugCode($totalTillers, $totalPests);
                break;
            default:
                $result = ['mean' => 0, 'code' => 0];
        }

        return [$result['mean'], $result['code']];
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





    //Pest code generate---------------------------------------------------------------------------------------------

    public function getGallMidgeCode($tillerTotal, $pestTotal)
    {
        if ($tillerTotal == 0) {
            return ['mean' => 0, 'code' => 0];
        }

        // Calculate mean as a percentage
        $mean = ($pestTotal / $tillerTotal) * 100;

        // Determine the code based on mean ranges
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
        } else { // mean >= 26
            $code = 9;
        }

        return [
            'mean' => round($mean, 2),
            'code' => $code,
        ];
    }

    public function getLeaffolderCode($tillerTotal, $pestTotal)
    {
        if ($tillerTotal == 0) {
            return ['mean' => 0, 'code' => 0];
        }

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
        } else { // mean >= 51
            $code = 9;
        }

        return [
            'mean' => round($mean, 2),
            'code' => $code,
        ];
    }

    public function getYellowStemBorerCode($tillerTotal, $pestTotal)
    {
        if ($tillerTotal == 0) {
            return ['mean' => 0, 'code' => 0];
        }

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
        } else { // mean >= 51
            $code = 9;
        }

        return [
            'mean' => round($mean, 2),
            'code' => $code,
        ];
    }

    public function getBphWbphCode($tillerTotal, $pestTotal)
    {
        if ($tillerTotal == 0) {
            return ['mean' => 0, 'code' => 0];
        }

        // Note: mean here is pest per tiller (not multiplied by 100)
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
        } else { // mean >= 21
            $code = 9;
        }

        return [
            'mean' => round($mean, 2),
            'code' => $code,
        ];
    }

    public function getPaddyBugCode($tillerTotal, $pestTotal)
    {
        // Since mean is pestTotal / 10, check if pestTotal is numeric and > 0
        if ($pestTotal === 0) {
            return ['mean' => 0, 'code' => 0];
        }

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
        } else { // mean >= 21
            $code = 9;
        }

        return [
            'mean' => round($mean, 2),
            'code' => $code,
        ];
    }

    //when input collector
    public function avarageCalculate($collectors)
    {

        if ($collectors->count() == 0) {
            return redirect()->route('chart.index')->with('error', 'No collectors found');
        }
        $noOfTillers = 0;
        $thrips = 0;
        $gallMidge = 0;
        $leaffolder = 0;
        $yellowStemBorer = 0;
        $bphWbph = 0;
        $paddyBug = 0;

        $thripscount = 0;

        foreach ($collectors as $collector) {

            foreach ($collector->commonDataCollect as $commonData) {
                foreach ($commonData->pestDataCollect as $pestData) {

                    if ($pestData->pest_name == 'Number_Of_Tillers') {
                        $noOfTillers += $pestData->total;
                    } elseif ($pestData->pest_name == 'Thrips') {
                        $thripscount++;
                        $thrips += $pestData->code;
                    } elseif ($pestData->pest_name == 'Gall Midge') {
                        $gallMidge += $pestData->total;
                    } elseif ($pestData->pest_name == 'Leaffolder') {
                        $leaffolder += $pestData->total;
                    } elseif ($pestData->pest_name == 'Yellow Stem Borer') {
                        $yellowStemBorer += $pestData->total;
                    } elseif ($pestData->pest_name == 'BPH+WBPH') {
                        $bphWbph += $pestData->total;
                    } elseif ($pestData->pest_name == 'Paddy Bug') {
                        $paddyBug += $pestData->total;
                    }
                }
            }
        }
        $possibleCodes = [0, 1, 3, 5, 7, 9];
        $thripsC = 0;
        if ($thripscount == 0) {
            $thripsC = 0;
        } else {
            $thripsC = $thrips / $thripscount;
        }


        $thripsCode = $this->getNearestCode($thripsC, $possibleCodes);
        $gallMidgeCode = 0;
        $leaffolderCode = 0;
        $yellowStemBorerCode = 0;
        $bphWbphCode = 0;
        $paddyBugCode = 0;
        if ($noOfTillers != 0) {
            $gallMidgeCode = $this->getgallMidgeCode($noOfTillers, $gallMidge)['code'];
            $leaffolderCode = $this->getLeaffolderCode($noOfTillers, $leaffolder)['code'];
            $yellowStemBorerCode = $this->getYellowStemBorerCode($noOfTillers, $yellowStemBorer)['code'];
            $bphWbphCode = $this->getBphWbphCode($noOfTillers, $bphWbph)['code'];
            $paddyBugCode = $this->getPaddyBugCode($noOfTillers, $paddyBug)['code'];
        }

        return [
            "pests" => [
                "thrips" => $thripsCode,
                "gallMidge" => $gallMidgeCode,
                "leaffolder" => $leaffolderCode,
                "yellowStemBorer" => $yellowStemBorerCode,
                "bphWbph" => $bphWbphCode,
                "paddyBug" => $paddyBugCode
            ]
        ];
    }
    // Function to find the nearest number
    function getNearestCode($value, $possibleCodes)
    {
        return array_reduce($possibleCodes, function ($carry, $item) use ($value) {
            return (abs($item - $value) < abs($carry - $value)) ? $item : $carry;
        }, $possibleCodes[0]);
    }
}
