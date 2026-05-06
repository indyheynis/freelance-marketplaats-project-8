<?php

use App\Models\Category;
use App\Models\Commission;
use App\Models\User;

test('bezoeker kan lijst van openstaande opdrachten zien', function () {
    $client = User::factory()->create(['role' => 'client']);
    $category = Category::create(['name' => 'Webdesign']);
    Commission::create([
        'title' => 'Website bouwen',
        'description' => 'Een moderne website',
        'budget' => 500,
        'deadline' => now()->addDays(30),
        'category_id' => $category->id,
        'user_id' => $client->id,
    ]);

    $response = $this->get('/commissions');

    $response->assertOk();
    $response->assertSee('Website bouwen');
});

test('bezoeker kan opdrachten filteren op categorie', function () {
    $client = User::factory()->create(['role' => 'client']);
    $webdesign = Category::create(['name' => 'Webdesign']);
    $marketing = Category::create(['name' => 'Marketing']);

    Commission::create([
        'title' => 'Website bouwen',
        'budget' => 500,
        'deadline' => now()->addDays(30),
        'category_id' => $webdesign->id,
        'user_id' => $client->id,
    ]);
    Commission::create([
        'title' => 'Social media campagne',
        'budget' => 300,
        'deadline' => now()->addDays(14),
        'category_id' => $marketing->id,
        'user_id' => $client->id,
    ]);

    $response = $this->get('/commissions?category_id=' . $webdesign->id);

    $response->assertOk();
    $response->assertSee('Website bouwen');
    $response->assertDontSee('Social media campagne');
});

test('bezoeker kan detailpagina van een opdracht zien', function () {
    $client = User::factory()->create(['role' => 'client']);
    $category = Category::create(['name' => 'Design']);
    $commission = Commission::create([
        'title' => 'Logo ontwerpen',
        'description' => 'Een professioneel logo voor ons bedrijf',
        'budget' => 250,
        'deadline' => now()->addDays(14),
        'category_id' => $category->id,
        'user_id' => $client->id,
    ]);

    $response = $this->get('/commissions/' . $commission->id);

    $response->assertOk();
    $response->assertSee('Logo ontwerpen');
    $response->assertSee('Een professioneel logo voor ons bedrijf');
});

test('bezoeker kan overzichtspagina van opdrachten bekijken', function () {
    $response = $this->get('/commissions');

    $response->assertOk();
});

test('bezoeker kan registreren als freelancer', function () {
    $this->post('/register', [
        'firstname' => 'Jan',
        'lastname' => 'Janssen',
        'email' => 'jan@example.com',
        'role' => 'freelancer',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'email' => 'jan@example.com',
        'role' => 'freelancer',
    ]);
});

test('bezoeker kan registreren als opdrachtgever', function () {
    $this->post('/register', [
        'firstname' => 'Piet',
        'lastname' => 'Pietersen',
        'email' => 'piet@example.com',
        'role' => 'client',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'email' => 'piet@example.com',
        'role' => 'client',
    ]);
});

test('bezoeker kan niet registreren als beheerder', function () {
    $response = $this->post('/register', [
        'firstname' => 'Admin',
        'lastname' => 'User',
        'email' => 'admin@example.com',
        'role' => 'admin',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasErrors('role');
    $this->assertGuest();
});
