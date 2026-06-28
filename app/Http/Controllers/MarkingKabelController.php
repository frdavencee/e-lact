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
        $validated = $request->validate([
            'jenis_kabel'   => 'required|string|max:255',
            'panjang_meter' => 'required|numeric|min:0',
        ]);

        $lokasi->markingKabel()->create($validated);

        return back()->with('success', 'Marking kabel berhasil ditambahkan.');
    }

    public function destroy(Lokasi $lokasi, MarkingKabel $markingKabel)
    {
        $markingKabel->delete();
        return back()->with('success', 'Marking kabel berhasil dihapus.');
    }
}
