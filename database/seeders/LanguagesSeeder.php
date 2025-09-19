<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('languages')->insert([
            ['id' => 1, 'slug' => Str::random(22), 'created_by' => 1, 'iso_code' => 'es', 'name' => 'Español', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'slug' => Str::random(22), 'created_by' => 1, 'iso_code' => 'en', 'name' => 'English', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'slug' => Str::random(22), 'created_by' => 1, 'iso_code' => 'pt', 'name' => 'Português', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
