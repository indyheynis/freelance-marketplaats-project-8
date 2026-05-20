<?php

namespace App\Http\Controllers;

use App\Mail\OfferStatusChanged;
use App\Mail\OfferSubmitted;
use App\Models\Application;
use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = Application::with('commission.category')
            ->where('user_id', Auth::id())
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->get();

        return view('applications.index', compact('applications'));
    }

    public function store(Request $request, Commission $commission)
    {
        $alreadyApplied = Application::where('commission_id', $commission->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($alreadyApplied) {
            return back()->with('error', 'Je hebt al gesolliciteerd op deze commission.');
        }

        $request->validate([
            'message' => 'nullable|string|max:1000',
        ]);

        $application = Application::create([
            'commission_id' => $commission->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'status' => 'pending',
        ]);

        Mail::to(Auth::user()->email)
            ->send(new OfferSubmitted($application));

        return back()->with('success', 'Je sollicitatie is verstuurd!');
    }

    public function destroy(Application $application)
    {
        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        $application->delete();

        return back()->with('success', 'Sollicitatie ingetrokken.');
    }

    public function accept(Application $application)
    {
        if ($application->commission->user_id !== Auth::id()) {
            abort(403);
        }

        $application->update([
            'status' => 'accepted'
        ]);

        Mail::to($application->freelancer->email)
            ->send(new OfferStatusChanged($application));

        // Reject all other applications for this commission
        Application::where('commission_id', $application->commission_id)
            ->where('id', '!=', $application->id)
            ->update(['status' => 'rejected']);

        return back()->with('success', 'Sollicitatie geaccepteerd!');
    }

    public function reject(Application $application)
    {
        if ($application->commission->user_id !== Auth::id()) {
            abort(403);
        }

        $application->update([
            'status' => 'rejected'
        ]);

        Mail::to($application->freelancer->email)
            ->send(new OfferStatusChanged($application));

        return back()->with('success', 'Sollicitatie afgewezen.');
    }
}
