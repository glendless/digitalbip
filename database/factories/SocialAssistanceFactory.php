<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SocialAssistance>
 */
class SocialAssistanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'thumbnail' => $this->faker->imageUrl(),
            'name' => $this->faker->randomElement(['Bansos Pangan', 'Bansos Non Pangan', 'Bansos Kesehatan']),
            'category' => $this->faker->randomElement(['cash', 'staple']),
            'amount' => $this->faker->randomFloat(2, 10000, 1000000),
            'provider' => $this->faker->company,
            'description' => $this->faker->sentence,
            'is_available' => $this->faker->randomElement([true, false]),
        ];
    }
}
