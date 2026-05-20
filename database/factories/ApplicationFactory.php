<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Commission;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'commission_id' => Commission::factory(),
            'user_id' => User::factory(),
            'message' => $this->faker->paragraph(),
            'status' => 'pending',
        ];
    }
}
