<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        $query = Branch::query();
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('code', 'like', "%{$keyword}%");
            });
        }
        $branches = $query->with(['lokasi' => fn($q) => $q->select('id','branch_id','name','code')->orderBy('code')])
                         ->withCount('lokasi')->latest()->paginate(15);
        return view('branch.index', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:branches,code',
        ]);

        Branch::create($request->only('name', 'code'));

        return back()->with('success', 'Branch berhasil ditambahkan.');
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:branches,code,' . $branch->id,
        ]);

        $branch->update($request->only('name', 'code'));

        return back()->with('success', 'Branch berhasil diperbarui.');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return back()->with('success', 'Branch berhasil dihapus.');
    }
}
