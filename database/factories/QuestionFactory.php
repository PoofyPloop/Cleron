<!-- StAuth10244: I Rawad Haddad, 000777218 certify that this material is my original work. No other person's work has been used without due acknowledgement. I have not made my work available to anyone else. -->

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
            'quiz_id' => Quiz::factory(),
        ];
    }
}
