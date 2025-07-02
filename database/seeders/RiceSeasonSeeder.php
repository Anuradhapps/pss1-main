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
        // $thisRiceSeason = $riceSeason->getSeasson();
        // RiceSeason::create([
        //     'id' => $thisRiceSeason['seasonId'],
        //     'name' => $thisRiceSeason['seasonName'],
        //     'start_date' => $thisRiceSeason['startDate'],
        //     'end_date' => $thisRiceSeason['endDate'],
        // ]);

        $riceSeason = new RiceSeasonController();

        $seasons = [[2021, 'maha'], [2022, 'yala'], [2022, 'maha'], [2023, 'yala'], [2023, 'maha'], [2024, 'yala'], [2024, 'maha']];


        foreach ($seasons as $season) {
            $thisRiceSeason = $riceSeason->getSeasson($season[0], $season[1]);
            RiceSeason::create([
                'id' => $thisRiceSeason['seasonId'],
                'name' => $thisRiceSeason['seasonName'],
                'start_date' => $thisRiceSeason['startDate'],
                'end_date' => $thisRiceSeason['endDate'],
            ]);
        }
    }
}
