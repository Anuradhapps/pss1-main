<?php

namespace App\Http\Livewire\Graph;

use App\Http\Controllers\PestDataCollectController;
use App\Models\CommonDataCollect;
use App\Models\District;
use App\Models\RiceSeason;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Chart extends Component
{
    public $dates = [];
    public $pestData = [];
    public $seasons;
    public $selectedSeason = 0;
    public $districtId = 0;
    public $districts;
    public $isLoading = false;


    protected $listeners = ['refreshData'];

    // Constants for cache keys and configuration
    const CACHE_TTL = 3600; // 1 hour
    const PEST_NAMES = [
        'thrips',
        'gallMidge',
        'leaffolder',
        'yellowStemBorer',
        'bphWbph',
        'paddyBug',
    ];

    public function mount()
    {
        $this->loadInitialData();
    }

    protected function loadInitialData()
    {
        $this->seasons = Cache::remember('rice-seasons-list', self::CACHE_TTL, function () {
            return RiceSeason::orderBy('start_date', 'desc')->get();
        });

        $this->districts = Cache::remember('districts-list', self::CACHE_TTL, function () {
            return District::orderBy('name')->get();
        });

        $this->generateData();
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['selectedSeason', 'districtId'])) {
            $this->refreshData();
        }
    }

    public function generateData()
    {
        $this->isLoading = true;

        try {
            $cacheKey = $this->getCacheKey();
            $cachedData = Cache::get($cacheKey);

            if ($cachedData) {
                $this->dates = $cachedData['dates'];
                $this->pestData = $cachedData['pestData'];
                return;
            }

            $dateRange = $this->getDateRange();
            $this->dates = $this->getWeeksInRange($dateRange['start'], $dateRange['end']);

            $commonData = $this->getCommonData($dateRange);
            $this->processPestData($commonData);

            Cache::put($cacheKey, [
                'dates' => $this->dates,
                'pestData' => $this->pestData
            ], self::CACHE_TTL);
        } finally {
            $this->isLoading = false;
        }
    }

    protected function getCacheKey()
    {
        return sprintf('pest-data-%s-%s', $this->selectedSeason, $this->districtId);
    }

    protected function getDateRange()
    {
        if ($this->selectedSeason == 0) {
            return [
                'start' => RiceSeason::min('start_date'),
                'end' => RiceSeason::max('end_date')
            ];
        }

        $season = RiceSeason::find($this->selectedSeason);
        return $season ? [
            'start' => $season->start_date,
            'end' => $season->end_date
        ] : ['start' => now(), 'end' => now()];
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

        return $query->get()
            ->groupBy(function ($item) {
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
                    $date = Carbon::parse($itemDate);
                    return $date->between($startDate, $endDate);
                })->flatten();

                if ($weeklyData->isEmpty()) {
                    return 0;
                }

                $pestDataCodes = $pestDataController->avarageCalculateByCommonData($weeklyData);
                return $pestDataCodes['pests'][$pest] ?? 0;
            }, $this->dates);
        }
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

        return view('livewire.graph.chart');
    }
}
