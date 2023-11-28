<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create categories
        \App\Models\Category::factory()->create([
            'title' => 'Algebra',
            'slug' => 'algebra'
        ]);

        \App\Models\Category::factory()->create([
            'title' => 'Statistics',
            'slug' => 'statistics'
        ]);

        \App\Models\Category::factory()->create([
            'title' => 'Arithmetic',
            'slug' => 'arithmetic'
        ]);

        \App\Models\Category::factory()->create([
            'title' => 'Probability',
            'slug' => 'probability'
        ]);
    }
}
