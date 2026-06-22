<?php
$root = __DIR__ . '/..';
require $root . '/vendor/autoload.php';
$app = require $root . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Lokasi;
use App\Models\GenerateLog;
use App\Services\LactDocumentService;
use Illuminate\Support\Facades\Auth;

$lokasis = Lokasi::with(['project.branchRelation','project.waspangRelation','commissioningTest.personel','boqItems','markingKabel','fotoLampiran','opmRecords','otdrFiles'])->get();

$summary = ['generated' => [], 'skipped' => [], 'failed' => []];

foreach ($lokasis as $lokasi) {
    echo "Processing Lokasi ID {$lokasi->id}...\n";
    // validate minimal requirements
    $missing = [];
    if (!$lokasi->commissioningTest) $missing[] = 'commissioningTest';
    if ($lokasi->boqItems()->count() === 0) $missing[] = 'boqItems';
    if ($lokasi->markingKabel()->count() === 0) $missing[] = 'markingKabel';
    if ($lokasi->fotoLampiran()->count() === 0) $missing[] = 'fotoLampiran';
    if ($lokasi->opmRecords()->count() === 0) $missing[] = 'opmRecords';

    if (!empty($missing)) {
        echo " - Skipped (missing: " . implode(',', $missing) . ")\n";
        $summary['skipped'][$lokasi->id] = $missing;
        continue;
    }

    $versi = $lokasi->generateLogs()->count() + 1;
    try {
        $service = new LactDocumentService($lokasi);
        $filePath = $service->generate((string)$versi);
        echo " - Generated: $filePath\n";

        // create generate log if model exists
        if (class_exists(GenerateLog::class)) {
            GenerateLog::create([
                'lokasi_id' => $lokasi->id,
                'generated_by' => 'script',
                'generated_at' => now(),
                'file_path' => 'generated/' . basename($filePath),
                'versi' => $versi,
            ]);
        }

        $lokasi->update(['status' => 'generated']);
        $summary['generated'][] = ['id' => $lokasi->id, 'file' => $filePath];
    } catch (Throwable $e) {
        echo " - Failed: " . $e->getMessage() . "\n";
        $summary['failed'][$lokasi->id] = $e->getMessage();
    }
}

echo "\nSummary:\n";
echo "Generated: " . count($summary['generated']) . "\n";
echo "Skipped: " . count($summary['skipped']) . "\n";
echo "Failed: " . count($summary['failed']) . "\n";

file_put_contents($root . '/storage/logs/generate_all_lact_summary.json', json_encode($summary, JSON_PRETTY_PRINT));

echo "Details saved to storage/logs/generate_all_lact_summary.json\n";
