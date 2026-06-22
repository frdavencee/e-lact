<?php

namespace App\Http\Controllers;

use App\Models\BoqItem;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class BoqController extends Controller
{
    public function globalIndex(Request $request)
    {
        $query = BoqItem::with(['lokasi', 'project']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('item_code', 'like', "%{$search}%")
                  ->orWhereHas('lokasi', function ($relation) use ($search) {
                      $relation->where('name', 'like', "%{$search}%")
                               ->orWhere('code', 'like', "%{$search}%");
                  });
            });
        }

        $items = $query->latest()->paginate(20);

        return view('boq.index', compact('items'));
    }

    public function create()
    {
        $lokasiList = \App\Models\Lokasi::with('branch')->orderBy('name')->get();
        $projectList = \App\Models\Project::orderBy('name')->get();

        return view('boq.create', compact('lokasiList', 'projectList'));
    }

    public function globalStore(Request $request)
    {
        $validated = $request->validate([
            'lokasi_id' => 'required|exists:locations,id',
            'kode_item' => 'nullable|string|max:80',
            'nama_item' => 'required|string|max:255',
            'volume' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'keterangan' => 'nullable|string|max:500',
        ]);

        \App\Models\Lokasi::findOrFail($validated['lokasi_id'])->boqItems()->create([
            'item_code' => $validated['kode_item'],
            'name' => $validated['nama_item'],
            'volume' => $validated['volume'],
            'unit' => $validated['satuan'],
            'price' => 0,
            'total' => 0,
            'notes' => $validated['keterangan'],
        ]);

        return redirect()->route('boq.index')
            ->with('success', 'Item BOQ berhasil ditambahkan.');
    }

    public function index(Lokasi $lokasi)
    {
        $items = $lokasi->boqItems()->latest()->get();
        return view('lokasi.partials.boq', compact('lokasi', 'items'));
    }

    public function report(Request $request)
    {
        abort(404);
    }

    public function store(Request $request, Lokasi $lokasi)
    {
        $validated = $request->validate([
            'kode_item' => 'nullable|string|max:80',
            'nama_item' => 'required|string|max:255',
            'volume' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $lokasi->boqItems()->create([
            'item_code' => $validated['kode_item'],
            'name' => $validated['nama_item'],
            'volume' => $validated['volume'],
            'unit' => $validated['satuan'],
            'price' => 0,
            'total' => 0,
            'notes' => $validated['keterangan'],
        ]);

        return back()->with('success', 'Item BOQ berhasil ditambahkan.');
    }

    public function update(Request $request, Lokasi $lokasi, BoqItem $boq)
    {
        $validated = $request->validate([
            'kode_item' => 'nullable|string|max:80',
            'nama_item' => 'required|string|max:255',
            'volume' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $boq->update([
            'item_code' => $validated['kode_item'],
            'name' => $validated['nama_item'],
            'volume' => $validated['volume'],
            'unit' => $validated['satuan'],
            'notes' => $validated['keterangan'],
        ]);

        return back()->with('success', 'Item BOQ berhasil diperbarui.');
    }

    public function destroy(Lokasi $lokasi, BoqItem $boq)
    {
        $boq->delete();

        return back()->with('success', 'Item BOQ berhasil dihapus.');
    }
}
