<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SystemModulesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('system_modules')->insert([
            [
                'slug' => Str::random(22),
                'name' => 'Countries',
                'permission_key' => 'countries',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => Str::random(22),
                'name' => 'Users',
                'permission_key' => 'users',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => Str::random(22),
                'name' => 'Companies',
                'permission_key' => 'companies',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
