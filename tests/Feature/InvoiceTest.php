<?php

use App\Models\Category;
use App\Models\Commission;
use App\Models\Invoice;
use App\Models\Offer;
use App\Models\User;

// Factuur aanmaken bij accepteren offerte
test('accepteren van een offerte maakt automatisch een factuur aan', function () {
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
    $offer = Offer::create([
        'user_id' => $freelancer->id,
        'commission_id' => $commission->id,
        'price' => 1750,
        'message' => 'Ik bouw dit graag.',
    ]);

    $this->actingAs($client)->post("/offers/{$offer->id}/accept");

    $this->assertDatabaseHas('invoices', [
        'offer_id' => $offer->id,
        'commission_id' => $commission->id,
        'client_id' => $client->id,
        'freelancer_id' => $freelancer->id,
        'amount' => 1750,
        'status' => 'pending',
    ]);
});

test('factuur krijgt een uniek factuurnummer in het formaat INV-JAAR-NNNNN', function () {
    $client = User::factory()->create(['role' => 'client']);
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $category = Category::create(['name' => 'Design']);
    $commission = Commission::create([
        'title' => 'Logo ontwerp',
        'budget' => 500,
        'deadline' => now()->addDays(14)->format('Y-m-d'),
        'category_id' => $category->id,
        'user_id' => $client->id,
    ]);
    $offer = Offer::create([
        'user_id' => $freelancer->id,
        'commission_id' => $commission->id,
        'price' => 400,
        'message' => 'Mijn ontwerp.',
    ]);

    $this->actingAs($client)->post("/offers/{$offer->id}/accept");

    $invoice = Invoice::where('offer_id', $offer->id)->firstOrFail();
    expect($invoice->invoice_number)->toMatch('/^INV-\d{4}-\d{5}$/');
});

test('opdracht gaat naar in_progress bij accepteren van een offerte', function () {
    $client = User::factory()->create(['role' => 'client']);
    $freelancer = User::factory()->create(['role' => 'freelancer']);
    $category = Category::create(['name' => 'Marketing']);
    $commission = Commission::create([
        'title' => 'Campagne',
        'budget' => 800,
        'deadline' => now()->addDays(21)->format('Y-m-d'),
        'category_id' => $category->id,
        'user_id' => $client->id,
    ]);
    $offer = Offer::create([
        'user_id' => $freelancer->id,
        'commission_id' => $commission->id,
        'price' => 700,
        'message' => 'Ik doe dit.',
    ]);

    $this->actingAs($client)->post("/offers/{$offer->id}/accept");

    $this->assertDatabaseHas('commissions', ['id' => $commission->id, 'status' => 'in_progress']);
});

// Factuur inzien
test('opdrachtgever kan eigen factuur bekijken', function () {
    $invoice = Invoice::factory()->create();

    $response = $this->actingAs($invoice->client)->get("/invoices/{$invoice->id}");

    $response->assertOk();
});

test('freelancer kan eigen factuur bekijken', function () {
    $invoice = Invoice::factory()->create();

    $response = $this->actingAs($invoice->freelancer)->get("/invoices/{$invoice->id}");

    $response->assertOk();
});

test('derde partij heeft geen toegang tot factuur', function () {
    $invoice = Invoice::factory()->create();
    $stranger = User::factory()->create(['role' => 'client']);

    $response = $this->actingAs($stranger)->get("/invoices/{$invoice->id}");

    $response->assertForbidden();
});

// PDF download
test('factuur PDF download werkt voor de opdrachtgever', function () {
    $invoice = Invoice::factory()->create();

    $response = $this->actingAs($invoice->client)->get("/invoices/{$invoice->id}/download");

    $response->assertOk();
    $response->assertHeader('Content-Type', 'application/pdf');
});

test('factuur PDF download is niet toegankelijk voor derden', function () {
    $invoice = Invoice::factory()->create();
    $stranger = User::factory()->create(['role' => 'freelancer']);

    $response = $this->actingAs($stranger)->get("/invoices/{$invoice->id}/download");

    $response->assertForbidden();
});

// Factuur als betaald markeren
test('opdrachtgever kan factuur markeren als betaald', function () {
    $invoice = Invoice::factory()->create();

    $this->actingAs($invoice->client)->patch("/invoices/{$invoice->id}/mark-paid");

    $this->assertDatabaseHas('invoices', ['id' => $invoice->id, 'status' => 'paid']);
    $invoice->refresh();
    expect($invoice->paid_at)->not->toBeNull();
});

test('freelancer kan een factuur niet markeren als betaald', function () {
    $invoice = Invoice::factory()->create();

    $response = $this->actingAs($invoice->freelancer)->patch("/invoices/{$invoice->id}/mark-paid");

    $response->assertForbidden();
    $this->assertDatabaseHas('invoices', ['id' => $invoice->id, 'status' => 'pending']);
});

// Factuurlijst
test('factuurlijst toont alleen eigen facturen van de opdrachtgever', function () {
    $invoiceA = Invoice::factory()->create();
    $invoiceB = Invoice::factory()->create();

    $response = $this->actingAs($invoiceA->client)->get('/invoices');

    $response->assertOk();
    $response->assertSee($invoiceA->invoice_number);
    $response->assertDontSee($invoiceB->invoice_number);
});

test('factuurlijst toont alleen eigen facturen van de freelancer', function () {
    $invoiceA = Invoice::factory()->create();
    $invoiceB = Invoice::factory()->create();

    $response = $this->actingAs($invoiceA->freelancer)->get('/invoices');

    $response->assertOk();
    $response->assertSee($invoiceA->invoice_number);
    $response->assertDontSee($invoiceB->invoice_number);
});
