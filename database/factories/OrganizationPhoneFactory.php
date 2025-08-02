<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrganizationPhone>
 */
class OrganizationPhoneFactory extends Factory
{
    public function definition(): array
    {
        return [
            'phone' => $this->faker->numerify('8-9##-###-##-##'),
            'organization_id' => \App\Models\Organization::factory(),
        ];
    }
}
