<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Optional: reset cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define module permissions
        $modules = [
            'countries',
            'users',
            'companies',
        ];

        $actions = [
            'index',   // list
            'show',    // view one
            'create',  // create new
            'edit',    // edit
            'delete',  // delete
        ];

        // Create permissions
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "{$module}_{$action}"]);
            }
        }

        // Create roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user = Role::firstOrCreate(['name' => 'user']);

        // Assign all permissions to admin
        $admin->syncPermissions(Permission::all());

        // You can assign limited permissions to 'user' role if needed
        $user->syncPermissions([
            'countries_index',
            'countries_show',
                        
        ]);
    }
}
