<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Definir acciones comunes
        $actions = ['view', 'show', 'create', 'edit', 'delete', 'export'];

        // Leer módulos desde la tabla system_modules
        $modules = DB::table('system_modules')->whereNull('deleted_at')->get();

        // Crear permisos dinámicamente
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$module->permission_key}.{$action}",
                    'guard_name' => 'web',
                ]);
            }
        }

        // Crear roles globales
        $super = Role::firstOrCreate(['name' => 'super', 'guard_name' => 'web']);
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $user  = Role::firstOrCreate(['name' => 'user',  'guard_name' => 'web']);

        // Super tiene todos los permisos
        $super->syncPermissions(Permission::all());

        // Admin tiene todos los permisos (igual que super en este caso)
        $admin->syncPermissions(Permission::all());

        // User tiene permisos limitados
        $user->syncPermissions([
            'countries.index',
            'countries.show',
        ]);
    }
}
