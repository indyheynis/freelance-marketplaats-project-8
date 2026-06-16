<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommissionStoreRequest;
use App\Models\Commission;
use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class   CommissionController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Commission::with('category');

        // Filter commissions based on user role
        if (auth()->check() && auth()->user()->isClient()) {
            $query->where('user_id', auth()->id());
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        $commissions = $query->get();
        return view('commissions.index', compact('commissions', 'categories'));
    }

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

    public function create()
    {
        $categories = Category::all();
        return view('commissions.create', compact('categories'));
    }

    public function store(CommissionStoreRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('commissions', 'public');
        }

        Commission::create($data);

        return redirect()->route('commissions.index')->with('success', 'Commission created successfully.');
    }

    public function show(Commission $commission)
    {
        // Clients can only view their own commissions
        if (auth()->check() && auth()->user()->isClient() && $commission->user_id !== auth()->id()) {
            abort(403, 'You can only view your own commissions.');
        }

        $commission->load(['applications.freelancer', 'offers.user']);
        return view('commissions.show', compact('commission'));
    }

    public function edit(Commission $commission)
    {
        $categories = Category::all();
        return view('commissions.edit', compact('commission', 'categories'));
    }

    public function update(CommissionStoreRequest $request, Commission $commission)
    {
        $data = $request->all();

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
        $commission->delete();

        return redirect()->route('commissions.index')->with('success', 'Commission deleted successfully.');
    }

    public function pdf(Commission $commission)
    {
        $commission->load('category', 'user');
        $pdf = Pdf::loadView('commissions.pdf', compact('commission'));
        return $pdf->download('commission_' . $commission->id . '.pdf');
    }
}
