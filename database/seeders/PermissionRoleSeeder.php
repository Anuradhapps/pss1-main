<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Roles\PermissionRole;
use Database\Factories\Roles\PermissionRoleFactory;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    public function run()
    {
        PermissionRoleFactory::factory(100)->create();
    }
}
