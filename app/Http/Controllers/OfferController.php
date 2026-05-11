<?php

namespace App\Http\Controllers;
use App\Models\Offer;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class OfferController extends Controller
{
        public function store(Request $request)
    {
        $request->validate([
            'commission_id' => 'required|exists:commissions,id',
            'price' => 'required|numeric',
            'message' => 'nullable|string',
        ]);

        Offer::create([
            'user_id' => Auth::id(),
            'commission_id' => $request->commission_id,
            'price' => $request->price,
            'message' => $request->message,
        ]);

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
