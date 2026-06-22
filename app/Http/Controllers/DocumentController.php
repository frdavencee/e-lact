<?php

namespace App\Http\Controllers;

use App\Models\GenerateLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = GenerateLog::with('lokasi')->latest()->paginate(15);
        return view('documents.index', compact('documents'));
    }

    public function store(Request $request)
    {
        return redirect()->route('documents.index');
    }

    public function show(GenerateLog $document)
    {
        $filePath = storage_path('app/public/' . $document->file_path);
        if (!file_exists($filePath)) {
            return back()->with('error', 'File tidak ditemukan.');
        }
        return response()->download($filePath);
    }

    public function destroy(GenerateLog $document)
    {
        Storage::disk('public')->delete($document->file_path);
        $document->delete();
        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
