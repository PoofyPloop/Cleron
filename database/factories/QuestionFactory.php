<?php

namespace Database\Factories;


use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'label' => fake()->sentence(),
            'value' => fake()->unique()->word(),
            'options' => [
                ...fake()->randomElement([
                    [
                        [
                            "label" => "Dog",
                            "value" => "dog"
                        ],
                        [
                            "label" => "Cat",
                            "value" => "cat"
                        ],
                        [
                            "label" => "Lizard",
                            "value" => "lizard"
                        ],
                        [
                            "label" => "Hamster",
                            "value" => "hamster"
                        ]
                    ],
                    [
                        [
                            "label" => "Toyota",
                            "value" => "toyota"
                        ],
                        [
                            "label" => "Honda",
                            "value" => "honda"
                        ],
                        [
                            "label" => "Suzuki",
                            "value" => "suzuki"
                        ],
                        [
                            "label" => "Nissan",
                            "value" => "nissan"
                        ]
                    ]
                ])
            ],
            'type' => fake()->randomElement([
                "text",
                "radio",
                "textarea"
            ]),
            'points' => fake()->numberBetween(0, 100),
            'quiz_id' => Quiz::all()->count() ? Quiz::all()->random()->id : Quiz::factory(),
        ];
    }
}
