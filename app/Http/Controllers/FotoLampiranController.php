<?php

namespace App\Http\Controllers;

use App\Models\FotoLampiran;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoLampiranController extends Controller
{
    public function index(Lokasi $lokasi)
    {
        $fotos = $lokasi->fotoLampiran()->latest()->get()->groupBy('kategori');

        return view('foto-lampiran.index', compact('lokasi', 'fotos'));
    }

    public function store(Request $request, Lokasi $lokasi)
    {
        $validated = $request->validate([
            'kategori' => 'required|string|max:255',
            'label' => 'nullable|string|max:255',
            'fotos.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $path = $foto->store('foto_lampiran/' . $lokasi->id . '/' . $validated['kategori'], 'public');

                $lokasi->fotoLampiran()->create([
                    'kategori' => $validated['kategori'],
                    'label' => $validated['label'] ?? null,
                    'file_path' => $path,
                ]);
            }
        }

        return back()->with('success', 'Foto lampiran berhasil diupload.');
    }

    public function replacePhoto(Request $request, Lokasi $lokasi, FotoLampiran $foto)
    {
        $request->validate(['foto' => 'required|image|mimes:jpg,jpeg,png|max:5120']);
        Storage::disk('public')->delete($foto->file_path);
        $path = $request->file('foto')->store('foto_lampiran/' . $lokasi->id . '/' . $foto->kategori, 'public');
        $foto->update(['file_path' => $path]);
        return response()->json(['success' => true, 'url' => asset('storage/' . $path)]);
    }

    public function updateLabel(Lokasi $lokasi, FotoLampiran $foto, Request $request)
    {
        $request->validate(['label' => 'nullable|string|max:255']);
        $foto->update(['label' => $request->label ?? '']);
        return response()->json(['success' => true]);
    }

    public function destroy(Lokasi $lokasi, FotoLampiran $foto)
    {
        Storage::disk('public')->delete($foto->file_path);
        $foto->delete();

        return back()->with('success', 'Foto lampiran berhasil dihapus.');
    }
}
