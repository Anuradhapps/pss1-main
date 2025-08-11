<?php

namespace App\Http\Livewire\Graph;

use App\Http\Controllers\PestDataCollectController;
use App\Models\CommonDataCollect;
use App\Models\RiceSeason;
use Carbon\Carbon;
use DateTime;
use Livewire\Component;

class Chart extends Component
{
    public $dates = [];
    public $pestData = [];
    public $seasons;
    public $selectedSeason = 0;
    public $isLoading = false;

    protected $listeners = ['refreshData'];

    public function mount()
    {
        $this->seasons = RiceSeason::orderBy('start_date', 'desc')->get();
        $this->generateData();
    }

    public function updatedSelectedSeason()
    {
        $this->refreshData();
    }

    public function generateData()
    {
        $this->isLoading = true;

        try {
            // Determine date range based on season selection
            if ($this->selectedSeason == 0) {
                $firstDate = RiceSeason::min('start_date');
                $lastDate = RiceSeason::max('end_date');
            } else {
                $season = RiceSeason::find($this->selectedSeason);
                if (!$season) {
                    $this->dates = [];
                    $this->pestData = [];
                    return;
                }
                $firstDate = $season->start_date;
                $lastDate = $season->end_date;
            }

            $this->dates = $this->getWeeksInRange($firstDate, $lastDate);

            // Preload all common data for the date range to reduce database queries
            $commonData = CommonDataCollect::whereBetween('c_date', [
                Carbon::parse($firstDate)->startOfDay(),
                Carbon::parse($lastDate)->endOfDay()
            ])->get()->groupBy(function ($item) {
                return Carbon::parse($item->c_date)->format('Y-m-d');
            });

            $pestNames = [
                'thrips',
                'gallMidge',
                'leaffolder',
                'yellowStemBorer',
                'bphWbph',
                'paddyBug',
            ];

            $this->pestData = [];

            $pestDataController = new PestDataCollectController();

            foreach ($pestNames as $pest) {
                $this->pestData[$pest] = array_map(function ($date) use ($commonData, $pest, $pestDataController) {
                    $startDate = Carbon::parse($date);
                    $endDate = $startDate->copy()->addDays(7);

                    // Filter from preloaded data instead of querying
                    $weeklyData = $commonData->filter(function ($items, $itemDate) use ($startDate, $endDate) {
                        $date = Carbon::parse($itemDate);
                        return $date >= $startDate && $date <= $endDate;
                    })->flatten();

                    if ($weeklyData->isEmpty()) {
                        return 0;
                    }

                    $pestDataCodes = $pestDataController->avarageCalculateByCommonData($weeklyData);
                    return $pestDataCodes['pests'][$pest] ?? 0;
                }, $this->dates);
            }
        } finally {
            $this->isLoading = false;
        }
    }

    private function getWeeksInRange(string $startDate, string $endDate): array
    {
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);
        $end->setTime(23, 59, 59);

        $weeks = [];
        while ($start <= $end) {
            $weeks[] = $start->format('Y-m-d');
            $start->modify('+7 days');
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
