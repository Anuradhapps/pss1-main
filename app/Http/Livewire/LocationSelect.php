<?php

namespace App\Http\Livewire;

use App\Models\AiRange;
use App\Models\As_center;
use App\Models\district;
use App\Models\Province;
use Livewire\Component;

class LocationSelect extends Component
{
    public $liveProvinces;
    public $liveDistricts;
    public $liveAsCenters;
    public $liveAiRanges;
    public $provinces;
    public $districts;
    public $asCenters;
    public $aiRanges;
    public $selectedProvince = null;
    public $selectedDistrict = null;
    public $selectedAsCenter = null;
    public $selectedAiRange = null;
    // public $collector;


    public function mount($selectedProvince = null, $selectedDistrict = null, $selectedAsCenter = null, $selectedAiRange = null)
    {
        $this->provinces = Province::all();
        if ($selectedProvince != null) {
            $this->selectedProvince = $selectedProvince;
            $this->selectedDistrict = $selectedDistrict;
            $this->selectedAsCenter = $selectedAsCenter;
            $this->selectedAiRange = $selectedAiRange;
            $this->updatedselectedProvince();
            $this->updatedselectedDistrict();
            $this->updatedselectedAsCenter();
        }
    }
    public function render()
    {

        return view('livewire.location-select');
    }
    public function updatedselectedProvince()
    {
        $this->districts = district::where('province_id', $this->selectedProvince)->get();
    }
    public function updatedselectedDistrict()
    {
        $this->asCenters = As_center::where('district_id', $this->selectedDistrict)->get();
    }
    public function updatedselectedAsCenter()
    {
        $this->aiRanges = AiRange::where('as_center_id', $this->selectedAsCenter)->get();
    }
}
