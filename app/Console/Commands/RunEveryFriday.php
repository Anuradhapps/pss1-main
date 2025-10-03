<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\PestInfoService;
use Illuminate\Console\Command;

class RunEveryFriday extends Command
{
    // Command signature to run manually
    protected $signature = 'run:everyfriday';

    // Command description
    protected $description = 'Run a method every Friday';

    public function handle()
    {
        // Call your method here
        $pestInfoService = new PestInfoService;
        $data = $pestInfoService->avaragePestCodeByDistrictAndDuration(1, 7);
        dd($data);
        $this->info('Method executed successfully!');
    }
}
