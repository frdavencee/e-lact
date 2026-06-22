<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\MarkingKabel;
use Illuminate\Http\Request;

class MarkingKabelController extends Controller
{
    public function index(Lokasi $lokasi)
    {
        $items = $lokasi->markingKabel()->latest()->get();
        return view('lokasi.partials.marking_kabel', compact('lokasi', 'items'));
    }

    public function store(Request $request, Lokasi $lokasi)
    {
        $validated = $request->validate([
            'jenis_kabel' => 'required|string|max:255',
            'panjang_meter' => 'required|numeric|min:0',
        ]);

        $lokasi->markingKabel()->create($validated);

        return back()->with('success', 'Marking kabel berhasil ditambahkan.');
    }

    public function update(Request $request, Lokasi $lokasi, MarkingKabel $markingKabel)
    {
        $validated = $request->validate([
            'jenis_kabel' => 'required|string|max:255',
            'panjang_meter' => 'required|numeric|min:0',
        ]);

        $markingKabel->update($validated);

        return back()->with('success', 'Marking kabel berhasil diperbarui.');
    }

    public function destroy(Lokasi $lokasi, MarkingKabel $markingKabel)
    {
        $markingKabel->delete();

        return back()->with('success', 'Marking kabel berhasil dihapus.');
    }
}
