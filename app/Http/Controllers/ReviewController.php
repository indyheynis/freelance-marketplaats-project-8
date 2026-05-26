<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(): View
    {
        $reviews = Auth::user()
            ->receivedReviews()
            ->with('reviewer', 'commission')
            ->latest()
            ->get();

        return view('reviews.index', compact('reviews'));
    }

    public function store(Request $request, Commission $commission): RedirectResponse
    {
        abort_if($commission->user_id !== Auth::id(), 403);
        abort_if(
            $commission->reviews()->where('reviewer_id', Auth::id())->exists(),
            422,
            'Je hebt al een review achtergelaten voor deze opdracht.'
        );

        $acceptedApplication = $commission->applications()->where('status', 'accepted')->first();
        abort_if($acceptedApplication === null, 422, 'Er is geen geaccepteerde freelancer voor deze opdracht.');

        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],

            'comment' => ['nullable', 'string', function ($attribute, $value, $fail) {
                if ($value && str_word_count($value) > 200) {
                    $fail('De review mag maximaal 200 woorden bevatten.');
                }
            }],
        ]);

        $commission->reviews()->create([
            'reviewer_id' => Auth::id(),
            'reviewee_id' => $acceptedApplication->user_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('review_success', 'Jouw review is geplaatst!');
    }
}
