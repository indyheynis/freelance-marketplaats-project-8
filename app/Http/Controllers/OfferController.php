<?php

namespace App\Http\Controllers;

use App\Mail\OfferStatusChanged;
use App\Mail\OfferSubmitted;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OfferController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'commission_id' => 'required|exists:commissions,id',
            'price' => 'required|numeric',
            'message' => 'nullable|string',
        ]);

        $offer = Offer::create([
            'user_id' => Auth::id(),
            'commission_id' => $request->commission_id,
            'price' => $request->price,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        // laad relaties (veilig voor mail)
        $offer->load(['user', 'commission']);

        Mail::to($offer->user->email)
            ->send(new OfferSubmitted($offer));

        return back()->with('success', 'Offerte verstuurd!');
    }

    public function accept(Offer $offer)
    {
        // check: alleen eigenaar van opdracht
        if ($offer->commission->user_id !== auth()->id()) {
            abort(403);
        }

        // laad relaties
        $offer->load(['user', 'commission']);

        // alleen als nog niet geaccepteerd
        if ($offer->status === 'accepted') {
            return back()->with('success', 'Deze offerte is al geaccepteerd.');
        }

        // andere offertes ophalen
        $otherOffers = Offer::with('user')
            ->where('commission_id', $offer->commission_id)
            ->where('id', '!=', $offer->id)
            ->get();

        foreach ($otherOffers as $otherOffer) {

            if ($otherOffer->status !== 'rejected') {
                $otherOffer->update(['status' => 'rejected']);

                Mail::to($otherOffer->user->email)
                    ->send(new OfferStatusChanged($otherOffer));
            }
        }

        // accept offer
        $offer->update(['status' => 'accepted']);

        Mail::to($offer->user->email)
            ->send(new OfferStatusChanged($offer));

        return back()->with('success', 'Offerte geaccepteerd!');
    }
}