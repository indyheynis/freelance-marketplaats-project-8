<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Category;
use App\Models\Commission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function freelancer()
    {
        /** @var User $user */
        $user = Auth::user();

        if (! $user->isFreelancer() && ! $user->isAdmin()) {
            abort(403, 'Access denied. Freelancer account required.');
        }

        $skills = array_map('strtolower', (array) ($user->skills ?? []));
        $matchingCommissions = collect();

        if (! empty($skills)) {
            $matchingCommissions = Commission::with(['category', 'applications'])
                ->where('status', 'open')
                ->where('user_id', '!=', $user->id)
                ->whereHas('category', function ($query) use ($skills) {
                    $query->whereRaw('LOWER(name) IN ('.implode(',', array_fill(0, count($skills), '?')).')', $skills);
                })
                ->latest()
                ->take(6)
                ->get();
        }

        return view('dashboard.freelancer', compact('matchingCommissions', 'skills'));
    }

    public function client()
    {
        /** @var User $user */
        $user = Auth::user();

        if (! $user->isClient() && ! $user->isAdmin()) {
            abort(403, 'Access denied. Client account required.');
        }

        return view('dashboard.client');
    }

    public function admin()
    {
        $stats = [
            'totalUsers' => User::count(),
            'totalFreelancers' => User::where('role', 'freelancer')->count(),
            'totalClients' => User::where('role', 'client')->count(),
            'openCommissions' => Commission::where('status', 'open')->count(),
            'closedCommissions' => Commission::where('status', 'closed')->count(),
            'totalApplications' => Application::count(),
            'avgBudget' => Commission::avg('budget') ?? 0,
        ];

        $commissionsByCategory = Category::withCount(['commissions' => function ($query) {
            $query->where('status', 'open');
        }])
            ->get()
            ->filter(fn ($category) => $category->commissions_count > 0)
            ->sortByDesc('commissions_count')
            ->values();

        return view('dashboard.admin', compact('stats', 'commissionsByCategory'));
    }
}
