<?php

use App\Models\Application;
use App\Models\Category;
use App\Models\Commission;
use App\Models\User;
use App\Notifications\ApplicationStatusChangedNotification;
use App\Notifications\NewApplicationNotification;
use Illuminate\Support\Facades\Notification;

test('opdrachtgever ontvangt melding bij nieuwe sollicitatie', function () {
    Notification::fake();

    $client = User::factory()->create(['role' => 'client']);
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $category = Category::create(['name' => 'Test']);
    $commission = Commission::create(['title' => 'Klus A', 'budget' => 500, 'deadline' => now()->addDays(10), 'category_id' => $category->id, 'user_id' => $client->id]);

    $this->actingAs($freelancer)->post(route('applications.store', $commission), ['message' => 'Ik wil dit doen']);

    Notification::assertSentTo($client, NewApplicationNotification::class);
});

test('freelancer ontvangt melding bij acceptatie sollicitatie', function () {
    Notification::fake();

    $client = User::factory()->create(['role' => 'client']);
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $category = Category::create(['name' => 'Test']);
    $commission = Commission::create(['title' => 'Klus B', 'budget' => 500, 'deadline' => now()->addDays(10), 'category_id' => $category->id, 'user_id' => $client->id]);
    $application = Application::create(['commission_id' => $commission->id, 'user_id' => $freelancer->id, 'status' => 'pending']);

    $this->actingAs($client)->patch(route('applications.accept', $application));

    Notification::assertSentTo($freelancer, ApplicationStatusChangedNotification::class);
});

test('freelancer ontvangt melding bij afwijzing sollicitatie', function () {
    Notification::fake();

    $client = User::factory()->create(['role' => 'client']);
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $category = Category::create(['name' => 'Test']);
    $commission = Commission::create(['title' => 'Klus C', 'budget' => 500, 'deadline' => now()->addDays(10), 'category_id' => $category->id, 'user_id' => $client->id]);
    $application = Application::create(['commission_id' => $commission->id, 'user_id' => $freelancer->id, 'status' => 'pending']);

    $this->actingAs($client)->patch(route('applications.reject', $application));

    Notification::assertSentTo($freelancer, ApplicationStatusChangedNotification::class);
});

test('gebruiker ziet alleen eigen meldingen', function () {
    $userA = User::factory()->create(['role' => 'freelancer']);
    $userB = User::factory()->create(['role' => 'freelancer']);
    $client = User::factory()->create(['role' => 'client']);
    $category = Category::create(['name' => 'Test']);
    $commission = Commission::create(['title' => 'Klus D', 'budget' => 500, 'deadline' => now()->addDays(10), 'category_id' => $category->id, 'user_id' => $client->id]);
    $application = Application::create(['commission_id' => $commission->id, 'user_id' => $userA->id, 'status' => 'accepted']);

    $userA->notify(new ApplicationStatusChangedNotification($application));

    $this->actingAs($userB)->get(route('notifications.index'))
        ->assertOk()
        ->assertDontSee('Klus D');
});

test('melding markeren als gelezen werkt', function () {
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $client = User::factory()->create(['role' => 'client']);
    $category = Category::create(['name' => 'Test']);
    $commission = Commission::create(['title' => 'Klus E', 'budget' => 500, 'deadline' => now()->addDays(10), 'category_id' => $category->id, 'user_id' => $client->id]);
    $application = Application::create(['commission_id' => $commission->id, 'user_id' => $freelancer->id, 'status' => 'accepted']);

    $freelancer->notify(new ApplicationStatusChangedNotification($application));
    $notification = $freelancer->unreadNotifications()->first();

    $this->actingAs($freelancer)->patch(route('notifications.read', $notification->id));

    expect($freelancer->fresh()->unreadNotifications()->count())->toBe(0);
});

test('alle meldingen markeren als gelezen werkt', function () {
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $client = User::factory()->create(['role' => 'client']);
    $category = Category::create(['name' => 'Test']);
    $commission = Commission::create(['title' => 'Klus F', 'budget' => 500, 'deadline' => now()->addDays(10), 'category_id' => $category->id, 'user_id' => $client->id]);
    $application = Application::create(['commission_id' => $commission->id, 'user_id' => $freelancer->id, 'status' => 'accepted']);

    $freelancer->notify(new ApplicationStatusChangedNotification($application));
    $freelancer->notify(new ApplicationStatusChangedNotification($application));

    $this->actingAs($freelancer)->patch(route('notifications.read-all'));

    expect($freelancer->fresh()->unreadNotifications()->count())->toBe(0);
});
