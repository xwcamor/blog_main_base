<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LocalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('locales')->insert([
            ['id' => 1, 'slug' => Str::random(22), 'created_by' => 1, 'code' => 'es_PE', 'name' => 'Español (Perú)', 'language_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'slug' => Str::random(22), 'created_by' => 1, 'code' => 'es_VE', 'name' => 'Español (Venezuela)', 'language_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'slug' => Str::random(22), 'created_by' => 1, 'code' => 'pt_BR', 'name' => 'Português (Brasil)', 'language_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'slug' => Str::random(22), 'created_by' => 1, 'code' => 'en_US', 'name' => 'English (US)', 'language_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'slug' => Str::random(22), 'created_by' => 1, 'code' => 'es_CL', 'name' => 'Español (Chile)', 'language_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
