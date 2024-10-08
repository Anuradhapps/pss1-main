<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Http\Controllers\RiceSeasonController;
use App\Models\RiceSeason;
use Illuminate\Database\Seeder;

class RiceSeasonSeeder extends Seeder
{
    public function run()
    {
        $riceSeason = new RiceSeasonController();
        $thisRiceSeason = $riceSeason->getSeasson();
        RiceSeason::create([
            'id'=>$thisRiceSeason['seasonId'],
            'name'=>$thisRiceSeason['seasonName'],
            'start_date'=>$thisRiceSeason['startDate'],
            'end_date'=>$thisRiceSeason['endDate'],
        ]);
        

    }
}
