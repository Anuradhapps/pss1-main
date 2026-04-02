<?php

namespace App\Http\Livewire\Graph;

use App\Http\Controllers\PestDataCollectController;
use App\Models\CommonDataCollect;
use App\Models\district;
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
    
    // Core Filters
    public string $selectedPest = '';
    public int $districtId = 0;
    public string $seasonFilter = 'all';
    
    // UI/UX Visual Toggles
    public string $chartType = 'line';
    public bool $showTemperature = false;
    
    public bool $isLoading = false;
    public array $pestData = [];

    protected $listeners = ['refreshData' => '$refresh'];

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
        $this->seasons = Cache::remember('rice-seasons-list', self::CACHE_TTL, fn() => RiceSeason::orderByDesc('start_date')->get());
        $this->districts = Cache::remember('districts-list', self::CACHE_TTL, fn() => district::orderBy('name')->get());
        $this->pests = self::PEST_NAMES;
    }

    public function updated($propertyName)
    {
        // If data filters change, fetch new data.
        if (in_array($propertyName, ['selectedPest', 'districtId', 'seasonFilter'])) {
            $this->fetchChartData();
        }
        
        // If visual filters change, just dispatch the event to update Chart.js instantly
        if (in_array($propertyName, ['chartType', 'showTemperature'])) {
            $this->dispatchBrowserEvent('chartUpdated', [
                'pestData' => $this->pestData,
                'seasonFilter' => $this->seasonFilter,
                'chartType' => $this->chartType,
                'showTemperature' => $this->showTemperature
            ]);
        }
    }

    public function fetchChartData()
    {
        $this->isLoading = true;
        $this->pestData = $this->getPestData();
        $this->isLoading = false;
        
        $this->dispatchBrowserEvent('chartUpdated', [
            'pestData' => $this->pestData,
            'seasonFilter' => $this->seasonFilter,
            'chartType' => $this->chartType,
            'showTemperature' => $this->showTemperature
        ]);
    }

    protected function getFilteredSeasons(): Collection
    {
        return $this->seasons->filter(function ($season) {
            if ($this->seasonFilter === 'all') return true;
            $startMonth = Carbon::parse($season->start_date)->month;
            if ($this->seasonFilter === 'yala') return $startMonth >= 3 && $startMonth <= 8;
            if ($this->seasonFilter === 'maha') return $startMonth >= 9 || $startMonth <= 2;
            return true;
        });
    }

    protected function getPestData(): array
    {
        $cacheKey = sprintf('pest-comp-%s-dist-%s-season-%s', $this->selectedPest, $this->districtId, $this->seasonFilter);

        return Cache::remember($cacheKey, self::CACHE_TTL, function () {
            $pestData = [];
            $controller = new PestDataCollectController();
            $filteredSeasons = $this->getFilteredSeasons();

            foreach ($filteredSeasons as $season) {
                $seasonStart = Carbon::parse($season->start_date)->startOfDay();
                $seasonEnd = Carbon::parse($season->end_date)->endOfDay();
                
                $weeks = $this->getWeeksInRange($seasonStart, $seasonEnd);
                $commonData = $this->getCommonData($seasonStart, $seasonEnd);
                
                $seasonData = [];
                $temperature = [];

                $groupedTimestamps = [];
                foreach ($commonData as $date => $items) {
                    $groupedTimestamps[Carbon::parse($date)->timestamp] = $items;
                }

                foreach ($weeks as $weekStartStr) {
                    $weekStart = Carbon::parse($weekStartStr)->startOfDay();
                    $weekEnd = $weekStart->copy()->addDays(6)->endOfDay();
                    
                    $startTimestamp = $weekStart->timestamp;
                    $endTimestamp = $weekEnd->timestamp;

                    $weeklyData = collect();
                    foreach ($groupedTimestamps as $timestamp => $items) {
                        if ($timestamp >= $startTimestamp && $timestamp <= $endTimestamp) {
                            $weeklyData = $weeklyData->merge($items);
                        }
                    }

                    if ($weeklyData->isEmpty()) {
                        $seasonData[] = 0;
                        $temperature[] = 0;
                    } else {
                        $weeklyPests = $controller->avarageCalculateByCommonData($weeklyData);
                        $seasonData[] = $weeklyPests['pests'][$this->selectedPest] ?? 0;
                        $temperature[] = $weeklyPests['temperature'] ?? 0;
                    }
                }

                $pestData[$season->id] = [
                    'name' => $season->name,
                    'data' => $seasonData,
                    'temperature' => $temperature
                ];
            }

            return $pestData;
        });
    }

    protected function getWeeksInRange(Carbon $start, Carbon $end): array
    {
        $weeks = [];
        $current = $start->copy();
        while ($current <= $end) {
            $weeks[] = $current->format('Y-m-d');
            $current->addWeek();
        }
        return $weeks;
    }

    protected function getCommonData(Carbon $start, Carbon $end)
    {
        $query = CommonDataCollect::with('collector')->whereBetween('c_date', [$start, $end]);
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