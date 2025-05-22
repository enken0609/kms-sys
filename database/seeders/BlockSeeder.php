<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blocks = [
            ['id' => 1, 'name' => '女子', 'display_order' => 1],
            ['id' => 2, 'name' => '男子', 'display_order' => 2],
            ['id' => 3, 'name' => '女子ペア', 'display_order' => 1],
            ['id' => 4, 'name' => '男子ペア', 'display_order' => 2],
            ['id' => 5, 'name' => '混合ペア', 'display_order' => 3],
            ['id' => 6, 'name' => '女子トリオ', 'display_order' => 1],
            ['id' => 7, 'name' => '男子トリオ', 'display_order' => 2],
            ['id' => 8, 'name' => '混合トリオ', 'display_order' => 3],
        ];

        foreach ($blocks as $block) {
            DB::table('blocks')->insert([
                'id' => $block['id'],
                'name' => $block['name'],
                'display_order' => $block['display_order'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
