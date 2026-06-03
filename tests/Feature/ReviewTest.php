<?php

use App\Models\Application;
use App\Models\Category;
use App\Models\Commission;
use App\Models\Review;
use App\Models\User;

function makeCommissionWithAcceptedApplication(): array
{
    $client = User::factory()->create(['role' => 'client']);
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $category = Category::create(['name' => 'Test categorie']);
    $commission = Commission::create([
        'title' => 'Test opdracht',
        'description' => 'Beschrijving',
        'budget' => 1000,
        'deadline' => now()->addDays(30)->format('Y-m-d'),
        'category_id' => $category->id,
        'user_id' => $client->id,
    ]);
    Application::create([
        'commission_id' => $commission->id,
        'user_id' => $freelancer->id,
        'message' => 'Ik doe het',
        'status' => 'accepted',
    ]);

    return compact('client', 'freelancer', 'commission');
}

test('opdrachtgever kan een review plaatsen', function () {
    ['client' => $client, 'freelancer' => $freelancer, 'commission' => $commission] = makeCommissionWithAcceptedApplication();

    $response = $this->actingAs($client)->post("/commissions/{$commission->id}/reviews", [
        'rating' => 4,
        'comment' => 'Goede freelancer, prima werk geleverd.',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('reviews', [
        'commission_id' => $commission->id,
        'reviewer_id' => $client->id,
        'reviewee_id' => $freelancer->id,
        'rating' => 4,
    ]);
});

test('opdrachtgever kan niet twee keer een review plaatsen', function () {
    ['client' => $client, 'freelancer' => $freelancer, 'commission' => $commission] = makeCommissionWithAcceptedApplication();

    Review::create([
        'commission_id' => $commission->id,
        'reviewer_id' => $client->id,
        'reviewee_id' => $freelancer->id,
        'rating' => 5,
        'comment' => 'Eerste review',
    ]);

    $response = $this->actingAs($client)->post("/commissions/{$commission->id}/reviews", [
        'rating' => 3,
        'comment' => 'Tweede poging',
    ]);

    $response->assertStatus(422);
    $this->assertDatabaseCount('reviews', 1);
});

test('freelancer kan geen review achterlaten', function () {
    ['freelancer' => $freelancer, 'commission' => $commission] = makeCommissionWithAcceptedApplication();

    $response = $this->actingAs($freelancer)->post("/commissions/{$commission->id}/reviews", [
        'rating' => 5,
        'comment' => 'Ik review mezelf',
    ]);

    $response->assertForbidden();
});

test('rating buiten bereik 1-5 faalt validatie', function () {
    ['client' => $client, 'commission' => $commission] = makeCommissionWithAcceptedApplication();

    $response = $this->actingAs($client)->post("/commissions/{$commission->id}/reviews", [
        'rating' => 6,
        'comment' => 'Te hoge score',
    ]);

    $response->assertSessionHasErrors(['rating']);
});

test('review comment mag maximaal 200 woorden bevatten', function () {
    ['client' => $client, 'commission' => $commission] = makeCommissionWithAcceptedApplication();

    $longComment = implode(' ', array_fill(0, 201, 'woord'));

    $response = $this->actingAs($client)->post("/commissions/{$commission->id}/reviews", [
        'rating' => 3,
        'comment' => $longComment,
    ]);

    $response->assertSessionHasErrors(['comment']);
});

test('freelancer profielpagina toont statistieken en reviews', function () {
    ['client' => $client, 'freelancer' => $freelancer, 'commission' => $commission] = makeCommissionWithAcceptedApplication();

    Review::create([
        'commission_id' => $commission->id,
        'reviewer_id' => $client->id,
        'reviewee_id' => $freelancer->id,
        'rating' => 4,
        'comment' => 'Geweldig werk!',
    ]);

    $response = $this->actingAs($client)->get("/freelancers/{$freelancer->id}");

    $response->assertOk();
    $response->assertSee($freelancer->firstname);
    $response->assertSee('4.0');
    $response->assertSee('Geweldig werk!');
    $response->assertSee('1'); // 1 opdracht gedaan
});

test('freelancer profiel is niet toegankelijk voor niet-ingelogde gebruikers', function () {
    $freelancer = User::factory()->create(['role' => 'freelancer']);

    $response = $this->get("/freelancers/{$freelancer->id}");

    $response->assertRedirect('/login');
});

test('freelancer kan eigen reviews bekijken', function () {
    ['client' => $client, 'freelancer' => $freelancer, 'commission' => $commission] = makeCommissionWithAcceptedApplication();

    Review::create([
        'commission_id' => $commission->id,
        'reviewer_id' => $client->id,
        'reviewee_id' => $freelancer->id,
        'rating' => 5,
        'comment' => 'Uitstekend werk!',
    ]);

    $response = $this->actingAs($freelancer)->get('/my-reviews');

    $response->assertOk();
    $response->assertSee('Uitstekend werk!');
    $response->assertSee($client->firstname);
});

test('freelancer ziet lege staat als er geen reviews zijn', function () {
    $freelancer = User::factory()->create(['role' => 'freelancer']);

    $response = $this->actingAs($freelancer)->get('/my-reviews');

    $response->assertOk();
    $response->assertSee('You have not received any reviews yet.');
});

test('opdrachtgever heeft geen toegang tot mijn reviews pagina', function () {
    $client = User::factory()->create(['role' => 'client']);

    $response = $this->actingAs($client)->get('/my-reviews');

    $response->assertForbidden();
});

test('niet-ingelogde gebruiker wordt doorgestuurd bij bezoek aan reviews pagina', function () {
    $response = $this->get('/my-reviews');

    $response->assertRedirect('/login');
});
