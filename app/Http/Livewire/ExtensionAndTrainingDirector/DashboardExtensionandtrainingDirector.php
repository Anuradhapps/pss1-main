<?php

namespace App\Http\Livewire\ExtensionAndTrainingDirector;

use App\Http\Controllers\PestDataCollectController;
use App\Http\Controllers\RiceSeasonController;
use App\Models\AuditTrail;
use App\Models\Collector;
use App\Models\Region;
use App\Models\RiceSeason;
use App\Services\toPDFService;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

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
    // public function downloadCollectorsList(toPDFService $pdfService)
    // {

    //     $season = RiceSeason::find($this->selectedSeason);
    //     if ($season == null) {
    //         $season = 'All Season';
    //     } else {
    //         $season = $season->name;
    //     }

    //     $result = $pdfService->collectorsList(null, $this->regionId, $this->selectedSeason);
    //     $region = Region::find($this->regionId);

    //     $pdf = Pdf::loadView('report.collectorsList', ['data' => $result, 'region' => $region->name, 'seasonName' => $season])
    //         ->setPaper('a4', 'landscape');

    //     // Stream download response compatible with Livewire
    //     $regionName = isset($region->name) ? Str::slug($region->name) : 'Region';
    //     $timestamp = now()->format('Y-m-d_H-i-s'); // e.g., 2025-09-08_10-30-15

    //     return response()->streamDownload(
    //         fn() => print($pdf->output()),
    //         "Collectors_List_{$regionName}_{$timestamp}.pdf"
    //     );
    // }

    public function downloadCollectorsList(toPDFService $pdfService)
    {
        $seasonModel = RiceSeason::find($this->selectedSeason);
        $seasonName = $seasonModel ? $seasonModel->name : 'All Season';

        $region = Region::find($this->regionId);
        $regionName = $region->name ?? 'Unknown Region';

        // Get data from service
        $rawResult = $pdfService->collectorsList(null, $this->regionId, $this->selectedSeason);
        // Example structure of $rawResult: district => collectors(array of 8 values)

        // Transform into nested structure
        $formattedData = [
            [
                'season' => $seasonName,
                'regions' => [
                    [
                        'region' => $regionName,
                        'districts' => collect($rawResult)->map(function ($districtData) {
                            return [
                                'district' => $districtData['district'],
                                'collectors' => collect($districtData['collectors'])->map(function ($collector) {
                                    return [
                                        'name' => $collector[0] ?? '-',
                                        'asc' => $collector[1] ?? '-',
                                        'ai_range' => $collector[2] ?? '-',
                                        'phone' => $collector[3] ?? '-',
                                        'joined_date' => $collector[4] ?? '-',
                                        'email' => $collector[5] ?? '-',
                                        'data_count' => $collector[6] ?? 0,
                                        'season' => $collector[7] ?? '-',
                                    ];
                                })->toArray()
                            ];
                        })->values()->toArray()
                    ]
                ]
            ]
        ];

        // Optional: add summary
        // $summary = collect($formattedData[0]['regions'][0]['districts'])->map(function ($district) {
        //     $collectors = $district['collectors'];
        //     return [
        //         'season' => $formattedData[0]['season'] ?? '-',
        //         'region' => $formattedData[0]['regions'][0]['region'] ?? '-',
        //         'district' => $district['district'],
        //         'collectorCount' => count($collectors),
        //         'countGE4' => collect($collectors)->where('data_count', '>=', 4)->count(),
        //         'countLT4' => collect($collectors)->where('data_count', '<', 4)->where('data_count', '>', 0)->count(),
        //         'countZero' => collect($collectors)->where('data_count', 0)->count(),
        //     ];
        // })->toArray();

        // Generate the PDF
        $pdf = Pdf::loadView('report.collectorsList', [
            'data' => $formattedData,
            // 'summary' => $summary,
            'region' => $regionName,
            'seasonName' => $seasonName,
        ])->setPaper('a4', 'portrait');

        $regionSlug = Str::slug($regionName);
        $timestamp = now()->format('Y-m-d_H-i-s');

        return response()->streamDownload(
            fn() => print($pdf->output()),
            "Collectors_List_{$regionSlug}_{$timestamp}.pdf"
        );
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
            ->whereHas('commonDataCollect') // Ensures only collectors with at least one related commonDataCollect
            ->when($this->search, function ($q) {
                $q->whereHas('user', function ($q2) {
                    $q2->where('name', 'like', "%{$this->search}%");
                });
            })
            ->when($this->selectedDistrict, function ($q) {
                $q->where('district', $this->selectedDistrict);
            })
            ->when($this->selectedSeason, function ($q) {
                $q->where('rice_season_id', $this->selectedSeason);
            })
            ->when($this->searchNumber, function ($q) {
                $q->where('phone_no', 'like', "%{$this->searchNumber}%");
            })
            ->orderBy('common_data_collect_count', $this->sortDirection)
            ->take(10)
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
