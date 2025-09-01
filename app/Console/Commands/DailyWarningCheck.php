<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Support\Str;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Console\Command;

class DailyWarningCheck extends Command
{
    protected $signature = 'warnings:check';
    protected $description = 'Run daily warnings check and generate notifications';

    public function handle()
    {
        Notification::create([
            'id' => Str::uuid(),
            'title' => "Daily system check: Please review your pending data",
            'assigned_to_user_id' => '31284867-d0e7-4872-a7a3-569c99c96994',
            'assigned_from_user_id' => '31284867-d0e7-4872-a7a3-569c99c96994', // system-generated
            'viewed' => false,
        ]);


        $this->info('Daily warnings generated successfully!');
    }
}
