<?php

namespace App\Http\Livewire;

use App\Models\AiRange;
use App\Models\As_center;
use App\Models\Collector;
use App\Models\district;
use App\Models\Province;
use App\Models\RiceSeason;
use Livewire\Component;

class SeasonSelect extends Component
{
    public $seasons;
    public $liveProvinces;
    public $liveDistricts;
    public $liveAsCenters;
    public $liveAiRanges;
    public $selectedSeason;
    public $provinces;
    public $districts;
    public $asCenters;
    public $aiRanges;
    public $selectedProvince;
    public $selectedDistrict;
    public $selectedAsCenter;
    public $selectedAiRange;





    public function mount(){
        $this->seasons = RiceSeason::all();

    }

    public function updatedselectedSeason(){
        $this->provinces = Province::all();
        $this->liveProvinces = Collector::where('rice_season_id' ,$this->selectedSeason)->distinct()->pluck('province')->toArray();
        $this->liveDistricts = Collector::where('rice_season_id' ,$this->selectedSeason)->distinct()->pluck('district')->toArray();
        $this->liveAsCenters = Collector::where('rice_season_id' ,$this->selectedSeason)->distinct()->pluck('asc')->toArray();
        $this->liveAiRanges = Collector::where('rice_season_id' ,$this->selectedSeason)->distinct()->pluck('ai_range')->toArray();

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
    public function render()
    {
        return view('livewire.season-select');
    }
}
