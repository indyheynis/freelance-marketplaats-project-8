<?php

use App\Models\Category;
use App\Models\Commission;
use App\Models\Favorite;
use App\Models\User;

test('freelancer kan een opdracht opslaan als favoriet', function () {
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $client = User::factory()->create(['role' => 'client']);
    $category = Category::create(['name' => 'Test']);
    $commission = Commission::create(['title' => 'Klus A', 'budget' => 500, 'deadline' => now()->addDays(10), 'category_id' => $category->id, 'user_id' => $client->id]);

    $this->actingAs($freelancer)->post(route('favorites.toggle', $commission));

    expect(Favorite::where('user_id', $freelancer->id)->where('commission_id', $commission->id)->exists())->toBeTrue();
});

test('freelancer kan favoriet verwijderen door opnieuw te klikken', function () {
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $client = User::factory()->create(['role' => 'client']);
    $category = Category::create(['name' => 'Test']);
    $commission = Commission::create(['title' => 'Klus B', 'budget' => 500, 'deadline' => now()->addDays(10), 'category_id' => $category->id, 'user_id' => $client->id]);

    Favorite::create(['user_id' => $freelancer->id, 'commission_id' => $commission->id]);

    $this->actingAs($freelancer)->post(route('favorites.toggle', $commission));

    expect(Favorite::where('user_id', $freelancer->id)->where('commission_id', $commission->id)->exists())->toBeFalse();
});

test('opdracht staat nooit dubbel in favorieten', function () {
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $client = User::factory()->create(['role' => 'client']);
    $category = Category::create(['name' => 'Test']);
    $commission = Commission::create(['title' => 'Klus C', 'budget' => 500, 'deadline' => now()->addDays(10), 'category_id' => $category->id, 'user_id' => $client->id]);

    $this->actingAs($freelancer)->post(route('favorites.toggle', $commission));
    $this->actingAs($freelancer)->post(route('favorites.toggle', $commission));
    $this->actingAs($freelancer)->post(route('favorites.toggle', $commission));

    expect(Favorite::where('user_id', $freelancer->id)->where('commission_id', $commission->id)->count())->toBe(1);
});

test('niet-ingelogde bezoeker kan geen favoriet opslaan', function () {
    $client = User::factory()->create(['role' => 'client']);
    $category = Category::create(['name' => 'Test']);
    $commission = Commission::create(['title' => 'Klus D', 'budget' => 500, 'deadline' => now()->addDays(10), 'category_id' => $category->id, 'user_id' => $client->id]);

    $this->post(route('favorites.toggle', $commission))->assertRedirect(route('login'));

    expect(Favorite::count())->toBe(0);
});

test('freelancer ziet mijn favorieten pagina', function () {
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $client = User::factory()->create(['role' => 'client']);
    $category = Category::create(['name' => 'Test']);
    $commission = Commission::create(['title' => 'Favoriete Klus', 'budget' => 500, 'deadline' => now()->addDays(10), 'category_id' => $category->id, 'user_id' => $client->id]);

    Favorite::create(['user_id' => $freelancer->id, 'commission_id' => $commission->id]);

    $this->actingAs($freelancer)->get(route('favorites.index'))
        ->assertOk()
        ->assertSee('Favoriete Klus');
});

test('favorieten pagina toont geen opdrachten van andere freelancers', function () {
    $freelancer1 = User::factory()->create(['role' => 'freelancer']);
    $freelancer2 = User::factory()->create(['role' => 'freelancer']);
    $client = User::factory()->create(['role' => 'client']);
    $category = Category::create(['name' => 'Test']);

    $commissionA = Commission::create(['title' => 'Klus van freelancer2', 'budget' => 500, 'deadline' => now()->addDays(10), 'category_id' => $category->id, 'user_id' => $client->id]);
    Favorite::create(['user_id' => $freelancer2->id, 'commission_id' => $commissionA->id]);

    $this->actingAs($freelancer1)->get(route('favorites.index'))
        ->assertOk()
        ->assertDontSee('Klus van freelancer2');
});
