<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\OpMRecord;
use Illuminate\Http\Request;

class OpMController extends Controller
{
    public function bulkUpdate(Request $request, Lokasi $lokasi)
    {
        $rows = $request->input('items', []);

        OpMRecord::where('lokasi_id', $lokasi->id)->delete();

        foreach ($rows as $row) {
            if (empty(trim($row['odp_name'] ?? ''))) continue;
            OpMRecord::create([
                'lokasi_id' => $lokasi->id,
                'odp_name'  => $row['odp_name'],
                'port_1'    => $row['port_1'] !== '' ? $row['port_1'] : null,
                'port_2'    => $row['port_2'] !== '' ? $row['port_2'] : null,
                'port_3'    => $row['port_3'] !== '' ? $row['port_3'] : null,
                'port_4'    => $row['port_4'] !== '' ? $row['port_4'] : null,
                'port_5'    => $row['port_5'] !== '' ? $row['port_5'] : null,
                'port_6'    => $row['port_6'] !== '' ? $row['port_6'] : null,
                'port_7'    => $row['port_7'] !== '' ? $row['port_7'] : null,
                'port_8'    => $row['port_8'] !== '' ? $row['port_8'] : null,
                'notes'     => $row['notes'] ?? null,
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function store(Request $request, Lokasi $lokasi)
    {
        $validated = $request->validate([
            'odp_name' => 'required|string|max:150',
            'port_1'   => 'nullable|string|max:50',
            'port_2'   => 'nullable|string|max:50',
            'port_3'   => 'nullable|string|max:50',
            'port_4'   => 'nullable|string|max:50',
            'port_5'   => 'nullable|string|max:50',
            'port_6'   => 'nullable|string|max:50',
            'port_7'   => 'nullable|string|max:50',
            'port_8'   => 'nullable|string|max:50',
            'notes'    => 'nullable|string|max:500',
        ]);

        OpMRecord::create(array_merge($validated, ['lokasi_id' => $lokasi->id]));

        return back()->with('success', 'Data OPM berhasil ditambahkan.');
    }

    public function update(Request $request, Lokasi $lokasi, OpMRecord $opmRecord)
    {
        $validated = $request->validate([
            'odp_name' => 'required|string|max:150',
            'port_1'   => 'nullable|string|max:50',
            'port_2'   => 'nullable|string|max:50',
            'port_3'   => 'nullable|string|max:50',
            'port_4'   => 'nullable|string|max:50',
            'port_5'   => 'nullable|string|max:50',
            'port_6'   => 'nullable|string|max:50',
            'port_7'   => 'nullable|string|max:50',
            'port_8'   => 'nullable|string|max:50',
            'notes'    => 'nullable|string|max:500',
        ]);

        $opmRecord->update($validated);

        return back()->with('success', 'Data OPM berhasil diperbarui.');
    }

    public function destroy(Lokasi $lokasi, OpMRecord $opmRecord)
    {
        $opmRecord->delete();
        return back()->with('success', 'Data OPM berhasil dihapus.');
    }
}
