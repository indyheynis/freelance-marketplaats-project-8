<?php

use App\Models\Category;
use App\Models\Commission;
use App\Models\User;

test('admin can view dashboard with KPIs', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    User::factory()->count(3)->create(['role' => 'freelancer']);
    User::factory()->count(2)->create(['role' => 'client']);
    Commission::factory()->count(4)->create(['status' => 'open']);
    Commission::factory()->count(1)->create(['status' => 'closed']);

    $response = $this->actingAs($admin)->get(route('dashboard.admin'));

    $response->assertOk();
    $response->assertSee('Total users');
    $response->assertSee('Open commissions');
    $response->assertSee('Total applications');
    $response->assertSee('Avg. budget');
});

test('admin dashboard shows correct user counts', function () {
    User::factory()->count(2)->create(['role' => 'freelancer']);
    User::factory()->count(3)->create(['role' => 'client']);
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get(route('dashboard.admin'));

    $response->assertOk();
    $response->assertSee('2 freelancers');
    $response->assertSee('3 clients');
});

test('admin dashboard shows correct open commission count', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    Commission::factory()->count(5)->create(['status' => 'open']);
    Commission::factory()->count(2)->create(['status' => 'closed']);

    $response = $this->actingAs($admin)->get(route('dashboard.admin'));

    $response->assertOk();
    $response->assertSee('5');
    $response->assertSee('2 closed');
});

test('admin dashboard includes commissions per category data', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $category = Category::factory()->create(['name' => 'Development']);
    Commission::factory()->count(3)->create(['category_id' => $category->id, 'status' => 'open']);

    $response = $this->actingAs($admin)->get(route('dashboard.admin'));

    $response->assertOk();
    $response->assertSee('Development');
});

test('non-admin is denied access to admin dashboard', function () {
    $freelancer = User::factory()->create(['role' => 'freelancer']);

    $response = $this->actingAs($freelancer)->get(route('dashboard.admin'));

    $response->assertForbidden();
});
