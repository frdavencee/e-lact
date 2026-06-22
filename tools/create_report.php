<?php
$root = __DIR__ . '/..';
require $root . '/vendor/autoload.php';
$app = require $root . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Project;
use App\Models\User;
use App\Models\Report;

$p = Project::first();
$u = User::first();

if (!$p) {
    echo "NO_PROJECT\n";
    exit;
}

if (!$u) {
    echo "NO_USER\n";
    exit;
}

$report = Report::create([
    'project_id' => $p->id,
    'user_id' => $u->id,
    'title' => 'Laporan Contoh',
    'type' => 'lapangan',
    'description' => 'Contoh deskripsi',
    'report_date' => date('Y-m-d'),
    'location' => 'Lokasi Contoh',
    'pd_staff' => 'Staff Contoh',
    'findings' => 'Temuan contoh',
    'recommendations' => 'Rekomendasi contoh',
    'action_plan' => 'Rencana contoh',
]);

echo "REPORT_CREATED:{$report->id}\n";
