<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrganizationAccountRequest>
 */
class OrganizationAccountRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'birth' => $this->faker->date(),
            'website' => $this->faker->url,
            'field' => $this->faker->word,
            'address' => $this->faker->address,
            'username' => $this->faker->userName,
            'information' => $this->faker->text,
            'representative_name' => $this->faker->name,
            'representative_phone_number' => $this->faker->phoneNumber,
            'representative_email' => $this->faker->unique()->safeEmail,
        ];
    }
}
