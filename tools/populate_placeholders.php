<?php
$root = __DIR__ . '/..';
require $root . '/vendor/autoload.php';
$app = require $root . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Lokasi;
use App\Models\Personel;
use App\Models\BoqItem;
use App\Models\MarkingKabel;
use App\Models\FotoLampiran;
use App\Models\OpMRecord;
use Illuminate\Support\Facades\Storage;

$assetsDir = $root . '/storage/app/public/assets';
if (!is_dir($assetsDir)) mkdir($assetsDir, 0755, true);

$placeholderPath = $assetsDir . '/placeholder.png';
if (!file_exists($placeholderPath)) {
    // create a tiny 1x1 png
    $data = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGNgYAAAAAMAASsJTYQAAAAASUVORK5CYII=');
    file_put_contents($placeholderPath, $data);
}

$lokasis = Lokasi::all();
foreach ($lokasis as $lokasi) {
    echo "Processing Lokasi {$lokasi->id}\n";
    $project = $lokasi->project;
    if (!$project) {
        echo " - No project associated, skipping\n";
        continue;
    }

    // ensure waspang personel exists
    $personel = $project->waspangRelation;
    if (!$personel) {
        $personel = Personel::first();
        if (!$personel) {
            $personel = Personel::create(['name' => 'Waspang Contoh', 'nik' => '000000', 'position' => 'WASPANG']);
        }
        $project->waspang_id = $personel->id;
        $project->save();
    }

    // commissioning test
    if (!$lokasi->commissioningTest) {
        
        $ct = $lokasi->commissioningTest()->create([
            'personel_id' => $personel->id,
            'tanggal' => date('Y-m-d'),
            'kota_ttd' => 'Semarang',
            'status_pekerjaan' => 'telah',
            'status_hasil' => 'dapat',
            'status_kelayakan' => 'layak',
        ]);
        echo " - CommissioningTest created\n";
    }

    // boq items (at least 1)
    if ($project->boqItems()->count() === 0) {
        $b = BoqItem::create([
            'project_id' => $project->id,
            'lokasi_id' => $lokasi->id,
            'item_code' => 'ITEM-001',
            'name' => 'Material Contoh',
            'volume' => 1,
            'unit' => 'PCS',
            'price' => 0,
            'total' => 0,
            'notes' => 'Placeholder',
        ]);
        if ($b) echo " - BOQ item created\n";
    }

    // ensure any existing project-level BOQ items are linked to lokasi
    foreach ($project->boqItems as $existing) {
        if (empty($existing->lokasi_id)) {
            $existing->lokasi_id = $lokasi->id;
            $existing->save();
        }
    }

    // marking kabel
    if ($lokasi->markingKabel()->count() === 0) {
        MarkingKabel::create([
            'lokasi_id' => $lokasi->id,
            'jenis_kabel' => 'FO',
            'panjang_meter' => 10,
        ]);
        echo " - MarkingKabel created\n";
    }

    // foto lampiran
    if ($lokasi->fotoLampiran()->count() === 0) {
        FotoLampiran::create([
            'lokasi_id' => $lokasi->id,
            'kategori' => 'evident_penarikan_kabel',
            'label' => 'Foto Contoh',
            'file_path' => 'assets/placeholder.png',
            'urutan' => 1,
        ]);
        echo " - FotoLampiran created\n";
    }

    // opm records
    if ($project->opmRecords()->count() === 0) {
        OpMRecord::create([
            'project_id' => $project->id,
            'scan' => 'sudah',
            'odp_name' => 'ODP-01',
            'port_1' => -20,
            'port_2' => -20,
            'port_3' => -20,
            'port_4' => -20,
            'port_5' => -20,
            'port_6' => -20,
            'port_7' => -20,
            'port_8' => -20,
            'loss_value' => -20,
            'notes' => 'Placeholder OPM',
        ]);
        echo " - OpMRecord created\n";
    }
}

echo "Done\n";
