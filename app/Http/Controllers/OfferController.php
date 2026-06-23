<?php

namespace App\Http\Controllers;

use App\Mail\OfferReceived;
use App\Mail\OfferStatusChanged;
use App\Mail\OfferSubmitted;
use App\Models\Commission;
use App\Models\Invoice;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OfferController extends Controller
{
    public function store(Request $request)
    {
        $offer = Offer::create([
            'user_id' => $user->id,
            'commission_id' => $commission->id,
            'price' => $request->price,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        $offer->load(['user', 'commission.user']);

        Mail::to($offer->user->email)->send(new OfferSubmitted($offer));
        Mail::to($offer->commission->user->email)->send(new OfferReceived($offer));

        return back()->with('success', __('Offer sent!'));
    }

    public function accept(Offer $offer)
    {
        if ($offer->commission->user_id !== Auth::id()) {
            abort(403);
        }

        $otherOffers = Offer::query()
            ->with('user')
            ->where('commission_id', $offer->commission_id)
            ->where('id', '!=', $offer->id)
            ->get();

        foreach ($otherOffers as $otherOffer) {
            $otherOffer->update(['status' => 'rejected']);
            Mail::to($otherOffer->user->email)->send(new OfferStatusChanged($otherOffer));
        }

        $offer->update(['status' => 'accepted']);

        $commission = $offer->commission;
        $commission->update(['status' => 'in_progress']);

        Mail::to($offer->user->email)->send(new OfferStatusChanged($offer));

        Invoice::create([
            'invoice_number' => Invoice::generateNumber(),
            'offer_id' => $offer->id,
            'commission_id' => $offer->commission_id,
            'client_id' => Auth::id(),
            'freelancer_id' => $offer->user_id,
            'amount' => $offer->price,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Offer accepted!');
    }
}
