<?php

namespace Database\Factories;

use App\Models\Commission;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Message>
 */
class MessageFactory extends Factory
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
            'sender_id' => User::factory(),
            'body' => $this->faker->sentence(),
        ];
    }
}
