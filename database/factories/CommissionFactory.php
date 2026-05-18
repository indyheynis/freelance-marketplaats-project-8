<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Commission;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Commission>
 */
class CommissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'budget' => $this->faker->numberBetween(100, 5000),
            'deadline' => $this->faker->dateTimeBetween('now', '+30 days'),
            'status' => 'open',
        ];
    }
}
