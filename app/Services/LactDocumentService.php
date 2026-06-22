<?php

namespace App\Services;

use App\Models\Lokasi;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use function App\Helpers\tanggalKeHuruf;

class LactDocumentService
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
            'commissioningTest.personel',
            'commissioningTest.images',
            'boqItems',
            'markingKabel',
            'fotoLampiran',
            'opmRecords',
            'otdrFiles',
        ]);

        $this->validateData($lokasi);

        $phpWord = new PhpWord();
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize(11);

        $section = $phpWord->addSection([
            'marginTop' => 1000,
            'marginBottom' => 1000,
            'marginLeft' => 1200,
            'marginRight' => 1200,
        ]);

        // Halaman 1: Cover
        $this->addCover($section, $lokasi);
        $section->addPageBreak();

        // Halaman 2: Daftar Isi
        $this->addTableOfContents($section);
        $section->addPageBreak();

        // Section 1: Laporan Commissioning Test
        $this->addSectionHeader($section, $lokasi);
        $section->addText('LAPORAN COMMISIONING TEST', ['bold' => true, 'size' => 14], ['spaceAfter' => 200]);
        $this->addCommissioningTest($section, $lokasi->commissioningTest, $lokasi);

        // Section 2: Laporan Bill of Quantity
        $section->addPageBreak();
        $this->addSectionHeader($section, $lokasi);
        $section->addText('LAPORAN BILL OF QUANTITY', ['bold' => true, 'size' => 14], ['spaceAfter' => 200]);
        $this->addBoqTable($section, $lokasi->boqItems);
        $this->addPhotoPageSignature($section, $lokasi);

        // Section 3: Lampiran Evident Pekerjaan (4 kategori digabung dalam 1 grid)
        $section->addPageBreak();
        $this->addSectionHeader($section, $lokasi);
        $section->addText('LAMPIRAN EVIDENT PEKERJAAN', ['bold' => true, 'size' => 14], ['alignment' => Jc::CENTER, 'spaceAfter' => 200]);
        $this->addEvidenceGrid($section, $lokasi->fotoLampiran, $lokasi);

        // Section 4: Lampiran Marking Kabel
        $section->addPageBreak();
        $this->addSectionHeader($section, $lokasi);
        $section->addText('LAMPIRAN MARKING KABEL', ['bold' => true, 'size' => 14], ['alignment' => Jc::CENTER, 'spaceAfter' => 200]);
        $this->addMarkingKabelGrid($section, $lokasi->fotoLampiran, $lokasi);

        // Section 5: Lampiran Evidence ODP (gabung odp_solid + pemasangan_odp)
        $this->addEvidenceMerged($section, $lokasi, ['odp_solid', 'pemasangan_odp'], 'LAMPIRAN EVIDENCE ODP');

        // Section 6: Lampiran Evidence Aksesoris (gabung aksesoris_hl + aksesoris_sc)
        $this->addEvidenceMerged($section, $lokasi, ['aksesoris_hl', 'aksesoris_sc'], 'LAMPIRAN EVIDENCE AKSESORIS');

        // Section 7: Lampiran Evidence Closure dan Spliter 1:4
        $this->addEvidenceMerged($section, $lokasi, ['closure_splitter'], 'LAMPIRAN EVIDENCE CLOSURE DAN SPLITER 1:4');

        // Section 8: Lampiran Evident Hasil Ukur OPM
        $section->addPageBreak();
        $this->addSectionHeader($section, $lokasi);
        $section->addText('LAMPIRAN EVIDENT HASIL UKUR OPM', ['bold' => true, 'size' => 14], ['alignment' => Jc::CENTER, 'spaceAfter' => 200]);
        $this->addOpmGrid($section, $lokasi->opmRecords, $lokasi);

        // Section 9: Lampiran Data Pengukuran OPM Project Outside Plant Fiber Optic
        $section->addPageBreak();
        $this->addOpmDataTable($section, $lokasi);

        // Section 10+: Lampiran Hasil Ukur OTDR per ODP
        $this->addOtdrByOdp($section, $lokasi);

        // Section: Lampiran Mancore
        $this->addEvidenceMerged($section, $lokasi, ['mancore'], 'LAMPIRAN MANCORE');

        // Section: Lampiran Evident As Build Drawing (ABD)
        $this->addEvidenceMerged($section, $lokasi, ['as_build_drawing'], 'LAMPIRAN EVIDENT AS BUILD DRAWING (ABD)');

        // Save
        $directory = storage_path('app/public/generated');
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $fileName = 'LACT_' . ($lokasi->code ?? $lokasi->id) . '_v' . $versi . '.docx';
        $filePath = $directory . DIRECTORY_SEPARATOR . $fileName;

        while (file_exists($filePath)) {
            $versi++;
            $fileName = 'LACT_' . ($lokasi->code ?? $lokasi->id) . '_v' . $versi . '.docx';
            $filePath = $directory . DIRECTORY_SEPARATOR . $fileName;
        }

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($filePath);

        return $filePath;
    }

    // ===================================================================
    // LOGIC 1: VALIDASI
    // ===================================================================
    protected function validateData(Lokasi $lokasi): void
    {
        $missing = [];
        if (!$lokasi->commissioningTest) $missing[] = 'Commissioning Test belum diisi.';
        if ($lokasi->boqItems()->count() === 0) $missing[] = 'BOQ masih kosong.';
        if ($lokasi->fotoLampiran()->count() === 0) $missing[] = 'Foto lampiran belum diupload.';
        if ($lokasi->opmRecords()->count() === 0) $missing[] = 'OPM belum diisi.';

        if (!empty($missing)) {
            throw new \RuntimeException('Gagal generate LACT: ' . implode(' ', $missing));
        }
    }

    // ===================================================================
    // LOGIC 2: COVER PAGE
    // ===================================================================
    protected function addCover($section, Lokasi $lokasi): void
    {
        $data = $this->getProjectData($lokasi);
        $waspangName = $data['pelaksana'];

        $section->addText('LAPORAN  COMMISSIONING TEST (LACT)', ['bold' => true, 'size' => 18], [
            'alignment' => Jc::CENTER,
            'spaceAfter' => 400,
        ]);

        // Header table
        $table = $section->addTable(['borderSize' => 4, 'borderColor' => '000000', 'cellPadding' => 80]);
        $rows = [
            ['PROYEK', $data['nama_proyek']],
            ['KONTRAK', $data['kontrak']],
            ['SURAT PESANAN', $data['surat_pesanan']],
            ['BRANCH', $data['branch']],
            ['LOKASI', 'PATI [' . $lokasi->code . ']'],
            ['PELAKSANA', $data['pelaksana']],
        ];
        foreach ($rows as $row) {
            $table->addRow();
            $table->addCell(2500)->addText($row[0], ['bold' => true]);
            $table->addCell(7500)->addText($row[1]);
        }

        // Spasi untuk kop surat
        $section->addTextBreak(6);
        $section->addText('ANTARA', ['bold' => true], ['alignment' => Jc::CENTER, 'spaceAfter' => 200]);
        $section->addText('PT. TELKOM INFRASTRUKTUR INDONESIA, Tbk.', ['bold' => true], ['alignment' => Jc::CENTER, 'spaceAfter' => 100]);
        $section->addText('DENGAN', ['bold' => true], ['alignment' => Jc::CENTER, 'spaceAfter' => 200]);
        $section->addText($waspangName, ['bold' => true], ['alignment' => Jc::CENTER, 'spaceAfter' => 400]);

    }

    protected function addTableOfContents($section): void
    {
        $section->addTextBreak(1);
        $section->addText('DAFTAR ISI', ['bold' => true, 'size' => 14], ['alignment' => Jc::CENTER, 'spaceAfter' => 100]);
        $section->addText('DOKUMEN LAPORAN COMMISIONING TEST', ['bold' => true, 'size' => 12], ['alignment' => Jc::CENTER, 'spaceAfter' => 100]);
        $section->addText('(LACT)', ['bold' => true, 'size' => 12], ['alignment' => Jc::CENTER, 'spaceAfter' => 400]);

        $items = [
            'Laporan Commisioning Test',
            'Lampiran Bill Of Quantity',
            'Hasil Ukur OPM & OTDR (End To End Sesuai SOW)',
            'Lampiran Mancore',
            'Berita Acara Lapangan & Dokumen Pendukung Lainnya',
        ];
        foreach ($items as $i => $item) {
            $section->addText(($i + 1) . '.   ' . $item, [], ['spaceAfter' => 200]);
        }
    }

    // ===================================================================
    // LOGIC 3: SECTION HEADER (HEADER TABEL BERULANG)
    // ===================================================================
    protected function addSectionHeader($section, Lokasi $lokasi): void
    {
        $data = $this->getProjectData($lokasi);

        $table = $section->addTable(['borderSize' => 4, 'borderColor' => '000000', 'cellPadding' => 80]);
        $rows = [
            ['PROYEK', $data['nama_proyek']],
            ['KONTRAK', $data['kontrak']],
            ['SURAT PESANAN', $data['surat_pesanan']],
            ['BRANCH', $data['branch']],
            ['LOKASI', 'PATI [' . $lokasi->code . ']'],
            ['PELAKSANA', $data['pelaksana']],
        ];
        foreach ($rows as $row) {
            $table->addRow();
            $table->addCell(2500)->addText($row[0], ['bold' => true]);
            $table->addCell(7500)->addText($row[1]);
        }
        $section->addTextBreak(1);
    }

    // ===================================================================
    // LOGIC 4: COMMISSIONING TEST
    // ===================================================================
    protected function addCommissioningTest($section, $ct, Lokasi $lokasi): void
    {
        $lokasiName = $lokasi->name . ' [' . $lokasi->code . ']';
        $tanggal = tanggalKeHuruf($ct->tanggal);
        $waspang = $ct->personel;
        $data = $this->getProjectData($lokasi);

        // Tabel info proyek
        $table = $section->addTable(['borderSize' => 0, 'cellPadding' => 80]);
        $rows = [
            ['PROYEK',        ': ' . $data['nama_proyek']],
            ['KONTRAK',       ': ' . $data['kontrak']],
            ['SURAT PESANAN', ': ' . $data['surat_pesanan']],
            ['BRANCH',        ': ' . $data['branch']],
            ['LOKASI',        ': ' . $lokasiName],
            ['PELAKSANA',     ': ' . $data['pelaksana']],
        ];
        foreach ($rows as $row) {
            $table->addRow();
            $table->addCell(2000)->addText($row[0], ['bold' => true]);
            $table->addCell(8000)->addText($row[1]);
        }

        $section->addTextBreak(1);

        // Narasi pembuka
        $section->addText(
            'Pada hari ini ' . ($tanggal['nama_hari'] ?? '-') .
            ' tanggal ' . ($tanggal['tanggal'] ?? '-') .
            ' bulan ' . ($tanggal['bulan'] ?? '-') .
            ' tahun ' . ($tanggal['tahun'] ?? '-') .
            ' yang bertanda tangan di bawah ini :',
            [],
            ['spaceAfter' => 200]
        );

        // Identitas waspang (tabel tanpa border)
        $idTable = $section->addTable(['borderSize' => 0, 'cellPadding' => 60]);
        $idRows = [
            ['Nama',    $waspang->name ?? '-'],
            ['NIK',     $waspang->nik ?? '-'],
            ['Jabatan', $waspang->position ?? 'WASPANG PT. TELKOM AKSES'],
        ];
        foreach ($idRows as $row) {
            $idTable->addRow();
            $idTable->addCell(1500)->addText($row[0]);
            $idTable->addCell(200)->addText(':');
            $idTable->addCell(8300)->addText($row[1]);
        }

        $section->addTextBreak(1);

        // Paragraf keterangan
        $section->addText(
            'Sehubungan dengan ' . $lokasiName .
            ' menerangkan bahwa telah melaksanakan pemeriksaan kesisteman (Commisioning Test)' .
            ' dan fisik pada lokasi ' . $lokasiName . ' sebagai berikut :',
            [],
            ['spaceAfter' => 200]
        );

        // Poin-poin
        $statusPekerjaan = $ct->status_pekerjaan === 'telah' ? 'telah' : 'belum';
        $statusHasil = $ct->status_hasil === 'dapat' ? 'dapat' : 'tidak dapat';
        $statusLayak = $ct->status_kelayakan === 'layak' ? 'layak' : 'tidak layak';

        $section->addText(
            '1.   Pelaksanaan pekerjaan ' . $statusPekerjaan . ' diselesaikan dengan spesifikasi teknis TELKOM',
            [],
            ['spaceAfter' => 100]
        );
        $section->addText(
            '2.   Hasil pekerjaan ' . $statusHasil . ' diterima dan ' . $statusLayak . ' untuk diajukan Uji Terima (UT)',
            [],
            ['spaceAfter' => 200]
        );

        $section->addText(
            'Demikian Laporan Commisioning Test dan Hasil Ukur ini dibuat dengan sebenarnya dan dapat dipertanggung jawabkan.',
            [],
            ['spaceAfter' => 400]
        );

        // Blok tanda tangan: kiri kosong, kanan tanda tangan
        $kotaTtd = strtoupper($ct->kota_ttd ?? $data['branch']);
        $ttdText = $kotaTtd . ', ' . ($tanggal['tanggal'] ?? '-') . ' ' . ($tanggal['bulan'] ?? '-') . ' ' . ($tanggal['tahun'] ?? '-');

        $sigTable = $section->addTable(['borderSize' => 0, 'cellPadding' => 80]);
        $sigTable->addRow();
        $sigTable->addCell(5000); // spacer kiri
        $cellKanan = $sigTable->addCell(5000);

        // Kanan: tanda tangan
        $cellKanan->addText($ttdText, ['bold' => true]);
        $cellKanan->addText('WASPANG');
        $cellKanan->addText('PT TELKOM AKSES');

        // Gambar tanda tangan jika ada
        if ($ct->images && $ct->images->count() > 0) {
            $firstImage = $ct->images->first();
            $fullPath = storage_path('app/public/' . $firstImage->file_path);
            if (file_exists($fullPath)) {
                try {
                    $cellKanan->addImage($fullPath, ['width' => 120, 'height' => 60]);
                } catch (\Throwable $e) {
                    $cellKanan->addTextBreak(3);
                }
            } else {
                $cellKanan->addTextBreak(3);
            }
        } else {
            $cellKanan->addTextBreak(3);
        }

        $cellKanan->addText($waspang->name ?? '-', ['bold' => true]);
        $cellKanan->addText('NIK : ' . ($waspang->nik ?? '-'));
    }

    // ===================================================================
    // LOGIC 5: BOQ TABLE
    // ===================================================================
    protected function addBoqTable($section, $boqItems): void
    {
        $table = $section->addTable(['borderSize' => 4, 'borderColor' => '000000', 'cellPadding' => 80]);
        $headers = ['No', 'Kode Item', 'Nama Item', 'Satuan', 'Volume', 'Keterangan'];
        $table->addRow();
        foreach ($headers as $h) {
            $table->addCell(1200)->addText($h, ['bold' => true]);
        }

        $no = 1;
        foreach ($boqItems as $item) {
            $table->addRow();
            $table->addCell(1200)->addText((string) $no++);
            $table->addCell(2000)->addText($item->kode_item ?? '-');
            $table->addCell(3000)->addText($item->nama_item ?? '-');
            $table->addCell(1200)->addText($item->satuan ?? '-');
            $table->addCell(1200)->addText((string) ($item->volume ?? '-'));
            $table->addCell(3000)->addText($item->keterangan ?? '-');
        }

        if ($boqItems->count() === 0) {
            $table->addRow();
            $table->addCell(1200)->addText('-');
            $table->addCell(2000)->addText('-');
            $table->addCell(3000)->addText('-');
            $table->addCell(1200)->addText('-');
            $table->addCell(1200)->addText('-');
            $table->addCell(3000)->addText('-');
        }
    }

    protected function addSignatureBlock($section, Lokasi $lokasi, bool $withName = false): void
    {
        $project = $lokasi->project;
        $waspang = $project?->waspangRelation ?? null;
        $tanggal = tanggalKeHuruf($lokasi->created_at ?? now());
        $ttdText = strtoupper($lokasi->branch->name ?? 'SEMARANG') . ', ' . $tanggal['tanggal'] . ' ' . $tanggal['bulan'] . ' ' . $tanggal['tahun'];

        $sigTable = $section->addTable(['borderSize' => 0]);
        $sigTable->addRow();
        $cell1 = $sigTable->addCell(5000);
        $sigTable->addCell(5000); // spacer kanan

        $cell1->addText($ttdText, ['bold' => true]);
        $cell1->addText('WASPANG');
        $cell1->addText('PT TELKOM AKSES');
        $cell1->addBreak();
        $cell1->addBreak();
        $cell1->addBreak();
        if ($withName && $waspang) {
            $cell1->addText($waspang->name, ['bold' => true]);
            $cell1->addText('NIK : ' . $waspang->nik);
        } else {
            $cell1->addText('PARAF');
        }
    }

    // ===================================================================
    // LOGIC 7: EVIDENCE GRID — gabung 4 kategori dalam 1 grid
    // ===================================================================
    protected function addEvidenceGrid($section, $fotos, Lokasi $lokasi): void
    {
        $categoryKeys = [
            'evident_penarikan_kabel',
            'evident_instalasi_aksesoris',
            'evident_closure',
            'evident_odp',
        ];

        $combined = collect();
        foreach ($categoryKeys as $key) {
            $combined = $combined->merge($fotos->where('kategori', $key)->values());
        }

        if ($combined->count() === 0) {
            $this->addPhotoPageSignature($section, $lokasi);
            return;
        }

        $this->addFotoGrid($section, $lokasi, $combined, 'LAMPIRAN EVIDENT PEKERJAAN');
    }

    // ===================================================================
    // LOGIC 8: MARKING KABEL GRID — hanya foto kategori marking_kabel
    // ===================================================================
    protected function addMarkingKabelGrid($section, $fotos, Lokasi $lokasi): void
    {
        $items = $fotos->where('kategori', 'marking_kabel')->values();

        if ($items->count() === 0) {
            $this->addPhotoPageSignature($section, $lokasi);
            return;
        }

        $this->addFotoGrid($section, $lokasi, $items, 'LAMPIRAN MARKING KABEL');
    }

    // ===================================================================
    // LOGIC 9: EVIDENCE MERGED — gabung beberapa kategori dalam 1 halaman
    // ===================================================================
    protected function addEvidenceMerged($section, Lokasi $lokasi, array $categories, string $title): void
    {
        $combined = collect();
        foreach ($categories as $cat) {
            $combined = $combined->merge($lokasi->fotoLampiran->where('kategori', $cat)->values());
        }

        if ($combined->count() === 0) return;

        $section->addPageBreak();
        $this->addSectionHeader($section, $lokasi);
        $section->addText(strtoupper($title), ['bold' => true, 'size' => 14], ['alignment' => Jc::CENTER, 'spaceAfter' => 200]);
        $this->addFotoGrid($section, $lokasi, $combined, strtoupper($title));
    }

    // ===================================================================
    // LOGIC 7b: REUSABLE FOTO GRID — 6 foto per halaman, paraf hanya di akhir
    // ===================================================================
    protected function addFotoGrid($section, Lokasi $lokasi, $fotos, string $title): void
    {
        $pages = $fotos->chunk(6);
        $totalPages = $pages->count();

        foreach ($pages as $pageIndex => $pageChunk) {
            if ($pageIndex > 0) {
                $section->addPageBreak();
                $this->addSectionHeader($section, $lokasi);
                $section->addText($title, ['bold' => true, 'size' => 14], ['alignment' => Jc::CENTER, 'spaceAfter' => 200]);
            }

            // Tabel foto: 3 kolom, maks 2 baris foto per halaman
            $fotoTable = $section->addTable([
                'borderSize' => 6,
                'borderColor' => '000000',
                'cellPadding' => 80,
                'width' => 10000,
                'unit' => 'dxa',
            ]);

            foreach ($pageChunk->chunk(3) as $chunk) {
                // Baris foto
                $fotoTable->addRow(2200);
                foreach ($chunk as $foto) {
                    $cell = $fotoTable->addCell(3333, ['valign' => 'center']);
                    $fullPath = storage_path('app/public/' . $foto->file_path);
                    if (file_exists($fullPath)) {
                        try { $cell->addImage($fullPath, ['width' => 190, 'height' => 160]); }
                        catch (\Throwable $e) { $cell->addText('[Gambar error]', ['size' => 9]); }
                    } else {
                        $cell->addText('[File tidak ditemukan]', ['size' => 9]);
                    }
                }
                for ($i = $chunk->count(); $i < 3; $i++) {
                    $fotoTable->addCell(3333);
                }

                // Baris label
                $fotoTable->addRow();
                foreach ($chunk as $foto) {
                    $fotoTable->addCell(3333)->addText($foto->label ?? '', ['size' => 9, 'italic' => true]);
                }
                for ($i = $chunk->count(); $i < 3; $i++) {
                    $fotoTable->addCell(3333);
                }
            }

            $section->addTextBreak(1);

            // Tanda tangan paraf hanya di halaman terakhir
            if ($pageIndex === $totalPages - 1) {
                $this->addPhotoPageSignature($section, $lokasi);
            }
        }
    }

    // ===================================================================
    // LOGIC 10: OPM 8-PORT GRID
    // ===================================================================
    protected function addOpmGrid($section, $opmRecords, Lokasi $lokasi): void
    {
        $opmByOdp = $opmRecords->groupBy('odp_name');

        foreach ($opmByOdp as $odpName => $records) {
            $record = $records->first();

            $section->addText('P-IN OUT SPL-1.04 ODC', ['bold' => true], [
                'alignment' => Jc::CENTER,
                'spaceAfter' => 100,
            ]);

            $mainTable = $section->addTable(['borderSize' => 4, 'borderColor' => '000000']);
            $mainTable->addRow();

            $leftCell = $mainTable->addCell(2500, ['vMerge' => 'restart', 'valign' => 'center']);
            $leftCell->addText($odpName, ['bold' => true]);

            $rightCell = $mainTable->addCell(7500);
            $rightTable = $rightCell->addTable(['borderSize' => 4, 'borderColor' => '000000']);

            $rightTable->addRow();
            $rightTable->addCell(2500)->addText('PORT 1 = ' . ($record->port_1 ?? '-'));
            $rightTable->addCell(2500)->addText('PORT 2 = ' . ($record->port_2 ?? '-'));
            $rightTable->addCell(2500);

            $rightTable->addRow();
            $rightTable->addCell(2500)->addText('PORT 3 = ' . ($record->port_3 ?? '-'));
            $rightTable->addCell(2500)->addText('PORT 4 = ' . ($record->port_4 ?? '-'));
            $rightTable->addCell(2500)->addText('PORT 5 = ' . ($record->port_5 ?? '-'));

            $rightTable->addRow();
            $rightTable->addCell(2500)->addText('PORT 6 = ' . ($record->port_6 ?? '-'));
            $rightTable->addCell(2500)->addText('PORT 7 = ' . ($record->port_7 ?? '-'));
            $rightTable->addCell(2500)->addText('PORT 8 = ' . ($record->port_8 ?? '-'));

            $mainTable->addRow();
            $mainTable->addCell(2500, ['vMerge' => 'continue']);
            $mainTable->addCell(7500);

            $mainTable->addRow();
            $mainTable->addCell(2500, ['vMerge' => 'continue']);
            $mainTable->addCell(7500);

            $section->addTextBreak(1);
        }

        $this->addPhotoPageSignature($section, $lokasi);
    }

    // ===================================================================
    // LOGIC 11: OPM DATA TABLE (EXCEL-LIKE)
    // ===================================================================
    protected function addOpmDataTable($section, Lokasi $lokasi): void
    {
        $section->addText('LAMPIRAN DATA PENGUKURAN OPM', ['bold' => true, 'size' => 14], ['spaceAfter' => 100]);
        $section->addText('PROJECT OUTSIDE PLANT FIBER OPTIC', ['bold' => true], ['spaceAfter' => 200]);

        $data = $this->getProjectData($lokasi);
        $waspang = $lokasi->project?->waspangRelation ?? null;
        $tanggal = tanggalKeHuruf($lokasi->created_at ?? now());
        $kotaTtd = strtoupper($data['branch'] !== '-' ? $data['branch'] : 'SEMARANG');
        $ttdText = $kotaTtd . ', ' . $tanggal['tanggal'] . ' ' . $tanggal['bulan'] . ' ' . $tanggal['tahun'];

        // Tanda tangan kanan dengan nama lengkap
        $outerTable = $section->addTable(['borderSize' => 0, 'cellPadding' => 0]);
        $outerTable->addRow();
        $outerTable->addCell(5000); // spacer kiri
        $rightCell = $outerTable->addCell(5000);
        $rightCell->addText($ttdText, ['bold' => true]);
        $rightCell->addText('WASPANG');
        $rightCell->addText('PT TELKOM AKSES');
        $rightCell->addTextBreak(3);
        if ($waspang) {
            $rightCell->addText($waspang->name, ['bold' => true]);
            $rightCell->addText('NIK : ' . ($waspang->nik ?? '-'));
        }

        $section->addTextBreak(2);

        // Detail OPM table
        $table = $section->addTable(['borderSize' => 4, 'borderColor' => '000000', 'cellPadding' => 80]);
        $headers = ['No', 'Nama ODP', 'Port 1', 'Port 2', 'Port 3', 'Port 4', 'Port 5', 'Port 6', 'Port 7', 'Port 8', 'Catatan'];
        $table->addRow();
        foreach ($headers as $h) {
            $table->addCell(800)->addText($h, ['bold' => true, 'size' => 9]);
        }

        $no = 1;
        foreach ($lokasi->opmRecords as $opm) {
            $table->addRow();
            $table->addCell(800)->addText((string) $no++);
            $table->addCell(1500)->addText($opm->odp_name);
            $table->addCell(900)->addText((string) ($opm->port_1 ?? '-'));
            $table->addCell(900)->addText((string) ($opm->port_2 ?? '-'));
            $table->addCell(900)->addText((string) ($opm->port_3 ?? '-'));
            $table->addCell(900)->addText((string) ($opm->port_4 ?? '-'));
            $table->addCell(900)->addText((string) ($opm->port_5 ?? '-'));
            $table->addCell(900)->addText((string) ($opm->port_6 ?? '-'));
            $table->addCell(900)->addText((string) ($opm->port_7 ?? '-'));
            $table->addCell(900)->addText((string) ($opm->port_8 ?? '-'));
            $table->addCell(1500)->addText($opm->notes ?? '');
        }
    }

    // ===================================================================
    // LOGIC 12: OTDR PER ODP
    // ===================================================================
    protected function addOtdrByOdp($section, Lokasi $lokasi): void
    {
        $otdrByOdp = $lokasi->otdrFiles->groupBy('odp_name');

        foreach ($otdrByOdp as $odpName => $files) {
            $section->addPageBreak();
            $this->addSectionHeader($section, $lokasi);
            $section->addText('LAMPIRAN HASIL UKUR OTDR ' . strtoupper($odpName), ['bold' => true, 'size' => 14], ['alignment' => Jc::CENTER, 'spaceAfter' => 200]);

            foreach ($files as $otdr) {
                $fullPath = storage_path('app/public/' . $otdr->file_path);
                if (file_exists($fullPath)) {
                    try {
                        $section->addImage($fullPath, ['width' => 500, 'height' => 300]);
                    } catch (\Throwable $e) {
                        $section->addText('[Gambar OTDR tidak dapat dimuat]');
                    }
                }
            }

            $this->addPhotoPageSignature($section, $lokasi);
        }
    }

    // ===================================================================
    // LOGIC 13: TANDA TANGAN PARAF PER HALAMAN FOTO (TABEL, KANAN BAWAH)
    // ===================================================================
    protected function addPhotoPageSignature($section, Lokasi $lokasi): void
    {
        $data = $this->getProjectData($lokasi);
        $waspang = $lokasi->waspang ?? $lokasi->project?->waspangRelation ?? null;
        $tanggal = tanggalKeHuruf($lokasi->created_at ?? now());
        $kotaTtd = strtoupper($data['branch'] !== '-' ? $data['branch'] : 'SEMARANG');
        $ttdText = $kotaTtd . ', ' . $tanggal['tanggal'] . ' ' . $tanggal['bulan'] . ' ' . $tanggal['tahun'];

        $section->addTextBreak(1);

        // Tabel luar: kolom kiri kosong (spacer), kolom kanan = tabel tanda tangan
        $outerTable = $section->addTable(['borderSize' => 0, 'cellPadding' => 0]);
        $outerTable->addRow();
        $outerTable->addCell(5000); // spacer kiri

        $rightCell = $outerTable->addCell(5000);

        // Tabel tanda tangan di dalam sel kanan
        $sigTable = $rightCell->addTable([
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellPadding' => 100,
            'width' => 5000,
            'unit' => 'dxa',
        ]);

        // Baris 1: header kiri & kanan
        $sigTable->addRow();
        $sigTable->addCell(2500)->addText('WASPANG / PT TELKOM AKSES', ['bold' => true, 'size' => 9], ['alignment' => Jc::CENTER]);
        $sigTable->addCell(2500)->addText('DIKETAHUI OLEH / ' . strtoupper($data['pelaksana']), ['bold' => true, 'size' => 9], ['alignment' => Jc::CENTER]);

        // Baris 2: tanggal
        $sigTable->addRow();
        $sigTable->addCell(2500)->addText($ttdText, ['size' => 9], ['alignment' => Jc::CENTER]);
        $sigTable->addCell(2500)->addText($ttdText, ['size' => 9], ['alignment' => Jc::CENTER]);

        // Baris 3: ruang tanda tangan
        $sigTable->addRow(1200);
        $sigTable->addCell(2500, ['valign' => 'bottom']);
        $sigTable->addCell(2500, ['valign' => 'bottom']);

        // Baris 4: nama
        $sigTable->addRow();
        $sigTable->addCell(2500)->addText($waspang ? $waspang->name : '(......................)', ['bold' => true, 'size' => 9], ['alignment' => Jc::CENTER]);
        $sigTable->addCell(2500)->addText('(......................)', ['size' => 9], ['alignment' => Jc::CENTER]);

        if ($waspang?->nik) {
            $sigTable->addRow();
            $sigTable->addCell(2500)->addText('NIK: ' . $waspang->nik, ['size' => 9], ['alignment' => Jc::CENTER]);
            $sigTable->addCell(2500)->addText('', ['size' => 9]);
        }
    }

    // ===================================================================
    // HELPER: AMBIL DATA PROYEK
    // ===================================================================
    protected function getProjectData(Lokasi $lokasi): array
    {
        $project = $lokasi->project ?? null;

        return [
            'nama_proyek' => $project?->name ?? '-',
            'kontrak' => $project?->contract_number ?? '-',
            'surat_pesanan' => $project?->purchase_order_number ?? '-',
            'branch' => $project?->branchRelation->name ?? $lokasi->branch->name ?? '-',
            'pelaksana' => $project?->implementer ?? 'PT TELKOM AKSES',
        ];
    }
}
