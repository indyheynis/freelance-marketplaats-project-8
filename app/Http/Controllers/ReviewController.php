<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Commission $commission): RedirectResponse
    {
        abort_if($commission->user_id !== auth()->id(), 403);
        abort_if(
            $commission->reviews()->where('reviewer_id', auth()->id())->exists(),
            422,
            'Je hebt al een review achtergelaten voor deze opdracht.'
        );

        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', function ($attribute, $value, $fail) {
                if ($value && str_word_count($value) > 200) {
                    $fail('De review mag maximaal 200 woorden bevatten.');
                }
            }],
        ]);

        $commission->reviews()->create([
            'reviewer_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('review_success', 'Jouw review is geplaatst!');
    }
}
