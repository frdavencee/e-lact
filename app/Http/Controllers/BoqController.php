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
            'lokasi_id'    => 'required|exists:locations,id',
            'kode_item'    => 'nullable|string|max:80',
            'nama_item'    => 'required|string|max:255',
            'satuan'       => 'required|string|max:50',
            'volume_drm'   => 'nullable|numeric|min:0',
            'volume_aktual' => 'nullable|numeric|min:0',
            'volume_tambah' => 'nullable|numeric|min:0',
            'volume_kurang' => 'nullable|numeric|min:0',
            'keterangan'   => 'nullable|string|max:500',
        ]);

        \App\Models\Lokasi::findOrFail($validated['lokasi_id'])->boqItems()->create([
            'item_code'    => $validated['kode_item'],
            'name'         => $validated['nama_item'],
            'unit'         => $validated['satuan'],
            'volume_drm'   => $validated['volume_drm'] ?? null,
            'volume_aktual' => $validated['volume_aktual'] ?? null,
            'volume_tambah' => $validated['volume_tambah'] ?? null,
            'volume_kurang' => $validated['volume_kurang'] ?? null,
            'notes'        => $validated['keterangan'],
            'price'        => 0,
            'total'        => 0,
        ]);

        return redirect()->route('boq.index')->with('success', 'Item BOQ berhasil ditambahkan.');
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
        $rows = $request->input('boq', []);

        $lokasi->boqItems()->delete();

        foreach ($rows as $row) {
            if (empty(trim($row['nama_item'] ?? ''))) continue;
            $lokasi->boqItems()->create([
                'item_code'    => $row['kode_item'] ?? null,
                'name'         => $row['nama_item'],
                'unit'         => $row['satuan'] ?? null,
                'volume_drm'   => is_numeric($row['volume_drm'] ?? '') ? (float) $row['volume_drm'] : null,
                'volume_aktual' => is_numeric($row['volume_aktual'] ?? '') ? (float) $row['volume_aktual'] : null,
                'volume_tambah' => is_numeric($row['volume_tambah'] ?? '') ? (float) $row['volume_tambah'] : null,
                'volume_kurang' => is_numeric($row['volume_kurang'] ?? '') ? (float) $row['volume_kurang'] : null,
                'notes'        => $row['keterangan'] ?? null,
                'price'        => 0,
                'total'        => 0,
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function update(Request $request, Lokasi $lokasi, BoqItem $boq)
    {
        $boq->update([
            'item_code'    => $request->input('kode_item'),
            'name'         => $request->input('nama_item'),
            'unit'         => $request->input('satuan'),
            'volume_drm'   => $request->input('volume_drm'),
            'volume_aktual' => $request->input('volume_aktual'),
            'volume_tambah' => $request->input('volume_tambah'),
            'volume_kurang' => $request->input('volume_kurang'),
            'notes'        => $request->input('keterangan'),
        ]);

        return back()->with('success', 'Item BOQ berhasil diperbarui.');
    }

    public function destroy(Lokasi $lokasi, BoqItem $boq)
    {
        $boq->delete();
        return back()->with('success', 'Item BOQ berhasil dihapus.');
    }
}
