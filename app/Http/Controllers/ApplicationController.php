<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
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

        Application::create([
            'commission_id' => $commission->id,
            'user_id'       => Auth::id(),
            'message'       => $request->message,
            'status'        => 'pending',
        ]);

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
}
