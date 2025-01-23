<?php

namespace Database\Factories;

use App\Enum\VolunteerStatus;
use App\Models\Department;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Volunteer>
 */
class VolunteerFactory extends Factory
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
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' => $this->faker->phoneNumber,
            'department_id' => Department::inRandomOrder()->value('id'),
            'class' => $this->faker->name,
            'student_code' => $this->faker->uuid,
            'status' => $this->faker->randomElement(VolunteerStatus::cases())->value,
            'note' => $this->faker->text,
        ];
    }
}