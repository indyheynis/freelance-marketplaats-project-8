<?php

use App\Models\Review;
use App\Models\User;

test('admin can view all reviews', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    Review::factory()->count(3)->create();

    $response = $this->actingAs($admin)->get(route('admin.reviews.index'));

    $response->assertOk();
});

test('non-admin cannot access admin reviews index', function () {
    $client = User::factory()->create(['role' => 'client']);

    $response = $this->actingAs($client)->get(route('admin.reviews.index'));

    $response->assertForbidden();
});

test('admin can view create review form', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get(route('admin.reviews.create'));

    $response->assertOk();
});

test('admin can create a review', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $review = Review::factory()->make();

    $response = $this->actingAs($admin)->post(route('admin.reviews.store'), [
        'commission_id' => $review->commission_id,
        'reviewer_id' => $review->reviewer_id,
        'reviewee_id' => $review->reviewee_id,
        'rating' => 4,
        'comment' => 'Great work!',
    ]);

    $response->assertRedirect(route('admin.reviews.index'));
    $this->assertDatabaseHas('reviews', ['rating' => 4, 'comment' => 'Great work!']);
});

test('admin can view edit review form', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $review = Review::factory()->create();

    $response = $this->actingAs($admin)->get(route('admin.reviews.edit', $review));

    $response->assertOk();
});

test('admin can update a review', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $review = Review::factory()->create(['rating' => 3, 'comment' => 'Old comment']);

    $response = $this->actingAs($admin)->put(route('admin.reviews.update', $review), [
        'rating' => 5,
        'comment' => 'Updated comment',
    ]);

    $response->assertRedirect(route('admin.reviews.index'));
    $this->assertDatabaseHas('reviews', ['id' => $review->id, 'rating' => 5, 'comment' => 'Updated comment']);
});

test('admin can delete a review', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $review = Review::factory()->create();

    $response = $this->actingAs($admin)->delete(route('admin.reviews.destroy', $review));

    $response->assertRedirect(route('admin.reviews.index'));
    $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
});

test('rating must be between 1 and 5 when updating', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $review = Review::factory()->create(['rating' => 3]);

    $response = $this->actingAs($admin)->put(route('admin.reviews.update', $review), [
        'rating' => 6,
    ]);

    $response->assertSessionHasErrors('rating');
    $this->assertDatabaseHas('reviews', ['id' => $review->id, 'rating' => 3]);
});
