<?php

namespace Database\Factories;

// StAuth10244: I Rawad Haddad, 000777218 certify that this material is my original work. No other person's work has been used without due acknowledgement. I have not made my work available to anyone else.

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
