<?php

namespace App\Services;

use App\Models\Lokasi;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class LactPdfService
{
    protected Lokasi $lokasi;

    public function __construct(Lokasi $lokasi)
    {
        $this->lokasi = $lokasi;
    }

    public function generate(string $versi): string
    {
        $lokasi = $this->lokasi->load([
            'project.branchRelation',
            'project.waspangRelation',
            'project.mancoreItems',
            'commissioningTest.personel',
            'commissioningTest.images',
            'boqItems',
            'markingKabel',
            'fotoLampiran',
            'opmRecords',
            'otdrFiles',
        ]);

        $data = $this->prepareData($lokasi);

        $fileName = 'LACT_' . ($lokasi->code ?? $lokasi->id) . '_v' . $versi . '.pdf';
        $filePath = storage_path('app/public/generated/lokasi_' . $lokasi->id . '/' . $fileName);

        if (!is_dir(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }

        $pdf = Pdf::loadView('pdf.lact', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdf->save($filePath);

        return $filePath;
    }

    protected function prepareData(Lokasi $lokasi): array
    {
        $project = $lokasi->project ?? null;
        $commissioning = $lokasi->commissioningTest;
        $waspang = $commissioning?->personel ?? $project?->waspangRelation;
        $tanggal = \Carbon\Carbon::parse($commissioning?->tanggal ?? $lokasi->created_at ?? now());
        $data = [
            'project' => $project,
            'lokasi' => $lokasi,
            'waspang' => $waspang,
            'tanggal_ttd' => $tanggal->format('d F Y'),
            'kota_ttd' => strtoupper($lokasi->branch->name ?? 'SEMARANG'),
            'commissioning' => $commissioning,
            'commissioningImages' => $commissioning?->images ?? collect(),
            'boqItems' => $lokasi->boqItems,
            'markingKabels' => $lokasi->markingKabel,
            'fotos' => $lokasi->fotoLampiran,
            'evidencePhotos' => $lokasi->fotoLampiran->groupBy('kategori'),
            'opmRecords' => $lokasi->opmRecords,
            'otdrFiles' => $lokasi->otdrFiles,
            'mancoreItems' => $project?->mancoreItems ?? collect(),
        ];

        return $data;
    }
}
