<?php

namespace Database\Seeders;

use App\Models\Race;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RaceSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Race::factory()->create([
            'name' => '第3回五頭登山競走',
            'date' => '2024/9/22',
        ]);
    }
}