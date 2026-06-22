<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Services\LactPdfService;
use Illuminate\Http\Request;

class GeneratePdfController extends Controller
{
    public function generate(Request $request, Lokasi $lokasi)
    {
        $lokasi->load([
            'project.branchRelation',
            'project.waspangRelation',
            'project.location',
            'project.approval.reviewer',
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

        if ($lokasi->fotoLampiran()->count() === 0) {
            return back()->with('error', 'Data foto lampiran belum lengkap.');
        }

        if ($lokasi->opmRecords()->count() === 0) {
            return back()->with('error', 'Data OPM belum lengkap.');
        }

        $service = new LactPdfService($lokasi);
        $filePath = $service->generate(1);

        return response()->download($filePath)->deleteFileAfterSend(false);
    }
}
