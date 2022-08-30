<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Modules\Admin\Entities\Admin;

class RolePermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

         // create permissions
         Permission::create(['name' => 'edit users']);
         Permission::create(['name' => 'delete users']);
         Permission::create(['name' => 'view users']);
         Permission::create(['name' => 'create users']);

         Permission::create(['name' => 'view competitions']);
         Permission::create(['name' => 'create competitions']);
         Permission::create(['name' => 'delete competitions']);
         Permission::create(['name' => 'edit competitions']);
         Permission::create(['name' => 'create teams']);
         Permission::create(['name' => 'delete teams']);
         Permission::create(['name' => 'edit teams']);
         Permission::create(['name' => 'view teams']);
            Permission::create(['name' => 'create results']);
            Permission::create(['name' => 'delete results']);
            Permission::create(['name' => 'edit results']);
            Permission::create(['name' => 'view results']);
    

        
 
         // create roles and assign created permissions
 
         // this can be done as separate statements
         $role = Role::create(['name' => 'user']);
         $role->givePermissionTo(['edit users', 'view users','create teams', 'view teams', 'edit teams', 'view competitions', 'create results', 'edit results', 'view results', 'delete results']);
 
         // or may be done by chaining
         $role = Role::create(['name' => 'admin'])
             ->givePermissionTo(['create users', 'create competitions', 'edit users', 'edit competitions', 'view users', 'view competitions', 'view teams', 'create teams', 'edit teams', 'create results', 'edit results', 'view results', 'delete results']);
 
         $role = Role::create(['name' => 'super-admin']);
         $role->givePermissionTo(Permission::all());
        // $menus = [
        //     'application' => [
        //         'user' => [
        //             'view-user',
        //             'create-user',
        //             'update-user',
        //             'delete-user',
        //         ],
        //         'competition' => [
        //             'view-competition',
        //             'create-competition',
        //             'update-competition',
        //             'delete-competition',
        //         ],
              
        //         'team' => [
        //             'view-team',
        //             'create-team',
        //             'update-team',
        //             'delete-team',
        //         ],
        //     ],
        //     'setting' => [
        //         'admin' => [
        //             'view-admin',
        //             'create-admin',
        //             'update-admin',
        //             'delete-admin',  
        //         ],
        //         'role' => [
        //             'view-role',
        //             'create-role',
        //             'update-role',
        //             'delete-role',  
        //         ],
        //     ],            
        // ];

        // foreach ($menus as $menu => $submenus) {
        //     foreach ($submenus as $submenu => $permissions) {
        //         foreach ($permissions as $permission) {
        //             Permission::updateOrCreate(
        //                 [
        //                     'name' => $permission, 
        //                     'guard_name' => 'admin',
        //                 ],
        //                 [
        //                     'menu' => $menu,
        //                     'submenu' => $submenu
        //                 ]
        //             );
        //         }
        //     }
        // }

        // $superAdmin = 'Super Admin';
        // $role = Role::updateOrCreate(['name' => $superAdmin, 'guard_name' => 'admin']);
        // $role->syncPermissions(Permission::all()->pluck('id')->toArray());

        // if($user = Admin::find(1)) {
        //     $user->assignRole($role);
        // }
    }
    
}
