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

        return view('branch.index', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'lokasi_name' => 'nullable|string|max:255',
            'lokasi_code' => 'nullable|string|max:255',
        ]);

        $branch = Branch::create(['name' => $request->name]);

        if ($request->filled('lokasi_name')) {
            Lokasi::create([
                'branch_id' => $branch->id,
                'name'      => $request->lokasi_name,
                'code'      => $request->lokasi_code ?? $request->lokasi_name,
                'status'    => 'belum',
            ]);
        }

        return back()->with('success', 'Branch berhasil ditambahkan.');
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'lokasi_name' => 'nullable|string|max:255',
            'lokasi_code' => 'nullable|string|max:255',
        ]);

        $branch->update(['name' => $request->name]);

        if ($request->filled('lokasi_name')) {
            Lokasi::create([
                'branch_id' => $branch->id,
                'name'      => $request->lokasi_name,
                'code'      => $request->lokasi_code ?? $request->lokasi_name,
                'status'    => 'belum',
            ]);
        }

        return back()->with('success', 'Branch berhasil diperbarui.');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return back()->with('success', 'Branch berhasil dihapus.');
    }
}
