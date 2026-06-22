<?php
require __DIR__ . '/bootstrap/app.php';

$app = new \Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? __DIR__,
);

$app->singleton(
    \Illuminate\Contracts\Http\Kernel::class,
    \App\Http\Kernel::class,
);

$app->singleton(
    \Illuminate\Contracts\Console\Kernel::class,
    \App\Console\Kernel::class,
);

$app->singleton(
    \Illuminate\Contracts\Debug\ExceptionHandler::class,
    \App\Exceptions\Handler::class,
);

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Lokasi;
use App\Services\LactPdfService;

try {
    $lokasi = Lokasi::first();
    if ($lokasi) {
        echo "Generating PDF for Lokasi: " . $lokasi->code . "\n";
        $service = new LactPdfService($lokasi);
        $path = $service->generate('1');
        echo "PDF generated successfully at: " . $path . "\n";
        echo "File exists: " . (file_exists($path) ? "Yes" : "No") . "\n";
        echo "File size: " . filesize($path) . " bytes\n";
    } else {
        echo "No Lokasi found\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
