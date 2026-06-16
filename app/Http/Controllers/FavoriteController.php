<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\Commission;
use App\Models\Favorite;
=======
use Illuminate\Http\Request;
use App\Models\Commission;
>>>>>>> 7dd6caf42c19ba790f10fb5dfe4920f9ceb79ce0
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
<<<<<<< HEAD
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
=======
        public function toggle(Commission $commission)
    {
        $user = Auth::user();

        if ($user->favorites()->where('commission_id', $commission->id)->exists()) {
            $user->favorites()->detach($commission->id);
            $message = 'Verwijderd uit favorieten.';
        } else {
            $user->favorites()->attach($commission->id);
            $message = 'Toegevoegd aan favorieten!';
        }

        return back()->with('success', $message);
    }

    public function index()
    {
        $favorites = Auth::user()->favorites()->with('category')->latest()->get();
        return view('favorites.index', compact('favorites'));
>>>>>>> 7dd6caf42c19ba790f10fb5dfe4920f9ceb79ce0
    }
}
