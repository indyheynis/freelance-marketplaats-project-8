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
            'You have already left a review for this commission.'
        );

        $acceptedApplication = $commission->applications()->where('status', 'accepted')->first();
        abort_if($acceptedApplication === null, 422, 'There is no accepted freelancer for this commission.');

        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],

            'comment' => ['nullable', 'string', function ($attribute, $value, $fail) {
                if ($value && str_word_count($value) > 200) {
                    $fail('The review may contain a maximum of 200 words.');
                }
            }],
        ]);

        $commission->reviews()->create([
            'reviewer_id' => Auth::id(),
            'reviewee_id' => $acceptedApplication->user_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('review_success', 'Your review has been posted!');
    }
}
