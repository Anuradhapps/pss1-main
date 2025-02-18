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
            RiceSeasonSeeder::class,
            ProvinceDistrictAscAiRangeSeeder::class,
            PestSeeder::class,
            AppDatabaseSeeder::class,
            AuditTrailsDatabaseSeeder::class,
            RolesDatabaseSeeder::class,
            SentEmailsDatabaseSeeder::class,
            UserDatabaseSeeder::class,
            // DummySeeder::class

        ]);
    }
}
