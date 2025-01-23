<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donation>
 */
class DonationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->value('id'),
            'project_id' => Project::inRandomOrder()->value('id'),
            'account_number' => $this->faker->bankAccountNumber,
            'account_name' => $this->faker->name,
            'code' => $this->faker->uuid,
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' => $this->faker->phoneNumber,
            'amount' => $this->faker->randomFloat(4, 0, 100000),
            'is_anonymous' => $this->faker->boolean,
            'note' => $this->faker->text,
            'department_id' => Department::inRandomOrder()->value('id'),
            'class' => $this->faker->name,
            'student_code' => $this->faker->uuid,
        ];
    }
}