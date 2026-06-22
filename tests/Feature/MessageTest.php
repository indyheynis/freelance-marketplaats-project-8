<?php

use App\Models\Application;
use App\Models\Commission;
use App\Models\Message;
use App\Models\User;

test('commission owner can view messages', function () {
    $client = User::factory()->create(['role' => 'client']);
    $commission = Commission::factory()->create(['user_id' => $client->id]);

    $response = $this->actingAs($client)->get(route('messages.index', $commission));

    $response->assertOk();
});

test('accepted freelancer can view messages', function () {
    $commission = Commission::factory()->create();
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    Application::factory()->create([
        'commission_id' => $commission->id,
        'user_id' => $freelancer->id,
        'status' => 'accepted',
    ]);

    $response = $this->actingAs($freelancer)->get(route('messages.index', $commission));

    $response->assertOk();
});

test('non-involved user cannot view messages', function () {
    $commission = Commission::factory()->create();
    $outsider = User::factory()->create(['role' => 'freelancer']);

    $response = $this->actingAs($outsider)->get(route('messages.index', $commission));

    $response->assertForbidden();
});

test('commission owner can send a message', function () {
    $client = User::factory()->create(['role' => 'client']);
    $commission = Commission::factory()->create(['user_id' => $client->id]);

    $response = $this->actingAs($client)->post(route('messages.store', $commission), [
        'body' => 'Hello, any questions?',
    ]);

    $response->assertRedirect(route('messages.index', $commission));
    $this->assertDatabaseHas('messages', [
        'commission_id' => $commission->id,
        'sender_id' => $client->id,
        'body' => 'Hello, any questions?',
    ]);
});

test('accepted freelancer can send a message', function () {
    $commission = Commission::factory()->create();
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    Application::factory()->create([
        'commission_id' => $commission->id,
        'user_id' => $freelancer->id,
        'status' => 'accepted',
    ]);

    $response = $this->actingAs($freelancer)->post(route('messages.store', $commission), [
        'body' => 'When do we start?',
    ]);

    $response->assertRedirect(route('messages.index', $commission));
    $this->assertDatabaseHas('messages', ['sender_id' => $freelancer->id, 'body' => 'When do we start?']);
});

test('empty message is rejected', function () {
    $client = User::factory()->create(['role' => 'client']);
    $commission = Commission::factory()->create(['user_id' => $client->id]);

    $response = $this->actingAs($client)->post(route('messages.store', $commission), [
        'body' => '',
    ]);

    $response->assertSessionHasErrors('body');
    $this->assertDatabaseCount('messages', 0);
});

test('non-involved user cannot send a message', function () {
    $commission = Commission::factory()->create();
    $outsider = User::factory()->create(['role' => 'freelancer']);

    $response = $this->actingAs($outsider)->post(route('messages.store', $commission), [
        'body' => 'Sneaky message',
    ]);

    $response->assertForbidden();
    $this->assertDatabaseCount('messages', 0);
});

test('messages are shown oldest first', function () {
    $client = User::factory()->create(['role' => 'client']);
    $commission = Commission::factory()->create(['user_id' => $client->id]);
    $first = Message::factory()->create(['commission_id' => $commission->id, 'sender_id' => $client->id, 'body' => 'First message', 'created_at' => now()->subMinutes(5)]);
    $second = Message::factory()->create(['commission_id' => $commission->id, 'sender_id' => $client->id, 'body' => 'Second message', 'created_at' => now()]);

    $response = $this->actingAs($client)->get(route('messages.index', $commission));

    $response->assertSeeInOrder(['First message', 'Second message']);
});
