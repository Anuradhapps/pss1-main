<?php

namespace App\Http\Livewire\PDA;

use Livewire\WithPagination;
use Livewire\Component;
use App\Http\Controllers\PestDataCollectController;
use App\Http\Controllers\RiceSeasonController;
use App\Models\AiRange;
use App\Models\As_center;
use App\Models\Collector;
use App\Models\district;
use App\Models\PestDataCollect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\AuditTrail;
use App\Models\ConductedProgram;
use App\Models\Province;
use App\Models\Region;
use App\Models\RiceSeason;
use App\Services\toPDFService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class Pdadash extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $province;
    public $districts = [];
    public $districtIds = [];
    public $seasons;

    // Advance Search------------------
    public $selectedSeason = '';
    public $search = '';
    public $selectedAiRange = '';
    public $selectedDistrict = ''; // Added for District filtering
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
        'selectedDistrict' => ['except' => ''],
        'searchNumber' => ['except' => null],
    ];

    public function mount()
    {
        $provinceName = str_replace('-PDA@domain.com', '', auth()->user()->email);
        $this->province = Province::where('name', $provinceName)->firstOrFail();

        // Get all districts associated with the province
        $this->districts = district::where('province_id', $this->province->id)->get();
        $this->districtIds = $this->districts->pluck('id')->toArray();

        $this->as_centers = As_center::whereIn('district_id', $this->districtIds)->pluck('id');
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
        $this->reset(['search', 'selectedAiRange', 'selectedSeason', 'searchNumber', 'selectedDistrict']);
        $this->resetPage();
    }

    public function viewCollector($collectorId)
    {
        $this->selectedCollector = Collector::with(['user', 'getAiRange', 'riceSeason', 'commonDataCollect', 'region'])->find($collectorId);
        $this->showModal = true;
        $this->pestData = app(PestDataCollectController::class)->avarageCalculate(collect([$this->selectedCollector]));
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedCollector = null;
    }

    public function getCollectorsProperty()
    {
        return Collector::with(['user', 'getAiRange', 'riceSeason', 'region'])
            ->when($this->selectedDistrict, fn($q) => $q->where('district', $this->selectedDistrict), fn($q) => $q->whereIn('district', $this->districtIds))
            ->where('region_id', $this->regionId)
            ->get();
    }

    public function getFilteredCollectorsByProperty()
    {
        $query = Collector::with(['user', 'getAiRange', 'riceSeason', 'region'])
            ->withCount('commonDataCollect')
            ->when($this->selectedDistrict, fn($q) => $q->where('district', $this->selectedDistrict), fn($q) => $q->whereIn('district', $this->districtIds))
            ->where('region_id', $this->regionId)
            ->whereHas('commonDataCollect');

        if (!empty($this->selectedSeason)) {
            $query->where('rice_season_id', $this->selectedSeason);
        }

        return $query->orderByDesc('common_data_collect_count')
            ->take(10)
            ->get();
    }

    public function getFilteredCollectorsProperty()
    {
        return Collector::with(['user', 'getAiRange', 'riceSeason'])
            ->when($this->selectedDistrict, fn($q) => $q->where('district', $this->selectedDistrict), fn($q) => $q->whereIn('district', $this->districtIds))
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
            ->when($this->selectedDistrict, function ($q) {
                $q->where('collectors.district', $this->selectedDistrict);
            }, function ($q) {
                $q->whereIn('collectors.district', $this->districtIds);
            })
            ->groupBy('pest_data_collects.pest_name')
            ->orderByDesc('total_count')
            ->get();
    }

    public function getTotalUsers()
    {
        return Collector::when($this->selectedDistrict, fn($q) => $q->where('district', $this->selectedDistrict), fn($q) => $q->whereIn('district', $this->districtIds))
            ->where('region_id', $this->regionId)
            ->whereHas('user', fn($q) => $q->where('is_active', 1))
            ->get();
    }

    public function getSeasonUserCount($season)
    {
        return Collector::when($this->selectedDistrict, fn($q) => $q->where('district', $this->selectedDistrict), fn($q) => $q->whereIn('district', $this->districtIds))
            ->where('region_id', $this->regionId)
            ->where('rice_season_id', $season)
            ->whereHas('user', fn($q) => $q->where('is_active', 1))
            ->get();
    }

    public function getNewReportsProperty()
    {
        return PestDataCollect::join('common_data_collects', 'pest_data_collects.common_data_collectors_id', '=', 'common_data_collects.id')
            ->join('collectors', 'common_data_collects.collector_id', '=', 'collectors.id')
            ->when($this->selectedDistrict, function ($q) {
                $q->where('collectors.district', $this->selectedDistrict);
            }, function ($q) {
                $q->whereIn('collectors.district', $this->districtIds);
            })
            ->where('collectors.region_id', $this->regionId)
            ->count();
    }

    public function getRecentActivities()
    {
        return AuditTrail::whereHas('user.collector', function ($q) {
            $q->when($this->selectedDistrict, fn($q2) => $q2->where('district', $this->selectedDistrict), fn($q2) => $q2->whereIn('district', $this->districtIds));
        })
            ->latest()
            ->limit(10)
            ->get();
    }

    public function getRecentPrograms()
    {
        return ConductedProgram::when($this->selectedDistrict, function ($q) {
            $districtName = $this->districts->firstWhere('id', $this->selectedDistrict)->name ?? '';
            $q->where('district', $districtName);
        }, function ($q) {
            $q->whereIn('district', $this->districts->pluck('name'));
        })
            ->orderByDesc('conducted_date')
            ->limit(5)
            ->get();
    }

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
        // When district filter changes, we might want to refresh as_centers and ai_ranges based on it
        if ($this->selectedDistrict) {
            $this->as_centers = As_center::where('district_id', $this->selectedDistrict)->pluck('id');
        } else {
            $this->as_centers = As_center::whereIn('district_id', $this->districtIds)->pluck('id');
        }

        $this->aiRanges = AiRange::whereIn('as_center_id', $this->as_centers)->get();

        // Reset sub-filters dependent on location and pagination
        $this->reset(['selectedAiRange']);
        $this->resetPage();
    }

    public function updatedSelectedSeason()
    {
        $this->resetPage();
    }

    public function downloadCollectorsList(toPDFService $pdfService)
    {
        $season = RiceSeason::find($this->selectedSeason);
        $seasonName = $season ? $season->name : 'All Season';

        // Pass array of District IDs or the single selected ID
        $districtsToExport = $this->selectedDistrict ? [$this->selectedDistrict] : $this->districtIds;
        $rawData = $pdfService->collectorsList($districtsToExport, $this->regionId, $this->selectedSeason);

        $data = [];
        $seasonEntry = [
            'season' => $seasonName,
            'regions' => []
        ];

        $regions = [];
        foreach ($rawData as $districtData) {
            $regionName = $this->regionId ? Region::find($this->regionId)->name  : 'All Regions';

            if (!isset($regions[$regionName])) {
                $regions[$regionName] = [
                    'region' => $regionName,
                    'districts' => []
                ];
            }

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

        $seasonEntry['regions'] = array_values($regions);
        $data[] = $seasonEntry;

        // Label for the PDF Title
        $displayDistrictName = $this->selectedDistrict
            ? $this->districts->firstWhere('id', $this->selectedDistrict)->name ?? 'Selected District'
            : 'All Districts in ' . $this->province->name;

        $pdf = Pdf::loadView('report.collectorsList', [
            'data' => $data,
            'district' => $displayDistrictName,
            'seasonName' => $seasonName
        ])->setPaper('a4', 'landscape');

        $districtSlug = Str::slug($displayDistrictName);
        $timestamp = now()->format('Y-m-d_H-i-s');

        return response()->streamDownload(
            fn() => print($pdf->output()),
            "Collectors_List_{$districtSlug}_{$timestamp}.pdf"
        );
    }

    public function render()
    {
        return view('livewire.p-d-a.pdadash', [
            'filteredCollectorsBy' => $this->filteredCollectorsBy,
            'filteredCollectors' => $this->filteredCollectors,
            'pestChartData' => $this->getPestChartData(),
            'totalUsersCount' => $this->getTotalUsers()->count(),
            'seasonUserCount' => $this->seasonUserCount,
            'newReports' => $this->newReports,
            'recentActivities' => $this->getRecentActivities(),
            'recentPrograms' => $this->getRecentPrograms(),
        ]);
    }
}
