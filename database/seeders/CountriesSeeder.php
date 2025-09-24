<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->insert([
            [
                'id' => 1,
                'region_id' => 1,
                'name' => 'Perú',
                'iso_code' => 'PE',
                'currency' => 'PEN',
                'timezone' => 'America/Lima',
                'default_locale_id' => 1,
                'slug' => Str::random(22),
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),                
            ],
            [
                'id' => 2,
                'region_id' => 1,
                'name' => 'Venezuela',
                'iso_code' => 'VE',
                'currency' => 'VES',
                'timezone' => 'America/Caracas',
                'default_locale_id' => 2,
                'slug' => Str::random(22),
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),                                
            ],
            [
                'id' => 3,
                'region_id' => 1,
                'name' => 'Brasil',
                'iso_code' => 'BR',
                'currency' => 'BRL',
                'timezone' => 'America/Sao_Paulo',
                'default_locale_id' => 3,
                'slug' => Str::random(22),
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),                                
            ],
            [
                'id' => 4,
                'region_id' => 2,
                'name' => 'Estados Unidos',
                'iso_code' => 'US',
                'currency' => 'USD',
                'timezone' => 'America/New_York',
                'default_locale_id' => 4,
                'slug' => Str::random(22),
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),                                
            ],
            [
                'id' => 5,
                'region_id' => 1,
                'name' => 'Chile',
                'iso_code' => 'CL',
                'currency' => 'CLP',
                'timezone' => 'America/Santiago',
                'default_locale_id' => 5,
                'slug' => Str::random(22),
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),                                
            ],
        ]);
    }
}
