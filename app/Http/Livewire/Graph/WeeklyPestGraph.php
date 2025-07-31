<?php

namespace App\Http\Livewire\Graph;

use App\Models\Collector;
use App\Models\Region;
use App\Models\Province;
use App\Models\District;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class WeeklyPestGraph extends Component
{
    public $startDate;
    public $endDate;
    public $chartData = [];
    public $regionId = null;
    public $provinceId = null;
    public $districtId = null;

    public function mount()
    {

        // Use a historical range for testing (e.g., May 6, 2025 to July 1, 2025)
        $this->endDate = Carbon::parse('2024-12-30')->endOfWeek()->format('Y-m-d H:i:s');
        $this->startDate = Carbon::parse('2024-12-01')->subWeeks(8)->startOfWeek()->format('Y-m-d H:i:s');
        $this->loadData();
    }

    public function updatedRegionId()
    {
        $this->provinceId = null;
        $this->districtId = null;
        $this->loadData();
    }

    public function updatedProvinceId()
    {
        $this->districtId = null;
        $this->loadData();
    }

    public function updatedDistrictId()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $query = Collector::with(['commonDataCollect' => function ($query) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate])
                ->with('pestDataCollect');
        }]);

        if ($this->districtId) {
            $query->where('district', $this->districtId);
        } elseif ($this->provinceId) {
            $query->where('province', $this->provinceId);
        } elseif ($this->regionId) {
            $query->where('region_id', $this->regionId);
        }

        $collectors = $query->get();

        Log::info('Collectors fetched', [
            'count' => $collectors->count(),
            'regionId' => $this->regionId,
            'provinceId' => $this->provinceId,
            'districtId' => $this->districtId,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate
        ]);

        $weeks = [];
        $current = Carbon::parse($this->startDate)->startOfWeek();
        $end = Carbon::parse($this->endDate)->endOfWeek();

        while ($current->lte($end)) {
            $weekStart = $current->copy();
            $weekEnd = $current->copy()->endOfWeek();

            $weeklyCollectors = $collectors->filter(function ($collector) use ($weekStart, $weekEnd) {
                return $collector->commonDataCollect->contains(function ($cd) use ($weekStart, $weekEnd) {
                    return Carbon::parse($cd->created_at)->between($weekStart, $weekEnd);
                });
            });

            $averages = $this->averageCalculate($weeklyCollectors);

            $weeks[] = [
                'week' => 'Week of ' . $weekStart->format('M d'),
                'data' => $averages['pests'] ?? [
                    'thrips' => 0,
                    'gallMidge' => 0,
                    'leaffolder' => 0,
                    'yellowStemBorer' => 0,
                    'bphWbph' => 0,
                    'paddyBug' => 0
                ],
            ];

            Log::info('Averages for week ' . $weekStart->format('M d'), ['averages' => $averages]);

            $current->addWeek();
        }

        $this->chartData = $weeks;
        Log::info('Chart data prepared', ['chartData' => $this->chartData]);
        $this->dispatchBrowserEvent('refreshChart');
    }

    public function averageCalculate($collectors)
    {
        if ($collectors->count() == 0) {
            return [
                "pests" => [
                    "thrips" => 0,
                    "gallMidge" => 0,
                    "leaffolder" => 0,
                    "yellowStemBorer" => 0,
                    "bphWbph" => 0,
                    "paddyBug" => 0
                ]
            ];
        }

        $noOfTillers = 0;
        $thrips = 0;
        $gallMidge = 0;
        $leaffolder = 0;
        $yellowStemBorer = 0;
        $bphWbph = 0;
        $paddyBug = 0;
        $thripsCount = 0;

        foreach ($collectors as $collector) {
            foreach ($collector->commonDataCollect as $commonData) {
                foreach ($commonData->pestDataCollect as $pestData) {
                    switch ($pestData->pest_name) {
                        case 'Number_Of_Tillers':
                            $noOfTillers += $pestData->total;
                            break;
                        case 'Thrips':
                            $thripsCount++;
                            $thrips += $pestData->code;
                            break;
                        case 'Gall Midge':
                            $gallMidge += $pestData->total;
                            break;
                        case 'Leaffolder':
                            $leaffolder += $pestData->total;
                            break;
                        case 'Yellow Stem Borer':
                            $yellowStemBorer += $pestData->total;
                            break;
                        case 'BPH+WBPH':
                            $bphWbph += $pestData->total;
                            break;
                        case 'Paddy Bug':
                            $paddyBug += $pestData->total;
                            break;
                    }
                }
            }
        }

        $possibleCodes = [0, 1, 3, 5, 7, 9];
        $thripsCode = $thripsCount > 0 ? $this->getNearestCode($thrips / $thripsCount, $possibleCodes) : 0;

        $pestCodes = [
            "thrips" => $thripsCode,
            "gallMidge" => 0,
            "leaffolder" => 0,
            "yellowStemBorer" => 0,
            "bphWbph" => 0,
            "paddyBug" => 0
        ];

        if ($noOfTillers > 0) {
            $pestCodes["gallMidge"] = $this->getPestCode($gallMidge / $noOfTillers);
            $pestCodes["leaffolder"] = $this->getPestCode($leaffolder / $noOfTillers);
            $pestCodes["yellowStemBorer"] = $this->getPestCode($yellowStemBorer / $noOfTillers);
            $pestCodes["bphWbph"] = $this->getPestCode($bphWbph / $noOfTillers);
            $pestCodes["paddyBug"] = $this->getPestCode($paddyBug / $noOfTillers);
        }

        return ["pests" => $pestCodes];
    }

    public function getNearestCode($value, $possibleCodes)
    {
        return array_reduce($possibleCodes, function ($carry, $item) use ($value) {
            return (abs($item - $value) < abs($carry - $value)) ? $item : $carry;
        }, $possibleCodes[0]);
    }

    private function getPestCode($ratio)
    {
        if ($ratio == 0) return 0;
        if ($ratio <= 0.05) return 1;
        if ($ratio <= 0.1) return 3;
        if ($ratio <= 0.2) return 5;
        if ($ratio <= 0.3) return 7;
        return 9;
    }

    public function render()
    {
        $regions = Cache::remember('regions', now()->addHours(1), function () {
            return Region::select('id', 'name')->orderBy('name')->get();
        });

        $provinces = $this->regionId ? Cache::remember("provinces_region_{$this->regionId}", now()->addHours(1), function () {
            return Province::whereIn('id', Collector::where('region_id', $this->regionId)
                ->distinct()
                ->pluck('province'))
                ->select('id', 'name')
                ->orderBy('name')
                ->get();
        }) : [];

        $districts = $this->provinceId ? Cache::remember("districts_province_{$this->provinceId}", now()->addHours(1), function () {
            return District::whereIn('id', Collector::where('province', $this->provinceId)
                ->distinct()
                ->pluck('district'))
                ->select('id', 'name')
                ->orderBy('name')
                ->get();
        }) : [];

        return view('livewire.graph.weekly-pest-graph', compact('regions', 'provinces', 'districts'));
    }
}
