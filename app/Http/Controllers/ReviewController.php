<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\Review;
use App\Models\User;
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

            'comment' => ['nullable', 'string', function ($_attribute, $value, $fail) {
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

    public function adminIndex(): View
    {
        $reviews = Review::query()
            ->with('reviewer', 'reviewee', 'commission')
            ->latest()
            ->paginate(20);

        return view('reviews.admin.index', compact('reviews'));
    }

    public function create(): View
    {
        $commissions = Commission::query()->with('user')->latest()->get();
        $clients = User::query()->where('role', 'client')->orderBy('firstname', 'asc')->get();
        $freelancers = User::query()->where('role', 'freelancer')->orderBy('firstname', 'asc')->get();

        return view('reviews.admin.create', compact('commissions', 'clients', 'freelancers'));
    }

    public function adminStore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'commission_id' => ['required', 'exists:commissions,id'],
            'reviewer_id' => ['required', 'exists:users,id'],
            'reviewee_id' => ['required', 'exists:users,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:5000'],
        ]);

        Review::create($data);

        return redirect()->route('admin.reviews.index')->with('success', __('Review created.'));
    }

    public function edit(Review $review): View
    {
        $review->load('reviewer', 'reviewee', 'commission');

        return view('reviews.admin.edit', compact('review'));
    }

    public function update(Request $request, Review $review): RedirectResponse
    {
        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:5000'],
        ]);

        $review->update($data);

        return redirect()->route('admin.reviews.index')->with('success', __('Review updated.'));
    }

    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', __('Review deleted.'));
    }
}
