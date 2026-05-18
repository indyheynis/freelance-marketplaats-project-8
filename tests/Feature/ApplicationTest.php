<?php

use App\Models\Application;
use App\Models\Category;
use App\Models\Commission;
use App\Models\User;

test('client kan een sollicitatie accepteren', function () {
    $client = User::factory()->create(['role' => 'client']);
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $category = Category::factory()->create();

    $commission = Commission::factory()->create([
        'user_id' => $client->id,
        'category_id' => $category->id,
    ]);

    $application = Application::factory()->create([
        'commission_id' => $commission->id,
        'user_id' => $freelancer->id,
        'status' => 'pending',
    ]);

    $response = $this->actingAs($client)->patch("/applications/{$application->id}/accept");

    $response->assertRedirect();
    $this->assertDatabaseHas('applications', [
        'id' => $application->id,
        'status' => 'accepted',
    ]);
});

test('wanneer een sollicitatie wordt geaccepteerd worden alle anderen afgewezen', function () {
    $client = User::factory()->create(['role' => 'client']);
    $freelancer1 = User::factory()->create(['role' => 'freelancer']);
    $freelancer2 = User::factory()->create(['role' => 'freelancer']);
    $freelancer3 = User::factory()->create(['role' => 'freelancer']);
    $category = Category::factory()->create();

    $commission = Commission::factory()->create([
        'user_id' => $client->id,
        'category_id' => $category->id,
    ]);

    $application1 = Application::factory()->create([
        'commission_id' => $commission->id,
        'user_id' => $freelancer1->id,
        'status' => 'pending',
    ]);

    $application2 = Application::factory()->create([
        'commission_id' => $commission->id,
        'user_id' => $freelancer2->id,
        'status' => 'pending',
    ]);

    $application3 = Application::factory()->create([
        'commission_id' => $commission->id,
        'user_id' => $freelancer3->id,
        'status' => 'pending',
    ]);

    // Accept application1
    $response = $this->actingAs($client)->patch("/applications/{$application1->id}/accept");

    $response->assertRedirect();

    // Check that application1 is accepted
    $this->assertDatabaseHas('applications', [
        'id' => $application1->id,
        'status' => 'accepted',
    ]);

    // Check that application2 and application3 are rejected
    $this->assertDatabaseHas('applications', [
        'id' => $application2->id,
        'status' => 'rejected',
    ]);

    $this->assertDatabaseHas('applications', [
        'id' => $application3->id,
        'status' => 'rejected',
    ]);
});

test('alleen de opdrachtgever kan een sollicitatie accepteren', function () {
    $client = User::factory()->create(['role' => 'client']);
    $otherClient = User::factory()->create(['role' => 'client']);
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $category = Category::factory()->create();

    $commission = Commission::factory()->create([
        'user_id' => $client->id,
        'category_id' => $category->id,
    ]);

    $application = Application::factory()->create([
        'commission_id' => $commission->id,
        'user_id' => $freelancer->id,
        'status' => 'pending',
    ]);

    $response = $this->actingAs($otherClient)->patch("/applications/{$application->id}/accept");

    $response->assertForbidden();
});
