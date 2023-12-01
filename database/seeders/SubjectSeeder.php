<?php

namespace Database\Seeders;

// StAuth10244: I Rawad Haddad, 000777218 certify that this material is my original work. No other person's work has been used without due acknowledgement. I have not made my work available to anyone else.

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
