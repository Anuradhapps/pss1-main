<?php

namespace App\Http\Livewire;

use App\Models\Collector;
use App\Models\ConductedProgram;
use App\Models\Pest;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class CountCard extends Component
{
    public $cardName;
    public $color;
    public $iconName;
    public $userCount = 0;
    public $targetCount = 0;

    public function mount()
    {
        $ttl = 300; // 5 minutes cache

        if ($this->cardName == 'Users') {
            $this->targetCount = Cache::remember('countcard_users', $ttl, function () {
                return User::count();
            });
        }

        if ($this->cardName == 'Pests') {
            $this->targetCount = Cache::remember('countcard_pests', $ttl, function () {
                return Pest::count();
            });
        }

        if ($this->cardName == 'Collectors') {
            $this->targetCount = Cache::remember('countcard_collectors', $ttl, function () {
                return Collector::count();
            });
        }

        if ($this->cardName == 'Districts') {
            $this->targetCount = Cache::remember('countcard_districts', $ttl, function () {
                return Collector::pluck('district')->unique()->count();
            });
        }

        if ($this->cardName == 'Provinces') {
            $this->targetCount = Cache::remember('countcard_provinces', $ttl, function () {
                return Collector::pluck('province')->unique()->count();
            });
        }

        if ($this->cardName == 'ASC') {
            $this->targetCount = Cache::remember('countcard_ascs', $ttl, function () {
                return Collector::pluck('asc')->unique()->count();
            });
        }

        if ($this->cardName == 'AiRanges') {
            $this->targetCount = Cache::remember('countcard_airanges', $ttl, function () {
                return Collector::pluck('ai_range')->unique()->count();
            });
        }

        if ($this->cardName == 'ConductedPrograms') {
            $this->targetCount = Cache::remember('countcard_programs', $ttl, function () {
                return ConductedProgram::count();
            });
        }

        // Display the count immediately
        $this->userCount = $this->targetCount;
    }

    public function render()
    {
        return view('livewire.count-card');
    }
}
