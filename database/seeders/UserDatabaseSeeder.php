<?php

namespace Database\Seeders;

use App\Models\RiceSeason;
use App\Models\Roles\Permission;
use App\Models\Roles\Role;
use App\Models\Roles\RoleUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UserDatabaseSeeder extends Seeder
{
    public function makeUser($userName)
    {
        $user = User::firstOrCreate([
            'name'                 => $userName,
            'slug'                 => $userName,
            'email'                => $userName . '@domain.com',
            'password'             => bcrypt($userName),
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

        $role = Role::where('name', $userName)->first();
        RoleUser::firstOrCreate([
            'role_id' => $role->id,
            'user_id' => $user->id
        ]);
    }
    public function run()
    {
        Model::unguard();

        Permission::firstOrCreate(['name' => 'view_users', 'label' => 'View Users', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'view_users_profiles', 'label' => 'View Users Profiles', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'view_users_activity', 'label' => 'View Users Activity', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'add_users', 'label' => 'Add Users', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'edit_users', 'label' => 'Edit Users', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'edit_own_account', 'label' => 'Edit Own Account', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'delete_users', 'label' => 'Delete Users', 'module' => 'Users']);

        Permission::firstOrCreate(['name' => 'view_pests', 'label' => 'View Pests', 'module' => 'Pests']);
        Permission::firstOrCreate(['name' => 'create_pests', 'label' => 'Create Pests', 'module' => 'Pests']);
        Permission::firstOrCreate(['name' => 'delete_pests', 'label' => 'Delete Pests', 'module' => 'Pests']);
        Permission::firstOrCreate(['name' => 'edit_pests', 'label' => 'Edit Pests', 'module' => 'Pests']);

        Permission::firstOrCreate(['name' => 'view_collectors', 'label' => 'View Collectos', 'module' => 'Collectos']);
        Permission::firstOrCreate(['name' => 'create_collectors', 'label' => 'Create Collectos', 'module' => 'Collectos']);
        Permission::firstOrCreate(['name' => 'delete_collectors', 'label' => 'Delete Collectos', 'module' => 'Collectos']);
        Permission::firstOrCreate(['name' => 'edit_collectors', 'label' => 'Edit Collectos', 'module' => 'Collectos']);

        Permission::firstOrCreate(['name' => 'view_reports', 'label' => 'View Reports', 'module' => 'Reports']);
        Permission::firstOrCreate(['name' => 'create_reports', 'label' => 'Create Reports', 'module' => 'Reports']);
        Permission::firstOrCreate(['name' => 'delete_reports', 'label' => 'Delete Reports', 'module' => 'Reports']);
        Permission::firstOrCreate(['name' => 'edit_reports', 'label' => 'Edit Reports', 'module' => 'Reports']);

        Permission::firstOrCreate(['name' => 'view_data_charts', 'label' => 'View Data Charts', 'module' => 'Data Charts']);
        Permission::firstOrCreate(['name' => 'create_data_charts', 'label' => 'Create Data Charts', 'module' => 'Data Charts']);
        Permission::firstOrCreate(['name' => 'delete_data_charts', 'label' => 'Delete Data Charts', 'module' => 'Data Charts']);
        Permission::firstOrCreate(['name' => 'edit_data_charts', 'label' => 'Edit Data Charts', 'module' => 'Data Charts']);

        Permission::firstOrCreate(['name' => 'view_data', 'label' => 'View Data', 'module' => 'Data']);
        Permission::firstOrCreate(['name' => 'create_data', 'label' => 'Create Data', 'module' => 'Data']);
        Permission::firstOrCreate(['name' => 'delete_data', 'label' => 'Delete Data', 'module' => 'Data']);
        Permission::firstOrCreate(['name' => 'edit_data', 'label' => 'Edit Data', 'module' => 'Data']);

        // $this->makeUser('admin');

        // $this->makeUser('deputyDirector');
        //create developer uncomment to use when seeding

        // $admin = User::firstOrCreate([
        //     'name'                 => 'Adminuser',
        //     'slug'                 => 'adminuser',
        //     'email'                => 'Adminuser@domain.com',
        //     'password'             => bcrypt('Adminuser'),
        //     'is_active'            => 1,
        //     'is_office_login_only' => 0
        // ]);
        // $deputyDirector = User::firstOrCreate([
        //     'name'                 => 'deputyDirector',
        //     'slug'                 => 'deputyDirector',
        //     'email'                => 'deputyDirector@domain.com',
        //     'password'             => bcrypt('deputyDirector'),
        //     'is_active'            => 1,
        //     'is_office_login_only' => 0
        // ]);
        // //generate image
        // $name      = get_initials($admin->name);
        // $id        = $admin->id . '.png';
        // $path      = 'users/';
        // $imagePath = create_avatar($name, $id, $path);

        // //save image
        // $admin->image = $imagePath;
        // $admin->save();

        // $role = Role::where('name', 'admin')->first();
        // RoleUser::firstOrCreate([
        //     'role_id' => $role->id,
        //     'user_id' => $admin->id
        // ]);
    }
}
