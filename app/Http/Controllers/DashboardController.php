<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function freelancer()
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user->isFreelancer()) {
            abort(403, 'Access denied. Freelancer account required.');
        }

        return view('dashboard.freelancer');
    }

    public function client()
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user->isClient()) {
            abort(403, 'Access denied. Client account required.');
        }

        return view('dashboard.client');
    }
}
