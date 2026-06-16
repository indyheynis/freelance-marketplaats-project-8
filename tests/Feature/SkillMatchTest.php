<?php

use App\Models\Category;
use App\Models\Commission;
use App\Models\User;

test('freelancer with matching skill sees commission in matches for you', function () {
    $category = Category::factory()->create(['name' => 'Design']);
    $freelancer = User::factory()->create(['role' => 'freelancer', 'skills' => ['Design', 'Photography']]);
    $commission = Commission::factory()->create(['category_id' => $category->id, 'status' => 'open']);

    $response = $this->actingAs($freelancer)->get(route('dashboard.freelancer'));

    $response->assertOk();
    $response->assertSee($commission->title);
});

test('freelancer without skills sees no-skills invitation', function () {
    $freelancer = User::factory()->create(['role' => 'freelancer', 'skills' => []]);

    $response = $this->actingAs($freelancer)->get(route('dashboard.freelancer'));

    $response->assertOk();
    $response->assertSee('No skills set yet');
});

test('freelancer with skills but no matching commission sees empty state', function () {
    $freelancer = User::factory()->create(['role' => 'freelancer', 'skills' => ['Welding']]);

    $response = $this->actingAs($freelancer)->get(route('dashboard.freelancer'));

    $response->assertOk();
    $response->assertSee('No open commissions match your skills right now');
});

test('freelancer does not see own commissions in matches', function () {
    $category = Category::factory()->create(['name' => 'Writing']);
    $freelancer = User::factory()->create(['role' => 'freelancer', 'skills' => ['Writing']]);
    Commission::factory()->create([
        'user_id' => $freelancer->id,
        'category_id' => $category->id,
        'status' => 'open',
    ]);

    $response = $this->actingAs($freelancer)->get(route('dashboard.freelancer'));

    $response->assertOk();
    $response->assertSee('No open commissions match your skills right now');
});

test('skill matching is case-insensitive', function () {
    $category = Category::factory()->create(['name' => 'Photography']);
    $freelancer = User::factory()->create(['role' => 'freelancer', 'skills' => ['photography']]);
    $commission = Commission::factory()->create(['category_id' => $category->id, 'status' => 'open']);

    $response = $this->actingAs($freelancer)->get(route('dashboard.freelancer'));

    $response->assertOk();
    $response->assertSee($commission->title);
});

test('closed commissions are excluded from matches', function () {
    $category = Category::factory()->create(['name' => 'Marketing']);
    $freelancer = User::factory()->create(['role' => 'freelancer', 'skills' => ['Marketing']]);
    $commission = Commission::factory()->create([
        'category_id' => $category->id,
        'status' => 'closed',
    ]);

    $response = $this->actingAs($freelancer)->get(route('dashboard.freelancer'));

    $response->assertOk();
    $response->assertDontSee($commission->title);
});
