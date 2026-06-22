<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $commissions = Auth::user()
            ->favoritedCommissions()
            ->with('category')
            ->latest('favorites.created_at')
            ->get();

        return view('favorites.index', compact('commissions'));
    }

    public function toggle(Commission $commission)
    {
        $existing = Favorite::where('user_id', Auth::id())
            ->where('commission_id', $commission->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $isFavorited = false;
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'commission_id' => $commission->id,
            ]);
            $isFavorited = true;
        }

        if (request()->wantsJson()) {
            return response()->json(['favorited' => $isFavorited]);
        }

        return back()->with('success', $isFavorited ? 'Saved to favorites.' : 'Removed from favorites.');
    }
}
