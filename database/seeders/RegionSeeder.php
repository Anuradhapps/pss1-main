<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    public function run()
    {
        $regionTypes = ['Provincial', 'Inter Provincial', 'Mahaweli'];

        // Loop through each pest name and create a new Pest record
        foreach ($regionTypes as $region) {
            Region::create(['name' => $region]);
        }
    }
}
