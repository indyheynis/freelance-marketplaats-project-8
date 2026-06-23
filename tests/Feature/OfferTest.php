<?php

use App\Models\Commission;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

beforeEach(fn () => Mail::fake());

test('freelancer can submit an offer', function () {
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $commission = Commission::factory()->create(['status' => 'open']);

    $response = $this->actingAs($freelancer)->post(route('offers.store'), [
        'commission_id' => $commission->id,
        'price' => 500,
        'message' => 'I am a great fit.',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('offers', [
        'user_id' => $freelancer->id,
        'commission_id' => $commission->id,
    ]);
});

test('client cannot submit an offer', function () {
    $client = User::factory()->create(['role' => 'client']);
    $commission = Commission::factory()->create(['status' => 'open']);

    $response = $this->actingAs($client)->post(route('offers.store'), [
        'commission_id' => $commission->id,
        'price' => 500,
        'message' => 'Trying to bid.',
    ]);

    $response->assertForbidden();
    $this->assertDatabaseMissing('offers', ['user_id' => $client->id]);
});

test('freelancer cannot bid on own commission', function () {
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $commission = Commission::factory()->create(['user_id' => $freelancer->id, 'status' => 'open']);

    $response = $this->actingAs($freelancer)->post(route('offers.store'), [
        'commission_id' => $commission->id,
        'price' => 500,
        'message' => 'Self-bid attempt.',
    ]);

    $response->assertSessionHasErrors('offer');
    $this->assertDatabaseMissing('offers', ['commission_id' => $commission->id]);
});

test('freelancer cannot submit duplicate offer', function () {
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $commission = Commission::factory()->create(['status' => 'open']);
    Offer::factory()->create(['user_id' => $freelancer->id, 'commission_id' => $commission->id]);

    $response = $this->actingAs($freelancer)->post(route('offers.store'), [
        'commission_id' => $commission->id,
        'price' => 999,
        'message' => 'Second attempt.',
    ]);

    $response->assertSessionHasErrors('offer');
    $this->assertDatabaseCount('offers', 1);
});
