<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Roles\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExtensionAndTrainingDirectorSeeder extends Seeder
{
    public function run()
    {
        // Create or get the Director – Extension and Training role
        $extensionAndTrainingDirectorRole = Role::firstOrCreate(
            ['name' => 'extensionAndTrainingDirector'],
            ['label' => 'Director – Extension and Training']
        );

        $ETDemail = 'ETD@domain.com';
        $ETDpassword = 'ETD@2025';
        $ETDuser = User::firstOrCreate([
            'email' => $ETDemail
        ], [
            'name'                 => 'Director – Extension and Training',
            'slug'                 => 'director-extension-and-training',
            'password'             => bcrypt($ETDpassword),
            'is_active'            => 1,
            'is_office_login_only' => 0
        ]);
        // Assign role if not already assigned
        if (!$ETDuser->roles->contains($extensionAndTrainingDirectorRole)) {
            $ETDuser->roles()->attach($extensionAndTrainingDirectorRole->id);
        }
    }
}
