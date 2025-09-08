<?php

namespace App\Http\Livewire;

use App\Services\PestInfoService;
use Livewire\Component;

class PestMemoCard extends Component
{
    //Public props so you can pass them from Blade
    public ?int $districtId = null;
    public ?int $days = null;

    // Data to display
    public $average = null;

    // Optional: inject via container
    protected PestInfoService $service;

    public function boot(PestInfoService $service)
    {
        $this->service = $service;
    }

    public function mount(?int $districtId = null, ?int $days = null)
    {

        $this->districtId = $districtId;
        $this->days = $days;
        $this->refreshCard();
    }

    public function updated($field)
    {
        // whenever districtId or days changes, recompute
        if (in_array($field, ['districtId', 'days'])) {
            $this->refreshCard();
        }
    }

    public function refreshCard()
    {
        // If you want average value:
        $this->average = $this->service->avaragePestCodeByDistrictAndDuration(
            $this->districtId,
            $this->days
        );
    }
    public function render()
    {
        return view('livewire.pest-memo-card');
    }
}
