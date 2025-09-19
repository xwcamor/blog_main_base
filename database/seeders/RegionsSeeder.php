<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('regions')->insert([
            ['id' => 1, 'slug' => Str::random(22), 'created_by' => 1, 'name' => 'América del Sur', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'slug' => Str::random(22), 'created_by' => 1, 'name' => 'América del Norte', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'slug' => Str::random(22), 'created_by' => 1, 'name' => 'Europa', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
