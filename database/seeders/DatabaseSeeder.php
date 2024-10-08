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

        $this->call([
            SubjectSeeder::class,
            CategorySeeder::class,
            QuizSeeder::class,
            ReportSeeder::class,
            QuestionSeeder::class,
            AnswerSeeder::class,
            ThreadSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
