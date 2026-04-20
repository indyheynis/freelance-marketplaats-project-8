<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\Category;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index()
    {
        $commissions = Commission::with('category')->get();
        return view('commissions.index', compact('commissions'));
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
            'amount' => 'nullable|numeric',
            'budget' => 'nullable|numeric',
            'deadline' => 'nullable|date',
            'category_id' => 'required|exists:categories,id',
        ]);

        Commission::create($request->all());

        return redirect()->route('commissions.index')->with('success', 'Commission created successfully.');
    }

    public function show(Commission $commission)
    {
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
            'amount' => 'nullable|numeric',
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
