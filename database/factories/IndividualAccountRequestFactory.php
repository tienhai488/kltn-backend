<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IndividualAccountRequest>
 */
class IndividualAccountRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'birth' => $this->faker->date(),
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' => $this->faker->phoneNumber,
            'club_name' => $this->faker->company,
            'website' => $this->faker->url,
            'address' => $this->faker->address,
            'information' => $this->faker->text,
            'username' => $this->faker->userName,
        ];
    }
}
