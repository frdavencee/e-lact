<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function store(Request $request, Lokasi $lokasi)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'contract_number'       => 'nullable|string|max:255',
            'purchase_order_number' => 'nullable|string|max:255',
            'implementer'           => 'nullable|string|max:255',
            'pihak_pertama'         => 'nullable|string|max:255',
            'waspang_id'            => 'nullable|exists:waspangs,id',
        ]);

        $lokasi->project()->create(array_merge($validated, [
            'location_id' => $lokasi->id,
            'branch_id'   => $lokasi->branch_id,
            'user_id'     => auth()->id(),
        ]));

        return redirect()->route('lokasi.show', $lokasi)
            ->with('success', 'Info proyek berhasil disimpan.');
    }

    public function update(Request $request, Lokasi $lokasi, Project $project)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'contract_number'       => 'nullable|string|max:255',
            'purchase_order_number' => 'nullable|string|max:255',
            'implementer'           => 'nullable|string|max:255',
            'pihak_pertama'         => 'nullable|string|max:255',
            'waspang_id'            => 'nullable|exists:waspangs,id',
        ]);

        $project->update($validated);

        return redirect()->route('lokasi.show', $lokasi)
            ->with('success', 'Info proyek berhasil diperbarui.');
    }
}
