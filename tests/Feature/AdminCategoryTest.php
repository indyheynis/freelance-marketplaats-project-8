<?php

use App\Models\Category;
use App\Models\User;

// Beheerder kan categorieën bekijken
test('beheerder kan overzicht van categorieën bekijken', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    Category::create(['name' => 'Webdesign']);
    Category::create(['name' => 'Marketing']);

    $response = $this->actingAs($admin)->get('/categories');

    $response->assertSuccessful();
    $response->assertSee('Webdesign');
    $response->assertSee('Marketing');
});

// Beheerder kan categorie aanmaken
test('beheerder kan een nieuwe categorie aanmaken', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->post('/categories', [
        'name' => 'Fotografie',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('categories', ['name' => 'Fotografie']);
});

test('categorie naam is verplicht bij aanmaken', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->post('/categories', [
        'name' => '',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('categorie naam moet uniek zijn', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    Category::create(['name' => 'Webdesign']);

    $response = $this->actingAs($admin)->post('/categories', [
        'name' => 'Webdesign',
    ]);

    $response->assertSessionHasErrors(['name']);
});

// Beheerder kan categorie bewerken
test('beheerder kan een categorie bewerken', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $category = Category::create(['name' => 'Oude naam']);

    $response = $this->actingAs($admin)->put("/categories/{$category->id}", [
        'name' => 'Nieuwe naam',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => 'Nieuwe naam']);
});

// Beheerder kan categorie verwijderen
test('beheerder kan een categorie verwijderen', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $category = Category::create(['name' => 'Te verwijderen']);

    $response = $this->actingAs($admin)->delete("/categories/{$category->id}");

    $response->assertRedirect();
    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
});

// Toegangscontrole - alleen beheerder mag categorieën beheren
test('niet-beheerder (client) kan geen categorie aanmaken', function () {
    $client = User::factory()->create(['role' => 'client']);

    $response = $this->actingAs($client)->post('/categories', [
        'name' => 'Ongeautoriseerde categorie',
    ]);

    $response->assertForbidden();
    $this->assertDatabaseMissing('categories', ['name' => 'Ongeautoriseerde categorie']);
});

test('niet-beheerder (freelancer) kan geen categorie aanmaken', function () {
    $freelancer = User::factory()->create(['role' => 'freelancer']);

    $response = $this->actingAs($freelancer)->post('/categories', [
        'name' => 'Ongeautoriseerde categorie',
    ]);

    $response->assertForbidden();
    $this->assertDatabaseMissing('categories', ['name' => 'Ongeautoriseerde categorie']);
});

test('gast kan geen categorie aanmaken', function () {
    $response = $this->post('/categories', [
        'name' => 'Gastcategorie',
    ]);

    $response->assertRedirect('/login');
    $this->assertDatabaseMissing('categories', ['name' => 'Gastcategorie']);
});

test('niet-beheerder kan geen categorie bewerken', function () {
    $client = User::factory()->create(['role' => 'client']);
    $category = Category::create(['name' => 'Onbewerkbaar']);

    $response = $this->actingAs($client)->put("/categories/{$category->id}", [
        'name' => 'Gewijzigde naam',
    ]);

    $response->assertForbidden();
    $this->assertDatabaseMissing('categories', ['name' => 'Gewijzigde naam']);
});

test('niet-beheerder kan geen categorie verwijderen', function () {
    $client = User::factory()->create(['role' => 'client']);
    $category = Category::create(['name' => 'Niet verwijderen']);

    $response = $this->actingAs($client)->delete("/categories/{$category->id}");

    $response->assertForbidden();
    $this->assertDatabaseHas('categories', ['id' => $category->id]);
});
