<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationStatusChanged;
use App\Mail\ApplicationSubmitted;
use App\Models\Application;
use App\Models\Commission;
use App\Models\Invoice;
use App\Notifications\ApplicationStatusChangedNotification;
use App\Notifications\NewApplicationNotification;
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
            return back()->with('error', 'You have already applied for this commission.');
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
            ->send(new ApplicationSubmitted($application));

        $commission->user->notify(new NewApplicationNotification($application));

        return back()->with('success', 'Your application has been sent!');
    }

    public function destroy(Application $application)
    {
        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        $application->delete();

        return back()->with('success', 'Application withdrawn.');
    }

    public function accept(Application $application)
    {
        if ($application->commission->user_id !== Auth::id()) {
            abort(403);
        }

        $application->update([
            'status' => 'accepted',
        ]);

        $application->commission->update(['status' => 'in_progress']);

        Mail::to($application->freelancer->email)
            ->send(new ApplicationStatusChanged($application));

        $application->freelancer->notify(new ApplicationStatusChangedNotification($application));

        // Reject all other applications for this commission
        Application::where('commission_id', $application->commission_id)
            ->where('id', '!=', $application->id)
            ->update(['status' => 'rejected']);

        Invoice::create([
            'invoice_number' => Invoice::generateNumber(),
            'offer_id' => null,
            'commission_id' => $application->commission_id,
            'client_id' => Auth::id(),
            'freelancer_id' => $application->user_id,
            'amount' => $application->commission->budget,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Application accepted!');
    }

    public function reject(Application $application)
    {
        if ($application->commission->user_id !== Auth::id()) {
            abort(403);
        }

        $application->update([
            'status' => 'rejected',
        ]);

        Mail::to($application->freelancer->email)
            ->send(new ApplicationStatusChanged($application));

        $application->freelancer->notify(new ApplicationStatusChangedNotification($application));

        return back()->with('success', 'Application rejected.');
    }
}
