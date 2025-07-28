<?php

namespace App\Http\Livewire\DeputyDirector;

use App\Http\Controllers\RiceSeasonController;
use App\Models\AiRange;
use App\Models\As_center;
use App\Models\Collector;
use App\Models\District;
use Livewire\Component;
use App\Models\PestDataCollect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\AuditTrail;
use App\Models\ConductedProgram;
use App\Models\RiceSeason;
use Livewire\WithPagination;

class DeputyDashboard extends Component
{
    use WithPagination;
    public $district;
    public $seasons;
    public $selectedSeason = '';
    public $collectors;
    public $search = '';
    public $selectedAiRange = '';
    public $aiRanges = [];
    public $as_centers = [];
    public $pestChartData = [];
    public $totalUsersCount = 0;
    public $seasonUserCount = 0;
    public $newReports = 0;
    public $recentActivities = [];
    public $recentPrograms = [];

    protected $queryString = ['search', 'selectedAiRange', 'selectedSeason'];

    public function mount()
    {
        $districtName = str_replace('DD@domain.com', '', auth()->user()->email);
        $this->district = District::where('name', $districtName)->firstOrFail();

        $this->as_centers = As_center::where('district_id', $this->district->id)->pluck('id');
        $this->aiRanges = AiRange::whereIn('as_center_id', $this->as_centers)->get();
        $this->seasons = RiceSeason::all();

        $season = new RiceSeasonController;
        $currentSeason = $season->getSeasson()['seasonId'] ?? null;

        if ($currentSeason) {
            $this->seasonUserCount = $this->getSeasonUserCount($currentSeason)->count();
        }

        $this->pestChartData = $this->getPestChartData();
        $this->totalUsersCount = $this->getTotalUsers()->count();
        $this->newReports = $this->getNewReports();
        $this->recentActivities = $this->getRecentActivities();
        $this->recentPrograms = $this->getRecentPrograms();
    }

    public function getFilteredCollectorsProperty()
    {
        return Collector::with(['user', 'getAiRange', 'riceSeason'])
            ->where('district', $this->district->id)
            ->when($this->search, function ($query) {
                $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$this->search}%"));
            })
            ->when($this->selectedAiRange, fn($q) => $q->where('ai_range', $this->selectedAiRange))
            ->when($this->selectedSeason, fn($q) => $q->where('rice_season_id', $this->selectedSeason))
            ->get();
    }

    public function getPestChartData()
    {
        return PestDataCollect::select(
            'pest_data_collects.pest_name as name',
            DB::raw('SUM(pest_data_collects.total) as total_count')
        )
            ->join('common_data_collects', 'pest_data_collects.common_data_collectors_id', '=', 'common_data_collects.id')
            ->join('collectors', 'common_data_collects.collector_id', '=', 'collectors.id')
            ->where('collectors.district', $this->district->id)
            ->groupBy('pest_data_collects.pest_name')
            ->orderByDesc('total_count')
            ->get();
    }

    public function getTotalUsers()
    {
        return Collector::where('district', $this->district->id)
            ->whereHas('user', fn($q) => $q->where('is_active', 1))
            ->get();
    }

    public function getSeasonUserCount($season)
    {
        return Collector::where('district', $this->district->id)
            ->where('rice_season_id', $season)
            ->whereHas('user', fn($q) => $q->where('is_active', 1))
            ->get();
    }

    public function getNewReports()
    {
        return PestDataCollect::join('common_data_collects', 'pest_data_collects.common_data_collectors_id', '=', 'common_data_collects.id')
            ->join('collectors', 'common_data_collects.collector_id', '=', 'collectors.id')
            ->where('collectors.district', $this->district->id)
            ->count();
    }

    public function getRecentActivities()
    {
        return AuditTrail::whereHas('user.collector', fn($q) => $q->where('district', $this->district->id))
            ->latest()
            ->limit(10)
            ->get();
    }

    public function getRecentPrograms()
    {
        return ConductedProgram::where('district', $this->district->name)
            ->orderByDesc('conducted_date')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.deputy-director.deputy-dashboard', [
            'filteredCollectors' => $this->filteredCollectors,
            'pestChartData' => $this->pestChartData,
            'totalUsersCount' => $this->totalUsersCount,
            'seasonUserCount' => $this->seasonUserCount,
            'newReports' => $this->newReports,
            'recentActivities' => $this->recentActivities,
            'recentPrograms' => $this->recentPrograms,
        ]);
    }
}
