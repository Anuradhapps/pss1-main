<?php

namespace App\Http\Livewire\ExtensionAndTrainingDirector;

use App\Http\Controllers\PestDataCollectController;
use App\Http\Controllers\RiceSeasonController;
use App\Models\AuditTrail;
use App\Models\Collector;
use App\Models\RiceSeason;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardExtensionAndTrainingDirector extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Filters and Search
    public $sortDirection = 'desc'; // or 'desc'
    public $selectedSeason = '';
    public $selectedSeasonName = null;
    public $selectedDistrict = '';
    public $search = '';
    public $searchNumber = null;

    // Data Stats
    public $seasonUserCount = 0;
    public $selectedSeasonUserCount = null;
    public $totalUsersCount = 0;

    // View Data
    public $districts = [];
    public $seasons;
    public $regionId = 2; // 1 - provincial, 2 - inter-provincial, 3 - mahaweli

    // Modal
    public $selectedCollector = null;
    public $showModal = false;
    public $recentActivities = [];
    public $pestData = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedDistrict' => ['except' => ''],
        'selectedSeason' => ['except' => ''],
        'searchNumber' => ['except' => null],
    ];

    public function mount()
    {
        $this->seasons = RiceSeason::all();

        $seasonController = new RiceSeasonController;
        $currentSeasonId = $seasonController->getSeasson()['seasonId'] ?? null;

        if ($currentSeasonId) {
            $this->seasonUserCount = $this->getSeasonUserCount($currentSeasonId)->count();
        }

        $this->recentActivities = $this->getRecentActivities();
        $this->districts = $this->getDistricts();



        $this->totalUsersCount = $this->getTotalUsers()->count();
        $this->updatedSelectedSeason($this->selectedSeason);
    }

    public function getDistricts()
    {
        return Collector::with('getDistrict')
            ->where('region_id', $this->regionId)
            ->get()
            ->map(function ($collector) {
                return $collector->getDistrict;
            })
            ->filter()             // remove nulls
            ->unique('id')         // filter unique by district ID
            ->values();            // reset keys
    }
    public function toggleSortDirection()
    {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['searchNumber', 'search', 'selectedDistrict', 'selectedSeason'])) {

            $this->selectedSeasonUserCount = $this->getFilteredCollectorsCount();
        }
    }


    public function updatedSelectedSeason($value)
    {
        $season = RiceSeason::find((int) $value);
        $this->selectedSeasonName = $season->name ?? null;
    }


    public function updatedselectedDistrict($value)
    {
        if ($this->selectedSeasonName == null) {
            $this->selectedSeasonName = 'All Season';
        }
    }


    public function resetFilters()
    {
        $this->reset(['search', 'selectedDistrict', 'selectedSeason', 'searchNumber', 'selectedSeasonName', 'selectedSeasonUserCount']);
        $this->resetPage();
    }

    public function viewCollector($collectorId)
    {
        $this->selectedCollector = Collector::with([
            'user',
            'getAiRange',
            'riceSeason',
            'commonDataCollect',
            'region'
        ])->find($collectorId);

        $this->showModal = true;
        $this->pestData = app(PestDataCollectController::class)->avarageCalculate(collect([$this->selectedCollector]));
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedCollector = null;
    }

    public function getFilteredCollectorsProperty()
    {
        return Collector::with(['user', 'getAiRange', 'riceSeason', 'region'])
            ->where('region_id', $this->regionId)
            ->when($this->search, fn($q) => $q->whereHas('user', fn($q2) => $q2->where('name', 'like', "%{$this->search}%")))
            ->when($this->selectedDistrict, fn($q) => $q->where('district', $this->selectedDistrict))
            ->when($this->selectedSeason, fn($q) => $q->where('rice_season_id', $this->selectedSeason))
            ->when($this->searchNumber, fn($q) => $q->where('phone_no', 'like', "%{$this->searchNumber}%"))
            ->paginate(5);
    }
    public function getFilteredCollectorsByProperty()
    {
        return Collector::with(['user', 'getAiRange', 'riceSeason', 'region'])
            ->withCount('commonDataCollect')
            ->where('region_id', $this->regionId)
            ->when($this->search, fn($q) => $q->whereHas('user', fn($q2) => $q2->where('name', 'like', "%{$this->search}%")))
            ->when($this->selectedDistrict, fn($q) => $q->where('district', $this->selectedDistrict))
            ->when($this->selectedSeason, fn($q) => $q->where('rice_season_id', $this->selectedSeason))
            ->when($this->searchNumber, fn($q) => $q->where('phone_no', 'like', "%{$this->searchNumber}%"))
            ->having('common_data_collect_count', '>', 0)    // Only those with count > 0
            ->orderBy('common_data_collect_count', $this->sortDirection)
            ->take(10)   // Limit to top 5
            ->get();
    }

    public function getCollectorsProperty()
    {
        return Collector::with(['user', 'getAiRange', 'riceSeason', 'region'])
            ->where('region_id', $this->regionId)
            ->get();
    }



    public function getFilteredCollectorsCount()
    {
        return Collector::where('region_id', $this->regionId)
            ->when($this->search, fn($q) => $q->whereHas('user', fn($q2) => $q2->where('name', 'like', "%{$this->search}%")))
            ->when($this->selectedDistrict, fn($q) => $q->where('district', $this->selectedDistrict))
            ->when($this->selectedSeason, fn($q) => $q->where('rice_season_id', $this->selectedSeason))
            ->when($this->searchNumber, fn($q) => $q->where('phone_no', 'like', "%{$this->searchNumber}%"))
            ->count();
    }


    public function getSeasonUserCount($seasonId)
    {
        return Collector::where('rice_season_id', $seasonId)
            ->whereHas('region', fn($q) => $q->where('region_id', $this->regionId))
            ->get();
    }

    public function getTotalUsers()
    {
        return Collector::whereHas('region', fn($q) => $q->where('region_id', $this->regionId))->get();
    }

    public function getRecentActivities()
    {
        return AuditTrail::whereHas('user.collector', fn($q) => $q->where('region_id', $this->regionId))
            ->latest()
            ->limit(10)
            ->get();
    }

    public function render()
    {
        return view('livewire.extension-and-training-director.dashboard-extensionandtraining-director', [
            'filteredCollectors' => $this->filteredCollectors,
            'filteredCollectorsBy' => $this->filteredCollectorsBy,
            'totalUsersCount' => $this->totalUsersCount,
            'seasonUserCount' => $this->seasonUserCount,
            'recentActivities' => $this->recentActivities,
        ]);
    }
}
