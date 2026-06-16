<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommissionStoreRequest;
use App\Models\Category;
use App\Models\Commission;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class   CommissionController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $commissions = $this->buildFilteredQuery($request)->get();

        return view('commissions.index', compact('commissions', 'categories'));
    }

    public function search(Request $request)
    {
        $categories = Category::all();
        $commissions = $this->buildFilteredQuery($request)->get();

        return view('commissions.index', compact('commissions', 'categories'));
    }

    private function buildFilteredQuery(Request $request)
    {
        $query = Commission::with('category');

        if (auth()->check() && auth()->user()->isClient()) {
            $query->where('user_id', auth()->id());
        }

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->q.'%')
                    ->orWhere('description', 'like', '%'.$request->q.'%');
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('budget_min')) {
            $query->where('budget', '>=', (float) $request->budget_min);
        }

        if ($request->filled('budget_max')) {
            $query->where('budget', '<=', (float) $request->budget_max);
        }

        match ($request->get('sort', 'newest')) {
            'budget_desc' => $query->orderByDesc('budget'),
            'budget_asc' => $query->orderBy('budget'),
            'deadline_asc' => $query->orderBy('deadline'),
            default => $query->latest(),
        };

        return $query;
    }

<<<<<<< HEAD
=======
    public function search(Request $request)
    {
        $categories = Category::all();
        $query = Commission::with('category');

        if (auth()->check() && auth()->user()->isClient()) {
            $query->where('user_id', auth()->id());
        }

        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        $commissions = $query->get();
        return view('commissions.index', compact('commissions', 'categories'));
    }

>>>>>>> 7dd6caf42c19ba790f10fb5dfe4920f9ceb79ce0
    public function create()
    {
        $categories = Category::all();

        return view('commissions.create', compact('categories'));
    }

    public function store(CommissionStoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('commissions', 'public');
        }

        Commission::create($data);

        return redirect()->route('commissions.index')->with('success', 'Commission created successfully.');
    }

    public function show(Commission $commission)
    {
        $commission->load(['applications.freelancer', 'offers.user']);

        return view('commissions.show', compact('commission'));
    }

    public function edit(Commission $commission)
    {
        $this->authorize('update', $commission);

        $categories = Category::all();

        return view('commissions.edit', compact('commission', 'categories'));
    }

    public function update(CommissionStoreRequest $request, Commission $commission)
    {
        $this->authorize('update', $commission);

        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($commission->image) {
                Storage::disk('public')->delete($commission->image);
            }

            $data['image'] = $request->file('image')->store('commissions', 'public');
        }

        $commission->update($data);

        return redirect()->route('commissions.show', $commission)->with('success', 'Commission updated successfully.');
    }

    public function destroy(Commission $commission)
    {
        $this->authorize('delete', $commission);

        if ($commission->image) {
            Storage::disk('public')->delete($commission->image);
        }

        $commission->delete();

        return redirect()->route('commissions.index')->with('success', 'Commission deleted successfully.');
    }

    public function pdf(Commission $commission)
    {
        $commission->load('category', 'user');
        $pdf = Pdf::loadView('commissions.pdf', compact('commission'));

        return $pdf->download('commission_'.$commission->id.'.pdf');
    }
}
