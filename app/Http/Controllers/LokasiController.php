<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Lokasi::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        $lokasiList = $query->with(['branch', 'project'])->latest()->paginate(10);

        return view('lokasi.index', compact('lokasiList'));
    }

    public function create()
    {
        $branches  = \App\Models\Branch::with(['lokasi' => fn($q) => $q->select('id','branch_id','name','code')->orderBy('code')])->orderBy('name')->get();
        $branchList = $branches;
        $branchData = $branches->mapWithKeys(fn($b) => [
            $b->id => $b->lokasi->map(fn($l) => ['code' => $l->code, 'name' => $l->name])->values()
        ]);
        return view('lokasi.create', compact('branchList', 'branchData'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id'   => 'nullable|exists:branches,id',
            'kode_lokasi' => 'required|string|max:255|unique:locations,code',
            'nama_lokasi' => 'required|string|max:255',
            'status'      => 'required|in:belum,draft,siap,generated',
        ]);

        Lokasi::create([
            'branch_id' => $validated['branch_id'] ?: null,
            'code'      => $validated['kode_lokasi'],
            'name'      => $validated['nama_lokasi'],
            'status'    => $validated['status'],
        ]);

        return redirect()->route('lokasi.index')
            ->with('success', 'Lokasi berhasil dibuat.');
    }

    public function show(Lokasi $lokasi)
    {
        $lokasi->load([
            'commissioningTest.personel',
            'commissioningTest.images',
            'boqItems',
            'markingKabel',
            'fotoLampiran',
            'generateLogs',
            'project.waspangRelation',
            'opmRecords',
            'otdrFiles',
        ]);

        $personelList = \App\Models\Personel::orderBy('name')->get();

        return view('lokasi.show', compact('lokasi', 'personelList'));
    }

    public function commissioning(Lokasi $lokasi)
    {
        $lokasi->load('commissioningTest.personel');
        $personelList = \App\Models\Personel::orderBy('name')->get();
        return view('lokasi.commissioningshow', compact('lokasi', 'personelList'));
    }

    public function marking(Lokasi $lokasi)
    {
        $items = $lokasi->markingKabel()->latest()->get();
        return view('lokasi.markingshow', compact('lokasi', 'items'));
    }

    public function boq(Lokasi $lokasi)
    {
        $items = $lokasi->boqItems()->latest()->get();
        return view('lokasi.boqshow', compact('lokasi', 'items'));
    }

    public function foto(Lokasi $lokasi)
    {
        $fotos = $lokasi->fotoLampiran()->latest()->get();
        return view('lokasi.fotoshow', compact('lokasi', 'fotos'));
    }

    public function opm(Lokasi $lokasi)
    {
        $opmRecords = $lokasi->opmRecords()->latest()->get();
        $otdrFiles = $lokasi->otdrFiles()->latest()->get();
        return view('lokasi.opmshow', compact('lokasi', 'opmRecords', 'otdrFiles'));
    }

    public function otdr(Lokasi $lokasi)
    {
        $otdrFiles = $lokasi->otdrFiles()->latest()->get();
        return view('lokasi.otdrshow', compact('lokasi', 'otdrFiles'));
    }

    public function edit(Lokasi $lokasi)
    {
        $branches   = \App\Models\Branch::with(['lokasi' => fn($q) => $q->select('id','branch_id','name','code')->orderBy('code')])->orderBy('name')->get();
        $branchList = $branches;
        $branchData = $branches->mapWithKeys(fn($b) => [
            $b->id => $b->lokasi->map(fn($l) => ['code' => $l->code, 'name' => $l->name])->values()
        ]);
        return view('lokasi.edit', compact('lokasi', 'branchList', 'branchData'));
    }

    public function update(Request $request, Lokasi $lokasi)
    {
        $validated = $request->validate([
            'branch_id' => 'nullable|exists:branches,id',
            'kode_lokasi' => 'required|string|max:255|unique:locations,code,' . $lokasi->id,
            'nama_lokasi' => 'required|string|max:255',
            'status' => 'required|in:belum,draft,siap,generated',
        ]);

        $lokasi->update([
            'branch_id' => $validated['branch_id'] ?? null,
            'code' => $validated['kode_lokasi'],
            'name' => $validated['nama_lokasi'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('lokasi.show', $lokasi)
            ->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function destroy(Lokasi $lokasi)
    {
        $lokasi->delete();

        return redirect()->route('lokasi.index')
            ->with('success', 'Lokasi berhasil dihapus.');
    }
}
