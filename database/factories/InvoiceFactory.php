<?php

namespace Database\Factories;

use App\Models\Commission;
use App\Models\Invoice;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Invoice>
 */
class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        $client = User::factory()->state(['role' => 'client'])->create();
        $freelancer = User::factory()->state(['role' => 'freelancer'])->create();
        $commission = Commission::factory()->state(['user_id' => $client->id])->create();
        $offer = Offer::factory()->state([
            'user_id' => $freelancer->id,
            'commission_id' => $commission->id,
        ])->create();

        return [
            'invoice_number' => 'INV-'.now()->year.'-'.str_pad(fake()->unique()->numberBetween(1, 99999), 5, '0', STR_PAD_LEFT),
            'offer_id' => $offer->id,
            'commission_id' => $commission->id,
            'client_id' => $client->id,
            'freelancer_id' => $freelancer->id,
            'amount' => $offer->price,
            'status' => 'pending',
            'paid_at' => null,
        ];
    }

    public function paid(): static
    {
        return $this->state([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }
}
