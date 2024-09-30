<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Subject;
use App\Models\User;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->realText(50),
            'description' => fake()->realText(200),
            'slug' => fake()->slug(),
            'started_at' => fake()->dateTimeBetween('-1 day', '+1 day'),
            'ended_at' => fake()->dateTimeBetween('-1 day', '+1 day'),
            'user_id' => User::all()->count() ? User::all()->random()->id : User::factory(),
            'category_id' => Category::factory(),
            'subject_id' => Subject::factory(),
        ];
    }

}
