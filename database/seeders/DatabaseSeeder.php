<?php

namespace Database\Seeders;

use App\Models\Pest;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RegionSeeder::class,

            // RiceSeasonSeeder::class,
            // ProvinceDistrictAscAiRangeSeeder::class,
            //run an individual seeder>
            //php artisan db:seed --class=ProvinceDistrictAscAiRangeSeeder  
            // PestSeeder::class,

            AppDatabaseSeeder::class,
            AuditTrailsDatabaseSeeder::class,

            // RolesDatabaseSeeder::class,

            SentEmailsDatabaseSeeder::class,
            UserDatabaseSeeder::class,

            // DummySeeder::class

        ]);
    }
}
