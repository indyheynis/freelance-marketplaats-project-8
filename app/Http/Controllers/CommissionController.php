<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\Category;
use Illuminate\Http\Request;

class CommissionController extends Controller
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

        $commissions = $query->get();
        return view('commissions.index', compact('commissions', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('commissions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'budget' => 'nullable|numeric',
            'deadline' => 'nullable|date',
            'category_id' => 'required|exists:categories,id',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        Commission::create($data);

        return redirect()->route('commissions.index')->with('success', 'Commission created successfully.');
    }

    public function show(Commission $commission)
    {
        $commission->load('applications.freelancer');
        return view('commissions.show', compact('commission'));
    }

    public function edit(Commission $commission)
    {
        $categories = Category::all();
        return view('commissions.edit', compact('commission', 'categories'));
    }

    public function update(Request $request, Commission $commission)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'budget' => 'nullable|numeric',
            'deadline' => 'nullable|date',
            'category_id' => 'required|exists:categories,id',
        ]);

        $commission->update($request->all());

        return redirect()->route('commissions.show', $commission)->with('success', 'Commission updated successfully.');
    }

    public function destroy(Commission $commission)
    {
        $commission->delete();

        return redirect()->route('commissions.index')->with('success', 'Commission deleted successfully.');
    }
}
