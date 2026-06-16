<?php

namespace App\Http\Controllers;

use App\Models\Commission;
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
}
