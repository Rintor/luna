<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Building>
 */
class BuildingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude(54.0, 56.0),
            'longitude' => $this->faker->longitude(37.0, 83.0),
        ];
    }
}
