<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MapView extends Component
{
    public $collectors;

    public function render()
    {
        return view('livewire.map-view');
    }
}
