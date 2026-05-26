<?php

<<<<<<< HEAD
use App\Mail\OfferReceived;
=======
use App\Mail\OfferStatusChanged;
>>>>>>> e1e47ddf3abae5f5faaa90f54b2293f1fab3e610
use App\Models\Category;
use App\Models\Commission;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

// Offertes bekijken
test('opdrachtgever kan offertes zien op eigen opdracht', function () {
    $client = User::factory()->create(['role' => 'client']);
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $category = Category::create(['name' => 'Development']);
    $commission = Commission::create([
        'title' => 'Website bouwen',
        'budget' => 2000,
        'deadline' => now()->addDays(30)->format('Y-m-d'),
        'category_id' => $category->id,
        'user_id' => $client->id,
    ]);

    Offer::create([
        'user_id' => $freelancer->id,
        'commission_id' => $commission->id,
        'price' => 1750,
        'message' => 'Ik kan dit voor jullie bouwen.',
    ]);

    $response = $this->actingAs($client)->get("/commissions/{$commission->id}");

    $response->assertSuccessful();
});

test('opdrachtgever kan meerdere offertes vergelijken op eigen opdracht', function () {
    $client = User::factory()->create(['role' => 'client']);
    $freelancer1 = User::factory()->create(['role' => 'freelancer']);
    $freelancer2 = User::factory()->create(['role' => 'freelancer']);
    $category = Category::create(['name' => 'Design']);
    $commission = Commission::create([
        'title' => 'Logo ontwerp',
        'budget' => 500,
        'deadline' => now()->addDays(14)->format('Y-m-d'),
        'category_id' => $category->id,
        'user_id' => $client->id,
    ]);

    Offer::create([
        'user_id' => $freelancer1->id,
        'commission_id' => $commission->id,
        'price' => 400,
        'message' => 'Offerte van freelancer 1',
    ]);

    Offer::create([
        'user_id' => $freelancer2->id,
        'commission_id' => $commission->id,
        'price' => 450,
        'message' => 'Offerte van freelancer 2',
    ]);

    $this->assertDatabaseCount('offers', 2);
    $this->assertDatabaseHas('offers', ['user_id' => $freelancer1->id, 'commission_id' => $commission->id]);
    $this->assertDatabaseHas('offers', ['user_id' => $freelancer2->id, 'commission_id' => $commission->id]);
});

// Offerte accepteren
test('opdrachtgever kan een offerte accepteren', function () {
    $client = User::factory()->create(['role' => 'client']);
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $category = Category::create(['name' => 'Marketing']);
    $commission = Commission::create([
        'title' => 'Social media campagne',
        'budget' => 800,
        'deadline' => now()->addDays(21)->format('Y-m-d'),
        'category_id' => $category->id,
        'user_id' => $client->id,
    ]);

    $offer = Offer::create([
        'user_id' => $freelancer->id,
        'commission_id' => $commission->id,
        'price' => 700,
        'message' => 'Ik pak dit graag op.',
    ]);

    $response = $this->actingAs($client)->post("/offers/{$offer->id}/accept");

    $response->assertRedirect();
    $this->assertDatabaseHas('offers', [
        'id' => $offer->id,
        'status' => 'accepted',
    ]);
});

test('freelancer ontvangt email bij geaccepteerde en afgewezen offertes', function () {
    Mail::fake();

    $client = User::factory()->create(['role' => 'client']);
    $freelancer1 = User::factory()->create(['role' => 'freelancer']);
    $freelancer2 = User::factory()->create(['role' => 'freelancer']);
    $freelancer3 = User::factory()->create(['role' => 'freelancer']);
    $category = Category::create(['name' => 'Marketing']);
    $commission = Commission::create([
        'title' => 'Social media campagne',
        'budget' => 800,
        'deadline' => now()->addDays(21)->format('Y-m-d'),
        'category_id' => $category->id,
        'user_id' => $client->id,
    ]);

    $acceptedOffer = Offer::create([
        'user_id' => $freelancer1->id,
        'commission_id' => $commission->id,
        'price' => 700,
        'message' => 'Ik pak dit graag op.',
    ]);

    $rejectedOffer1 = Offer::create([
        'user_id' => $freelancer2->id,
        'commission_id' => $commission->id,
        'price' => 720,
        'message' => 'Ook goed.',
    ]);

    $rejectedOffer2 = Offer::create([
        'user_id' => $freelancer3->id,
        'commission_id' => $commission->id,
        'price' => 740,
        'message' => 'Mijn bod.',
    ]);

    $response = $this->actingAs($client)->post("/offers/{$acceptedOffer->id}/accept");

    $response->assertRedirect();

    Mail::assertSent(OfferStatusChanged::class, 3);
    Mail::assertSent(OfferStatusChanged::class, function ($mail) use ($freelancer1) {
        return $mail->hasTo($freelancer1->email) && $mail->offer->status === 'accepted';
    });
    Mail::assertSent(OfferStatusChanged::class, function ($mail) use ($freelancer2) {
        return $mail->hasTo($freelancer2->email) && $mail->offer->status === 'rejected';
    });
    Mail::assertSent(OfferStatusChanged::class, function ($mail) use ($freelancer3) {
        return $mail->hasTo($freelancer3->email) && $mail->offer->status === 'rejected';
    });
});

test('accepteren van een offerte wijst andere offertes automatisch af', function () {
    $client = User::factory()->create(['role' => 'client']);
    $freelancer1 = User::factory()->create(['role' => 'freelancer']);
    $freelancer2 = User::factory()->create(['role' => 'freelancer']);
    $freelancer3 = User::factory()->create(['role' => 'freelancer']);
    $category = Category::create(['name' => 'Fotografie']);
    $commission = Commission::create([
        'title' => 'Productfoto sessie',
        'budget' => 600,
        'deadline' => now()->addDays(10)->format('Y-m-d'),
        'category_id' => $category->id,
        'user_id' => $client->id,
    ]);

    $acceptedOffer = Offer::create([
        'user_id' => $freelancer1->id,
        'commission_id' => $commission->id,
        'price' => 550,
        'message' => 'Top offerte.',
    ]);

    $rejectedOffer1 = Offer::create([
        'user_id' => $freelancer2->id,
        'commission_id' => $commission->id,
        'price' => 580,
        'message' => 'Ook goed.',
    ]);

    $rejectedOffer2 = Offer::create([
        'user_id' => $freelancer3->id,
        'commission_id' => $commission->id,
        'price' => 600,
        'message' => 'Mijn bod.',
    ]);

    $this->actingAs($client)->post("/offers/{$acceptedOffer->id}/accept");

    $this->assertDatabaseHas('offers', ['id' => $acceptedOffer->id, 'status' => 'accepted']);
    $this->assertDatabaseHas('offers', ['id' => $rejectedOffer1->id, 'status' => 'rejected']);
    $this->assertDatabaseHas('offers', ['id' => $rejectedOffer2->id, 'status' => 'rejected']);
});

test('opdrachtgever kan geen offerte accepteren van een andere opdrachtgever zijn opdracht', function () {
    $owner = User::factory()->create(['role' => 'client']);
    $otherClient = User::factory()->create(['role' => 'client']);
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $category = Category::create(['name' => 'Content']);
    $commission = Commission::create([
        'title' => 'Blogartikelen schrijven',
        'budget' => 300,
        'deadline' => now()->addDays(7)->format('Y-m-d'),
        'category_id' => $category->id,
        'user_id' => $owner->id,
    ]);

    $offer = Offer::create([
        'user_id' => $freelancer->id,
        'commission_id' => $commission->id,
        'price' => 250,
        'message' => 'Ik schrijf graag.',
    ]);

    $response = $this->actingAs($otherClient)->post("/offers/{$offer->id}/accept");

    $response->assertForbidden();
    $this->assertDatabaseMissing('offers', ['id' => $offer->id, 'status' => 'accepted']);
});

test('freelancer kan geen offerte accepteren', function () {
    $client = User::factory()->create(['role' => 'client']);
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $category = Category::create(['name' => 'Video']);
    $commission = Commission::create([
        'title' => 'Promotievideo',
        'budget' => 1000,
        'deadline' => now()->addDays(14)->format('Y-m-d'),
        'category_id' => $category->id,
        'user_id' => $client->id,
    ]);

    $offer = Offer::create([
        'user_id' => $freelancer->id,
        'commission_id' => $commission->id,
        'price' => 900,
        'message' => 'Mijn offerte.',
    ]);

    $response = $this->actingAs($freelancer)->post("/offers/{$offer->id}/accept");

    $response->assertForbidden();
});

// Opdrachtgever dashboard
test('opdrachtgever kan het client dashboard bekijken', function () {
    $client = User::factory()->create(['role' => 'client']);

    $response = $this->actingAs($client)->get('/dashboard/client');

    $response->assertSuccessful();
});

test('freelancer heeft geen toegang tot het client dashboard', function () {
    $freelancer = User::factory()->create(['role' => 'freelancer']);

    $response = $this->actingAs($freelancer)->get('/dashboard/client');

    $response->assertForbidden();
});

test('gast wordt doorgestuurd naar login bij client dashboard', function () {
    $response = $this->get('/dashboard/client');

    $response->assertRedirect('/login');
});

test('opdrachtgever ontvangt een e-mail bij nieuwe offerte', function () {
    Mail::fake();

    $client = User::factory()->create(['role' => 'client']);
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $category = Category::create(['name' => 'Test']);
    $commission = Commission::create([
        'title' => 'Testproject',
        'budget' => 500,
        'deadline' => now()->addDays(14)->format('Y-m-d'),
        'category_id' => $category->id,
        'user_id' => $client->id,
    ]);

    $this->actingAs($freelancer)->post('/offers', [
        'commission_id' => $commission->id,
        'price' => 450,
        'message' => 'Ik doe dit graag.',
    ]);

    Mail::assertSent(OfferReceived::class, function (OfferReceived $mail) use ($client, $commission) {
        return $mail->hasTo($client->email)
            && $mail->offer->commission_id === $commission->id;
    });
});
