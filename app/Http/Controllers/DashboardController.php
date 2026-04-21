<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
     public function freelancer()
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user->isFreelancer()) {
            return redirect()->route('dashboard.client');
        }

        return view('dashboard.freelancer');
    }

    public function client()
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user->isClient()) {
            return redirect()->route('dashboard.freelancer');
        }

        return view('dashboard.client');
    }
}
