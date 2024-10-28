<?php
namespace App\Http\Livewire;

use App\Models\Collector;
use App\Models\Pest;
use App\Models\User;
use Livewire\Component;

class CountCard extends Component
{
    public $cardName;
    public $color;
    public $iconName;
    public $userCount = 0;
    public $targetCount = 0;

    // Triggered when the component is mounted (loaded)
    public function mount()
    {
        if($this->cardName == 'Users'){
            $this->targetCount = User::count();
        }
        if($this->cardName == 'Pests'){
            $this->targetCount = Pest::count();
        }
        if($this->cardName == 'Collectors'){
            $this->targetCount = Collector::count();
        }
        if($this->cardName == 'Districts'){
            $this->targetCount = Collector::pluck('district')->unique()->count();
        }
        if($this->cardName == 'Provinces'){
            $this->targetCount = Collector::pluck('province')->unique()->count();
        }
        if($this->cardName == 'ASC'){
            $this->targetCount = Collector::pluck('asc')->unique()->count();
        }
        if($this->cardName == 'AiRanges'){
            $this->targetCount = Collector::pluck('ai_range')->unique()->count();
        }
        
        
        $this->userCount = 0;

    }

    // Render the Livewire component
    public function render()
    {
        return view('livewire.count-card');
    }
}
