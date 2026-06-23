<?php

namespace Database\Factories;

use App\Models\Commission;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'commission_id' => Commission::factory(),
            'reviewer_id' => User::factory()->state(['role' => 'client']),
            'reviewee_id' => User::factory()->state(['role' => 'freelancer']),
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->optional()->sentence(),
        ];
    }
}
