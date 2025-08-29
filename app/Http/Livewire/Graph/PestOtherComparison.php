<?php

namespace App\Http\Livewire\Graph;

use App\Http\Controllers\PestDataCollectController;
use App\Models\Collector;
use Livewire\Component;

class PestOtherComparison extends Component
{
    public $labels = [];             // Top rice varieties
    public $values = [];             // Counts for top varieties
    public $allVarieties = [];       // Normalized rice varieties with counts
    public $pestDataByVariety = [];  // Pest data per variety
    public $collectorsCount = [];    // Number of collectors per variety

    protected $topCount = 15;

    public function mount()
    {
        $this->loadRiceVarieties();
        $this->calculatePestData();
    }

    /**
     * Normalize rice variety name
     */
    private function normalizeVariety(string $variety): ?string
    {
        $variety = strtolower($variety);
        $variety = preg_replace('/[\s\.\-,\(\)]/', '', $variety);

        if (preg_match('/^(bg|at|ld|bw)(\d+)/i', $variety, $matches)) {
            return ucfirst($matches[1]) . ' ' . $matches[2];
        }

        return null; // skip non-standard varieties
    }

    /**
     * Get all rice varieties and counts
     */
    private function allRiceVarietyList(): array
    {
        $collectors = Collector::select('rice_variety')->get();
        $counts = [];

        foreach ($collectors as $c) {
            $variety = $this->normalizeVariety($c->rice_variety);
            if (!$variety) continue;
            $counts[$variety] = ($counts[$variety] ?? 0) + 1;
        }

        arsort($counts);
        return $counts;
    }

    /**
     * Load top rice varieties
     */
    private function loadRiceVarieties()
    {
        $allVarieties = $this->allRiceVarietyList();
        $topVarieties = array_slice($allVarieties, 0, $this->topCount, true);

        $this->labels = array_keys($topVarieties);
        $this->values = array_values($topVarieties);
        $this->allVarieties = $topVarieties;
    }

    /**
     * Find collectors by rice variety
     */
    private function findCollectorsByRice(string $variety)
    {
        $normalized = $this->normalizeVariety($variety);
        if (!$normalized) return collect();

        return Collector::get()->filter(fn($c) => $this->normalizeVariety($c->rice_variety) === $normalized);
    }

    /**
     * Calculate pest data per variety and store collectors count
     */
    private function calculatePestData()
    {
        $pestController = new PestDataCollectController;

        foreach ($this->allVarieties as $variety => $count) {
            $collectors = $this->findCollectorsByRice($variety);
            $this->collectorsCount[$variety] = $collectors->count();

            $result = $pestController->avarageCalculate($collectors);
            $this->pestDataByVariety[$variety] = $result['pests'] ?? [];
        }
    }

    public function render()
    {
        return view('livewire.graph.pest-other-comparison', [
            'pestDataByVariety' => $this->pestDataByVariety,
            'collectorsCount' => $this->collectorsCount,
        ]);
    }
}
