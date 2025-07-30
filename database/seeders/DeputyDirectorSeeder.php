<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Roles\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DeputyDirectorSeeder extends Seeder
{
    public function run()
    {

        // Create or get the deputyDirector role
        $deputyDirectorRole = Role::firstOrCreate(
            ['name' => 'deputyDirector'],
            ['label' => 'Deputy Director']
        );

        $deputyDirectorRole = Role::where('name', 'deputyDirector')->first();
        foreach (\App\Models\district::all() as $district) {
            $districtNameNoSpace = preg_replace('/\s+/', '', $district->name);
            $email = strtolower($districtNameNoSpace) . 'DD@domain.com';
            $password = strtolower($districtNameNoSpace) . 'dd@2025';
            $user = User::firstOrCreate([
                'email' => $email
            ], [
                'name'                 => $district->name . ' Deputy Director',
                'slug'                 => strtolower($districtNameNoSpace) . '-deputy-director',
                'password'             => bcrypt($password),
                'is_active'            => 1,
                'is_office_login_only' => 0
            ]);
            // Assign role if not already assigned
            if (!$user->roles->contains($deputyDirectorRole)) {
                $user->roles()->attach($deputyDirectorRole->id);
            }
        }
    }
}
