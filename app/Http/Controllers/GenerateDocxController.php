<?php

namespace App\Http\Controllers;

use App\Models\GenerateLog;
use App\Models\Lokasi;
use App\Services\LactDocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GenerateDocxController extends Controller
{
    public function generate(Request $request, Lokasi $lokasi)
    {
        $lokasi->load([
            'project.branchRelation',
            'project.waspangRelation',
            'commissioningTest.personel',
            'boqItems',
            'markingKabel',
            'fotoLampiran',
            'opmRecords',
            'otdrFiles',
        ]);

        if (!$lokasi->commissioningTest) {
            return back()->with('error', 'Data commissioning test belum lengkap.');
        }

        if ($lokasi->boqItems()->count() === 0) {
            return back()->with('error', 'Data BOQ belum lengkap.');
        }

        if ($lokasi->markingKabel()->count() === 0) {
            return back()->with('error', 'Data marking kabel belum lengkap.');
        }

        if ($lokasi->fotoLampiran()->count() === 0) {
            return back()->with('error', 'Data foto lampiran belum lengkap.');
        }

        if ($lokasi->opmRecords()->count() === 0) {
            return back()->with('error', 'Data OPM belum lengkap.');
        }

        $versi = $lokasi->generateLogs()->count() + 1;

        try {
            $service = new LactDocumentService($lokasi);
            $filePath = $service->generate($versi);
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        GenerateLog::create([
            'lokasi_id' => $lokasi->id,
            'generated_by' => Auth::user()->name,
            'generated_at' => now(),
            'file_path' => 'generated/' . basename($filePath),
            'versi' => $versi,
        ]);

        $lokasi->update(['status' => 'generated']);

        return response()->download($filePath)->deleteFileAfterSend(false);
    }
}
