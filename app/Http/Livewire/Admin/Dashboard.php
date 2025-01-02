<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Base;
use Illuminate\Contracts\View\View;
use App\Models\district;

use function abort_if_cannot;
use function view;

class Dashboard extends Base
{
    public $test;
    public function render(): View
    {
        // abort_if_cannot('view_dashboard');

        return view('livewire.admin.dashboard');
    }
}
