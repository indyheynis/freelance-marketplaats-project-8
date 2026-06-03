<?php

namespace Database\Factories;

use App\Models\Commission;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Offer>
 */
class OfferFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => 'freelancer']),
            'commission_id' => Commission::factory(),
            'price' => fake()->randomFloat(2, 100, 5000),
            'message' => fake()->sentence(),
            'status' => 'pending',
        ];
    }
}
