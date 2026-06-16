<?php

use App\Models\Category;
use App\Models\Commission;
use App\Models\User;

test('bezoeker kan lijst van opdrachten zien', function () {
    $user = User::factory()->create(['role' => 'client']);
    $category = Category::create(['name' => 'Webdesign']);

    Commission::create([
        'title' => 'Website bouwen',
        'description' => 'Een mooie website',
        'budget' => 500,
        'deadline' => now()->addDays(30),
        'category_id' => $category->id,
        'user_id' => $user->id,
    ]);

    $response = $this->get('/commissions');

    $response->assertOk();
    $response->assertSee('Website bouwen');
});

test('bezoeker ziet een tijdelijke afbeelding als er geen commission image is', function () {
    $user = User::factory()->create(['role' => 'client']);
    $category = Category::create(['name' => 'Webdesign']);

    Commission::create([
        'title' => 'Website bouwen',
        'description' => 'Een mooie website',
        'budget' => 500,
        'deadline' => now()->addDays(30),
        'category_id' => $category->id,
        'user_id' => $user->id,
    ]);

    $response = $this->get('/commissions');

    $response->assertOk();
    $response->assertSee('commission-placeholder.svg');
});

test('bezoeker kan opdrachten filteren op categorie', function () {
    $user = User::factory()->create(['role' => 'client']);
    $webdesign = Category::create(['name' => 'Webdesign']);
    $marketing = Category::create(['name' => 'Marketing']);

    Commission::create([
        'title' => 'Website bouwen',
        'budget' => 500,
        'deadline' => now()->addDays(30),
        'category_id' => $webdesign->id,
        'user_id' => $user->id,
    ]);

    Commission::create([
        'title' => 'Social media campagne',
        'budget' => 300,
        'deadline' => now()->addDays(14),
        'category_id' => $marketing->id,
        'user_id' => $user->id,
    ]);

    $response = $this->get('/commissions?category_id='.$webdesign->id);

    $response->assertOk();
    $response->assertSee('Website bouwen');
    $response->assertDontSee('Social media campagne');
});

test('bezoeker ziet lege lijst als er geen opdrachten zijn', function () {
    $response = $this->get('/commissions');

    $response->assertOk();
});

test('freelancer kan filteren op minimumbudget', function () {
    $user = User::factory()->create(['role' => 'client']);
    $category = Category::create(['name' => 'Dev']);

    Commission::create(['title' => 'Goedkope klus', 'budget' => 200, 'deadline' => now()->addDays(10), 'category_id' => $category->id, 'user_id' => $user->id]);
    Commission::create(['title' => 'Dure klus', 'budget' => 1500, 'deadline' => now()->addDays(20), 'category_id' => $category->id, 'user_id' => $user->id]);

    $response = $this->get('/commissions?budget_min=500');

    $response->assertOk();
    $response->assertSee('Dure klus');
    $response->assertDontSee('Goedkope klus');
});

test('freelancer kan filteren op maximumbudget', function () {
    $user = User::factory()->create(['role' => 'client']);
    $category = Category::create(['name' => 'Design']);

    Commission::create(['title' => 'Klein budget', 'budget' => 300, 'deadline' => now()->addDays(10), 'category_id' => $category->id, 'user_id' => $user->id]);
    Commission::create(['title' => 'Groot budget', 'budget' => 2000, 'deadline' => now()->addDays(20), 'category_id' => $category->id, 'user_id' => $user->id]);

    $response = $this->get('/commissions?budget_max=500');

    $response->assertOk();
    $response->assertSee('Klein budget');
    $response->assertDontSee('Groot budget');
});

test('filters zijn combineerbaar: zoekwoord en categorie samen', function () {
    $user = User::factory()->create(['role' => 'client']);
    $webdesign = Category::create(['name' => 'Webdesign']);
    $marketing = Category::create(['name' => 'Marketing']);

    Commission::create(['title' => 'Website bouwen', 'description' => 'Laravel project', 'budget' => 800, 'deadline' => now()->addDays(30), 'category_id' => $webdesign->id, 'user_id' => $user->id]);
    Commission::create(['title' => 'Laravel API', 'description' => 'REST API', 'budget' => 600, 'deadline' => now()->addDays(20), 'category_id' => $marketing->id, 'user_id' => $user->id]);
    Commission::create(['title' => 'Logo ontwerp', 'description' => 'Huisstijl', 'budget' => 400, 'deadline' => now()->addDays(10), 'category_id' => $webdesign->id, 'user_id' => $user->id]);

    $response = $this->get('/commissions?q=Laravel&category_id='.$webdesign->id);

    $response->assertOk();
    $response->assertSee('Website bouwen');
    $response->assertDontSee('Laravel API');    // juiste q, verkeerde categorie
    $response->assertDontSee('Logo ontwerp');   // juiste categorie, verkeerde q
});

test('sorteren op hoogste budget werkt', function () {
    $user = User::factory()->create(['role' => 'client']);
    $category = Category::create(['name' => 'Test']);

    Commission::create(['title' => 'Budget 100', 'budget' => 100, 'deadline' => now()->addDays(10), 'category_id' => $category->id, 'user_id' => $user->id]);
    Commission::create(['title' => 'Budget 999', 'budget' => 999, 'deadline' => now()->addDays(20), 'category_id' => $category->id, 'user_id' => $user->id]);
    Commission::create(['title' => 'Budget 500', 'budget' => 500, 'deadline' => now()->addDays(15), 'category_id' => $category->id, 'user_id' => $user->id]);

    $response = $this->get('/commissions?sort=budget_desc');

    $response->assertOk();
    $content = $response->getContent();
    // Budget 999 moet vóór Budget 100 staan
    expect(strpos($content, 'Budget 999'))->toBeLessThan(strpos($content, 'Budget 100'));
});

test('lege filterresultaten tonen nette melding', function () {
    $user = User::factory()->create(['role' => 'client']);
    $category = Category::create(['name' => 'Niche']);

    Commission::create(['title' => 'Normale klus', 'budget' => 500, 'deadline' => now()->addDays(10), 'category_id' => $category->id, 'user_id' => $user->id]);

    $response = $this->get('/commissions?budget_min=99999');

    $response->assertOk();
    $response->assertSee('No commissions match your filters');
});

test('zoeken doorzoekt ook de beschrijving', function () {
    $user = User::factory()->create(['role' => 'client']);
    $category = Category::create(['name' => 'Tech']);

    Commission::create(['title' => 'Opdracht A', 'description' => 'Wij zoeken een Laravel expert', 'budget' => 500, 'deadline' => now()->addDays(10), 'category_id' => $category->id, 'user_id' => $user->id]);
    Commission::create(['title' => 'Opdracht B', 'description' => 'WordPress website', 'budget' => 300, 'deadline' => now()->addDays(5), 'category_id' => $category->id, 'user_id' => $user->id]);

    $response = $this->get('/commissions?q=Laravel');

    $response->assertOk();
    $response->assertSee('Opdracht A');
    $response->assertDontSee('Opdracht B');
});

test('client kan de opdracht aanmaken pagina bereiken', function () {
    $client = User::factory()->create(['role' => 'client']);

    $response = $this->actingAs($client)->get('/commissions/create');

    $response->assertOk();
    $response->assertSee('Create New Commission');
});
