<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Roles\Role;

class RolesDatabaseSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        Role::firstOrCreate(['name' => 'admin', 'label' => 'Admin']);
        Role::firstOrCreate(['name' => 'collector', 'label' => 'Collector']);
        Role::firstOrCreate(['name' => 'user', 'label' => 'User']);
        $deputyDirector = Role::firstOrCreate(['name' => 'deputyDirector', 'label' => 'Deputy Director']);

        // Assign permissions to deputy director
        $dashboardPermission = \App\Models\Roles\Permission::firstOrCreate([
            'name' => 'view_dashboard',
            'label' => 'View Dashboard',
            'module' => 'App'
        ]);
        $districtDetailsPermission = \App\Models\Roles\Permission::firstOrCreate([
            'name' => 'view_deputy_district_details',
            'label' => 'View Deputy District Details',
            'module' => 'District'
        ]);
        $deputyDirector->syncPermissions([
            $dashboardPermission->id,
            $districtDetailsPermission->id
        ]);
    }
}
