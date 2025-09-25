<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;

class TenantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tenant::create([
            'name' => 'HITACHI ENERGY',
            'created_by' => 1,
        ]);

        Tenant::create([
            'name' => 'SIEMBRES',
            'created_by' => 1,
        ]);
    }
}
