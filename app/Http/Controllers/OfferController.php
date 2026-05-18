<?php

namespace App\Http\Controllers;

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
        ]);

        Mail::to(Auth::user()->email)->send(new OfferSubmitted($offer));

        return back()->with('success', 'Offerte verstuurd!');
    }

    public function accept(Offer $offer)
    {
        // check: alleen eigenaar van opdracht
        if ($offer->commission->user_id !== auth()->id()) {
            abort(403);
        }

        // 1. Zet alle andere offers op rejected
        Offer::where('commission_id', $offer->commission_id)
            ->where('id', '!=', $offer->id)
            ->update(['status' => 'rejected']);

        // 2. Zet deze offer op accepted
        $offer->update(['status' => 'accepted']);

        return back()->with('success', 'Offerte geaccepteerd!');
    }
}
