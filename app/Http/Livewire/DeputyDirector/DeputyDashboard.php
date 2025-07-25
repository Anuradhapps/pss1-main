<?php

namespace App\Http\Livewire\DeputyDirector;

use App\Models\AiRange;
use App\Models\Collector;
use App\Models\District;
use Livewire\Component;
use App\Models\PestDataCollect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\AuditTrail;
use App\Models\ConductedProgram;
use App\Models\RiceSeason;

class DeputyDashboard extends Component
{
    public $district;
    public $seasons;
    public $selectedSeason = '';
    public $collectors;
    public $search = '';
    public $selectedAiRange = '';
    public $aiRanges = [];
    public $pestSummary = [];
    public $pestChartData = [];
    public $activeUsers = 0;
    public $newReports = 0;
    public $recentActivities = [];
    public $recentPrograms = [];

    public function mount()
    {
        $districtName = str_replace('DD@domain.com', '', auth()->user()->email);
        $this->district = District::where('name', $districtName)->firstOrFail();

        $this->aiRanges = AiRange::all();
        $this->seasons = RiceSeason::all();
        $this->pestSummary = $this->getPestSummary();
        $this->pestChartData = $this->getPestChartData();
        $this->activeUsers = $this->getActiveUsers();
        $this->newReports = $this->getNewReports();
        $this->recentActivities = $this->getRecentActivities();
        $this->recentPrograms = $this->getRecentPrograms();
        $this->collectors;
    }

    public function getFilteredCollectorsProperty()
    {
        return Collector::with(['user', 'getAiRange', 'riceSeason'])
            ->where('district', $this->district->id)
            ->when($this->search, fn($q) => $q->whereHas('user', fn($uq) => $uq->where('name', 'like', "%{$this->search}%")))
            ->when($this->selectedAiRange, fn($q) => $q->where('ai_range', $this->selectedAiRange))
            ->when($this->selectedSeason, fn($q) => $q->where('rice_season_id', $this->selectedSeason))
            ->get();
    }

    public function getPestSummary()
    {
        // Join through collector to rice_seasons for season name
        return PestDataCollect::select(
            'rice_seasons.name as season',
            DB::raw('COUNT(*) as records'),
            DB::raw('SUM(pest_data_collects.total) as total_pests')
        )
            ->join('common_data_collects', 'pest_data_collects.common_data_collectors_id', '=', 'common_data_collects.id')
            ->join('collectors', 'common_data_collects.collector_id', '=', 'collectors.id')
            ->join('rice_seasons', 'collectors.rice_season_id', '=', 'rice_seasons.id')
            ->where('collectors.district', $this->district->id)
            ->groupBy('rice_seasons.name')
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

    public function getActiveUsers()
    {
        return Collector::where('district', $this->district->id)
            ->whereHas('user', function ($q) {
                $q->where('is_active', 1);
            })
            ->count();
    }

    public function getNewReports()
    {
        // Use pest data records as 'reports' for now
        return \App\Models\PestDataCollect::join('common_data_collects', 'pest_data_collects.common_data_collectors_id', '=', 'common_data_collects.id')
            ->join('collectors', 'common_data_collects.collector_id', '=', 'collectors.id')
            ->where('collectors.district', $this->district->id)
            ->count();
    }

    public function getRecentActivities()
    {
        // Get recent audit trails for users in this district
        return AuditTrail::whereHas('user.collector', function ($q) {
            $q->where('district', $this->district->id);
        })->latest()->limit(10)->get();
    }

    public function getRecentPrograms()
    {
        // ConductedProgram: district is stored as name, so match by district name
        return ConductedProgram::where('district', $this->district->name)
            ->orderByDesc('conducted_date')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.deputy-director.deputy-dashboard', [
            'filteredCollectors' => $this->filteredCollectors,
            'pestSummary' => $this->pestSummary,
            'pestChartData' => $this->pestChartData,
            'activeUsers' => $this->activeUsers,
            'newReports' => $this->newReports,
            'recentActivities' => $this->recentActivities,
            'recentPrograms' => $this->recentPrograms,
        ]);
    }
}
