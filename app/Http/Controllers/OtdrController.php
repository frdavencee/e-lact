<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\OtdrFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OtdrController extends Controller
{
    public function store(Request $request, Lokasi $lokasi)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'odp_name' => 'required|string|max:150',
        ]);

        $project = $lokasi->project;
        if (!$project) {
            return back()->with('error', 'Lokasi belum memiliki project.');
        }

        $file = $request->file('file');
        $path = $file->store('otdr', 'public');

        OtdrFile::create([
            'project_id'    => $project->id,
            'file_path'     => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type'     => $file->getMimeType(),
            'size'          => $file->getSize(),
            'odp_name'      => $request->odp_name,
        ]);

        return back()->with('success', 'File OTDR berhasil diupload.');
    }

    public function destroy(Lokasi $lokasi, OtdrFile $otdrFile)
    {
        Storage::disk('public')->delete($otdrFile->file_path);
        $otdrFile->delete();

        return back()->with('success', 'File OTDR berhasil dihapus.');
    }
}
