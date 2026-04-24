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

    $response = $this->get('/commissions?category_id=' . $webdesign->id);

    $response->assertOk();
    $response->assertSee('Website bouwen');
    $response->assertDontSee('Social media campagne');
});

test('bezoeker ziet lege lijst als er geen opdrachten zijn', function () {
    $response = $this->get('/commissions');

    $response->assertOk();
});
