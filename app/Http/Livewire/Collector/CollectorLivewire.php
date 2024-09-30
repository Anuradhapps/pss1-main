<?php

namespace App\Http\Livewire\Collector;

use App\Models\Collector;
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
            ->orwhere('districts.name', 'like', '%' . $this->query . '%');
        }

        return $query->paginate($this->paginate);
    }
    public function builder()
    {
        // return Collector::orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');

        return   Collector::join('users', 'collectors.user_id', '=', 'users.id')
            ->join('districts', 'collectors.district', '=', 'districts.id')
            ->join('as_centers', 'collectors.asc', '=', 'as_centers.id')
            ->select('collectors.user_id', 'collectors.phone_no', 'collectors.ai_range', 'collectors.village', 'collectors.gps_lati', 'collectors.gps_long', 'collectors.rice_variety', 'collectors.date_establish', 'users.name', 'users.email', 'districts.name as dname', 'as_centers.name as asname')
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');

            // return view('collectors.show-collectors')->with('collectors', $collector);
    }
}
