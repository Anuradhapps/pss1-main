<?php

namespace App\Http\Livewire\Graph;

use App\Http\Controllers\PestDataCollectController;
use App\Models\CommonDataCollect;
use App\Models\district;
use App\Models\RiceSeason;
use Carbon\Carbon;
use Livewire\Component;

class PestBothSeasonCombined extends Component
{
    public $dates = [];
    public $pestData = [];
    public $districts;

    // Enhanced Filters
    public $districtId = 0;
    public $selectedYear = 'all';
    public $selectedSeasonType = 'both'; // 'yala', 'maha', 'both'
    public $availableYears = [];

    // Analytics & Decision Making
    public $isLoading = false;
    public $analytics = [
        'highest_risk_pest' => null,
        'highest_risk_level' => 0,
        'critical_alerts' => [],
        'trend_direction' => 'stable', // up, down, stable
    ];

    protected $listeners = ['refreshData'];

    const PEST_NAMES = [
        'thrips',
        'gallMidge',
        'leaffolder',
        'yellowStemBorer',
        'bphWbph',
        'paddyBug'
    ];

    public function mount()
    {
        $this->loadInitialFilters();
        $this->generateData();
    }

    protected function loadInitialFilters()
    {
        $this->districts = district::orderBy('name')->get();

        // Extract distinct years from seasons for the filter dropdown
        $seasons = RiceSeason::orderBy('start_date', 'desc')->get();
        $years = [];
        foreach ($seasons as $season) {
            $year = Carbon::parse($season->start_date)->format('Y');
            $years[$year] = $year;
        }
        $this->availableYears = array_unique($years);
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['selectedYear', 'selectedSeasonType', 'districtId'])) {
            $this->refreshData();
        }
    }

    public function generateData()
    {
        $this->isLoading = true;

        try {
            $dateRange = $this->getDateRange();
            $this->dates = $this->getWeeksInRange($dateRange['start'], $dateRange['end']);

            $commonData = $this->getCommonData($dateRange);
            $this->processPestData($commonData);
            $this->generateDecisionInsights();
        } finally {
            $this->isLoading = false;
        }
    }

    protected function getDateRange()
    {
        $query = RiceSeason::query();

        // Filter by Year
        if ($this->selectedYear !== 'all') {
            $query->whereYear('start_date', $this->selectedYear);
        }

        // Filter by Season Type (Assuming your season names contain 'Yala' or 'Maha')
        if ($this->selectedSeasonType !== 'both') {
            $query->where('name', 'like', '%' . $this->selectedSeasonType . '%');
        }

        $seasons = $query->get();

        if ($seasons->isEmpty()) {
            return ['start' => now()->subMonths(6), 'end' => now()]; // Fallback
        }

        return [
            'start' => $seasons->min('start_date'),
            'end' => $seasons->max('end_date')
        ];
    }

    protected function getCommonData(array $dateRange)
    {
        $query = CommonDataCollect::with('collector')
            ->whereBetween('c_date', [
                Carbon::parse($dateRange['start'])->startOfDay(),
                Carbon::parse($dateRange['end'])->endOfDay()
            ]);

        if ($this->districtId != 0) {
            $query->whereHas('collector', function ($q) {
                $q->where('district', $this->districtId);
            });
        }

        return $query->get()->groupBy(function ($item) {
            return Carbon::parse($item->c_date)->format('Y-m-d');
        });
    }

    protected function processPestData($commonData)
    {
        $pestDataController = new PestDataCollectController();
        $this->pestData = [];

        foreach (self::PEST_NAMES as $pest) {
            $this->pestData[$pest] = array_map(function ($date) use ($commonData, $pest, $pestDataController) {
                $startDate = Carbon::parse($date);
                $endDate = $startDate->copy()->addDays(7);

                $weeklyData = $commonData->filter(function ($items, $itemDate) use ($startDate, $endDate) {
                    return Carbon::parse($itemDate)->between($startDate, $endDate);
                })->flatten();

                if ($weeklyData->isEmpty()) return 0;

                $pestDataCodes = $pestDataController->avarageCalculateByCommonData($weeklyData);
                return $pestDataCodes['pests'][$pest] ?? 0;
            }, $this->dates);
        }
    }

    protected function generateDecisionInsights()
    {
        $this->analytics['critical_alerts'] = [];
        $highestRisk = 0;
        $highestPest = null;
        $recentTrend = 0;

        foreach ($this->pestData as $pest => $dataPoints) {
            if (empty($dataPoints)) continue;

            $latestRisk = end($dataPoints);
            $previousRisk = count($dataPoints) > 1 ? $dataPoints[count($dataPoints) - 2] : 0;

            // Determine Peak Pest
            if ($latestRisk > $highestRisk) {
                $highestRisk = $latestRisk;
                $highestPest = $pest;
            }

            // Generate Alerts for Decision Making
            if ($latestRisk >= 7) {
                $this->analytics['critical_alerts'][] = "CRITICAL: " . $this->formatPestName($pest) . " has reached severe levels ($latestRisk). Immediate action recommended.";
            } elseif ($latestRisk >= 5 && $latestRisk > $previousRisk) {
                $this->analytics['critical_alerts'][] = "WARNING: " . $this->formatPestName($pest) . " is trending upwards ($latestRisk) and has crossed the economic threshold.";
            }

            $recentTrend += ($latestRisk - $previousRisk);
        }

        $this->analytics['highest_risk_pest'] = $highestPest ? $this->formatPestName($highestPest) : 'None';
        $this->analytics['highest_risk_level'] = $highestRisk;
        $this->analytics['trend_direction'] = $recentTrend > 0 ? 'up' : ($recentTrend < 0 ? 'down' : 'stable');
    }

    private function formatPestName($pest)
    {
        return trim(ucwords(preg_replace('/([A-Z])/', ' $1', str_replace('bphWbph', 'BPH/WBPH', $pest))));
    }

    protected function getWeeksInRange($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate)->endOfDay();
        $weeks = [];
        while ($start <= $end) {
            $weeks[] = $start->format('Y-m-d');
            $start->addWeek();
        }
        return $weeks;
    }

    public function refreshData()
    {
        $this->generateData();
        $this->dispatchBrowserEvent('chartUpdated', [
            'dates' => $this->dates,
            'pestData' => $this->pestData,
        ]);
    }

    public function render()
    {
        return view('livewire.graph.pest-both-season-combined');
    }
}
