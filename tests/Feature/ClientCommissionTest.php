<?php

use App\Models\Category;
use App\Models\Commission;
use App\Models\User;

test('opdrachtgever kan een nieuwe opdracht aanmaken', function () {
    $client = User::factory()->create(['role' => 'client']);
    $category = Category::create(['name' => 'Webdesign']);

    $response = $this->actingAs($client)->post('/commissions', [
        'title' => 'Website bouwen',
        'description' => 'Een moderne website voor ons bedrijf',
        'budget' => 1500,
        'deadline' => now()->addDays(30)->format('Y-m-d'),
        'category_id' => $category->id,
    ]);

    $response->assertRedirect('/commissions');
    $this->assertDatabaseHas('commissions', [
        'title' => 'Website bouwen',
        'user_id' => $client->id,
    ]);
});

test('opdracht vereist een titel en categorie', function () {
    $client = User::factory()->create(['role' => 'client']);

    $response = $this->actingAs($client)->post('/commissions', [
        'title' => '',
        'category_id' => '',
    ]);

    $response->assertSessionHasErrors(['title', 'category_id']);
});

test('freelancer kan geen opdracht aanmaken', function () {
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $category = Category::create(['name' => 'Design']);

    $response = $this->actingAs($freelancer)->post('/commissions', [
        'title' => 'Poging opdracht',
        'budget' => 500,
        'deadline' => now()->addDays(14)->format('Y-m-d'),
        'category_id' => $category->id,
    ]);

    $response->assertForbidden();
});

test('gast kan geen opdracht aanmaken', function () {
    $category = Category::create(['name' => 'Design']);

    $response = $this->post('/commissions', [
        'title' => 'Poging opdracht',
        'category_id' => $category->id,
    ]);

    $response->assertRedirect('/login');
});

test('opdrachtgever kan eigen opdracht bewerken', function () {
    $client = User::factory()->create(['role' => 'client']);
    $category = Category::create(['name' => 'Marketing']);
    $commission = Commission::create([
        'title' => 'Oude titel',
        'description' => 'Oude beschrijving',
        'budget' => 300,
        'deadline' => now()->addDays(20)->format('Y-m-d'),
        'category_id' => $category->id,
        'user_id' => $client->id,
    ]);

    $response = $this->actingAs($client)->put("/commissions/{$commission->id}", [
        'title' => 'Nieuwe titel',
        'description' => 'Bijgewerkte beschrijving',
        'budget' => 500,
        'deadline' => now()->addDays(30)->format('Y-m-d'),
        'category_id' => $category->id,
    ]);

    $response->assertRedirect("/commissions/{$commission->id}");
    $this->assertDatabaseHas('commissions', [
        'id' => $commission->id,
        'title' => 'Nieuwe titel',
    ]);
});

test('opdrachtgever kan eigen opdracht verwijderen', function () {
    $client = User::factory()->create(['role' => 'client']);
    $category = Category::create(['name' => 'Fotografie']);
    $commission = Commission::create([
        'title' => 'Te verwijderen opdracht',
        'budget' => 200,
        'deadline' => now()->addDays(10)->format('Y-m-d'),
        'category_id' => $category->id,
        'user_id' => $client->id,
    ]);

    $response = $this->actingAs($client)->delete("/commissions/{$commission->id}");

    $response->assertRedirect('/commissions');
    $this->assertDatabaseMissing('commissions', ['id' => $commission->id]);
});

test('freelancer kan een offerte indienen op een opdracht', function () {
    $client = User::factory()->create(['role' => 'client']);
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $category = Category::create(['name' => 'Development']);
    $commission = Commission::create([
        'title' => 'App bouwen',
        'budget' => 2000,
        'deadline' => now()->addDays(60)->format('Y-m-d'),
        'category_id' => $category->id,
        'user_id' => $client->id,
    ]);

    $response = $this->actingAs($freelancer)->post('/offers', [
        'commission_id' => $commission->id,
        'price' => 1800,
        'message' => 'Ik kan dit project uitvoeren voor dit bedrag.',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('offers', [
        'commission_id' => $commission->id,
        'user_id' => $freelancer->id,
        'price' => 1800,
    ]);
});

test('commission show can load offers without relation error', function () {
    $client = User::factory()->create(['role' => 'client']);
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $category = Category::create(['name' => 'Development']);
    $commission = Commission::create([
        'title' => 'App bouwen',
        'budget' => 2000,
        'deadline' => now()->addDays(60)->format('Y-m-d'),
        'category_id' => $category->id,
        'user_id' => $client->id,
    ]);

    $commission->offers()->create([
        'user_id' => $freelancer->id,
        'price' => 1800,
        'message' => 'Ik kan dit project uitvoeren voor dit bedrag.',
    ]);

    $response = $this->get("/commissions/{$commission->id}");

    $response->assertOk();
    $response->assertSee('App bouwen');
    $response->assertSee('1800');
});

test('gast kan geen offerte indienen', function () {
    $client = User::factory()->create(['role' => 'client']);
    $category = Category::create(['name' => 'Design']);
    $commission = Commission::create([
        'title' => 'Logo ontwerpen',
        'budget' => 300,
        'deadline' => now()->addDays(14)->format('Y-m-d'),
        'category_id' => $category->id,
        'user_id' => $client->id,
    ]);

    $response = $this->post('/offers', [
        'commission_id' => $commission->id,
        'price' => 250,
    ]);

    $response->assertRedirect('/login');
});
