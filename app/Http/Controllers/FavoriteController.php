<?php

namespace App\Http\Controllers;

use App\Models\Commission;
<<<<<<< HEAD
use App\Models\Favorite;
=======
>>>>>>> ace4f4b5cfad5e473da473df4460e5b088f4cdab
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()
            ->favorites()
            ->with('category')
            ->latest()
            ->get();

        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Commission $commission)
    {
<<<<<<< HEAD
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
=======
        $user = Auth::user();

        if ($user->favorites()->where('commission_id', $commission->id)->exists()) {
            $user->favorites()->detach($commission->id);
            $message = 'Verwijderd uit favorieten.';
        } else {
            $user->favorites()->attach($commission->id);
            $message = 'Toegevoegd aan favorieten!';
        }

        return back()->with('success', $message);
>>>>>>> ace4f4b5cfad5e473da473df4460e5b088f4cdab
    }
}
