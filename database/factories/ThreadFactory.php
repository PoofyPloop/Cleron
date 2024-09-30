<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Question;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Thread>
 */
class ThreadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'description' => $this->faker->realText(200),
            'user_id' => User::factory(),
            'image' => $this->faker->optional()->imageUrl(),
            'metadata' => [
                'views' => $this->faker->numberBetween(0, 1000),
                'likes' => $this->faker->numberBetween(0, 1000),
                'dislikes' => $this->faker->numberBetween(0, 1000),
            ]
        ];
    }
}
