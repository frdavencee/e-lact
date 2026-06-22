<?php
$root = __DIR__ . '/..';
require $root . '/vendor/autoload.php';
$app = require $root . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo 'Users: ' . App\Models\User::count() . "\n";
echo 'Projects: ' . App\Models\Project::count() . "\n";
echo 'Branches: ' . App\Models\Branch::count() . "\n";
echo 'Lokasis: ' . App\Models\Lokasi::count() . "\n";
