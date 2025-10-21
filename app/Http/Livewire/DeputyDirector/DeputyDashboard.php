<?php

namespace App\Http\Livewire\DeputyDirector;

use App\Http\Controllers\PestDataCollectController;
use App\Http\Controllers\RiceSeasonController;
use App\Models\AiRange;
use App\Models\As_center;
use App\Models\Collector;
use App\Models\district;
use Livewire\Component;
use App\Models\PestDataCollect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\AuditTrail;
use App\Models\ConductedProgram;
use App\Models\Region;
use App\Models\RiceSeason;
use App\Services\toPDFService;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class DeputyDashboard extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $district;
    public $seasons;


    // Advance Search------------------
    public $selectedSeason = '';
    public $search = '';
    public $selectedAiRange = '';
    public $searchNumber = null;
    //---------------------------------

    public $selectedCollector = null;  // Will hold the collector data
    public $showModal = false;         // Control modal visibility


    public $pestData = [];

    public $aiRanges = [];
    public $as_centers = [];
    public $pestChartData = [];
    public $totalUsersCount = 0;
    public $seasonUserCount = 0;
    public $recentActivities = [];
    public $recentPrograms = [];

    public $regionId = 1; // 1 - provincial, 2 - inter-provincial, 3 - mahaweli

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedAiRange' => ['except' => ''],
        'selectedSeason' => ['except' => ''],
        'searchNumber' => ['except' => null],
    ];


    public function mount()
    {

        $districtName = str_replace('DD@domain.com', '', auth()->user()->email);
        $this->district = district::where('name', $districtName)->firstOrFail();

        $this->as_centers = As_center::where('district_id', $this->district->id)->pluck('id');
        $this->aiRanges = AiRange::whereIn('as_center_id', $this->as_centers)->get();
        $this->seasons = RiceSeason::all();

        $seasonController = new RiceSeasonController;
        $currentSeason = $seasonController->getSeasson()['seasonId'] ?? null;

        if ($currentSeason) {
            $this->seasonUserCount = $this->getSeasonUserCount($currentSeason)->count();
        }

        $this->pestChartData = $this->getPestChartData();
        $this->totalUsersCount = $this->getTotalUsers()->count();
        $this->recentActivities = $this->getRecentActivities();
        $this->recentPrograms = $this->getRecentPrograms();
    }
    public function resetFilters()
    {
        $this->reset(['search', 'selectedAiRange', 'selectedSeason', 'searchNumber']);
        $this->resetPage(); // reset pagination to page 1 if using pagination
    }

    // Load collector details by ID and show modal
    public function viewCollector($collectorId)
    {
        $this->selectedCollector = Collector::with(['user', 'getAiRange', 'riceSeason', 'commonDataCollect', 'region'])->find($collectorId);
        $this->showModal = true;
        // Call average calculation (assuming it accepts a single collector model or ID)
        $this->pestData = app(PestDataCollectController::class)->avarageCalculate(collect([$this->selectedCollector]));
    }
    // Close modal
    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedCollector = null;
    }
    public function getCollectorsProperty()
    {
        return Collector::with(['user', 'getAiRange', 'riceSeason', 'region'])
            ->where('district', $this->district->id)
            ->where('region_id', $this->regionId)
            ->get();
    }
    public function getFilteredCollectorsByProperty()
    {
        // Start query with relationships and count
        $query = Collector::with(['user', 'getAiRange', 'riceSeason', 'region'])
            ->withCount('commonDataCollect')
            ->where('district', $this->district->id)
            ->where('region_id', $this->regionId)
            ->whereHas('commonDataCollect'); // Ensure at least one related record exists

        // Apply season filter if selected
        if (!empty($this->selectedSeason)) {
            $query->where('rice_season_id', $this->selectedSeason);
        }

        // Order and limit
        return $query->orderByDesc('common_data_collect_count')
            ->take(10)
            ->get();
    }



    // Computed property for filtered collectors
    public function getFilteredCollectorsProperty()
    {
        return Collector::with(['user', 'getAiRange', 'riceSeason'])
            ->where('district', $this->district->id)
            ->where('region_id', $this->regionId)
            ->when($this->search, function ($query) {
                $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$this->search}%"));
            })
            ->when($this->selectedAiRange, fn($q) => $q->where('ai_range', $this->selectedAiRange))
            ->when($this->selectedSeason, fn($q) => $q->where('rice_season_id', $this->selectedSeason))
            ->when($this->searchNumber, fn($q) => $q->where('phone_no', 'like', "%{$this->searchNumber}%"))
            ->paginate(5);
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
            ->where('region_id', $this->regionId)
            ->whereHas('user', fn($q) => $q->where('is_active', 1))
            ->get();
    }

    public function getSeasonUserCount($season)
    {
        return Collector::where('district', $this->district->id)
            ->where('region_id', $this->regionId)
            ->where('rice_season_id', $season)
            ->whereHas('user', fn($q) => $q->where('is_active', 1))
            ->get();
    }

    public function getNewReportsProperty()
    {
        return PestDataCollect::join('common_data_collects', 'pest_data_collects.common_data_collectors_id', '=', 'common_data_collects.id')
            ->join('collectors', 'common_data_collects.collector_id', '=', 'collectors.id')
            ->where('collectors.district', $this->district->id)
            ->where('collectors.region_id', $this->regionId)
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

    // Reset pagination when filters update
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatedSearchNumber()
    {
        $this->resetPage();
    }

    public function updatedSelectedDistrict()
    {
        $this->resetPage();
    }

    public function updatedSelectedSeason()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.deputy-director.deputy-dashboard', [
            'filteredCollectorsBy' => $this->filteredCollectorsBy,
            'filteredCollectors' => $this->filteredCollectors,
            'pestChartData' => $this->pestChartData,
            'totalUsersCount' => $this->totalUsersCount,
            'seasonUserCount' => $this->seasonUserCount,
            'newReports' => $this->newReports,
            'recentActivities' => $this->recentActivities,
            'recentPrograms' => $this->recentPrograms,
        ]);
    }

    public function downloadCollectorsList(toPDFService $pdfService)
    {
        $season = RiceSeason::find($this->selectedSeason);
        $seasonName = $season ? $season->name : 'All Season';

        $rawData = $pdfService->collectorsList($this->district->id, $this->regionId, $this->selectedSeason);

        // Group data by season -> region -> district
        $data = [];

        // Assuming all raw data belong to the same season
        $seasonEntry = [
            'season' => $seasonName,
            'regions' => []
        ];

        // Group by region
        $regions = [];
        foreach ($rawData as $districtData) {
            $regionName = $this->regionId ? 'Region ' . Region::find($this->regionId)->name  : 'All Regions';
            if (!isset($regions[$regionName])) {
                $regions[$regionName] = [
                    'region' => $regionName,
                    'districts' => []
                ];
            }

            // Collectors
            $collectors = [];
            foreach ($districtData['collectors'] as $col) {
                $collectors[] = [
                    'name' => $col[0] ?? '',
                    'ai_range' => $col[1] ?? '',
                    'phone' => $col[3] ?? '',
                    'email' => $col[5] ?? '',
                    'season' => $col[7] ?? $seasonName,
                    'data_count' => $col[6] ?? 0,
                ];
            }

            $regions[$regionName]['districts'][] = [
                'district' => $districtData['district'],
                'collectors' => $collectors
            ];
        }

        // Push all regions under the season
        $seasonEntry['regions'] = array_values($regions);

        // Single season entry
        $data[] = $seasonEntry;

        $pdf = Pdf::loadView('report.collectorsList', [
            'data' => $data,
            'district' => $this->district->name,
            'seasonName' => $seasonName
        ])->setPaper('a4', 'landscape');

        $districtSlug = isset($this->district->name) ? Str::slug($this->district->name) : 'Region';
        $timestamp = now()->format('Y-m-d_H-i-s');

        return response()->streamDownload(
            fn() => print($pdf->output()),
            "Collectors_List_{$districtSlug}_{$timestamp}.pdf"
        );
    }
}
