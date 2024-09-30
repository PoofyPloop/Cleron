<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create subjects
        \App\Models\Subject::factory()->create([
            'title' => 'Math',
            'slug' => 'math'
        ]);

        \App\Models\Subject::factory()->create([
            'title' => 'Science',
            'slug' => 'science'
        ]);

        \App\Models\Subject::factory()->create([
            'title' => 'Geography',
            'slug' => 'geography'
        ]);
    }
}
