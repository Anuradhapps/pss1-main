<?php

namespace Database\Seeders;

use App\Models\AiRange;
use App\Models\Collector;
use App\Models\CommonDataCollect;
use App\Models\Pest;
use App\Models\PestDataCollect;
use App\Models\Roles\Permission;
use App\Models\Roles\Role;
use App\Models\Roles\RoleUser;
use App\Models\User;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Nette\Utils\Random;
use Faker\Factory as Faker; // Import Faker
class UserDatabaseSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        Model::unguard();

        Permission::firstOrCreate(['name' => 'view_users', 'label' => 'View Users', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'view_users_profiles', 'label' => 'View Users Profiles', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'view_users_activity', 'label' => 'View Users Activity', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'add_users', 'label' => 'Add Users', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'edit_users', 'label' => 'Edit Users', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'edit_own_account', 'label' => 'Edit Own Account', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'delete_users', 'label' => 'Delete Users', 'module' => 'Users']);

        //create developer uncomment to use when seeding

        $user = User::firstOrCreate(['email' => 'user@domain.com'], [
            'name'                 => 'Adminuser',
            'slug'                 => 'adminuser',
            'email'                => 'Adminuser@domain.com',
            'password'             => bcrypt('Adminuser'),
            'is_active'            => 1,
            'is_office_login_only' => 0
        ]);

        //generate image
        $name      = get_initials($user->name);
        $id        = $user->id . '.png';
        $path      = 'users/';
        $imagePath = create_avatar($name, $id, $path);

        //save image
        $user->image = $imagePath;
        $user->save();

        $role = Role::where('name', 'admin')->first();
        RoleUser::firstOrCreate([
            'role_id' => $role->id,
            'user_id' => $user->id
        ]);

        $aiRanges = AiRange::all();

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
            $user->image = $imagePath;
            $testUser->save();

            $role = Role::where('name', 'collector')->first();
            RoleUser::firstOrCreate([
                'role_id' => $role->id,
                'user_id' => $testUser->id
            ]);

            $collector = Collector::firstOrCreate([
                'user_id' => $testUser->id,
                'phone_no' => '071' . $counter . '000000',
                'ai_range' => $aiRange->id,
                'asc' => $aiRange->as_center->id,
                'district' => $aiRange->as_center->district->id,
                'province' => $aiRange->as_center->district->province->id,
                'village' => 'Village' . $counter,
                'gps_lati' => '10.0' . $counter,
                'gps_long' => '10.0' . $counter,
                'rice_variety' => 'Bg' . Random::generate(2, '1234567890'),
                'date_establish' => Carbon::createFromTimestamp(rand(strtotime('2024-09-01'), strtotime('2024-09-10')))
            ]);
            //change for loop number to add more weekly data
            for ($i = 1; $i <= 3; $i++) {
                $commonData = CommonDataCollect::firstOrCreate([
                    'user_id' => $testUser->id,
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
