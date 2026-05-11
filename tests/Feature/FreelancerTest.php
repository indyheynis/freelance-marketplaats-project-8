<?php

use App\Models\Category;
use App\Models\Commission;
use App\Models\Offer;
use App\Models\User;

// Dashboard toegang
test('freelancer kan het freelancer dashboard bekijken', function () {
    $freelancer = User::factory()->create(['role' => 'freelancer']);

    $response = $this->actingAs($freelancer)->get('/dashboard/freelancer');

    $response->assertSuccessful();
});

test('client heeft geen toegang tot het freelancer dashboard', function () {
    $client = User::factory()->create(['role' => 'client']);

    $response = $this->actingAs($client)->get('/dashboard/freelancer');

    $response->assertForbidden();
});

test('gast wordt doorgestuurd naar login bij freelancer dashboard', function () {
    $response = $this->get('/dashboard/freelancer');

    $response->assertRedirect('/login');
});

// Offertes bekijken
test('freelancer kan ingediende offerte terugzien op de opdracht', function () {
    $client = User::factory()->create(['role' => 'client']);
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $category = Category::create(['name' => 'Development']);
    $commission = Commission::create([
        'title' => 'App bouwen',
        'budget' => 2000,
        'deadline' => now()->addDays(30)->format('Y-m-d'),
        'category_id' => $category->id,
        'user_id' => $client->id,
    ]);

    Offer::create([
        'user_id' => $freelancer->id,
        'commission_id' => $commission->id,
        'price' => 1800,
        'message' => 'Ik kan dit uitvoeren.',
    ]);

    $response = $this->actingAs($freelancer)->get("/commissions/{$commission->id}");

    $response->assertSuccessful();
});

test('freelancer kan meerdere offertes indienen op verschillende opdrachten', function () {
    $client = User::factory()->create(['role' => 'client']);
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $category = Category::create(['name' => 'Design']);

    $commission1 = Commission::create([
        'title' => 'Logo ontwerp',
        'budget' => 500,
        'deadline' => now()->addDays(14)->format('Y-m-d'),
        'category_id' => $category->id,
        'user_id' => $client->id,
    ]);

    $commission2 = Commission::create([
        'title' => 'Banner ontwerp',
        'budget' => 300,
        'deadline' => now()->addDays(7)->format('Y-m-d'),
        'category_id' => $category->id,
        'user_id' => $client->id,
    ]);

    $this->actingAs($freelancer)->post('/offers', [
        'commission_id' => $commission1->id,
        'price' => 450,
        'message' => 'Ik doe het logo.',
    ]);

    $this->actingAs($freelancer)->post('/offers', [
        'commission_id' => $commission2->id,
        'price' => 280,
        'message' => 'Ik doe de banner.',
    ]);

    $this->assertDatabaseCount('offers', 2);
    $this->assertDatabaseHas('offers', ['user_id' => $freelancer->id, 'commission_id' => $commission1->id]);
    $this->assertDatabaseHas('offers', ['user_id' => $freelancer->id, 'commission_id' => $commission2->id]);
});

// Profiel beheren
test('freelancer kan profiel bijwerken', function () {
    $freelancer = User::factory()->create([
        'role' => 'freelancer',
        'firstname' => 'Oud',
        'lastname' => 'Naam',
        'email' => 'oud@example.com',
    ]);

    $response = $this->actingAs($freelancer)->patch('/profile', [
        'firstname' => 'Nieuw',
        'lastname' => 'Naam',
        'email' => 'nieuw@example.com',
    ]);

    $response->assertRedirect(route('profile.edit'));
    $this->assertDatabaseHas('users', [
        'id' => $freelancer->id,
        'firstname' => 'Nieuw',
        'email' => 'nieuw@example.com',
    ]);
});

test('freelancer kan vaardigheden toevoegen aan profiel', function () {
    $freelancer = User::factory()->create(['role' => 'freelancer']);

    $response = $this->actingAs($freelancer)->patch('/profile', [
        'firstname' => $freelancer->firstname,
        'lastname' => $freelancer->lastname,
        'email' => $freelancer->email,
        'skills' => 'PHP, Laravel, Vue.js',
    ]);

    $response->assertRedirect(route('profile.edit'));

    $freelancer->refresh();
    expect($freelancer->skills)->toContain('PHP');
    expect($freelancer->skills)->toContain('Laravel');
    expect($freelancer->skills)->toContain('Vue.js');
});

test('freelancer kan bestaande vaardigheden bijwerken', function () {
    $freelancer = User::factory()->create([
        'role' => 'freelancer',
        'skills' => ['PHP', 'MySQL'],
    ]);

    $this->actingAs($freelancer)->patch('/profile', [
        'firstname' => $freelancer->firstname,
        'lastname' => $freelancer->lastname,
        'email' => $freelancer->email,
        'skills' => 'Python, Django',
    ]);

    $freelancer->refresh();
    expect($freelancer->skills)->toContain('Python');
    expect($freelancer->skills)->not->toContain('PHP');
});

test('profiel vereist een voornaam en achternaam', function () {
    $freelancer = User::factory()->create(['role' => 'freelancer']);

    $response = $this->actingAs($freelancer)->patch('/profile', [
        'firstname' => '',
        'lastname' => '',
        'email' => $freelancer->email,
    ]);

    $response->assertSessionHasErrors(['firstname', 'lastname']);
});

test('profiel vereist een geldig e-mailadres', function () {
    $freelancer = User::factory()->create(['role' => 'freelancer']);

    $response = $this->actingAs($freelancer)->patch('/profile', [
        'firstname' => $freelancer->firstname,
        'lastname' => $freelancer->lastname,
        'email' => 'geen-geldig-email',
    ]);

    $response->assertSessionHasErrors(['email']);
});

test('gast heeft geen toegang tot profielpagina', function () {
    $response = $this->get('/profile');

    $response->assertRedirect('/login');
});
