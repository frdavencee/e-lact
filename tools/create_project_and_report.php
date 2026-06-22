<?php
$root = __DIR__ . '/..';
require $root . '/vendor/autoload.php';
$app = require $root . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Branch;
use App\Models\Lokasi;
use App\Models\Project;
use App\Models\Report;

$user = User::first();
$branch = Branch::first();
$lokasi = Lokasi::first();

if (!$user) {
    echo "NO_USER\n";
    exit;
}
if (!$branch) {
    echo "NO_BRANCH\n";
    exit;
}
if (!$lokasi) {
    echo "NO_LOKASI\n";
    exit;
}

$project = Project::create([
    'user_id' => $user->id,
    'branch_id' => $branch->id,
    'location_id' => $lokasi->id,
    'name' => 'Demo Project',
]);

if (!$project) {
    echo "PROJECT_FAILED\n";
    exit;
}

$report = Report::create([
    'project_id' => $project->id,
    'user_id' => $user->id,
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

echo "PROJECT_CREATED:{$project->id}\n";
echo "REPORT_CREATED:{$report->id}\n";
