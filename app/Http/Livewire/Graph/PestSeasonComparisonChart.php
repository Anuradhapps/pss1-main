<?php

namespace App\Http\Livewire\Graph;

use App\Http\Controllers\PestDataCollectController;
use App\Models\CommonDataCollect;
use App\Models\District;
use App\Models\RiceSeason;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class PestSeasonComparisonChart extends Component
{
    public Collection $seasons;
    public Collection $districts;
    public array $pests = [];
    public string $selectedPest = '';
    public int $districtId = 0;
    public bool $isLoading = false;
    public array $pestData = [];

    protected $listeners = ['refreshData'];

    const CACHE_TTL = 3600;
    const PEST_NAMES = [
        'thrips' => 'Thrips',
        'gallMidge' => 'Gall Midge',
        'leaffolder' => 'Leaffolder',
        'yellowStemBorer' => 'Yellow Stem Borer',
        'bphWbph' => 'BPH/WBPH',
        'paddyBug' => 'Paddy Bug',
    ];

    public function mount()
    {
        $this->loadInitialData();
        $this->selectedPest = array_key_first($this->pests) ?? '';
        $this->fetchChartData();
    }

    protected function loadInitialData()
    {
        $this->seasons = Cache::remember(
            'rice-seasons-list',
            self::CACHE_TTL,
            fn() => RiceSeason::orderByDesc('start_date')->get()
        );
        $this->districts = Cache::remember(
            'districts-list',
            self::CACHE_TTL,
            fn() => District::orderBy('name')->get()
        );
        $this->pests = self::PEST_NAMES;
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['selectedPest', 'districtId'])) {
            $this->fetchChartData();
        }
    }

    public function fetchChartData()
    {
        $this->isLoading = true;
        $this->pestData = $this->getPestData();
        $this->isLoading = false;

        // Always fresh chart update
        $this->dispatchBrowserEvent('chartUpdated', ['pestData' => $this->pestData]);
    }

    protected function getPestData(): array
    {
        $cacheKey = sprintf(
            'pest-season-comparison-%s-%s',
            $this->selectedPest,
            $this->districtId
        );

        return Cache::remember($cacheKey, self::CACHE_TTL, function () {
            $pestData = [];
            $controller = new PestDataCollectController();

            foreach ($this->seasons as $season) {
                $weeks = $this->getWeeksInRange($season->start_date, $season->end_date);
                $commonData = $this->getCommonData($season->start_date, $season->end_date);

                $seasonData = [];
                foreach ($weeks as $weekStart) {
                    $weekEnd = Carbon::parse($weekStart)->copy()->addDays(6);

                    $weeklyData = $commonData
                        ->filter(fn($items, $date) => Carbon::parse($date)->between($weekStart, $weekEnd))
                        ->flatten();

                    if ($weeklyData->isEmpty()) {
                        $seasonData[] = 0;
                    } else {
                        $weeklyPests = $controller->avarageCalculateByCommonData($weeklyData);
                        $seasonData[] = $weeklyPests['pests'][$this->selectedPest] ?? 0;
                    }
                }

                $pestData[$season->id] = [
                    'name' => $season->name,
                    'data' => $seasonData
                ];
            }

            return $pestData;
        });
    }

    protected function getWeeksInRange($start, $end): array
    {
        $start = Carbon::parse($start);
        $end = Carbon::parse($end)->endOfDay();
        $weeks = [];

        while ($start <= $end) {
            $weeks[] = $start->format('Y-m-d');
            $start->addWeek();
        }
        return $weeks;
    }

    protected function getCommonData($start, $end)
    {
        $query = CommonDataCollect::with('collector')
            ->whereBetween('c_date', [Carbon::parse($start)->startOfDay(), Carbon::parse($end)->endOfDay()]);

        if ($this->districtId != 0) {
            $query->whereHas('collector', fn($q) => $q->where('district', $this->districtId));
        }

        return $query->get()->groupBy(fn($item) => Carbon::parse($item->c_date)->format('Y-m-d'));
    }

    public function render()
    {
        return view('livewire.graph.pest-season-comparison-chart');
    }
}
