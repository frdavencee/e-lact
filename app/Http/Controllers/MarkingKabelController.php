<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\MarkingKabel;
use Illuminate\Http\Request;

class MarkingKabelController extends Controller
{
    public function bulkUpdate(Request $request, Lokasi $lokasi)
    {
        $rows = $request->input('items', []);
        $lokasi->markingKabel()->delete();
        foreach ($rows as $row) {
            if (empty(trim($row['jenis_kabel'] ?? ''))) continue;
            $lokasi->markingKabel()->create([
                'jenis_kabel'   => $row['jenis_kabel'],
                'panjang_meter' => is_numeric($row['panjang_meter'] ?? '') ? (float) $row['panjang_meter'] : null,
            ]);
        }
        return response()->json(['success' => true]);
    }

    public function store(Request $request, Lokasi $lokasi)
    {
        $request->validate([
            'jenis_kabel'   => 'nullable|string|max:255',
            'panjang_meter' => 'required|numeric|min:0',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $lokasi->markingKabel()->create([
            'jenis_kabel'   => $request->jenis_kabel ?: null,
            'panjang_meter' => $request->panjang_meter,
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store(
                'foto_lampiran/' . $lokasi->id . '/marking_kabel', 'public'
            );
            $lokasi->fotoLampiran()->create([
                'kategori'  => 'marking_kabel',
                'label'     => $request->jenis_kabel ?: 'Marking Kabel',
                'file_path' => $path,
            ]);
        }

        return back()->with('success', 'Data marking kabel berhasil ditambahkan.');
    }

    public function updateLabel(Request $request, Lokasi $lokasi, MarkingKabel $markingKabel)
    {
        $request->validate(['jenis_kabel' => 'nullable|string|max:255']);
        $markingKabel->update(['jenis_kabel' => $request->jenis_kabel ?: null]);
        return response()->json(['success' => true]);
    }

    public function destroy(Lokasi $lokasi, MarkingKabel $markingKabel)
    {
        $markingKabel->delete();
        return back()->with('success', 'Marking kabel berhasil dihapus.');
    }
}
