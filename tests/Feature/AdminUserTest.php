<?php

use App\Models\User;

// Beheerder kan gebruikers bekijken
test('beheerder kan lijst van alle gebruikers bekijken', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    User::factory()->create(['role' => 'freelancer']);
    User::factory()->create(['role' => 'client']);

    $response = $this->actingAs($admin)->get('/users');

    $response->assertSuccessful();
});

// Beheerder kan gebruiker bewerken
test('beheerder kan gebruikersrol aanpassen', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['role' => 'freelancer']);

    $response = $this->actingAs($admin)->put("/users/{$user->id}", [
        'firstname' => $user->firstname,
        'lastname' => $user->lastname,
        'email' => $user->email,
        'role' => 'client',
    ]);

    $response->assertRedirect(route('users.index'));
    $this->assertDatabaseHas('users', ['id' => $user->id, 'role' => 'client']);
});

test('beheerder kan een nieuwe gebruiker toevoegen', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->post('/users', [
        'firstname' => 'Nieuwe',
        'lastname' => 'Gebruiker',
        'email' => 'nieuwe@example.com',
        'role' => 'client',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect(route('users.index'));
    $this->assertDatabaseHas('users', [
        'firstname' => 'Nieuwe',
        'lastname' => 'Gebruiker',
        'name' => 'Nieuwe Gebruiker',
        'email' => 'nieuwe@example.com',
        'role' => 'client',
    ]);
});

test('beheerder kan gebruikersgegevens bijwerken', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['role' => 'freelancer', 'email' => 'oud@example.com']);

    $response = $this->actingAs($admin)->put("/users/{$user->id}", [
        'firstname' => 'Bijgewerkt',
        'lastname' => 'Naam',
        'email' => 'nieuw@example.com',
        'role' => 'freelancer',
    ]);

    $response->assertRedirect(route('users.index'));
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'firstname' => 'Bijgewerkt',
        'lastname' => 'Naam',
        'name' => 'Bijgewerkt Naam',
        'email' => 'nieuw@example.com',
    ]);
});

// Beheerder kan gebruiker verwijderen (blokkeren/verwijderen)
test('beheerder kan een gebruiker verwijderen', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['role' => 'freelancer']);

    $response = $this->actingAs($admin)->delete("/users/{$user->id}");

    $response->assertRedirect(route('users.index'));
    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});

// Validatie bij gebruiker bijwerken
test('gebruikersrol moet geldig zijn bij bijwerken', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['role' => 'freelancer']);

    $response = $this->actingAs($admin)->put("/users/{$user->id}", [
        'firstname' => $user->firstname,
        'lastname' => $user->lastname,
        'email' => $user->email,
        'role' => 'superuser',
    ]);

    $response->assertSessionHasErrors(['role']);
});

test('e-mailadres moet uniek zijn bij bijwerken van gebruiker', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user1 = User::factory()->create(['email' => 'bestaand@example.com']);
    $user2 = User::factory()->create(['role' => 'freelancer']);

    $response = $this->actingAs($admin)->put("/users/{$user2->id}", [
        'firstname' => $user2->firstname,
        'lastname' => $user2->lastname,
        'email' => 'bestaand@example.com',
        'role' => 'freelancer',
    ]);

    $response->assertSessionHasErrors(['email']);
});

// Toegangscontrole - alleen beheerder mag gebruikers beheren
test('freelancer heeft geen toegang tot gebruikersbeheer', function () {
    $freelancer = User::factory()->create(['role' => 'freelancer']);

    $response = $this->actingAs($freelancer)->get('/users');

    $response->assertForbidden();
});

test('client heeft geen toegang tot gebruikersbeheer', function () {
    $client = User::factory()->create(['role' => 'client']);

    $response = $this->actingAs($client)->get('/users');

    $response->assertForbidden();
});

test('gast wordt doorgestuurd naar login bij gebruikersbeheer', function () {
    $response = $this->get('/users');

    $response->assertRedirect('/login');
});

test('freelancer kan geen gebruiker verwijderen', function () {
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $target = User::factory()->create(['role' => 'client']);

    $response = $this->actingAs($freelancer)->delete("/users/{$target->id}");

    $response->assertForbidden();
    $this->assertDatabaseHas('users', ['id' => $target->id]);
});
