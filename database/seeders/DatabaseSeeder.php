<!-- StAuth10244: I Rawad Haddad, 000777218 certify that this material is my original work. No other person's work has been used without due acknowledgement. I have not made my work available to anyone else. -->

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'role' => 3,
            'school' => 'Test School',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Test Teacher',
            'email' => 'teacher@test.com',
            'role' => 2,
            'school' => 'Test School',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Test Student',
            'email' => 'student@test.com',
            'role' => 1,
            'school' => 'Test School',
        ]);

        $this -> call([
            SubjectSeeder::class,
            CategorySeeder::class,
            QuizSeeder::class,
            QuestionSeeder::class,
            AnswerSeeder::class,
        ]);
    }
}
