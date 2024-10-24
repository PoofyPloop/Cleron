<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Question;
use App\Models\Thread;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'body' => $this->faker->paragraph,
            'user_id' => User::factory(),
            // 'thread_id' => Thread::all()->count() ? Thread::all()->random()->id : Thread::factory(),
            'thread_id' => Thread::exists() ? Thread::inRandomOrder()->first()->id : Thread::factory(),
        ];
    }
}
