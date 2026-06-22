<?php

namespace App\Http\Controllers;

use App\Models\Personel;
use Illuminate\Http\Request;

class WaspangController extends Controller
{
    public function index(Request $request)
    {
        $query = Personel::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('nik', 'like', "%{$request->search}%");
            });
        }

        $personelList = $query->latest()->paginate(10);

        return view('waspang.index', compact('personelList'));
    }

    public function create()
    {
        return view('waspang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:50|unique:waspangs,nik',
            'jabatan' => 'nullable|string|max:255',
        ]);

        Personel::create([
            'name' => $validated['nama'],
            'nik' => $validated['nik'],
            'position' => $validated['jabatan'] ?? 'WASPANG',
        ]);

        return redirect()->route('waspang.index')
            ->with('success', 'Waspang berhasil ditambahkan.');
    }

    public function show(Personel $personel)
    {
        $personel->load('commissioningTests');

        return view('waspang.show', compact('personel'));
    }

    public function edit(Personel $personel)
    {
        return view('waspang.edit', compact('personel'));
    }

    public function update(Request $request, Personel $personel)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:50|unique:waspangs,nik,' . $personel->id,
            'jabatan' => 'nullable|string|max:255',
        ]);

        $personel->update([
            'name' => $validated['nama'],
            'nik' => $validated['nik'],
            'position' => $validated['jabatan'] ?? 'WASPANG',
        ]);

        return redirect()->route('waspang.show', $personel)
            ->with('success', 'Waspang berhasil diperbarui.');
    }

    public function destroy(Personel $personel)
    {
        $personel->delete();

        return redirect()->route('waspang.index')
            ->with('success', 'Waspang berhasil dihapus.');
    }
}
