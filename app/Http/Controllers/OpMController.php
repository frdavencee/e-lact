<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\OpMRecord;
use Illuminate\Http\Request;

class OpMController extends Controller
{
    public function store(Request $request, Lokasi $lokasi)
    {
        $validated = $request->validate([
            'odp_name' => 'required|string|max:150',
            'port_1'   => 'nullable|numeric|between:-50,30',
            'port_2'   => 'nullable|numeric|between:-50,30',
            'port_3'   => 'nullable|numeric|between:-50,30',
            'port_4'   => 'nullable|numeric|between:-50,30',
            'port_5'   => 'nullable|numeric|between:-50,30',
            'port_6'   => 'nullable|numeric|between:-50,30',
            'port_7'   => 'nullable|numeric|between:-50,30',
            'port_8'   => 'nullable|numeric|between:-50,30',
            'notes'    => 'nullable|string|max:500',
        ]);

        $project = $lokasi->project;
        if (!$project) {
            return back()->with('error', 'Lokasi belum memiliki project.');
        }

        OpMRecord::create(array_merge($validated, ['project_id' => $project->id]));

        return back()->with('success', 'Data OPM berhasil ditambahkan.');
    }

    public function update(Request $request, Lokasi $lokasi, OpMRecord $opmRecord)
    {
        $validated = $request->validate([
            'odp_name' => 'required|string|max:150',
            'port_1'   => 'nullable|numeric|between:-50,30',
            'port_2'   => 'nullable|numeric|between:-50,30',
            'port_3'   => 'nullable|numeric|between:-50,30',
            'port_4'   => 'nullable|numeric|between:-50,30',
            'port_5'   => 'nullable|numeric|between:-50,30',
            'port_6'   => 'nullable|numeric|between:-50,30',
            'port_7'   => 'nullable|numeric|between:-50,30',
            'port_8'   => 'nullable|numeric|between:-50,30',
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
