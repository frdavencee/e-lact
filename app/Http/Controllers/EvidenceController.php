<?php

namespace App\Http\Controllers;

use App\Models\EvidenceImage;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EvidenceController extends Controller
{
    public function index(Project $project)
    {
        $kategoriList = ['Penarikan kabel', 'ODP', 'Closure', 'Splitter', 'Aksesoris', 'Mancore', 'ABD'];
        $images = $project->evidenceImages()->latest()->get()->groupBy('kategori');

        return view('evidence.index', compact('project', 'kategoriList', 'images'));
    }

    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'kategori' => 'required|string|max:255',
            'images.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('evidence', 'public');
                $project->evidenceImages()->create([
                    'kategori' => $validated['kategori'],
                    'path' => $path,
                    'nama_file' => $image->getClientOriginalName(),
                ]);
            }
        }

        return back()->with('success', 'Gambar evidence berhasil diupload.');
    }

    public function destroy(Project $project, EvidenceImage $evidence)
    {
        Storage::disk('public')->delete($evidence->path);
        $evidence->delete();

        return back()->with('success', 'Gambar berhasil dihapus.');
    }
}
