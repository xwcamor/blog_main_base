<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TenantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tenants')->insert([
            ['id' => 1, 'slug' => Str::random(22), 'created_by' => 1, 'name' => 'HITACHI ENERGY', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'slug' => Str::random(22), 'created_by' => 1, 'name' => 'SIEMBRES', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
