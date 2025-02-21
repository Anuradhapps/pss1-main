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

            //comment when actual database is ready
            // RiceSeasonSeeder::class,


            // ProvinceDistrictAscAiRangeSeeder::class,
            //run an individual seeder>
            //php artisan db:seed --class=ProvinceDistrictAscAiRangeSeeder



            PestSeeder::class,

            AppDatabaseSeeder::class,
            AuditTrailsDatabaseSeeder::class,

            //comment when actual database is ready
            //comment on user seeder also
            // RolesDatabaseSeeder::class,

            SentEmailsDatabaseSeeder::class,
            UserDatabaseSeeder::class,

            //comment when actual database is ready
            // DummySeeder::class

        ]);
    }
}
