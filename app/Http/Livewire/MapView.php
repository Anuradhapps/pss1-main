<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MapView extends Component
{
    public $collectors;
    public $height;
    public $width;

    public function mount($collectors, $height = '500px', $width = '100%')
    {
        $this->collectors = $collectors;
        $this->height = $height;
        $this->width = $width;
    }
    public function render()
    {
        return view('livewire.map-view');
    }
}
