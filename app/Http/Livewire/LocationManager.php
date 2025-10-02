<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\district;
use App\Models\As_center;
use App\Models\AiRange;

class LocationManager extends Component
{
    public $districts, $selectedDistrict;
    public $asCenters = [], $newAsCenterName, $searchAsCenter = '';
    public $editingAsCenterId = null, $editingAsCenterName = '';
    public $aiRanges = [], $editingAiRangeId = null, $editingAiRangeName = '', $newAiRangeName = '';

    public function mount()
    {
        $this->districts = district::all();
    }

    public function updatedSelectedDistrict()
    {
        $this->loadAsCenters();
        $this->editingAsCenterId = null;
        $this->aiRanges = [];
    }

    public function updatedSearchAsCenter()
    {
        $this->loadAsCenters();
    }

    protected function loadAsCenters()
    {
        $query = As_center::where('district_id', $this->selectedDistrict);

        if ($this->searchAsCenter) {
            $query->where('name', 'like', '%' . $this->searchAsCenter . '%');
        }

        $this->asCenters = $query->get();
    }

    public function addAsCenter()
    {
        $this->validate(['newAsCenterName' => 'required|string|min:2']);
        As_center::create([
            'district_id' => $this->selectedDistrict,
            'name' => $this->newAsCenterName,
        ]);
        $this->newAsCenterName = '';
        $this->loadAsCenters();
    }

    public function deleteAsCenter($id)
    {
        As_center::find($id)?->delete();
        if ($this->editingAsCenterId === $id) {
            $this->editingAsCenterId = null;
            $this->aiRanges = [];
        }
        $this->loadAsCenters();
    }

    public function startEditAsCenter($id, $name)
    {
        $this->editingAsCenterId = $id;
        $this->editingAsCenterName = $name;
        $this->aiRanges = AiRange::where('as_center_id', $id)->get();
        $this->editingAiRangeId = null;
        $this->newAiRangeName = '';
    }

    public function updateAsCenter()
    {
        $this->validate(['editingAsCenterName' => 'required|string|min:2']);
        As_center::find($this->editingAsCenterId)?->update([
            'name' => $this->editingAsCenterName
        ]);
        $this->editingAsCenterId = null;
        $this->editingAsCenterName = '';
        $this->loadAsCenters();
    }

    public function addAiRange()
    {
        $this->validate(['newAiRangeName' => 'required|string|min:2']);
        AiRange::create([
            'as_center_id' => $this->editingAsCenterId,
            'name' => $this->newAiRangeName,
        ]);
        $this->newAiRangeName = '';
        $this->aiRanges = AiRange::where('as_center_id', $this->editingAsCenterId)->get();
    }

    public function deleteAiRange($id)
    {
        AiRange::find($id)?->delete();
        $this->aiRanges = AiRange::where('as_center_id', $this->editingAsCenterId)->get();
    }

    public function startEditAiRange($id, $name)
    {
        $this->editingAiRangeId = $id;
        $this->editingAiRangeName = $name;
    }

    public function updateAiRange()
    {
        $this->validate(['editingAiRangeName' => 'required|string|min:2']);
        AiRange::find($this->editingAiRangeId)?->update([
            'name' => $this->editingAiRangeName
        ]);
        $this->editingAiRangeId = null;
        $this->editingAiRangeName = '';
        $this->aiRanges = AiRange::where('as_center_id', $this->editingAsCenterId)->get();
    }

    public function render()
    {
        return view('livewire.location-manager');
    }
}
