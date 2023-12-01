<?php

namespace Database\Seeders;

// StAuth10244: I Rawad Haddad, 000777218 certify that this material is my original work. No other person's work has been used without due acknowledgement. I have not made my work available to anyone else.

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
            'title' => 'Arithmetic',
            'subject_id' => 1
        ]);

        \App\Models\Category::factory()->create([
            'title' => 'Algebra',
            'subject_id' => 1
        ]);

        \App\Models\Category::factory()->create([
            'title' => 'Statistics',
            'subject_id' => 1
        ]);

        \App\Models\Category::factory()->create([
            'title' => 'Trigonometry',
            'subject_id' => 1
        ]);

        \App\Models\Category::factory()->create([
            'title' => 'Geometry',
            'subject_id' => 1
        ]);

        \App\Models\Category::factory()->create([
            'title' => 'Calculus',
            'subject_id' => 1
        ]);

        \App\Models\Category::factory()->create([
            'title' => 'Physics',
            'subject_id' => 2
        ]);

        \App\Models\Category::factory()->create([
            'title' => 'Chemistry',
            'subject_id' => 2
        ]);

        \App\Models\Category::factory()->create([
            'title' => 'Biology',
            'subject_id' => 2
        ]);

        \App\Models\Category::factory()->create([
            'title' => 'Earth Science',
            'subject_id' => 2
        ]);

        \App\Models\Category::factory()->create([
            'title' => 'Astronomy',
            'subject_id' => 2
        ]);

        \App\Models\Category::factory()->create([
            'title' => 'Regional Geography',
            'subject_id' => 3
        ]);

        \App\Models\Category::factory()->create([
            'title' => 'Geopolitics',
            'subject_id' => 3
        ]);

        \App\Models\Category::factory()->create([
            'title' => 'Cartography',
            'subject_id' => 3

        ]);

        \App\Models\Category::factory()->create([
            'title' => 'Climatology',
            'subject_id' => 3
        ]);

        \App\Models\Category::factory()->create([
            'title' => 'Meteorology',
            'subject_id' => 3
        ]);
    }
}
