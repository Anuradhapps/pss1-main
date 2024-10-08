<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Http\Controllers\RiceSeasonController;
use App\Models\AiRange;
use App\Models\Collector;
use App\Models\CommonDataCollect;
use App\Models\PestDataCollect;
use App\Models\RiceSeason;
use App\Models\Roles\Role;
use App\Models\Roles\RoleUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Nette\Utils\Random;

class DummySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $riceSeason = new RiceSeasonController();

        $seasons = [[2022, 'yala'], [2022, 'maha'], [2023, 'yala'], [2023, 'maha'], [2024, 'yala']];


        foreach ($seasons as $season) {
            $thisRiceSeason = $riceSeason->getSeasson($season[0], $season[1]);
            RiceSeason::create([
                'id' => $thisRiceSeason['seasonId'],
                'name' => $thisRiceSeason['seasonName'],
                'start_date' => $thisRiceSeason['startDate'],
                'end_date' => $thisRiceSeason['endDate'],
            ]);
        }

        //uncomment below when production-----------------------------
        $aiRanges = AiRange::all();
        $seasons = RiceSeason::all();
        $DataWeeeks = 3;
        foreach ($aiRanges as $aiRange) {
            $counter = $aiRange->id;
            $testUser = User::firstOrCreate(['email' => 'test@domain.com'], [
                'name'                 => 'Testuser' . $counter,
                'slug'                 => 'testuser' . $counter,
                'email'                => 'Testuser' . $counter . '@domain.com',
                'password'             => bcrypt('Testuser' . $counter),
                'is_active'            => 1,
                'is_office_login_only' => 0
            ]);
            $name      = get_initials($testUser->name);
            $id        = $testUser->id . '.png';
            $path      = 'users/';
            $imagePath = create_avatar($name, $id, $path);

            //save image
            $testUser->image = $imagePath;
            $testUser->save();

            $role = Role::where('name', 'collector')->first();
            RoleUser::firstOrCreate([
                'role_id' => $role->id,
                'user_id' => $testUser->id
            ]);
            foreach ($seasons as $season) {
                $start = Carbon::parse($season->start_date)->addWeek(2);
                $end = Carbon::parse($season->start_date)->addWeek(4);

                $collector = Collector::firstOrCreate([
                    'user_id' => $testUser->id,
                    'rice_season_id' => $season->id,
                    'phone_no' => '071' . $counter . '000000',
                    'ai_range' => $aiRange->id,
                    'asc' => $aiRange->as_center->id,
                    'district' => $aiRange->as_center->district->id,
                    'province' => $aiRange->as_center->district->province->id,
                    'village' => 'Village' . $counter,
                    'gps_lati' => '10.0' . $counter,
                    'gps_long' => '10.0' . $counter,
                    'rice_variety' => 'Bg' . Random::generate(2, '1234567890'),
                    'date_establish' => Carbon::createFromTimestamp(
                        rand($start->timestamp, $end->timestamp) // Generate random timestamp between the two
                    )
                ]);
                //change for loop number to add more weekly data----------------------------------
                for ($i = 1; $i <= $DataWeeeks; $i++) {
                    $commonData = CommonDataCollect::firstOrCreate([
                        'user_id' => $testUser->id,
                        'collector_id' => $collector->id,
                        'c_date'  => Carbon::parse($collector->date_establish)->addWeeks(1 * $i),
                        'temperature' => rand(0, 50),
                        'numbrer_r_day' => rand(1, 7),
                        'growth_s_c' => 1 + $i,
                        'otherinfo' =>  $faker->words(3, true) . $counter
                    ]);

                    $pests = ['Number_Of_Tillers', 'Thrips', 'Gall Midge', 'Leaffolder', 'Yellow Stem Borer', 'BPH+WBPH', 'Paddy Bug'];
                    foreach ($pests as $pest) {
                        $pestData = PestDataCollect::firstOrCreate([
                            'common_data_collectors_id' => $commonData->id,
                            'pest_name' => $pest,
                            'location_1' => rand(1, 9),
                            'location_2' => rand(1, 9),
                            'location_3' => rand(1, 9),
                            'location_4' => rand(1, 9),
                            'location_5' => rand(1, 9),
                            'location_6' => rand(1, 9),
                            'location_7' => rand(1, 9),
                            'location_8' => rand(1, 9),
                            'location_9' => rand(1, 9),
                            'location_10' => rand(1, 9),
                            'total' => rand(1, 9),
                            'mean' => rand(1, 9),
                            'code' => rand(1, 9),
                        ]);
                        $totalpest = 0;
                        for ($j = 1; $j <= 10; $j++) {
                            $totalpest += $pestData->location_ . $j;
                        }

                        $pestData->update([
                            'total' => $totalpest,
                            'mean' => $totalpest / 10,
                        ]);
                    }
                }
            }
        }
    }
}
