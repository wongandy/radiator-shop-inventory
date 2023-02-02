<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;

class BranchController extends Controller
{
    public function index(): View
    {
        $branches = Branch::latest()->paginate(5);
        
        return view('branches.index', compact('branches'));
    }

    public function create(): View
    {
        return view('branches.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:branches'],
        ]);

        Branch::create($request->only('name'));

        return to_route('branches.index')->with('success', 'Branch created successfully!');
    }

    public function show(Branch $branch)
    {
        //
    }

    public function edit(Branch $branch): View
    {
        return view('branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('branches')->ignore($branch)],
        ]);

        $branch->update($request->only('name'));

        return to_route('branches.index')->with('success', 'Branch updated successfully!');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();

        return to_route('branches.index')->with('success', 'Branch deleted successfully!');
    }
}
