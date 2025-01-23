<?php

namespace Database\Factories;

use App\Enum\ProjectStatus;
use App\Enum\ProjectType;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $endDate = $this->faker->dateTimeBetween('+1 week', '+1 year');
        $startDate = $this->faker->dateTimeBetween('-1 year', $endDate);

        return [
            'category_id' => Category::inRandomOrder()->value('id'),
            'user_id' => User::inRandomOrder()->value('id'),
            'name' => $this->faker->name,
            'donation_target' => $this->faker->randomFloat(4, 0, 1000000),
            'volunteer_quantity' => $this->faker->randomNumber(2),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'content' => $this->faker->text,
            'status' => $this->faker->randomElement(ProjectStatus::cases())->value,
            'type' => $this->faker->randomElement(ProjectType::cases())->value,
        ];
    }
}