<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\Province;
use App\Models\district;
use App\Models\As_center;
use App\Models\AiRange;

class LocationManager extends Component
{
    /*
    |--------------------------------------------------------------------
    | NOTE ON TABLE NAMES
    |--------------------------------------------------------------------
    | The uniqueness rules below assume Eloquent's default table names:
    |   Province   -> provinces
    |   district   -> districts
    |   As_center  -> as_centers
    |   AiRange    -> ai_ranges
    | If any model overrides $table, update the Rule::unique() calls
    | for that level to match.
    */

    // ---------- FLASH ----------
    public $successMessage = null;
    public $flashId = 0;

    // ---------- PROVINCE ----------
    public $provinces = [];
    public $searchProvince = '';
    public $newProvinceName = '';
    public $editingProvinceId = null, $editingProvinceName = '';
    public $selectedProvince = null;
    public $selectedProvinceName = null;

    // ---------- DISTRICT ----------
    public $districts = [];
    public $searchDistrict = '';
    public $newDistrictName = '';
    public $editingDistrictId = null, $editingDistrictName = '';
    public $selectedDistrict = null;
    public $selectedDistrictName = null;

    // ---------- ASC ----------
    public $asCenters = [];
    public $searchAsCenter = '';
    public $newAsCenterName = '';
    public $editingAsCenterId = null, $editingAsCenterName = '';
    public $selectedAsCenter = null;
    public $selectedAsCenterName = null;

    // ---------- AI RANGE ----------
    public $aiRanges = [];
    public $newAiRangeName = '';
    public $editingAiRangeId = null, $editingAiRangeName = '';

    public function mount()
    {
        $this->loadProvinces();
    }

    protected function flash(string $message)
    {
        $this->successMessage = $message;
        $this->flashId++;
    }

    public function dismissFlash()
    {
        $this->successMessage = null;
    }

    /* ================================================================
     |  PROVINCE
     |=================================================================*/

    public function updatedSearchProvince()
    {
        $this->loadProvinces();
    }

    protected function loadProvinces()
    {
        $query = Province::query();

        if ($this->searchProvince) {
            $query->where('name', 'like', '%' . $this->searchProvince . '%');
        }

        $this->provinces = $query->orderBy('name')->get(['id', 'name']);
    }

    public function addProvince()
    {
        $this->resetErrorBag();

        $this->validate([
            'newProvinceName' => ['required', 'string', 'min:2', Rule::unique('provinces', 'name')],
        ]);

        $province = Province::create(['name' => $this->newProvinceName]);

        $this->newProvinceName = '';
        $this->loadProvinces();
        $this->flash("Province \"{$province->name}\" created.");
    }

    public function startEditProvince($id, $name)
    {
        $this->resetErrorBag();
        $this->editingProvinceId = $id;
        $this->editingProvinceName = $name;
    }

    public function cancelEditProvince()
    {
        $this->resetErrorBag();
        $this->editingProvinceId = null;
        $this->editingProvinceName = '';
    }

    public function updateProvince()
    {
        $this->resetErrorBag();

        $this->validate([
            'editingProvinceName' => [
                'required',
                'string',
                'min:2',
                Rule::unique('provinces', 'name')->ignore($this->editingProvinceId),
            ],
        ]);

        Province::find($this->editingProvinceId)?->update([
            'name' => $this->editingProvinceName,
        ]);

        $this->cancelEditProvince();
        $this->loadProvinces();
        $this->flash('Province updated.');
    }

    public function deleteProvince($id)
    {
        $province = Province::find($id);
        $name = $province?->name;
        $province?->delete();

        if ((int) $this->selectedProvince === (int) $id) {
            $this->clearFromDistrictLevel(true);
        }

        if ($this->editingProvinceId === $id) {
            $this->cancelEditProvince();
        }

        $this->loadProvinces();
        $this->flash($name ? "Province \"{$name}\" deleted." : 'Province deleted.');
    }

    public function selectProvince($id, $name = null)
    {
        // toggle off if clicking the already-selected row
        if ((int) $this->selectedProvince === (int) $id) {
            $this->clearFromDistrictLevel(true);
            return;
        }

        $this->selectedProvince = $id;
        $this->selectedProvinceName = $name;
        $this->clearFromDistrictLevel(false);
        $this->loadDistricts();
    }

    /* ================================================================
     |  DISTRICT
     |=================================================================*/

    public function updatedSearchDistrict()
    {
        $this->loadDistricts();
    }

    protected function loadDistricts()
    {
        $query = district::where('province_id', $this->selectedProvince);

        if ($this->searchDistrict) {
            $query->where('name', 'like', '%' . $this->searchDistrict . '%');
        }

        $this->districts = $query->orderBy('name')->get(['id', 'name', 'province_id']);
    }

    /**
     * Reset everything from the district level downward.
     */
    protected function clearFromDistrictLevel(bool $clearSelectedProvince)
    {
        if ($clearSelectedProvince) {
            $this->selectedProvince = null;
            $this->selectedProvinceName = null;
        }

        $this->districts = [];
        $this->searchDistrict = '';
        $this->newDistrictName = '';
        $this->editingDistrictId = null;
        $this->editingDistrictName = '';

        $this->clearFromAscLevel(true);
    }

    public function addDistrict()
    {
        $this->resetErrorBag();

        $this->validate([
            'newDistrictName' => [
                'required',
                'string',
                'min:2',
                Rule::unique('districts', 'name')->where('province_id', $this->selectedProvince),
            ],
        ]);

        $district = district::create([
            'province_id' => $this->selectedProvince,
            'name' => $this->newDistrictName,
        ]);

        $this->newDistrictName = '';
        $this->loadDistricts();
        $this->flash("District \"{$district->name}\" created.");
    }

    public function startEditDistrict($id, $name)
    {
        $this->resetErrorBag();
        $this->editingDistrictId = $id;
        $this->editingDistrictName = $name;
    }

    public function cancelEditDistrict()
    {
        $this->resetErrorBag();
        $this->editingDistrictId = null;
        $this->editingDistrictName = '';
    }

    public function updateDistrict()
    {
        $this->resetErrorBag();

        $this->validate([
            'editingDistrictName' => [
                'required',
                'string',
                'min:2',
                Rule::unique('districts', 'name')
                    ->where('province_id', $this->selectedProvince)
                    ->ignore($this->editingDistrictId),
            ],
        ]);

        district::find($this->editingDistrictId)?->update([
            'name' => $this->editingDistrictName,
        ]);

        $this->cancelEditDistrict();
        $this->loadDistricts();
        $this->flash('District updated.');
    }

    public function deleteDistrict($id)
    {
        $district = district::find($id);
        $name = $district?->name;
        $district?->delete();

        if ((int) $this->selectedDistrict === (int) $id) {
            $this->clearFromAscLevel(true);
        }

        if ($this->editingDistrictId === $id) {
            $this->cancelEditDistrict();
        }

        $this->loadDistricts();
        $this->flash($name ? "District \"{$name}\" deleted." : 'District deleted.');
    }

    public function selectDistrict($id, $name = null)
    {
        if ((int) $this->selectedDistrict === (int) $id) {
            $this->clearFromAscLevel(true);
            return;
        }

        $this->selectedDistrict = $id;
        $this->selectedDistrictName = $name;
        $this->clearFromAscLevel(false);
        $this->loadAsCenters();
    }

    /* ================================================================
     |  ASC (AS CENTER)
     |=================================================================*/

    /**
     * Reset everything from the ASC level downward.
     */
    protected function clearFromAscLevel(bool $clearSelectedDistrict)
    {
        if ($clearSelectedDistrict) {
            $this->selectedDistrict = null;
            $this->selectedDistrictName = null;
        }

        $this->asCenters = [];
        $this->searchAsCenter = '';
        $this->newAsCenterName = '';
        $this->editingAsCenterId = null;
        $this->editingAsCenterName = '';

        $this->clearFromAiRangeLevel(true);
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

        $this->asCenters = $query->orderBy('name')->get(['id', 'name', 'district_id']);
    }

    public function addAsCenter()
    {
        $this->resetErrorBag();

        $this->validate([
            'newAsCenterName' => [
                'required',
                'string',
                'min:2',
                Rule::unique('as_centers', 'name')->where('district_id', $this->selectedDistrict),
            ],
        ]);

        $asCenter = As_center::create([
            'district_id' => $this->selectedDistrict,
            'name' => $this->newAsCenterName,
        ]);

        $this->newAsCenterName = '';
        $this->loadAsCenters();
        $this->flash("ASC \"{$asCenter->name}\" created.");
    }

    public function startEditAsCenter($id, $name)
    {
        $this->resetErrorBag();
        $this->editingAsCenterId = $id;
        $this->editingAsCenterName = $name;
    }

    public function cancelEditAsCenter()
    {
        $this->resetErrorBag();
        $this->editingAsCenterId = null;
        $this->editingAsCenterName = '';
    }

    public function updateAsCenter()
    {
        $this->resetErrorBag();

        $this->validate([
            'editingAsCenterName' => [
                'required',
                'string',
                'min:2',
                Rule::unique('as_centers', 'name')
                    ->where('district_id', $this->selectedDistrict)
                    ->ignore($this->editingAsCenterId),
            ],
        ]);

        As_center::find($this->editingAsCenterId)?->update([
            'name' => $this->editingAsCenterName,
        ]);

        $this->cancelEditAsCenter();
        $this->loadAsCenters();
        $this->flash('ASC updated.');
    }

    public function deleteAsCenter($id)
    {
        $asCenter = As_center::find($id);
        $name = $asCenter?->name;
        $asCenter?->delete();

        if ((int) $this->selectedAsCenter === (int) $id) {
            $this->clearFromAiRangeLevel(true);
        }

        if ($this->editingAsCenterId === $id) {
            $this->cancelEditAsCenter();
        }

        $this->loadAsCenters();
        $this->flash($name ? "ASC \"{$name}\" deleted." : 'ASC deleted.');
    }

    public function selectAsCenter($id, $name = null)
    {
        if ((int) $this->selectedAsCenter === (int) $id) {
            $this->clearFromAiRangeLevel(true);
            return;
        }

        $this->selectedAsCenter = $id;
        $this->selectedAsCenterName = $name;
        $this->clearFromAiRangeLevel(false);
        $this->loadAiRanges();
    }

    /* ================================================================
     |  AI RANGE
     |=================================================================*/

    protected function clearFromAiRangeLevel(bool $clearSelectedAsCenter)
    {
        if ($clearSelectedAsCenter) {
            $this->selectedAsCenter = null;
            $this->selectedAsCenterName = null;
        }

        $this->aiRanges = [];
        $this->newAiRangeName = '';
        $this->editingAiRangeId = null;
        $this->editingAiRangeName = '';
    }

    protected function loadAiRanges()
    {
        $this->aiRanges = AiRange::where('as_center_id', $this->selectedAsCenter)
            ->orderBy('name')
            ->get(['id', 'name', 'as_center_id']);
    }

    public function addAiRange()
    {
        $this->resetErrorBag();

        $this->validate([
            'newAiRangeName' => [
                'required',
                'string',
                'min:2',
                Rule::unique('ai_ranges', 'name')->where('as_center_id', $this->selectedAsCenter),
            ],
        ]);

        $aiRange = AiRange::create([
            'as_center_id' => $this->selectedAsCenter,
            'name' => $this->newAiRangeName,
        ]);

        $this->newAiRangeName = '';
        $this->loadAiRanges();
        $this->flash("AI Range \"{$aiRange->name}\" created.");
    }

    public function startEditAiRange($id, $name)
    {
        $this->resetErrorBag();
        $this->editingAiRangeId = $id;
        $this->editingAiRangeName = $name;
    }

    public function cancelEditAiRange()
    {
        $this->resetErrorBag();
        $this->editingAiRangeId = null;
        $this->editingAiRangeName = '';
    }

    public function updateAiRange()
    {
        $this->resetErrorBag();

        $this->validate([
            'editingAiRangeName' => [
                'required',
                'string',
                'min:2',
                Rule::unique('ai_ranges', 'name')
                    ->where('as_center_id', $this->selectedAsCenter)
                    ->ignore($this->editingAiRangeId),
            ],
        ]);

        AiRange::find($this->editingAiRangeId)?->update([
            'name' => $this->editingAiRangeName,
        ]);

        $this->cancelEditAiRange();
        $this->loadAiRanges();
        $this->flash('AI Range updated.');
    }

    public function deleteAiRange($id)
    {
        $aiRange = AiRange::find($id);
        $name = $aiRange?->name;
        $aiRange?->delete();

        if ($this->editingAiRangeId === $id) {
            $this->cancelEditAiRange();
        }

        $this->loadAiRanges();
        $this->flash($name ? "AI Range \"{$name}\" deleted." : 'AI Range deleted.');
    }

    public function render()
    {
        return view('livewire.location-manager');
    }
}
