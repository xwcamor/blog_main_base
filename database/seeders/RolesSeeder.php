<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $super = Role::firstOrCreate(
            ['name' => 'super', 'guard_name' => 'web'],
            ['description' => 'Super Admin: Full Access']
        );

        $admin = Role::firstOrCreate(
            ['name' => 'admin', 'guard_name' => 'web'],
            ['description' => 'Tenant Administrator']
        );

        $user = Role::firstOrCreate(
            ['name' => 'user', 'guard_name' => 'web'],
            ['description' => 'User with profiles']
        );

      
    }
}
