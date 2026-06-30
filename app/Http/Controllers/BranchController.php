<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        $query = Branch::query();
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where('name', 'like', "%{$keyword}%");
        }
        $branches = $query->with(['lokasi' => fn($q) => $q->select('id','branch_id','name','code')->orderBy('code')])
                         ->withCount('lokasi')->latest()->paginate(15);

        $lokasiList = Lokasi::orderBy('name')->get(['id', 'name', 'code']);

        return view('branch.index', compact('branches', 'lokasiList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'lokasi_id' => 'nullable|exists:locations,id',
        ]);

        $branch = Branch::create(['name' => $request->name]);

        if ($request->filled('lokasi_id')) {
            Lokasi::where('id', $request->lokasi_id)
                  ->update(['branch_id' => $branch->id]);
        }

        return back()->with('success', 'Branch berhasil ditambahkan.');
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $branch->update(['name' => $request->name]);

        return back()->with('success', 'Branch berhasil diperbarui.');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return back()->with('success', 'Branch berhasil dihapus.');
    }
}
