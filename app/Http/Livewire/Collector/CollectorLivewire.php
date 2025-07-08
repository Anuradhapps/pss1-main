<?php

namespace App\Http\Livewire\Collector;

use App\Http\Controllers\RiceSeasonController;
use App\Models\As_center;
use App\Models\Collector;
use App\Models\district;
use Livewire\WithPagination;
use Livewire\Component;

class CollectorLivewire extends Component
{
    use WithPagination;

    public $paginate  = '';
    public $query     = '';
    public $sortField = 'name';
    public $sortAsc   = true;

    public function render()
    {
        return view('livewire.collector.collector');
    }
    public function updatedQuery()
    {
        $this->resetPage();
    }

    public function edit(Collector $collector)
    {


        $districts = district::all();
        $selected_asc = $collector->asc;
        $ascs = As_center::where('district_id', $collector->district)->get();

        return view('collector.edit', compact('collector', 'districts', 'selected_asc', 'ascs'));
    }
    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function collectors(): object
    {
        $query = $this->builder();

        if ($this->query) {
            $query->where('email', 'like', '%' . $this->query . '%')
                ->orwhere('users.name', 'like', '%' . $this->query . '%')
                ->orwhere('districts.name', 'like', '%' . $this->query . '%')
                ->orwhere('as_centers.name', 'like', '%' . $this->query . '%')
                ->orwhere('ai_ranges.name', 'like', '%' . $this->query . '%');
        }

        return $query->paginate($this->paginate);
    }
    public function builder()
    {
        // return Collector::orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        $season = new RiceSeasonController;
        $thisSeason = $season->getSeasson();

        $collector = Collector::join('users', 'collectors.user_id', '=', 'users.id')
            // ->where('collectors.rice_season_id', '=', $thisSeason['seasonId'])
            ->join('districts', 'collectors.district', '=', 'districts.id')
            ->join('regions', 'collectors.region_id', '=', 'regions.id')
            ->join('as_centers', 'collectors.asc', '=', 'as_centers.id')
            ->join('ai_ranges', 'collectors.ai_range', '=', 'ai_ranges.id')
            ->join('rice_seasons', 'collectors.rice_season_id', '=', 'rice_seasons.id')
            ->select('collectors.user_id', 'rice_seasons.name as riceSeasonName', 'regions.name as regionName', 'collectors.phone_no', 'collectors.id', 'collectors.ai_range', 'collectors.village', 'collectors.gps_lati', 'collectors.gps_long', 'collectors.rice_variety', 'collectors.date_establish', 'users.name', 'users.email', 'districts.name as dname', 'as_centers.name as asname', 'ai_ranges.name as ainame')
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        return $collector;
        // return view('collectors.show-collectors')->with('collectors', $collector);
    }
}
