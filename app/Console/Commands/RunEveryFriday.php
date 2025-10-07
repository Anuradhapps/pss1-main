<?php

namespace App\Console\Commands;

use App\Models\Collector;
use App\Models\district;
use App\Models\Notification;
use App\Services\PestInfoService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RunEveryFriday extends Command
{
    protected $signature = 'run:everyfriday';
    protected $description = 'Calculate weekly pest codes and notify collectors of threshold or critical alerts';

    protected PestInfoService $pestInfoService;

    public function __construct(PestInfoService $pestInfoService)
    {
        parent::__construct();
        $this->pestInfoService = $pestInfoService;
    }

    public function handle()
    {
        $districts = district::all();

        foreach ($districts as $district) {
            // Calculate pest codes for the last 100 days
            $data = $this->pestInfoService->avaragePestCodeByDistrictAndDuration($district->id, 60);

            foreach ($data['pests'] as $pestName => $code) {
                $title = null;

                if ($code == 5) {
                    $title = "Threshold Alert: {$pestName} detected in your district. Pest control is suggested.";
                } elseif ($code >= 7 && $code <= 9) {
                    $title = "Critical Alert: {$pestName} detected in your district. Immediate action required!";
                }

                if ($title) {
                    $collectors = Collector::where('district', $district->id)->get();

                    foreach ($collectors as $collector) {
                        if ($collector->user) {
                            Notification::create([
                                'title' => $title . ' (' . Carbon::now()->format('Y-m-d H:i:s') . ')',
                                'assigned_to_user_id' => $collector->user->id,
                                'assigned_from_user_id' => 0, // system
                                'link' => null,
                                'viewed' => false,
                            ]);

                            $this->info("Notification sent to {$collector->user->name} ({$pestName}, code {$code})");
                        }
                    }
                }
            }
        }

        $this->info('Weekly pest forecast processing completed successfully.');
    }
}
