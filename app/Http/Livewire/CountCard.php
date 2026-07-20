<?php

namespace App\Http\Livewire;

use App\Models\Collector;
use App\Models\ConductedProgram;
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
        $ttl = 300; // 5 minutes cache

        if ($this->cardName == 'Users') {
            $this->targetCount = \Illuminate\Support\Facades\Cache::remember('countcard_users', $ttl, function () {
                return User::count();
            });
        }
        if ($this->cardName == 'Pests') {
            $this->targetCount = \Illuminate\Support\Facades\Cache::remember('countcard_pests', $ttl, function () {
                return Pest::count();
            });
        }
        if ($this->cardName == 'Collectors') {
            $this->targetCount = \Illuminate\Support\Facades\Cache::remember('countcard_collectors', $ttl, function () {
                return Collector::count();
            });
        }
        if ($this->cardName == 'Districts') {
            $this->targetCount = \Illuminate\Support\Facades\Cache::remember('countcard_districts', $ttl, function () {
                return Collector::pluck('district')->unique()->count();
            });
        }
        if ($this->cardName == 'Provinces') {
            $this->targetCount = \Illuminate\Support\Facades\Cache::remember('countcard_provinces', $ttl, function () {
                return Collector::pluck('province')->unique()->count();
            });
        }
        if ($this->cardName == 'ASC') {
            $this->targetCount = \Illuminate\Support\Facades\Cache::remember('countcard_ascs', $ttl, function () {
                return Collector::pluck('asc')->unique()->count();
            });
        }
        if ($this->cardName == 'AiRanges') {
            $this->targetCount = \Illuminate\Support\Facades\Cache::remember('countcard_airanges', $ttl, function () {
                return Collector::pluck('ai_range')->unique()->count();
            });
        }
        if ($this->cardName == 'ConductedPrograms') {
            $this->targetCount = \Illuminate\Support\Facades\Cache::remember('countcard_programs', $ttl, function () {
                return ConductedProgram::count();
            });
        }

        $this->userCount = 0;
    }

    // Render the Livewire component
    public function render()
    {
        return view('livewire.count-card');
    }
}
